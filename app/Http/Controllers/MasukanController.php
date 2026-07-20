<?php

namespace App\Http\Controllers;

use App\Models\Masukan;
use Illuminate\Http\Request;

class MasukanController extends Controller
{
    public function kirimMasukan(Request $request)
    {
        $masukan = Masukan::kirimMasukan($request->validate([
            'nama_pengadu' => ['nullable', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'isi_masukan' => ['required', 'string'],
            'lampiran' => ['nullable', 'string', 'max:255'],
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Masukan berhasil dikirim.',
            'id_masukan' => $masukan->id_masukan,
        ], 201);
    }

    public function cekStatusMasukan(int $id)
    {
        $masukan = Masukan::with('statusMasukan')->findOrFail($id);

        return response()->json([
            'success' => true,
            'status' => $masukan->statusMasukan?->nama_status ?? $masukan->status,
            'balasan_admin' => $masukan->balasan_admin,
            'waktu_proses' => $masukan->waktu_proses,
            'waktu_selesai' => $masukan->waktu_selesai,
        ]);
    }
}
