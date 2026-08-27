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
        $totalAduan = DB::table('sirapi_md_dataaduan')->count();

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
                "Kode OTP aduan SIRAPI Anda: {$otp}\n\nKode ini berlaku selama " . self::ADUAN_OTP_TTL_MINUTES . " menit. Abaikan email ini jika Anda tidak meminta kode OTP.",
                function ($message) use ($email) {
                    $message->to($email)->subject('Kode OTP Aduan SIRAPI');
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
            'nomor_pengadu' => 'required|string|max:13|regex:/^[0-9]+$/',
            'email' => 'required|email|max:255',
            'otp' => 'required|digits:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'isi_aduan'    => 'required|string',
        ], [
            'nomor_pengadu.required' => 'Nomor HP wajib diisi.',
            'nomor_pengadu.max' => 'Nomor HP maksimal 13 digit angka.',
            'nomor_pengadu.regex' => 'Nomor HP hanya boleh berisi angka.',
            'otp.digits' => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $this->validateAduanOtp($validated['email'], $validated['otp']);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('aduan', 'public');
        }

        $idAduan = DB::table('sirapi_md_dataaduan')->insertGetId([
            'nama_pengadu' => $validated['nama_pengadu'],
            'nomor_pengadu' => $validated['nomor_pengadu'],
            'email' => $validated['email'],
            'foto' => $validated['foto'] ?? null,
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
        $aduan = DB::table('sirapi_md_dataaduan')->where('id_dataaduan', $id)->first();

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
            'foto_captured' => 'nullable|string',
            'foto_selfie'   => 'nullable',
            'tanda_tangan'  => 'nullable|string',
            'lokasi_presensi' => 'nullable|string',
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
        if ($agenda && $agenda->status_label === \App\Models\Agenda::STATUS_MENDATANG) {
            $pesanMendatang = 'Presensi belum dibuka. Agenda rapat baru dimulai pada pukul ' . (substr((string) $agenda->waktu, 0, 5) ?: '-') . ' WIB.';
            if (! $request->wantsJson()) {
                return back()->withErrors(['agenda' => $pesanMendatang]);
            }

            return response()->json(['success' => false, 'message' => $pesanMendatang], 400);
        }

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

        if ($agenda && $agenda->isKuotaPenuh()) {
            $pesanPenuh = 'Pendaftaran kehadiran tamu ditolak. Kuota peserta agenda ini sudah penuh.';
            if (! $request->wantsJson()) {
                return back()->withErrors(['agenda' => $pesanPenuh]);
            }

            return response()->json(['success' => false, 'message' => $pesanPenuh], 400);
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('tamu', 'public');
        } elseif ($request->filled('foto_captured')) {
            try {
                $imageParts = explode(';base64,', (string) $request->input('foto_captured'));
                $imageTypeAux = explode('image/', $imageParts[0] ?? '');
                $imageType = $imageTypeAux[1] ?? 'jpeg';
                if (isset($imageParts[1])) {
                    $imageBase64 = base64_decode($imageParts[1]);
                    $fileName = 'tamu_snap_' . $validated['id_agenda'] . '_' . time() . '_' . rand(100, 999) . '.' . $imageType;
                    \Illuminate\Support\Facades\Storage::disk('public')->put('tamu/' . $fileName, $imageBase64);
                    $fotoPath = 'tamu/' . $fileName;
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Gagal menyimpan live capture tamu: ' . $e->getMessage());
            }
        } elseif ($request->hasFile('foto_selfie')) {
            $fotoPath = $request->file('foto_selfie')->store('tamu', 'public');
        } elseif ($request->filled('foto_selfie') && str_contains((string) $request->input('foto_selfie'), ';base64,')) {
            try {
                $imageParts = explode(';base64,', (string) $request->input('foto_selfie'));
                $imageTypeAux = explode('image/', $imageParts[0] ?? '');
                $imageType = $imageTypeAux[1] ?? 'jpeg';
                if (isset($imageParts[1])) {
                    $imageBase64 = base64_decode($imageParts[1]);
                    $fileName = 'tamu_snap_' . $validated['id_agenda'] . '_' . time() . '_' . rand(100, 999) . '.' . $imageType;
                    \Illuminate\Support\Facades\Storage::disk('public')->put('tamu/' . $fileName, $imageBase64);
                    $fotoPath = 'tamu/' . $fileName;
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Gagal menyimpan live capture tamu: ' . $e->getMessage());
            }
        }

        if (! $fotoPath) {
            $pesanFoto = 'Foto presensi / swafoto wajib diambil melalui kamera atau diunggah.';
            if (! $request->wantsJson()) {
                return back()->withErrors(['foto' => $pesanFoto])->withInput();
            }
            return response()->json(['success' => false, 'message' => $pesanFoto], 400);
        }

        $validated['foto_selfie'] = $fotoPath;
        unset($validated['foto'], $validated['foto_captured'], $validated['tanda_tangan']);

        if (empty($validated['lokasi_presensi'])) {
            $validated['lokasi_presensi'] = $agenda?->lokasi ?: 'Dinas Komunikasi dan Informasi Kabupaten Bogor, Jalan Tegar Beriman, Pakansari, Cibinong, Bogor, Jawa Barat';
        }

        $idTamu = DB::table('sirapi_md_tamu')->insertGetId(array_merge($validated, [
            'created_at' => now(),
            'updated_at' => now()
        ]));

        $redirectUrl = route('publik.agenda.detail', $validated['id_agenda']);

        if (! $request->wantsJson() && !$request->ajax()) {
            return redirect($redirectUrl)->with('success', 'Data kehadiran tamu berhasil disimpan!');
        }

        return response()->json([
            'success' => true,
            'message' => 'Data kehadiran tamu berhasil disimpan!',
            'id_non_pegawai' => $idTamu,
            'nama' => $validated['nama'],
            'redirect_url' => $redirectUrl
        ], 201);
    }
}
