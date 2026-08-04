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
use Illuminate\Support\Facades\Storage;

class PegawaiAuthController extends Controller
{
    private const TIMEZONE = 'Asia/Jakarta';

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
            'nip' => ['required', 'string', 'max:18', 'regex:/^[0-9]+$/', 'unique:app_md_pegawai,nip'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jabatan' => ['required', 'string', 'max:255'],
            'bidang' => ['nullable', 'string', 'max:255'],
            'nomor_hp' => ['required', 'string', 'max:13', 'regex:/^[0-9]+$/'],
            'email' => ['required', 'email', 'max:255', 'unique:app_md_pegawai,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $pegawai = Pegawai::create($validated);

        Auth::guard('pegawai')->login($pegawai);
        $request->session()->regenerate();

        return redirect()->route('pegawai.presensi.index');
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

            $existingPeserta = DB::table('app_md_peserta')->where('email', $pegawai->email)->first();

            if ($existingPeserta) {
                DB::table('app_md_peserta')->where('id_peserta', $existingPeserta->id_peserta)->update($pesertaData);
            } else {
                DB::table('app_md_peserta')->insert($pesertaData + [
                    'email' => $pegawai->email,
                    'created_at' => $now,
                ]);
            }

            $idPeserta = DB::table('app_md_peserta')->where('email', $pegawai->email)->value('id_peserta');

            $idLog = DB::table('app_md_logbook')->insertGetId([
                'Id_agenda' => $agenda->id_agenda,
                'catatan' => 'Presensi pegawai otomatis: ' . $pegawai->nama_pegawai,
                'waktu_isi' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $existing = DB::table('app_md_kehadiran')
                ->where('id_agenda', $agenda->id_agenda)
                ->where('id_peserta', $idPeserta)
                ->first();

            if ($existing) {
                DB::table('app_md_kehadiran')
                    ->where('id_kehadiran', $existing->id_kehadiran)
                    ->update([
                        'id_log' => $idLog,
                        'updated_at' => $now,
                    ]);

                return;
            }

            DB::table('app_md_kehadiran')->insert([
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
            'nip' => ['required', 'string', 'max:18', 'regex:/^[0-9]+$/', 'unique:app_md_pegawai,nip,' . $pegawai->id_pegawai . ',id_pegawai'],
            'jabatan' => ['required', 'string', 'max:255'],
            'bidang' => ['nullable', 'string', 'max:255'],
            'nomor_hp' => ['nullable', 'string', 'max:13', 'regex:/^[0-9]+$/'],
            'email' => ['required', 'email', 'max:255', 'unique:app_md_pegawai,email,' . $pegawai->id_pegawai . ',id_pegawai'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($request->hasFile('foto')) {
            if ($pegawai->foto && ! str_starts_with($pegawai->foto, 'foto/') && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $pegawai->update($validated);

        return back()->with('profile_success', 'Profil berhasil diperbarui.');
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
        return $this->queryOrDefault(fn () => DB::table('app_md_kehadiran')
            ->join('app_md_peserta', 'app_md_kehadiran.id_peserta', '=', 'app_md_peserta.id_peserta')
            ->where('app_md_kehadiran.id_agenda', $idAgenda)
            ->where('app_md_peserta.email', $email)
            ->select('app_md_kehadiran.*')
            ->first());
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
