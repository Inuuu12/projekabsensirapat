<?php

namespace App\Http\Controllers;

use App\Models\Dinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDinasController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $keyword = trim((string) $request->query('keyword', ''));

        $dinasList = Dinas::query()
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($search) use ($keyword) {
                    $search->where('nama_dinas', 'like', "%{$keyword}%")
                        ->orWhere('kode_dinas', 'like', "%{$keyword}%")
                        ->orWhere('alamat', 'like', "%{$keyword}%")
                        ->orWhere('telepon', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%")
                        ->orWhere('kepala_dinas', 'like', "%{$keyword}%");
                });
            })
            ->latest('id_dinas')
            ->get();

        $totalDinas = Dinas::count();

        return view('admin.dinas.index', compact(
            'admin',
            'dinasList',
            'totalDinas',
            'keyword'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_dinas' => 'nullable|string|max:50|unique:sirapi_md_dinas,kode_dinas',
            'nama_dinas' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'kepala_dinas' => 'nullable|string|max:255',
        ]);

        $dinas = Dinas::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Data dinas berhasil ditambahkan', 'data' => $dinas]);
        }

        return back()->with('success', 'Master data Dinas berhasil ditambahkan.');
    }

    public function update($id, Request $request)
    {
        $dinas = Dinas::findOrFail($id);

        $validated = $request->validate([
            'kode_dinas' => 'nullable|string|max:50|unique:sirapi_md_dinas,kode_dinas,' . $id . ',id_dinas',
            'nama_dinas' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'kepala_dinas' => 'nullable|string|max:255',
        ]);

        $dinas->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Data dinas berhasil diperbarui', 'data' => $dinas]);
        }

        return back()->with('success', 'Master data Dinas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Dinas::findOrFail($id)->delete();

        return back()->with('success', 'Master data Dinas berhasil dihapus.');
    }
}
