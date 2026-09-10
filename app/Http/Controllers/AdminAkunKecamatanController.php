<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAkunKecamatanController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $keyword = trim((string) $request->query('keyword', ''));
        $kecamatanFilter = (string) $request->query('kecamatan', 'semua');
        $statusFilter = (string) $request->query('status', 'semua');

        $akunList = Admin::with('kecamatan')
            ->where('role', 'kecamatan')
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($search) use ($keyword) {
                    $search->where('nama', 'like', "%{$keyword}%")
                        ->orWhere('username', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%")
                        ->orWhere('nomor_hp', 'like', "%{$keyword}%")
                        ->orWhereHas('kecamatan', function ($q) use ($keyword) {
                            $q->where('nama_kecamatan', 'like', "%{$keyword}%");
                        });
                });
            })
            ->when($kecamatanFilter !== 'semua', fn ($query) => $query->where('id_kecamatan', $kecamatanFilter))
            ->when($statusFilter !== 'semua', fn ($query) => $query->where('status', $statusFilter))
            ->latest('id_admin')
            ->get();

        $totalAkun = Admin::where('role', 'kecamatan')->count();
        $totalAktif = Admin::where('role', 'kecamatan')->where('status', 'aktif')->count();
        $totalNonaktif = Admin::where('role', 'kecamatan')->where('status', 'nonaktif')->count();
        $masterKecamatan = Kecamatan::orderBy('nama_kecamatan')->get();

        return view('admin.akun.kecamatan.index', compact(
            'admin',
            'akunList',
            'totalAkun',
            'totalAktif',
            'totalNonaktif',
            'keyword',
            'kecamatanFilter',
            'statusFilter',
            'masterKecamatan'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:sirapi_md_admin,username',
            'password' => 'required|string|min:6',
            'id_kecamatan' => 'required|exists:sirapi_md_kecamatan,id_kecamatan',
            'email' => 'nullable|email|max:255',
            'nomor_hp' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $validated['role'] = 'kecamatan';
        $validated['password'] = Hash::make($validated['password']);

        Admin::create($validated);

        return back()->with('success', 'Akun Kecamatan berhasil dibuat.');
    }

    public function update($id, Request $request)
    {
        $akun = Admin::where('role', 'kecamatan')->findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:sirapi_md_admin,username,' . $id . ',id_admin',
            'id_kecamatan' => 'required|exists:sirapi_md_kecamatan,id_kecamatan',
            'email' => 'nullable|email|max:255',
            'nomor_hp' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif',
            'password' => 'nullable|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $akun->update($validated);

        return back()->with('success', 'Data Akun Kecamatan berhasil diperbarui.');
    }

    public function resetPassword($id, Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:6',
        ]);

        $akun = Admin::where('role', 'kecamatan')->findOrFail($id);
        $akun->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return back()->with('success', 'Password akun Kecamatan berhasil direset.');
    }

    public function destroy($id)
    {
        Admin::where('role', 'kecamatan')->findOrFail($id)->delete();

        return back()->with('success', 'Akun Kecamatan berhasil dihapus.');
    }
}
