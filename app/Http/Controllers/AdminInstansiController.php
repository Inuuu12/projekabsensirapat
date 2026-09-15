<?php

namespace App\Http\Controllers;

use App\Models\Dinas;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminInstansiController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $tab = $request->query('tab', 'dinas');
        $keyword = trim((string) $request->query('keyword', ''));

        if ($tab === 'kecamatan') {
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
            $dinasList = collect();
            $totalDinas = Dinas::count();
        } else {
            $tab = 'dinas';
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
            $kecamatanList = collect();
            $totalKecamatan = Kecamatan::count();
        }

        return view('admin.instansi.index', compact(
            'admin',
            'tab',
            'dinasList',
            'totalDinas',
            'kecamatanList',
            'totalKecamatan',
            'keyword'
        ));
    }

    public function storeDinas(Request $request)
    {
        $validated = $request->validate([
            'kode_dinas' => 'nullable|string|max:50|unique:sirapi_md_dinas,kode_dinas',
            'nama_dinas' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'kepala_dinas' => 'nullable|string|max:255',
        ]);

        Dinas::create($validated);

        return redirect()->route('admin.instansi.index', ['tab' => 'dinas'])
            ->with('success', 'Master data Dinas berhasil ditambahkan.');
    }

    public function updateDinas($id, Request $request)
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

        return redirect()->route('admin.instansi.index', ['tab' => 'dinas'])
            ->with('success', 'Master data Dinas berhasil diperbarui.');
    }

    public function destroyDinas($id)
    {
        Dinas::findOrFail($id)->delete();

        return redirect()->route('admin.instansi.index', ['tab' => 'dinas'])
            ->with('success', 'Master data Dinas berhasil dihapus.');
    }

    public function storeKecamatan(Request $request)
    {
        $validated = $request->validate([
            'kode_kecamatan' => 'nullable|string|max:50|unique:sirapi_md_kecamatan,kode_kecamatan',
            'nama_kecamatan' => 'required|string|max:255',
            'alamat_kantor' => 'nullable|string',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'camat' => 'nullable|string|max:255',
        ]);

        Kecamatan::create($validated);

        return redirect()->route('admin.instansi.index', ['tab' => 'kecamatan'])
            ->with('success', 'Master data Kecamatan berhasil ditambahkan.');
    }

    public function updateKecamatan($id, Request $request)
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

        return redirect()->route('admin.instansi.index', ['tab' => 'kecamatan'])
            ->with('success', 'Master data Kecamatan berhasil diperbarui.');
    }

    public function destroyKecamatan($id)
    {
        Kecamatan::findOrFail($id)->delete();

        return redirect()->route('admin.instansi.index', ['tab' => 'kecamatan'])
            ->with('success', 'Master data Kecamatan berhasil dihapus.');
    }
}
