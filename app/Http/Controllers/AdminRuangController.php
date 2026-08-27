<?php

namespace App\Http\Controllers;

use App\Models\RuangRapat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRuangController extends Controller
{
    public function daftarRuang(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $statusFilter = (string) $request->query('status', 'semua');

        $allRuang = RuangRapat::with(['agendas' => function ($query) {
            $query->whereDate('tanggal', Carbon::today(config('app.timezone', 'Asia/Jakarta')));
        }])->latest('id_ruangrapat')->get();

        $totalRuangan = $allRuang->count();
        $totalTerpakai = $allRuang->filter(fn ($item) => $item->dynamic_status === 'terpakai')->count();
        $totalTersedia = $totalRuangan - $totalTerpakai;

        $ruang = $allRuang->when($statusFilter !== 'semua', function ($collection) use ($statusFilter) {
            return $collection->filter(fn ($item) => $item->dynamic_status === $statusFilter);
        });

        return view('admin.ruang.index', compact(
            'admin',
            'ruang',
            'statusFilter',
            'totalRuangan',
            'totalTersedia',
            'totalTerpakai'
        ));
    }

    public function store_Ruang(Request $request)
    {
        RuangRapat::create($request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,terpakai',
            'keterangan' => 'required|string|max:255',
        ]));

        return back()->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function update_Ruang($id, Request $request)
    {
        RuangRapat::findOrFail($id)->update($request->validate([
            'nama_ruang' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:tersedia,terpakai',
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
