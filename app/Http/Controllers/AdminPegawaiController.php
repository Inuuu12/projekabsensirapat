<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminPegawaiController extends Controller
{
    public function dataPegawai(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $keyword = trim((string) $request->query('keyword', ''));
        $bidangFilter = (string) $request->query('bidang', 'semua');
        $jabatanFilter = (string) $request->query('jabatan', 'semua');

        $pegawaiQuery = Pegawai::query()
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($search) use ($keyword) {
                    $search->where('nama_pegawai', 'like', "%{$keyword}%")
                        ->orWhere('nip', 'like', "%{$keyword}%")
                        ->orWhere('tanggal_lahir', 'like', "%{$keyword}%")
                        ->orWhere('jabatan', 'like', "%{$keyword}%")
                        ->orWhere('bidang', 'like', "%{$keyword}%")
                        ->orWhere('nomor_hp', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%");
                });
            })
            ->when($bidangFilter !== 'semua', fn ($query) => $query->where('bidang', $bidangFilter))
            ->when($jabatanFilter !== 'semua', fn ($query) => $query->where('jabatan', $jabatanFilter));

        $pegawai = $pegawaiQuery->latest('id_pegawai')->get();
        $totalPegawai = Pegawai::count();
        $bidangOptions = Pegawai::query()
            ->whereNotNull('bidang')
            ->where('bidang', '!=', '')
            ->distinct()
            ->orderBy('bidang')
            ->pluck('bidang');
        $jabatanOptions = Pegawai::query()
            ->whereNotNull('jabatan')
            ->where('jabatan', '!=', '')
            ->distinct()
            ->orderBy('jabatan')
            ->pluck('jabatan');

        return view('admin.pegawai.index', compact(
            'admin',
            'pegawai',
            'totalPegawai',
            'keyword',
            'bidangFilter',
            'jabatanFilter',
            'bidangOptions',
            'jabatanOptions'
        ));
    }

    public function store_Pegawai(Request $request)
    {
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:app_md_pegawai,nip',
            'tanggal_lahir' => 'nullable|date',
            'jabatan' => 'required|string|max:255',
            'bidang' => 'nullable|string|max:255',
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
            'tanggal_lahir' => 'nullable|date',
            'jabatan' => 'required|string|max:255',
            'bidang' => 'nullable|string|max:255',
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
