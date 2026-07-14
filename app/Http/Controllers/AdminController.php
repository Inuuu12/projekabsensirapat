<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agenda;
use App\Models\Aduan;
use App\Models\Logbook;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    // AUTHENTICATION
    // + login()
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $credentials['username'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'admin'   => $admin
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Kredensial salah.'], 401);
    }

    // PENGATURAN AGENDA (Sesuai Class Agenda & Admin)

    // + kelola_Agenda() -> Gabungan tambah, lihat, dan update agenda
    public function kelola_Agenda(Request $request)
    {
        $validated = $request->validate([
            'nama_agenda' => 'required|string|max:255',
            'tanggal'     => 'required|date',
            'waktu'       => 'required',
            'lokasi'      => 'required|string',
        ]);

        $agenda = Agenda::create($validated);
        return response()->json(['message' => 'Agenda berhasil dikelola/ditambahkan', 'data' => $agenda]);
    }

    // + lihat_Agenda()
    public function lihat_Agenda()
    {
        $agenda = Agenda::all();
        return response()->json(['success' => true, 'data' => $agenda]);
    }

    // + cari_Agenda() -> Admin juga bisa nyari internal
    public function cari_Agenda(Request $request)
    {
        $keyword = $request->query('keyword');
        $agenda = Agenda::when($keyword, function ($query, $keyword) {
            return $query->where('nama_agenda', 'like', "%{$keyword}%");
        })->get();

        return response()->json(['success' => true, 'data' => $agenda]);
    }

    // + konfigurasi_FaceRecognition()
    public function konfigurasi_FaceRecognition($id, Request $request)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->update([
            'status_qr' => $request->status_qr // set 'aktif' atau 'nonaktif'
        ]);

        return response()->json(['message' => 'Konfigurasi Face Recognition / QR diperbarui']);
    }

    // + generate_QR()
    public function generate_QR($id)
    {
        $agenda = Agenda::findOrFail($id);
        return response()->json(['message' => 'QR Code berhasil di-generate untuk ID: ' . $agenda->id_agenda]);
    }

    // + verifikasi_Kehadiran() -> Mengesahkan absensi manual/logbook oleh admin jika sistem error
    public function verifikasi_Kehadiran(Request $request)
    {
        $validated = $request->validate([
            'id_agenda' => 'required|integer',
            'catatan'   => 'required|string'
        ]);

        $log = Logbook::create([
            'id_agenda' => $validated['id_agenda'],
            'catatan'   => '[Diverifikasi Admin] ' . $validated['catatan'],
            'waktu_isi' => Carbon::now()
        ]);

        return response()->json(['message' => 'Kehadiran berhasil diverifikasi oleh admin', 'data' => $log]);
    }

    // FITUR ADUAN & KUNJUNGAN

    // + lihat_Aduan()
    public function lihat_Aduan()
    {
        $aduan = Aduan::all();
        return response()->json(['success' => true, 'data' => $aduan]);
    }

    // + verifikasi_Aduan()
    public function verifikasi_Aduan($id, Request $request)
    {
        // Validasi input agar status yang dikirimkan hanya boleh 'Di Baca' atau 'Pending'
        $request->validate([
            'status' => 'required|string|in:Pending,Di Baca'
        ]);

        $aduan = Aduan::findOrFail($id);
        $aduan->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status aduan berhasil diperbarui menjadi: ' . $aduan->status,
            'data'    => $aduan
        ]);
    }

    // + kelola_Kunjungan()
    public function kelola_Kunjungan(Request $request)
    {
        $validated = $request->validate([
            'keperluan'         => 'required|string',
            'tanggal_kunjungan' => 'required|date',
        ]);

        $kunjungan = Kunjungan::create($validated);
        return response()->json(['message' => 'Data kunjungan berhasil dikelola', 'data' => $kunjungan]);
    }

    // + cetak_Laporan()
    public function cetak_Laporan()
    {
        $logbook = Logbook::all();
        return response()->json(['message' => 'Laporan logbook berhasil ditarik', 'data' => $logbook]);
    }
}
