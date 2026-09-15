<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminKecamatanDataController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $keyword = trim((string) $request->query('keyword', ''));

        $kecamatanList = Kecamatan::query()
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($search) use ($keyword) {
                    $search->where('nama_kecamatan', 'like', "%{$keyword}%")
                        ->orWhere('kode_kecamatan', 'like', "%{$keyword}%")
                        ->orWhere('alamat_kantor', 'like', "%{$keyword}%")
                        ->orWhere('telepon', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%")
                        ->orWhere('camat', 'like', "%{$keyword}%");
                });
            })
            ->latest('id_kecamatan')
            ->get();

        $totalKecamatan = Kecamatan::count();

        return view('admin.kecamatan.data', compact(
            'admin',
            'kecamatanList',
            'totalKecamatan',
            'keyword'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kecamatan' => 'nullable|string|max:50|unique:sirapi_md_kecamatan,kode_kecamatan',
            'nama_kecamatan' => 'required|string|max:255',
            'alamat_kantor' => 'nullable|string',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'camat' => 'nullable|string|max:255',
        ]);

        $kecamatan = Kecamatan::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Data Kecamatan berhasil ditambahkan', 'data' => $kecamatan]);
        }

        return back()->with('success', 'Master data Kecamatan berhasil ditambahkan.');
    }

    public function update($id, Request $request)
    {
        $kecamatan = Kecamatan::findOrFail($id);

        $validated = $request->validate([
            'kode_kecamatan' => 'nullable|string|max:50|unique:sirapi_md_kecamatan,kode_kecamatan,' . $id . ',id_kecamatan',
            'nama_kecamatan' => 'required|string|max:255',
            'alamat_kantor' => 'nullable|string',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'camat' => 'nullable|string|max:255',
        ]);

        $kecamatan->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Data Kecamatan berhasil diperbarui', 'data' => $kecamatan]);
        }

        return back()->with('success', 'Master data Kecamatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kecamatan::findOrFail($id)->delete();

        return back()->with('success', 'Master data Kecamatan berhasil dihapus.');
    }
}
