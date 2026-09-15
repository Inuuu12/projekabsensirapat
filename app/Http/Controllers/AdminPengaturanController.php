<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Services\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPengaturanController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('admin.dashboard', ['tab' => $request->query('tab', 'publik')]);
    }

    public function updatePublik(Request $request)
    {
        $validated = $request->validate([
            'alamat' => 'required|string|max:500',
            'telepon' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'instagram_url' => 'nullable|url|max:500',
            'facebook_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
        ]);

        AppSetting::setMany([
            'sirapi_alamat' => $validated['alamat'],
            'sirapi_telepon' => $validated['telepon'],
            'sirapi_email' => $validated['email'],
            'sirapi_instagram_url' => $validated['instagram_url'] ?? '',
            'sirapi_facebook_url' => $validated['facebook_url'] ?? '',
            'sirapi_youtube_channel_url' => $validated['youtube_url'] ?? '',
        ]);

        return back()->with('setting_tab', 'publik')
            ->with('success', 'Pengaturan publik berhasil diperbarui!');
    }

    public function storeBidang(Request $request)
    {
        $validated = $request->validate([
            'nama_bidang' => 'required|string|max:255|unique:sirapi_md_bidang,nama_bidang',
        ]);

        Bidang::create($validated);

        return back()->with('setting_tab', 'admin')
            ->with('success', 'Bidang berhasil ditambahkan.');
    }

    public function destroyBidang(int $id)
    {
        $bidang = Bidang::findOrFail($id);

        if (Pegawai::where('bidang', $bidang->nama_bidang)->exists()) {
            return back()->with('setting_tab', 'admin')
                ->with('error', 'Bidang masih digunakan pegawai.');
        }

        $bidang->delete();

        return back()->with('setting_tab', 'admin')
            ->with('success', 'Bidang berhasil dihapus.');
    }

    public function storeJabatan(Request $request)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:sirapi_md_jabatan,nama_jabatan',
            'kategori' => 'nullable|string|max:255',
        ]);

        Jabatan::create($validated);

        return back()->with('setting_tab', 'admin')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function destroyJabatan(int $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        if (Pegawai::where('jabatan', $jabatan->nama_jabatan)->exists()) {
            return back()->with('setting_tab', 'admin')
                ->with('error', 'Jabatan masih digunakan pegawai.');
        }

        $jabatan->delete();

        return back()->with('setting_tab', 'admin')
            ->with('success', 'Jabatan berhasil dihapus.');
    }
}
