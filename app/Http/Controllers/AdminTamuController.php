<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminTamuController extends Controller
{
    public function dataTamu()
    {
        $admin = Auth::guard('admin')->user();
        $tamu = Tamu::latest('id_tamu')->get();
        $agenda = Agenda::latest('id_agenda')->get();

        return view('admin.tamu.index', compact('admin', 'tamu', 'agenda'));
    }

    public function store_Tamu(Request $request)
    {
        $validated = $request->validate([
            'foto_selfie' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:255',
            'no_hp' => 'required|string|max:30',
            'asal_instansi' => 'required|string|max:255',
            'id_agenda' => 'required|exists:app_md_agenda,id_agenda',
        ]);
        if ($request->hasFile('foto_selfie')) {
            $validated['foto_selfie'] = $request->file('foto_selfie')->store('tamu', 'public');
        }
        Tamu::create($validated);

        return back()->with('success', 'Tamu berhasil ditambahkan.');
    }

    public function update_Tamu($id, Request $request)
{
    $tamu = Tamu::findOrFail($id);

    // 1. SIMPAN HASIL VALIDASI KE DALAAM VARIABEL $validated
    $validated = $request->validate([
        'foto_selfie'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'nama'          => 'required|string|max:255',
        'nik'           => 'nullable|string|max:50',
        'jabatan'       => 'nullable|string|max:255',
        'no_hp'         => 'required|string|max:30',
        'asal_instansi' => 'required|string|max:255',
        'id_agenda'     => 'required|exists:app_md_agenda,id_agenda',
    ]);

    // 2. PROSES UPLOAD FOTO JIKA ADA FILE BARU
    if ($request->hasFile('foto_selfie')) {
        // Hapus foto lama jika ada
        if ($tamu->foto_selfie && Storage::disk('public')->exists($tamu->foto_selfie)) {
            Storage::disk('public')->delete($tamu->foto_selfie);
        }

        // Simpan foto baru ke array $validated
        $validated['foto_selfie'] = $request->file('foto_selfie')->store('tamu', 'public');
    } else {
        // Hapus key foto_selfie agar tidak menimpa foto lama dengan NULL jika user tidak upload foto baru
        unset($validated['foto_selfie']);
    }

    // 3. UPDATE DATA TAMU DENGAN $validated
    $tamu->update($validated);

    return back()->with('success', 'Data tamu berhasil diperbarui!');
}
    public function hapus_Tamu($id)
    {
        Tamu::findOrFail($id)->delete();

        return back()->with('success', 'Tamu berhasil dihapus.');
    }
}
