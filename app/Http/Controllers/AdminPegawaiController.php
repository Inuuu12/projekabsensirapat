<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminPegawaiController extends Controller
{
    public function dataPegawai()
    {
        $admin = Auth::guard('admin')->user();
        $pegawai = Pegawai::latest('id_pegawai')->get();

        return view('admin.pegawai.index', compact('admin', 'pegawai'));
    }

    public function store_Pegawai(Request $request)
    {
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:app_md_pegawai,nip',
            'jabatan' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:30',
            'email' => 'required|email|max:255|unique:app_md_pegawai,email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        Pegawai::create($validated);

        return back()->with('success', 'Data pegawai berhasil ditambahkan!');
    }

    public function update_Pegawai($id, Request $request)
    {
        $pegawai = Pegawai::findOrFail($id);

        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:app_md_pegawai,nip,' . $id . ',id_pegawai',
            'jabatan' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:30',
            'email' => 'required|email|max:255|unique:app_md_pegawai,email,' . $id . ',id_pegawai',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        $pegawai->update($validated);

        return back()->with('success', 'Data pegawai berhasil diperbarui!');
    }

    public function hapus_Pegawai($id)
    {
        Pegawai::findOrFail($id)->delete();

        return back()->with('success', 'Pegawai berhasil dihapus.');
    }
}
