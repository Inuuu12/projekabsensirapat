<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Cuaca;
use App\Models\Galeri;
use App\Models\UlangTahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPublikController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $berita = Berita::latest('tanggal')->latest('id_berita')->get();
        $galeri = Galeri::latest('tanggal')->latest('id_galeri')->get();
        $ulangTahun = UlangTahun::orderByRaw('MONTH(tanggal), DAY(tanggal)')->get();
        $cuaca = Cuaca::latest('id_cuaca')->get();

        return view('admin.publik.index', compact('admin', 'berita', 'galeri', 'ulangTahun', 'cuaca'));
    }

    public function storeBerita(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'sumber' => 'required|string|max:255',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->storePublicImage($request, 'gambar', 'berita');
        } else {
            $validated['gambar'] = 'foto/Suratlogo.png';
        }

        Berita::create($validated);

        return back()->with('success', 'Berita publik berhasil ditambahkan.');
    }

    public function updateBerita(Request $request, int $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'sumber' => 'required|string|max:255',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->storePublicImage($request, 'gambar', 'berita');
        }

        Berita::findOrFail($id)->update($validated);

        return back()->with('success', 'Berita publik berhasil diperbarui.');
    }

    public function destroyBerita(int $id)
    {
        Berita::findOrFail($id)->delete();

        return back()->with('success', 'Berita publik berhasil dihapus.');
    }

    public function storeGaleri(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['gambar'] = $this->storePublicImage($request, 'gambar', 'galeri');

        Galeri::create($validated);

        return back()->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function destroyGaleri(int $id)
    {
        Galeri::findOrFail($id)->delete();

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }

    public function storeUlangTahun(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['gambar'] = $request->hasFile('gambar')
            ? $this->storePublicImage($request, 'gambar', 'ulang-tahun')
            : 'foto/Pegawailogo.png';

        UlangTahun::create($validated);

        return back()->with('success', 'Data ulang tahun berhasil ditambahkan.');
    }

    public function destroyUlangTahun(int $id)
    {
        UlangTahun::findOrFail($id)->delete();

        return back()->with('success', 'Data ulang tahun berhasil dihapus.');
    }

    public function storeCuaca(Request $request)
    {
        $validated = $request->validate([
            'lokasi' => 'required|string|max:255',
            'isi_berita' => 'nullable|string',
            'suhu' => 'required|string|max:50',
            'kondisi' => 'required|string|max:255',
            'kelembapan' => 'required|string|max:50',
        ]);

        $validated['isi_berita'] = $validated['isi_berita'] ?? $validated['kondisi'];

        Cuaca::create($validated);

        return back()->with('success', 'Data cuaca berhasil ditambahkan.');
    }

    public function destroyCuaca(int $id)
    {
        Cuaca::findOrFail($id)->delete();

        return back()->with('success', 'Data cuaca berhasil dihapus.');
    }

    private function storePublicImage(Request $request, string $field, string $folder): string
    {
        $file = $request->file($field);
        $directory = public_path('uploads/' . $folder);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/' . $folder . '/' . $filename;
    }
}
