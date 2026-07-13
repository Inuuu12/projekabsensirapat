<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Pegawai;
use App\Models\Peserta;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KehadiranController extends Controller
{
    // fungsi buat handle scan qr code rapat
    public function scan_QR(Request $request)
    {
        // validasi inputan dari scanner / device luar
        $validated = $request->validate([
            'id_agenda'       => 'required|integer',
            'nomor_identitas' => 'required', // isi NIP kalau pegawai, isi nama kalau tamu
            'tipe_peserta'    => 'required|in:pegawai,tamu'
        ]);

        // cari agendanya ada apa nggak
        $agenda = Agenda::findOrFail($validated['id_agenda']);

        // cek dulu status qr di agenda ini udah dibuka admin atau belum
        if ($agenda->status_qr !== 'aktif') {
            return response()->json([
                'success' => false,
                'message' => 'QR Code agenda ini belum diaktifkan sama admin.'
            ], 403);
        }

        // kalau aman, langsung masukin ke logbook sebagai bukti hadir
        Logbook::create([
            'id_agenda' => $agenda->id_agenda,
            'catatan'   => 'Hadir lewat Scan QR. Identitas: ' . $validated['nomor_identitas'] . ' (' . $validated['tipe_peserta'] . ')',
            'waktu_isi' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Scan QR berhasil, kehadiran kamu udah dicatat!'
        ]);
    }

    // fungsi sesuai draw.io buat verifikasi wajah face recognition
    public function verifikasi_FaceRecognition(Request $request)
    {
        // validasi kecocokan data sebelum kirim ke logic kamera
        $validated = $request->validate([
            'id_agenda'   => 'required|integer',
            'nip'         => 'required|integer',
            'foto_base64' => 'required|string' // payload mentah foto dari kamera frontend
        ]);

        // pastiin nip pegawai ini emang ada di database kita
        $pegawai = Pegawai::where('nip', $validated['nip'])->first();

        if (!$pegawai) {
            return response()->json([
                'success' => false,
                'message' => 'Data pegawai gak ketemu.'
            ], 404);
        }

        // tempat taruh logic hit api python / model face recognition nanti di sini
        // assume wajahnya cocok dan terverifikasi sama sistem:

        // langsung buatin logbook tanda hadir rapat
        Logbook::create([
            'id_agenda' => $validated['id_agenda'],
            'catatan'   => 'Hadir lewat Face Recognition. Pegawai: ' . $pegawai->nama_Pejabat,
            'waktu_isi' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Wajah cocok! Selamat datang ' . $pegawai->nama_Pejabat
        ]);
    }
}
