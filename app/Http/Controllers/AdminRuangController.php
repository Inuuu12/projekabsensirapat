<?php

namespace App\Http\Controllers;

use App\Models\RuangRapat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRuangController extends Controller
{
    public function daftarRuang()
    {
        $admin = Auth::guard('admin')->user();
        $ruang = RuangRapat::latest('id_ruangrapat')->get();

        return view('admin.ruang.index', compact('admin', 'ruang'));
    }

    public function store_Ruang(Request $request)
    {
        RuangRapat::create($request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255',
        ]));

        return back()->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function update_Ruang($id, Request $request)
    {
        RuangRapat::findOrFail($id)->update($request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255',
        ]));

        return back()->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function hapus_Ruang($id)
    {
        RuangRapat::findOrFail($id)->delete();

        return back()->with('success', 'Ruangan berhasil dihapus.');
    }
}
