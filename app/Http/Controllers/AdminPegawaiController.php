<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPegawaiController extends Controller
{
    public function dataPegawai(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $keyword = trim((string) $request->query('keyword', ''));
        $statusFilter = (string) $request->query('status', 'semua');
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
            ->when($statusFilter !== 'semua', fn ($query) => $query->where('status_verifikasi', $statusFilter))
            ->when($bidangFilter !== 'semua', fn ($query) => $query->where('bidang', $bidangFilter))
            ->when($jabatanFilter !== 'semua', fn ($query) => $query->where('jabatan', $jabatanFilter));

        $pegawai = $pegawaiQuery->latest('id_pegawai')->get();
        $totalPegawai = Pegawai::count();
        $totalAktif = Pegawai::where('status_verifikasi', 'aktif')->count();
        $totalPending = Pegawai::where('status_verifikasi', 'pending')->count();
        $totalDitolak = Pegawai::where('status_verifikasi', 'ditolak')->count();

        $bidangMaster = Bidang::orderBy('nama_bidang')->get();
        $jabatanMaster = Jabatan::orderByRaw("
                CASE
                    WHEN kategori = 'Struktural' THEN 0
                    WHEN kategori = 'Jabatan Fungsional' THEN 1
                    ELSE 2
                END
            ")
            ->orderBy('nama_jabatan')
            ->get();
        $bidangTerpakai = Pegawai::query()
            ->whereNotNull('bidang')
            ->where('bidang', '!=', '')
            ->distinct()
            ->orderBy('bidang')
            ->pluck('bidang');
        $jabatanTerpakai = Pegawai::query()
            ->whereNotNull('jabatan')
            ->where('jabatan', '!=', '')
            ->distinct()
            ->orderBy('jabatan')
            ->pluck('jabatan');
        $bidangOptions = $bidangMaster->pluck('nama_bidang')
            ->merge($bidangTerpakai)
            ->unique()
            ->sort()
            ->values();
        $jabatanOptions = $jabatanMaster->pluck('nama_jabatan')
            ->merge($jabatanTerpakai)
            ->unique()
            ->sort()
            ->values();

        return view('admin.pegawai.index', compact(
            'admin',
            'pegawai',
            'totalPegawai',
            'totalAktif',
            'totalPending',
            'totalDitolak',
            'keyword',
            'statusFilter',
            'bidangFilter',
            'jabatanFilter',
            'bidangOptions',
            'jabatanOptions',
            'bidangMaster',
            'jabatanMaster'
        ));
    }

    public function store_Pegawai(Request $request)
    {
        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|string|max:18|regex:/^[0-9]+$/|unique:sirapi_md_pegawai,nip',
            'tanggal_lahir' => 'nullable|date',
            'jabatan' => 'required|string|max:255',
            'bidang' => 'nullable|string|max:255',
            'nomor_hp' => 'required|string|max:13|regex:/^[0-9]+$/',
            'email' => 'required|email|max:255|unique:sirapi_md_pegawai,email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        $defaultPassword = Str::password(12);
        $validated['password'] = $defaultPassword;
        $validated['status_verifikasi'] = Pegawai::STATUS_AKTIF;

        Pegawai::create($validated);

        try {
            Mail::raw(
                "Akun pegawai SIRAPI Anda sudah dibuat.\n\nEmail: {$validated['email']}\nPassword sementara: {$defaultPassword}\n\nSilakan login dan ubah password dari menu profil.",
                function ($message) use ($validated) {
                    $message->to($validated['email'])->subject('Akun Pegawai SIRAPI');
                }
            );
        } catch (\Throwable) {
            return back()->with('warning', 'Data pegawai berhasil ditambahkan, tetapi email password gagal dikirim. Periksa konfigurasi email aplikasi.');
        }

        return back()->with('success', 'Data pegawai berhasil ditambahkan. Password sementara sudah dikirim ke email pegawai.');
    }

    public function verifikasi_Pegawai(int $id, Request $request)
    {
        $validated = $request->validate([
            'status_verifikasi' => 'required|in:aktif,ditolak,pending',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update([
            'status_verifikasi' => $validated['status_verifikasi'],
        ]);

        $statusText = match ($validated['status_verifikasi']) {
            'aktif' => 'disetujui dan diaktifkan',
            'ditolak' => 'ditolak',
            default => 'diubah menjadi pending',
        };

        if ($validated['status_verifikasi'] === 'aktif') {
            try {
                Mail::raw(
                    "Halo {$pegawai->nama_pegawai},\n\nAkun Pegawai SIRAPI Anda telah DISETUJUI oleh Administrator.\nAnda sekarang dapat login ke sistem SIRAPI menggunakan email: {$pegawai->email}\n\nTerima kasih.",
                    function ($message) use ($pegawai) {
                        $message->to($pegawai->email)->subject('Pemberitahuan: Akun Pegawai SIRAPI Disetujui');
                    }
                );
            } catch (\Throwable) {
                // Email notification fail shouldn't break the approval
            }
        }

        return back()->with('success', "Akun pegawai {$pegawai->nama_pegawai} berhasil {$statusText}!");
    }

    public function update_Pegawai($id, Request $request)
    {
        $pegawai = Pegawai::findOrFail($id);

        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|string|max:18|regex:/^[0-9]+$/|unique:sirapi_md_pegawai,nip,' . $id . ',id_pegawai',
            'tanggal_lahir' => 'nullable|date',
            'jabatan' => 'required|string|max:255',
            'bidang' => 'nullable|string|max:255',
            'nomor_hp' => 'required|string|max:13|regex:/^[0-9]+$/',
            'email' => 'required|email|max:255|unique:sirapi_md_pegawai,email,' . $id . ',id_pegawai',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        } elseif ($request->input('hapus_foto') == '1') {
            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            $validated['foto'] = null;
        }

        $pegawai->update($validated);

        return back()->with('success', 'Data pegawai berhasil diperbarui!');
    }

    public function hapus_Pegawai($id)
    {
        Pegawai::findOrFail($id)->delete();

        return back()->with('success', 'Pegawai berhasil dihapus.');
    }

    public function storeBidang(Request $request)
    {
        $validated = $request->validate([
            'nama_bidang' => 'required|string|max:255|unique:sirapi_md_bidang,nama_bidang',
        ]);

        Bidang::create($validated);

        return back()->with('success', 'Bidang berhasil ditambahkan.');
    }

    public function destroyBidang(int $id)
    {
        $bidang = Bidang::findOrFail($id);

        if (Pegawai::where('bidang', $bidang->nama_bidang)->exists()) {
            return back()->with('error', 'Bidang masih digunakan pegawai.');
        }

        $bidang->delete();

        return back()->with('success', 'Bidang berhasil dihapus.');
    }

    public function storeJabatan(Request $request)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:sirapi_md_jabatan,nama_jabatan',
            'kategori' => 'nullable|string|max:255',
        ]);

        Jabatan::create($validated);

        return back()->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function destroyJabatan(int $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        if (Pegawai::where('jabatan', $jabatan->nama_jabatan)->exists()) {
            return back()->with('error', 'Jabatan masih digunakan pegawai.');
        }

        $jabatan->delete();

        return back()->with('success', 'Jabatan berhasil dihapus.');
    }

    public function resetWajah(int $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        
        \DB::table('sirapi_md_pegawai')
            ->where('id_pegawai', $id)
            ->update([
                'face_descriptor' => null,
                'updated_at' => now(),
            ]);

        return back()->with('success', "Data wajah {$pegawai->nama_pegawai} berhasil direset.");
    }
}
