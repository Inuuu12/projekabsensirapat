<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agenda;
use App\Models\Aduan;
use App\Models\Logbook;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // 1. + login()
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

    // 2. + tambah_Agenda()
    public function tambah_Agenda(Request $request)
    {
        $validated = $request->validate([
            'nama_agenda' => 'required|string|max:255',
            'tanggal'     => 'required|date',
            'waktu'       => 'required',
            'lokasi'      => 'required|string',
        ]);

        $agenda = Agenda::create($validated);
        return response()->json(['message' => 'Agenda berhasil ditambahkan', 'data' => $agenda]);
    }

    // 3. + lihat_Agenda()
    public function lihat_Agenda()
    {
        $agenda = Agenda::all();
        return response()->json(['success' => true, 'data' => $agenda]);
    }

    // 4. + konfigurasi_FaceRecognition()
    public function konfigurasi_FaceRecognition($id, Request $request)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->update([
            'status_qr' => $request->status_qr
        ]);

        return response()->json(['message' => 'Konfigurasi Face Recognition diperbarui']);
    }

    // 5. + generate_QR()
    public function generate_QR($id)
    {
        $agenda = Agenda::findOrFail($id);
        return response()->json(['message' => 'QR Code berhasil di-generate untuk ID: ' . $agenda->id_agenda]);
    }

    // 6. + verifikasi_Aduan()
    public function verifikasi_Aduan($id, Request $request)
    {
        $request->validate(['status' => 'required|string']);

        $aduan = Aduan::findOrFail($id);
        $aduan->update(['status' => $request->status]);

        return response()->json(['message' => 'Aduan berhasil diverifikasi']);
    }

    // 7. + lihat_Aduan()
    public function lihat_Aduan()
    {
        $aduan = Aduan::all();
        return response()->json(['success' => true, 'data' => $aduan]);
    }

    // 8. + kelola_Kunjungan()
    public function kelola_Kunjungan(Request $request)
    {
        $validated = $request->validate([
            'keperluan'         => 'required|string',
            'tanggal_kunjungan' => 'required|date',
        ]);

        $kunjungan = Kunjungan::create($validated);
        return response()->json(['message' => 'Data kunjungan berhasil dikelola oleh Admin', 'data' => $kunjungan]);
    }

    // 9. + cetak_Laporan()
    public function cetak_Laporan()
    {
        $logbook = Logbook::all();
        return response()->json(['message' => 'Laporan berhasil dicetak', 'data' => $logbook]);
    }
}
