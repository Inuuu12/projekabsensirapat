<?php

namespace App\Http\Controllers;

use App\Models\DataAduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMasukkanController extends Controller
{
    public function umpanBalik()
    {
        $admin = Auth::guard('admin')->user();
        $masukan = DataAduan::latest('id_dataaduan')->get();

        return view('admin.masukkan.index', compact('admin', 'masukan'));
    }

    public function update_Masukan($id, Request $request)
    {
        DataAduan::findOrFail($id)->update($request->validate([
            'status' => 'required|string|max:50',
        ]));

        return back()->with('success', 'Status aduan berhasil diperbarui.');
    }

    public function reply_Masukan($id, Request $request)
    {
        $validated = $request->validate([
            'balasan_admin' => 'required|string|max:5000',
        ]);

        DataAduan::findOrFail($id)->update([
            'balasan_admin' => $validated['balasan_admin'],
            'status' => 'Diproses',
            'id_admin' => Auth::guard('admin')->id(),
        ]);

        return back()->with('success', 'Balasan aduan berhasil disimpan.');
    }

    public function hapus_Masukan($id)
    {
        DataAduan::findOrFail($id)->delete();

        return back()->with('success', 'Aduan berhasil dihapus.');
    }
}
