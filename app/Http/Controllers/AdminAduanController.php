<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;

class AdminAduanController extends Controller
{
    public function lihat_Aduan()
    {
        $aduan = Aduan::all();

        return response()->json(['success' => true, 'data' => $aduan]);
    }

    public function verifikasi_Aduan($id, Request $request)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Di Baca',
        ]);

        $aduan = Aduan::findOrFail($id);
        $aduan->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status aduan berhasil diperbarui menjadi: ' . $aduan->status,
            'data' => $aduan,
        ]);
    }
}
