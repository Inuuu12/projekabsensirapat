<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminKunjunganController extends Controller
{
    public function daftarKunjungan(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $keyword = trim((string) $request->query('keyword', ''));
        $pihakDitujuFilter = (string) $request->query('pihak_dituju', 'semua');
        $keperluanFilter = (string) $request->query('keperluan', 'semua');
        $tanggalFilter = (string) $request->query('tanggal', '');

        $hasNamaPegawai = \Illuminate\Support\Facades\Schema::hasColumn('app_md_kunjungan', 'nama_pegawai');
        $colPegawai = $hasNamaPegawai ? 'nama_pegawai' : 'nama_pejabat';

        $kunjungan = Kunjungan::query()
            ->when($keyword !== '', function ($query) use ($keyword, $colPegawai) {
                $query->where(function ($search) use ($keyword, $colPegawai) {
                    $search->where('nama_pengunjung', 'like', "%{$keyword}%")
                        ->orWhere($colPegawai, 'like', "%{$keyword}%")
                        ->orWhere('asal_instansi', 'like', "%{$keyword}%")
                        ->orWhere('nomorhp_pengunjung', 'like', "%{$keyword}%")
                        ->orWhere('email_pengunjung', 'like', "%{$keyword}%")
                        ->orWhere('keperluan', 'like', "%{$keyword}%");
                });
            })
            ->when($pihakDitujuFilter !== 'semua', fn ($query) => $query->where($colPegawai, $pihakDitujuFilter))
            ->when($keperluanFilter !== 'semua', fn ($query) => $query->where('keperluan', $keperluanFilter))
            ->when($tanggalFilter !== '', fn ($query) => $query->whereDate('tanggal_kunjungan', $tanggalFilter))
            ->latest('id_kunjungan')
            ->get();
        $totalKunjungan = Kunjungan::count();
        $pihakDitujuOptions = Kunjungan::query()
            ->whereNotNull($colPegawai)
            ->where($colPegawai, '!=', '')
            ->distinct()
            ->orderBy($colPegawai)
            ->pluck($colPegawai);
        $keperluanOptions = Kunjungan::query()
            ->whereNotNull('keperluan')
            ->where('keperluan', '!=', '')
            ->distinct()
            ->orderBy('keperluan')
            ->pluck('keperluan');
        $pegawaiList = \App\Models\Pegawai::orderBy('nama_pegawai')->get();

        return view('admin.kunjungan.index', compact(
            'admin',
            'kunjungan',
            'totalKunjungan',
            'keyword',
            'pihakDitujuFilter',
            'keperluanFilter',
            'tanggalFilter',
            'pihakDitujuOptions',
            'keperluanOptions',
            'pegawaiList'
        ));
    }

    public function kelola_Kunjungan(Request $request)
    {
        $namaPegawai = $request->input('nama_pegawai') ?: $request->input('nama_pejabat');
        $request->merge(['nama_pegawai' => $namaPegawai, 'nama_pejabat' => $namaPegawai]);

        $validated = $request->validate([
            'nama_pegawai' => 'nullable|string|max:255',
            'nama_pejabat' => 'nullable|string|max:255',
            'nama_pengunjung' => 'nullable|string|max:255',
            'asal_instansi' => 'nullable|string|max:255',
            'nomorhp_pengunjung' => 'nullable|string|max:13|regex:/^[0-9]+$/',
            'email_pengunjung' => 'nullable|email|max:255',
            'keperluan' => 'required|string',
            'waktu' => 'nullable',
            'tanggal_kunjungan' => 'required|date',
        ]);
        $validated['id_admin'] = Auth::guard('admin')->id();

        $kunjungan = Kunjungan::create($validated);
        if (! $request->wantsJson()) {
            return back()->with('success', 'Kunjungan berhasil ditambahkan.');
        }

        return response()->json(['message' => 'Data kunjungan berhasil dikelola', 'data' => $kunjungan]);
    }

    public function update_Kunjungan($id, Request $request)
    {
        $namaPegawai = $request->input('nama_pegawai') ?: $request->input('nama_pejabat');
        $request->merge(['nama_pegawai' => $namaPegawai, 'nama_pejabat' => $namaPegawai]);

        $validated = $request->validate([
            'nama_pegawai' => 'nullable|string|max:255',
            'nama_pejabat' => 'nullable|string|max:255',
            'nama_pengunjung' => 'nullable|string|max:255',
            'asal_instansi' => 'nullable|string|max:255',
            'nomorhp_pengunjung' => 'nullable|string|max:13|regex:/^[0-9]+$/',
            'email_pengunjung' => 'nullable|email|max:255',
            'keperluan' => 'required|string',
            'waktu' => 'nullable',
            'tanggal_kunjungan' => 'required|date',
        ]);

        Kunjungan::findOrFail($id)->update($validated);

        return back()->with('success', 'Kunjungan berhasil diperbarui.');
    }

    public function hapus_Kunjungan($id)
    {
        Kunjungan::findOrFail($id)->delete();

        return back()->with('success', 'Kunjungan berhasil dihapus.');
    }
}
