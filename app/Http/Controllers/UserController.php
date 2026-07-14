<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Agenda; // Pastikan model agenda merujuk ke tabel tunggal 'agenda'

class UserController extends Controller
{
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
        $totalAgenda = DB::table('agenda')->count();
        $totalAduan = DB::table('aduan')->count();

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
        $agenda = DB::table('agenda')->select('id_agenda', 'judul', 'tanggal', 'waktu', 'lokasi')->get();
        return response()->json(['success' => true, 'data' => $agenda]);
    }

    public function CariAgenda(Request $request)
    {
        $keyword = $request->query('keyword');
        $agenda = DB::table('agenda')
            ->where('judul', 'like', "%{$keyword}%")
            ->orWhere('lokasi', 'like', "%{$keyword}%")
            ->get();

        return response()->json(['success' => true, 'results' => $agenda]);
    }

    public function tampilkanQrKode($id)
    {
        // Mendapatkan / simulasi path gambar QR code untuk agenda tertentu
        return response()->json([
            'success' => true,
            'id_agenda' => $id,
            'qr_code_url' => url("/storage/qrcodes/agenda-{$id}.png")
        ]);
    }

    // 3. CLASS ADUAN
    public function kirimAduan(Request $request)
    {
        $validated = $request->validate([
            'Nama_Pengadu' => 'required|string|max:255',
            'isi_Aduan'    => 'required|string',
        ]);

        $idAduan = DB::table('aduan')->insertGetId([
            'Nama_Pengadu' => $validated['Nama_Pengadu'],
            'isi_Aduan'    => $validated['isi_Aduan'],
            'status'       => 'Pending',
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Aduan berhasil dikirim!',
            'id_aduan' => $idAduan
        ], 201);
    }

    public function cekStatusAduan($id)
    {
        $aduan = DB::table('aduan')->where('id_Aduan', $id)->first();

        if (!$aduan) {
            return response()->json(['success' => false, 'message' => 'Data aduan tidak ditemukan.'], 404);
        }

        return response()->json(['success' => true, 'status' => $aduan->status]);
    }

    // 4. CLASS NON_PEGAWAI (TAMU EXSTERNAL)
    public function inputDataTamu(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string',
            'no_hp'         => 'required|string',
            'asal_instansi' => 'required|string',
            'id_agenda'     => 'required|integer',
            'foto_selfie'   => 'nullable|string',      // Menerima file path atau base64 string
            'tanda_tangan'  => 'nullable|string',     // Menerima data koordinat canvas / base64 string
        ]);

        $idTamu = DB::table('non_pipegawai')->insertGetId(array_merge($validated, [
            'created_at' => now(),
            'updated_at' => now()
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Data kehadiran tamu berhasil disimpan!',
            'id_non_pegawai' => $idTamu
        ], 201);
    }
}
