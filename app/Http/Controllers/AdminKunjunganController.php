<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminKunjunganController extends Controller
{
    public function daftarKunjungan()
    {
        $admin = Auth::guard('admin')->user();
        $kunjungan = Kunjungan::latest('id_kunjungan')->get();

        return view('admin.kunjungan.index', compact('admin', 'kunjungan'));
    }

    public function kelola_Kunjungan(Request $request)
    {
        $validated = $request->validate([
            'nama_pejabat' => 'nullable|string|max:255',
            'nama_pengunjung' => 'nullable|string|max:255',
            'asal_instansi' => 'nullable|string|max:255',
            'nomorhp_pengunjung' => 'nullable|string|max:30',
            'email_pengunjung' => 'nullable|email|max:255|unique:app_md_kunjungan,email_pengunjung',
            'keperluan' => 'required|string',
            'waktu' => 'nullable|date_format:H:i',
            'tanggal_kunjungan' => 'required|date',
        ]);
        $validated['id_admin'] = Auth::guard('admin')->id();

        $kunjungan = Kunjungan::create($validated);
        if (! $request->wantsJson()) {
            return back()->with('success', 'Kunjungan berhasil ditambahkan.');
        }

        return response()->json(['message' => 'Data kunjungan berhasil dikelola', 'data' => $kunjungan]);
    }

    public function update_Kunjungan($id, Request $request)
    {
        $validated = $request->validate([
            'nama_pejabat' => 'nullable|string|max:255',
            'nama_pengunjung' => 'nullable|string|max:255',
            'asal_instansi' => 'nullable|string|max:255',
            'nomorhp_pengunjung' => 'nullable|string|max:30',
            'email_pengunjung' => 'nullable|email|max:255|unique:app_md_kunjungan,email_pengunjung,' . $id . ',id_kunjungan',
            'keperluan' => 'required|string',
            'waktu' => 'nullable|date_format:H:i',
            'tanggal_kunjungan' => 'required|date',
        ]);

        Kunjungan::findOrFail($id)->update($validated);

        return back()->with('success', 'Kunjungan berhasil diperbarui.');
    }

    public function hapus_Kunjungan($id)
    {
        Kunjungan::findOrFail($id)->delete();

        return back()->with('success', 'Kunjungan berhasil dihapus.');
    }
}
