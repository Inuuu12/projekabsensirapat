<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\Http\Request;

class TamuController extends Controller
{
    /**
     * Tampilkan halaman daftar tamu.
     */
    public function index()
    {
        // Ambil data tamu, diurutkan dari yang terbaru dengan pagination
        $tamu = Tamu::latest('id_tamu')->paginate(10); // Ganti 'id_tamu' sesuai primary key tabel tamu lu
        
        return view('admin.tamu.index', compact('tamu'));
    }

    /**
     * Simpan data tamu baru (dari Modal Tambah).
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'instansi'  => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
            'nomor_hp'  => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:255',
        ]);

        Tamu::create($validatedData);

        return redirect()->route('tamu.index')->with('success', 'Data tamu berhasil ditambahkan.');
    }

    /**
     * Update data tamu (dari Modal Edit).
     */
    public function update(Request $request, Tamu $tamu)
    {
        $validatedData = $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'instansi'  => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
            'nomor_hp'  => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:255',
        ]);

        $tamu->update($validatedData);

        return redirect()->route('tamu.index')->with('success', 'Data tamu berhasil diubah.');
    }

    /**
     * Hapus data tamu.
     */
    public function destroy(Tamu $tamu)
    {
        $tamu->delete();

        return redirect()->route('tamu.index')->with('success', 'Data tamu berhasil dihapus.');
    }
}