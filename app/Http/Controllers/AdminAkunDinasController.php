<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Dinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAkunDinasController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $keyword = trim((string) $request->query('keyword', ''));
        $dinasFilter = (string) $request->query('dinas', 'semua');
        $statusFilter = (string) $request->query('status', 'semua');

        $akunList = Admin::with('dinas')
            ->where('role', 'dinas')
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($search) use ($keyword) {
                    $search->where('nama', 'like', "%{$keyword}%")
                        ->orWhere('username', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%")
                        ->orWhere('nomor_hp', 'like', "%{$keyword}%")
                        ->orWhereHas('dinas', function ($q) use ($keyword) {
                            $q->where('nama_dinas', 'like', "%{$keyword}%");
                        });
                });
            })
            ->when($dinasFilter !== 'semua', fn ($query) => $query->where('id_dinas', $dinasFilter))
            ->when($statusFilter !== 'semua', fn ($query) => $query->where('status', $statusFilter))
            ->latest('id_admin')
            ->get();

        $totalAkun = Admin::where('role', 'dinas')->count();
        $totalAktif = Admin::where('role', 'dinas')->where('status', 'aktif')->count();
        $totalNonaktif = Admin::where('role', 'dinas')->where('status', 'nonaktif')->count();
        $masterDinas = Dinas::orderBy('nama_dinas')->get();

        return view('admin.akun.dinas.index', compact(
            'admin',
            'akunList',
            'totalAkun',
            'totalAktif',
            'totalNonaktif',
            'keyword',
            'dinasFilter',
            'statusFilter',
            'masterDinas'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:sirapi_md_admin,username',
            'password' => 'required|string|min:6',
            'id_dinas' => 'required|exists:sirapi_md_dinas,id_dinas',
            'email' => 'nullable|email|max:255',
            'nomor_hp' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $validated['role'] = 'dinas';
        $validated['password'] = Hash::make($validated['password']);

        Admin::create($validated);

        return back()->with('success', 'Akun Dinas berhasil dibuat.');
    }

    public function update($id, Request $request)
    {
        $akun = Admin::where('role', 'dinas')->findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:sirapi_md_admin,username,' . $id . ',id_admin',
            'id_dinas' => 'required|exists:sirapi_md_dinas,id_dinas',
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

        return back()->with('success', 'Data Akun Dinas berhasil diperbarui.');
    }

    public function resetPassword($id, Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:6',
        ]);

        $akun = Admin::where('role', 'dinas')->findOrFail($id);
        $akun->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return back()->with('success', 'Password akun Dinas berhasil direset.');
    }

    public function destroy($id)
    {
        Admin::where('role', 'dinas')->findOrFail($id)->delete();

        return back()->with('success', 'Akun Dinas berhasil dihapus.');
    }
}
