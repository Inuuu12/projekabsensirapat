<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Models\Agenda; // Pastikan model agenda merujuk ke tabel tunggal 'agenda'
use App\Models\QRCode;

class UserController extends Controller
{
    private const ADUAN_OTP_SESSION_KEY = 'aduan_otp';
    private const ADUAN_OTP_TTL_MINUTES = 10;
    private const ADUAN_OTP_RESEND_SECONDS = 60;

    // 1. CLASS BERANDA
    public function TampilkanPengumuman()
    {
        return response()->json([
            'success' => true,
            'pengumuman' => 'Pengumuman: Jadwal koordinasi rapat dinas bulan ini bersifat terbuka.'
        ]);
    }

    public function TampilkanRingkasan()
    {
        $totalAgenda = DB::table('sirapi_md_agenda')->count();
        $totalAduan = DB::table('sirapi_md_datamasukan')->count();

        return response()->json([
            'success' => true,
            'ringkasan' => [
                'total_agenda_aktif' => $totalAgenda,
                'total_aduan_masuk' => $totalAduan
            ]
        ]);
    }

    // 2. CLASS AGENDA RAPAT PUBLIK
    public function listAgenda()
    {
        $agenda = DB::table('sirapi_md_agenda')->select('id_agenda', 'nama_agenda', 'tanggal', 'waktu', 'lokasi')->get();
        return response()->json(['success' => true, 'data' => $agenda]);
    }

    public function CariAgenda(Request $request)
    {
        $keyword = $request->query('keyword');
        $agenda = DB::table('sirapi_md_agenda')
            ->where('nama_agenda', 'like', "%{$keyword}%")
            ->orWhere('lokasi', 'like', "%{$keyword}%")
            ->get();

        return response()->json(['success' => true, 'results' => $agenda]);
    }

    public function tampilkanQrKode($id)
    {
        $qrCode = QRCode::where('id_agenda', $id)->first();

        return response()->json([
            'success' => (bool) $qrCode,
            'id_agenda' => $id,
            'qr_code_url' => $qrCode?->qr_codepath,
            'qr_image_url' => $qrCode
                ? 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($qrCode->qr_codepath)
                : null,
        ]);
    }

    // 3. CLASS ADUAN
    public function kirimOtpAduan(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = strtolower($validated['email']);
        $existingOtp = session(self::ADUAN_OTP_SESSION_KEY);
        $now = now();

        if (
            ($existingOtp['email'] ?? null) === $email
            && ($existingOtp['sent_at'] ?? 0) > $now->copy()->subSeconds(self::ADUAN_OTP_RESEND_SECONDS)->timestamp
        ) {
            return response()->json([
                'success' => false,
                'message' => 'OTP sudah dikirim. Tunggu 60 detik sebelum meminta kode baru.',
            ], 429);
        }

        $otp = (string) random_int(100000, 999999);

        try {
            Mail::raw(
                "Kode OTP masukan SIRAPI Anda: {$otp}\n\nKode ini berlaku selama " . self::ADUAN_OTP_TTL_MINUTES . " menit. Abaikan email ini jika Anda tidak meminta kode OTP.",
                function ($message) use ($email) {
                    $message->to($email)->subject('Kode OTP Masukan SIRAPI');
                }
            );
        } catch (\Throwable) {
            return response()->json([
                'success' => false,
                'message' => 'OTP gagal dikirim. Periksa konfigurasi email aplikasi.',
            ], 500);
        }

        session()->put(self::ADUAN_OTP_SESSION_KEY, [
            'email' => $email,
            'otp_hash' => Hash::make($otp),
            'expires_at' => $now->copy()->addMinutes(self::ADUAN_OTP_TTL_MINUTES)->timestamp,
            'sent_at' => $now->timestamp,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP sudah dikirim ke email Anda.',
        ]);
    }

    public function kirimAduan(Request $request)
    {
        $validated = $request->validate([
            'nama_pengadu' => 'required|string|max:255',
            'nomor_pengadu' => 'required|string|max:30',
            'email' => 'required|email|max:255',
            'otp' => 'required|digits:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'isi_aduan'    => 'required|string',
        ]);

        $this->validateAduanOtp($validated['email'], $validated['otp']);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('aduan', 'public');
        }

