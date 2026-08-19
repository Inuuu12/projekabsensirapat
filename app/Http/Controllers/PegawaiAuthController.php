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

    public function showLoginForm(Request $request)
    {
        if (Auth::guard('pegawai')->check()) {
            $pegawai = Auth::guard('pegawai')->user();
            $agendaId = $request->query('agenda_id');
            $agenda = $agendaId ? Agenda::find($agendaId) : null;

            if ($agenda) {
                if ($agenda->status_label === Agenda::STATUS_SELESAI) {
                    return redirect()->route('pegawai.presensi.index', ['agenda_id' => $agenda->id_agenda])
                        ->withErrors(['presensi' => 'Agenda rapat telah selesai. Presensi sudah ditutup.']);
                }

                if (! $agenda->canPegawaiPresensi($pegawai)) {
                    return redirect()->route('pegawai.presensi.index', ['agenda_id' => $agenda->id_agenda])
                        ->withErrors(['presensi' => 'Presensi ditolak. Agenda surat masuk ini hanya dikhususkan untuk pegawai yang ditugaskan (' . ($agenda->ditugaskan ?: '-') . ').']);
                }

                if (! $agenda->isPegawaiSudahHadir($pegawai) && $agenda->isKuotaPenuh()) {
                    return redirect()->route('pegawai.presensi.index', ['agenda_id' => $agenda->id_agenda])
                        ->withErrors(['presensi' => 'Presensi ditolak karena kuota peserta agenda ini sudah penuh.']);
                }

                $this->catatKehadiranPegawai($agenda, $pegawai, 'Hadir lewat Login Manual Pegawai');

                return redirect()->route('pegawai.presensi.index', ['agenda_id' => $agenda->id_agenda])
                    ->with('success', 'Kehadiran Anda pada agenda ' . $agenda->nama_agenda . ' telah tercatat!');
            }

            return redirect()->route('pegawai.presensi.index', array_filter(['agenda_id' => $request->query('agenda_id')]));
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
            $pegawai = Auth::guard('pegawai')->user();

            $agendaId = $request->input('agenda_id') ?: $request->query('agenda_id');
            $agenda = $agendaId ? Agenda::find($agendaId) : $this->agendaPresensi($request);

            if ($agenda) {
                if ($agenda->status_label === Agenda::STATUS_SELESAI) {
                    return redirect()->route('pegawai.presensi.index', ['agenda_id' => $agenda->id_agenda])
                        ->withErrors(['presensi' => 'Login berhasil, namun agenda rapat telah selesai. Presensi sudah ditutup.']);
                }

                if (! $agenda->canPegawaiPresensi($pegawai)) {
                    return redirect()->route('pegawai.presensi.index', ['agenda_id' => $agenda->id_agenda])
                        ->withErrors(['presensi' => 'Login berhasil, namun presensi ditolak. Agenda surat masuk ini hanya dikhususkan untuk pegawai yang ditugaskan (' . ($agenda->ditugaskan ?: '-') . ').']);
                }

                if (! $agenda->isPegawaiSudahHadir($pegawai) && $agenda->isKuotaPenuh()) {
                    return redirect()->route('pegawai.presensi.index', ['agenda_id' => $agenda->id_agenda])
                        ->withErrors(['presensi' => 'Login berhasil, namun presensi ditolak karena kuota peserta agenda ini sudah penuh.']);
                }

                $this->catatKehadiranPegawai($agenda, $pegawai, 'Hadir lewat Login Manual Pegawai');

                return redirect()->route('pegawai.presensi.index', ['agenda_id' => $agenda->id_agenda])
                    ->with('success', 'Login berhasil dan kehadiran Anda pada agenda ' . $agenda->nama_agenda . ' telah tercatat!');
            }

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
        $isDitugaskan = $agenda ? $agenda->canPegawaiPresensi($pegawai) : true;

        return view('pegawai.presensi.index', compact('pegawai', 'agenda', 'dokumen', 'kehadiran', 'bidangOptions', 'jabatanOptions', 'isDitugaskan'));
    }

    public function simpanPresensi(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();
        $agenda = $this->agendaPresensi($request);

        if (! $agenda) {
            return back()->withErrors(['presensi' => 'Agenda presensi belum tersedia.']);
        }

        if ($agenda->status_label === Agenda::STATUS_SELESAI) {
            return back()->withErrors(['presensi' => 'Agenda rapat telah selesai. Presensi sudah ditutup.']);
        }

        if (! $agenda->canPegawaiPresensi($pegawai)) {
            return back()->withErrors(['presensi' => 'Presensi ditolak. Agenda surat masuk ini hanya dikhususkan untuk pegawai yang ditugaskan (' . ($agenda->ditugaskan ?: '-') . ').']);
        }

        if (! $agenda->isPegawaiSudahHadir($pegawai) && $agenda->isKuotaPenuh()) {
            return back()->withErrors(['presensi' => 'Presensi ditolak karena kuota peserta agenda ini sudah penuh.']);
        }

        $this->catatKehadiranPegawai($agenda, $pegawai, 'Presensi pegawai manual');

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

    public function updateFace(Request $request)
    {
        $pegawai = Auth::guard('pegawai')->user();

        $validated = $request->validate([
            'face_descriptor' => ['required', 'string'],
            'foto_wajah' => ['nullable', 'string'],
        ]);

        $fotoWajahPath = null;
        if (!empty($validated['foto_wajah'])) {
            $imageParts = explode(';base64,', $validated['foto_wajah']);
            if (count($imageParts) == 2) {
                $imageTypeAux = explode('image/', $imageParts[0]);
                $imageType = $imageTypeAux[1] ?? 'jpeg';
                $imageBase64 = base64_decode($imageParts[1]);
                $fileName = 'face_scan_' . $pegawai->id_pegawai . '_' . time() . '.' . $imageType;
                
                \Storage::disk('public')->put('pegawai/' . $fileName, $imageBase64);
                $fotoWajahPath = 'pegawai/' . $fileName;
            }
        }

        DB::table('sirapi_md_pegawai')
            ->where('id_pegawai', $pegawai->id_pegawai)
            ->update([
                'face_descriptor' => $validated['face_descriptor'],
                'foto_wajah' => $fotoWajahPath,
                'foto' => $fotoWajahPath,
                'updated_at' => now(),
            ]);

        return response()->json(['success' => true, 'message' => 'Data wajah berhasil didaftarkan.']);
    }

    public function getRegisteredFaces()
    {
        $pegawai = DB::table('sirapi_md_pegawai')
            ->whereNotNull('face_descriptor')
            ->select('id_pegawai', 'nama_pegawai', 'face_descriptor')
            ->get();

        return response()->json($pegawai);
    }

    public function simpanPresensiFace(Request $request)
    {
        $validated = $request->validate([
            'id_pegawai' => 'required|integer',
            'id_agenda' => 'required|integer',
        ]);

        $pegawai = DB::table('sirapi_md_pegawai')->where('id_pegawai', $validated['id_pegawai'])->first();
        $agenda = Agenda::find($validated['id_agenda']);

        if (! $pegawai || ! $agenda) {
            return response()->json(['success' => false, 'message' => 'Data tidak valid.'], 400);
        }

        if ($agenda->status_label === Agenda::STATUS_SELESAI) {
            return response()->json(['success' => false, 'message' => 'Agenda rapat telah selesai. Presensi sudah ditutup.'], 400);
        }

        if (! $agenda->canPegawaiPresensi($pegawai)) {
            return response()->json([
                'success' => false,
                'message' => 'Presensi ditolak. Agenda surat masuk ini hanya dikhususkan untuk pegawai yang ditugaskan (' . ($agenda->ditugaskan ?: '-') . ').'
            ], 403);
        }

        if (! $agenda->isPegawaiSudahHadir($pegawai) && $agenda->isKuotaPenuh()) {
            return response()->json([
                'success' => false,
                'message' => 'Presensi ditolak karena kuota peserta agenda ini sudah penuh.'
            ], 403);
        }

        $this->catatKehadiranPegawai($agenda, $pegawai, 'Hadir lewat Scan Wajah (Face Recognition)');

        $pegawaiModel = Pegawai::find($pegawai->id_pegawai);
        if ($pegawaiModel) {
            Auth::guard('pegawai')->login($pegawaiModel);
            $request->session()->regenerate();
        }

        return response()->json([
            'success' => true,
            'message' => "Presensi Wajah berhasil untuk {$pegawai->nama_pegawai}!",
            'redirect_url' => route('pegawai.presensi.index', ['agenda_id' => $agenda->id_agenda]),
        ]);
    }

    private function catatKehadiranPegawai(Agenda $agenda, mixed $pegawai, string $catatan = 'Presensi pegawai otomatis'): void
    {
        $now = Carbon::now(self::TIMEZONE);
        $nama = is_object($pegawai) ? ($pegawai->nama_pegawai ?? $pegawai->nama ?? '-') : '-';
        $jabatan = is_object($pegawai) ? ($pegawai->jabatan ?? '-') : '-';
        $instansi = is_object($pegawai) ? ($pegawai->bidang ?? 'Diskominfo Kabupaten Bogor') : 'Diskominfo Kabupaten Bogor';
        $noHp = is_object($pegawai) ? ($pegawai->nomor_hp ?? '-') : '-';
        $email = is_object($pegawai) ? ($pegawai->email ?? '') : '';

        DB::transaction(function () use ($agenda, $nama, $jabatan, $instansi, $noHp, $email, $now, $catatan) {
            $pesertaData = [
                'nama' => $nama,
                'jabatan' => $jabatan ?: '-',
                'instansi' => $instansi ?: 'Diskominfo Kabupaten Bogor',
                'jenis_peserta' => 'pegawai',
                'nomor_hp' => $noHp ?: '-',
                'email' => $email,
                'updated_at' => $now,
            ];

            $peserta = DB::table('sirapi_md_peserta')
                ->where('email', $email)
                ->where('jenis_peserta', 'pegawai')
                ->first();

            if ($peserta) {
                DB::table('sirapi_md_peserta')
                    ->where('id_peserta', $peserta->id_peserta)
                    ->update($pesertaData);
                $idPeserta = $peserta->id_peserta;
            } else {
                $pesertaData['created_at'] = $now;
                $idPeserta = DB::table('sirapi_md_peserta')->insertGetId($pesertaData);
            }

            $idLog = DB::table('sirapi_md_logbook')->insertGetId([
                'Id_agenda' => $agenda->id_agenda,
                'catatan' => $catatan . ': ' . $nama,
                'waktu_isi' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('sirapi_md_kehadiran')->updateOrInsert(
                [
                    'id_agenda' => $agenda->id_agenda,
                    'id_peserta' => $idPeserta,
                ],
                [
                    'id_log' => $idLog,
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        });
    }
}
