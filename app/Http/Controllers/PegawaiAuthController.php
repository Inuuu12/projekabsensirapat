<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Bidang;
use App\Models\DokumenNotulen;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PegawaiAuthController extends Controller
{
    private const TIMEZONE = 'Asia/Jakarta';
    private const PASSWORD_OTP_SESSION_KEY = 'pegawai_password_otp';
    private const PASSWORD_OTP_TTL_MINUTES = 10;
    private const PASSWORD_OTP_RESEND_SECONDS = 60;
    private const FORGOT_PASSWORD_OTP_SESSION_KEY = 'pegawai_forgot_password_otp';

    public function showLoginForm()
    {
        if (Auth::guard('pegawai')->check()) {
            return redirect()->route('pegawai.presensi.index');
        }

        return view('auth.login_pegawai.index');
    }

    public function showRegisterForm()
    {
        if (Auth::guard('pegawai')->check()) {
            return redirect()->route('pegawai.presensi.index');
        }

        [$bidangOptions, $jabatanOptions] = $this->masterPegawaiOptions();

        return view('auth.register_pegawai.index', compact('bidangOptions', 'jabatanOptions'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('pegawai')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('pegawai.presensi.index'));
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_pegawai' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:18', 'regex:/^[0-9]+$/', 'unique:sirapi_md_pegawai,nip'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jabatan' => ['required', 'string', 'max:255'],
            'bidang' => ['nullable', 'string', 'max:255'],
            'nomor_hp' => ['required', 'string', 'max:13', 'regex:/^[0-9]+$/'],
            'email' => ['required', 'email', 'max:255', 'unique:sirapi_md_pegawai,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $pegawai = Pegawai::create($validated);

        Auth::guard('pegawai')->login($pegawai);
        $request->session()->regenerate();

        return redirect()->route('pegawai.presensi.index');
    }

    public function kirimOtpLupaPassword(Request $request)
    {
        $validated = $request->validate([
            'reset_email' => ['required', 'email', 'max:255'],
        ]);

        $email = strtolower($validated['reset_email']);
        $existingOtp = session(self::FORGOT_PASSWORD_OTP_SESSION_KEY);
        $now = now();

        if (
            ($existingOtp['email'] ?? null) === $email
            && ($existingOtp['sent_at'] ?? 0) > $now->copy()->subSeconds(self::PASSWORD_OTP_RESEND_SECONDS)->timestamp
        ) {
            return back()
                ->withErrors(['reset_email' => 'OTP sudah dikirim. Tunggu 60 detik sebelum meminta kode baru.'])
                ->withInput($request->only('reset_email'))
                ->with('forgot_open', true);
        }

        $otp = (string) random_int(100000, 999999);

        try {
            Mail::raw(
                "Kode OTP reset password SIRAPI Anda: {$otp}\n\nKode ini berlaku selama " . self::PASSWORD_OTP_TTL_MINUTES . " menit. Abaikan email ini jika Anda tidak meminta reset password.",
                function ($message) use ($email) {
                    $message->to($email)->subject('Kode OTP Reset Password SIRAPI');
                }
            );
        } catch (\Throwable) {
            return back()
                ->withErrors(['reset_email' => 'OTP gagal dikirim. Periksa konfigurasi email aplikasi.'])
                ->withInput($request->only('reset_email'))
                ->with('forgot_open', true);
        }

        session()->put(self::FORGOT_PASSWORD_OTP_SESSION_KEY, [
            'email' => $email,
            'otp_hash' => Hash::make($otp),
            'expires_at' => $now->copy()->addMinutes(self::PASSWORD_OTP_TTL_MINUTES)->timestamp,
            'sent_at' => $now->timestamp,
        ]);

        return back()
            ->with('status', 'Kode OTP reset password sudah dikirim ke email tujuan.')
            ->withInput($request->only('reset_email'))
            ->with('forgot_open', true);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'reset_email' => ['required', 'email', 'max:255'],
            'otp' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = strtolower($validated['reset_email']);
        $this->validateForgotPasswordOtp($email, $validated['otp']);

        if (! Schema::hasTable((new Pegawai())->getTable())) {
            return back()
                ->withErrors(['reset_email' => 'Tabel pegawai belum tersedia. Jalankan migration sirapi_md terlebih dahulu.'])
                ->withInput($request->only('reset_email'))
                ->with('forgot_open', true);
        }

        $pegawai = Pegawai::where('email', $email)->first();

        if (! $pegawai) {
            return back()
                ->withErrors(['reset_email' => 'OTP valid, tetapi email ini belum terdaftar sebagai akun pegawai.'])
                ->withInput($request->only('reset_email'))
                ->with('forgot_open', true);
        }

        $pegawai->update([
            'password' => $validated['password'],
        ]);

        session()->forget(self::FORGOT_PASSWORD_OTP_SESSION_KEY);

        return redirect()
            ->route('pegawai.login')
            ->with('status', 'Password berhasil diubah. Silakan login dengan password baru.');
    }

    public function presensi(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();
        $agenda = $this->agendaPresensi($request);
        $dokumen = $this->dokumenAgenda($agenda);
        $kehadiran = $agenda ? $this->kehadiranPegawai($agenda->id_agenda, $pegawai->email) : null;
        [$bidangOptions, $jabatanOptions] = $this->masterPegawaiOptions();

        return view('pegawai.presensi_pegawai.index', compact('pegawai', 'agenda', 'dokumen', 'kehadiran', 'bidangOptions', 'jabatanOptions'));
    }

    public function simpanPresensi(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();
        $agenda = $this->agendaPresensi($request);

        if (! $agenda) {
            return back()->withErrors(['presensi' => 'Agenda presensi belum tersedia.']);
        }

        $now = Carbon::now(self::TIMEZONE);

        DB::transaction(function () use ($agenda, $pegawai, $now) {
            $pesertaData = [
                    'nama' => $pegawai->nama_pegawai,
                    'jabatan' => $pegawai->jabatan ?: '-',
                    'instansi' => $pegawai->bidang ?: 'Diskominfo Kabupaten Bogor',
                    'jenis_peserta' => 'pegawai',
                    'nomor_hp' => $pegawai->nomor_hp ?: '-',
                    'updated_at' => $now,
            ];

            $existingPeserta = DB::table('sirapi_md_peserta')->where('email', $pegawai->email)->first();

            if ($existingPeserta) {
                DB::table('sirapi_md_peserta')->where('id_peserta', $existingPeserta->id_peserta)->update($pesertaData);
            } else {
                DB::table('sirapi_md_peserta')->insert($pesertaData + [
                    'email' => $pegawai->email,
                    'created_at' => $now,
                ]);
            }

            $idPeserta = DB::table('sirapi_md_peserta')->where('email', $pegawai->email)->value('id_peserta');

            $idLog = DB::table('sirapi_md_logbook')->insertGetId([
                'Id_agenda' => $agenda->id_agenda,
                'catatan' => 'Presensi pegawai otomatis: ' . $pegawai->nama_pegawai,
                'waktu_isi' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $existing = DB::table('sirapi_md_kehadiran')
                ->where('id_agenda', $agenda->id_agenda)
                ->where('id_peserta', $idPeserta)
                ->first();

            if ($existing) {
                DB::table('sirapi_md_kehadiran')
                    ->where('id_kehadiran', $existing->id_kehadiran)
                    ->update([
                        'id_log' => $idLog,
                        'updated_at' => $now,
                    ]);

                return;
            }

            DB::table('sirapi_md_kehadiran')->insert([
                'id_agenda' => $agenda->id_agenda,
                'id_peserta' => $idPeserta,
                'id_log' => $idLog,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        });

        return redirect()
            ->route('pegawai.presensi.index', ['agenda_id' => $agenda->id_agenda])
            ->with('success', 'Presensi telah berhasil.');
    }

    public function updateProfil(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();

        $validated = $request->validate([
            'nama_pegawai' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:18', 'regex:/^[0-9]+$/', 'unique:sirapi_md_pegawai,nip,' . $pegawai->id_pegawai . ',id_pegawai'],
            'jabatan' => ['required', 'string', 'max:255'],
            'bidang' => ['nullable', 'string', 'max:255'],
            'nomor_hp' => ['nullable', 'string', 'max:13', 'regex:/^[0-9]+$/'],
            'email' => ['required', 'email', 'max:255', 'unique:sirapi_md_pegawai,email,' . $pegawai->id_pegawai . ',id_pegawai'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_otp' => ['required_with:password', 'nullable', 'digits:6'],
        ]);

        if (! empty($validated['password'])) {
            $this->validatePasswordOtp($pegawai->email, $validated['password_otp'] ?? '');
            session()->forget(self::PASSWORD_OTP_SESSION_KEY);
        } else {
            unset($validated['password']);
        }

        unset($validated['password_otp']);

        if ($request->hasFile('foto')) {
            if ($pegawai->foto && ! str_starts_with($pegawai->foto, 'foto/') && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        $pegawai->update($validated);

        return back()->with('profile_success', 'Profil berhasil diperbarui.');
    }

    public function kirimOtpPassword(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();

        if (! $pegawai || ! $pegawai->email) {
            return response()->json([
                'success' => false,
                'message' => 'Email pegawai tidak ditemukan.',
            ], 422);
        }

        $email = strtolower($pegawai->email);
        $existingOtp = session(self::PASSWORD_OTP_SESSION_KEY);
        $now = now();

        if (
            ($existingOtp['email'] ?? null) === $email
            && ($existingOtp['sent_at'] ?? 0) > $now->copy()->subSeconds(self::PASSWORD_OTP_RESEND_SECONDS)->timestamp
        ) {
            return response()->json([
                'success' => false,
                'message' => 'OTP sudah dikirim. Tunggu 60 detik sebelum meminta kode baru.',
            ], 429);
        }

        $otp = (string) random_int(100000, 999999);

        try {
            Mail::raw(
                "Kode OTP ubah password SIRAPI Anda: {$otp}\n\nKode ini berlaku selama " . self::PASSWORD_OTP_TTL_MINUTES . " menit. Abaikan email ini jika Anda tidak meminta perubahan password.",
                function ($message) use ($email) {
                    $message->to($email)->subject('Kode OTP Ubah Password SIRAPI');
                }
            );
        } catch (\Throwable) {
            return response()->json([
                'success' => false,
                'message' => 'OTP gagal dikirim. Periksa konfigurasi email aplikasi.',
            ], 500);
        }

        session()->put(self::PASSWORD_OTP_SESSION_KEY, [
            'email' => $email,
            'otp_hash' => Hash::make($otp),
            'expires_at' => $now->copy()->addMinutes(self::PASSWORD_OTP_TTL_MINUTES)->timestamp,
            'sent_at' => $now->timestamp,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP sudah dikirim ke email akun Anda.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('pegawai')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pegawai.login')->with('status', 'Anda telah logout.');
    }

    private function agendaPresensi(Request $request): ?Agenda
    {
        $id = $request->query('agenda_id');
        $today = Carbon::today(self::TIMEZONE)->toDateString();

        return $this->queryOrDefault(fn () => Agenda::query()
            ->when($id, fn ($query) => $query->whereKey($id))
            ->orderByRaw('tanggal >= ? desc', [$today])
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->first());
    }

    private function dokumenAgenda(?Agenda $agenda)
    {
        if (! $agenda) {
            return collect();
        }

        return $this->queryOrDefault(fn () => DokumenNotulen::where('id_agenda', $agenda->id_agenda)
            ->orderBy('jenis_dokumen')
            ->orderBy('id_dokumen')
            ->get(), collect());
    }

    private function kehadiranPegawai(int $idAgenda, string $email): mixed
    {
        return $this->queryOrDefault(fn () => DB::table('sirapi_md_kehadiran')
            ->join('sirapi_md_peserta', 'sirapi_md_kehadiran.id_peserta', '=', 'sirapi_md_peserta.id_peserta')
            ->where('sirapi_md_kehadiran.id_agenda', $idAgenda)
            ->where('sirapi_md_peserta.email', $email)
            ->select('sirapi_md_kehadiran.*')
            ->first());
    }

    private function validatePasswordOtp(string $email, string $otp): void
    {
        $otpSession = session(self::PASSWORD_OTP_SESSION_KEY);
        $normalizedEmail = strtolower($email);

        if (! $otpSession) {
            throw ValidationException::withMessages([
                'password_otp' => 'Silakan kirim OTP ke email terlebih dahulu.',
            ]);
        }

        if (($otpSession['email'] ?? null) !== $normalizedEmail) {
            throw ValidationException::withMessages([
                'password_otp' => 'Email akun tidak sama dengan email yang menerima OTP.',
            ]);
        }

        if (($otpSession['expires_at'] ?? 0) < now()->timestamp) {
            session()->forget(self::PASSWORD_OTP_SESSION_KEY);

            throw ValidationException::withMessages([
                'password_otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta OTP baru.',
            ]);
        }

        if (! Hash::check($otp, $otpSession['otp_hash'] ?? '')) {
            throw ValidationException::withMessages([
                'password_otp' => 'Kode OTP tidak valid.',
            ]);
        }
    }

    private function validateForgotPasswordOtp(string $email, string $otp): void
    {
        $otpSession = session(self::FORGOT_PASSWORD_OTP_SESSION_KEY);
        $normalizedEmail = strtolower($email);

        if (! $otpSession) {
            throw ValidationException::withMessages([
                'otp' => 'Silakan kirim OTP ke email terlebih dahulu.',
            ]);
        }

        if (($otpSession['email'] ?? null) !== $normalizedEmail) {
            throw ValidationException::withMessages([
                'otp' => 'Email tidak sama dengan email yang menerima OTP.',
            ]);
        }

        if (($otpSession['expires_at'] ?? 0) < now()->timestamp) {
            session()->forget(self::FORGOT_PASSWORD_OTP_SESSION_KEY);

            throw ValidationException::withMessages([
                'otp' => 'Kode OTP sudah kedaluwarsa. Silakan minta OTP baru.',
            ]);
        }

        if (! Hash::check($otp, $otpSession['otp_hash'] ?? '')) {
            throw ValidationException::withMessages([
                'otp' => 'Kode OTP tidak valid.',
            ]);
        }
    }

    private function masterPegawaiOptions(): array
    {
        $bidang = $this->queryOrDefault(fn () => Bidang::orderBy('nama_bidang')->pluck('nama_bidang'), collect());
        $jabatan = $this->queryOrDefault(fn () => Jabatan::orderByRaw("
                CASE
                    WHEN kategori = 'Struktural' THEN 0
                    WHEN kategori = 'Jabatan Fungsional' THEN 1
                    ELSE 2
                END
            ")
            ->orderBy('nama_jabatan')
            ->pluck('nama_jabatan'), collect());

        return [$bidang, $jabatan];
    }

    private function queryOrDefault(callable $query, mixed $default = null): mixed
    {
        try {
            return $query();
        } catch (QueryException) {
            return $default;
        }
    }
}