        $idAduan = DB::table('sirapi_md_datamasukan')->insertGetId([
            'nama_pengadu' => $validated['nama_pengadu'],
            'nomor_pengadu' => $validated['nomor_pengadu'],
            'email' => $validated['email'],
            'foto' => $validated['foto'] ?? 'aduan/default.jpg',
            'isi_aduan'    => $validated['isi_aduan'],
            'status'       => 'Pending',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        session()->forget(self::ADUAN_OTP_SESSION_KEY);

        if (! $request->wantsJson()) {
            return back()->with('success', 'Aduan berhasil dikirim!');
        }

        return response()->json([
            'success' => true,
            'message' => 'Aduan berhasil dikirim!',
            'id_aduan' => $idAduan
        ], 201);
    }

    public function cekStatusAduan($id)
    {
        $aduan = DB::table('sirapi_md_datamasukan')->where('id_datamasukan', $id)->first();

        if (!$aduan) {
            return response()->json(['success' => false, 'message' => 'Data aduan tidak ditemukan.'], 404);
        }

        return response()->json(['success' => true, 'status' => $aduan->status]);
    }

    private function validateAduanOtp(string $email, string $otp): void
    {
        $otpSession = session(self::ADUAN_OTP_SESSION_KEY);
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
            session()->forget(self::ADUAN_OTP_SESSION_KEY);

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

    // 4. CLASS NON_PEGAWAI (TAMU EKSTERNAL)
    public function inputDataTamu(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'nik'           => 'nullable|string|max:16|regex:/^[0-9]+$/',
            'jabatan'       => 'nullable|string|max:255',
            'no_hp'         => 'required|string|max:13|regex:/^[0-9]+$/',
            'asal_instansi' => 'required|string|max:255',
            'id_agenda'     => 'required|integer|exists:sirapi_md_agenda,id_agenda',
            'foto'          => 'nullable|file|image|mimes:jpeg,png,jpg,webp|max:5120',
            'foto_selfie'   => 'nullable',
            'tanda_tangan'  => 'nullable|string',
        ], [
            'nama.required' => 'Nama lengkap tamu wajib diisi.',
            'no_hp.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka.',
            'asal_instansi.required' => 'Instansi / asal wajib diisi.',
            'id_agenda.required' => 'Agenda wajib dipilih.',
            'foto.image' => 'File foto harus berupa gambar (JPG, PNG, WebP).',
            'foto.max' => 'Ukuran foto maksimal 5MB.',
        ]);

        $agenda = \App\Models\Agenda::find($validated['id_agenda']);
        if ($agenda && $agenda->status_label === \App\Models\Agenda::STATUS_SELESAI) {
            if (! $request->wantsJson()) {
                return back()->withErrors(['agenda' => 'Agenda rapat telah selesai. Presensi sudah ditutup.']);
            }

            return response()->json(['success' => false, 'message' => 'Agenda rapat telah selesai. Presensi sudah ditutup.'], 400);
        }

        if ($agenda && strtolower((string) ($agenda->kategori_surat ?? '')) === 'masuk') {
            if (! $request->wantsJson()) {
                return back()->withErrors(['agenda' => 'Agenda surat masuk hanya diperuntukkan untuk presensi pegawai yang ditugaskan.']);
            }

            return response()->json(['success' => false, 'message' => 'Agenda surat masuk hanya diperuntukkan untuk presensi pegawai yang ditugaskan.'], 400);
        }

        if ($request->hasFile('foto')) {
            $validated['foto_selfie'] = $request->file('foto')->store('tamu', 'public');
        } elseif ($request->hasFile('foto_selfie')) {
            $validated['foto_selfie'] = $request->file('foto_selfie')->store('tamu', 'public');
        }

        unset($validated['foto'], $validated['tanda_tangan']);

        $idTamu = DB::table('sirapi_md_tamu')->insertGetId(array_merge($validated, [
            'created_at' => now(),
            'updated_at' => now()
        ]));

        if (! $request->wantsJson()) {
            return back()->with('success', 'Data kehadiran tamu berhasil disimpan!');
        }

        return response()->json([
            'success' => true,
            'message' => 'Data kehadiran tamu berhasil disimpan!',
            'id_non_pegawai' => $idTamu
        ], 201);
    }
}
