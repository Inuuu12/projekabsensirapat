<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;

class AduanController extends Controller
{
    // fungsi buat user umum ngirim aduan baru
    public function kirim_Aduan(Request $request)
    {
        // validasi inputan form pengaduan
        $validated = $request->validate([
            'nama_pengadu' => 'required|string|max:255',
            'isi_aduan'    => 'required|string',
        ]);

        // simpan ke DB, status otomatis diset 'pending' bawaan migrasi
        $aduan = Aduan::create([
            'nama_pengadu' => $validated['nama_pengadu'],
            'isi_aduan'    => $validated['isi_aduan'],
            'status'       => 'pending'
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Aduan kamu udah kekirim!',
            'id_aduan' => $aduan->id_aduan
        ], 201);
    }

    // fungsi buat masyarakat ngecek status aduannya udah diproses atau belum
    public function cek_StatusAduan($id)
    {
        // cari data aduannya berdasarkan ID
        $aduan = Aduan::findOrFail($id);

        return response()->json([
            'success' => true,
            'status'  => $aduan->status
        ]);
    }
}
