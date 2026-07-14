<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;

class AduanController extends Controller
{
    // fungsi buat user umum ngirim aduan baru
    public function kirim_Aduan(Request $request)
    {
        // validasi inputan form pengaduan (tetap pakai lowercase untuk request input)
        $validated = $request->validate([
            'nama_pengadu' => 'required|string|max:255',
            'isi_aduan'    => 'required|string',
        ]);

        // SIMPAN KE DB: Sesuaikan nama kolom dengan database (Nama_Pengadu & isi_Aduan)
        $aduan = Aduan::create([
            'Nama_Pengadu' => $validated['nama_pengadu'], // Memetakan request ke kolom DB
            'isi_Aduan'    => $validated['isi_aduan'],    // Memetakan request ke kolom DB
            'status'       => 'Pending'                  // Kita buat huruf depan kapital 'Pending' agar rapi
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Aduan anda udah kekirim!',
            'id_aduan' => $aduan->id_Aduan // Sesuaikan 'id_Aduan' (A kapital)
        ], 201);
    }

    // fungsi buat masyarakat ngecek status aduannya udah diproses atau belum
    public function cek_StatusAduan($id)
    {
        // cari data aduannya berdasarkan ID (Laravel otomatis mencari berdasarkan PK 'id_Aduan' yang diset di Model)
        $aduan = Aduan::findOrFail($id);

        return response()->json([
            'success' => true,
            'status'  => $aduan->status
        ]);
    }
}
