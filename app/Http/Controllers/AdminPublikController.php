<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\UlangTahun;
use App\Models\VideoPublik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminPublikController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $berita = Berita::latest('tanggal')->latest('id_berita')->get();
        $galeri = Galeri::latest('tanggal')->latest('id_galeri')->get();
        $ulangTahun = UlangTahun::orderByRaw('MONTH(tanggal), DAY(tanggal)')->get();
        $video = VideoPublik::latest()->latest('id_video')->get();

        return view('admin.publik.index', compact('admin', 'berita', 'galeri', 'ulangTahun', 'video'));
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

    public function updateGaleri(Request $request, int $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->storePublicImage($request, 'gambar', 'galeri');
        }

        Galeri::findOrFail($id)->update($validated);

        return back()->with('success', 'Foto galeri berhasil diperbarui.');
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

    public function updateUlangTahun(Request $request, int $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->storePublicImage($request, 'gambar', 'ulang-tahun');
        }

        UlangTahun::findOrFail($id)->update($validated);

        return back()->with('success', 'Data ulang tahun berhasil diperbarui.');
    }

    public function destroyUlangTahun(int $id)
    {
        UlangTahun::findOrFail($id)->delete();

        return back()->with('success', 'Data ulang tahun berhasil dihapus.');
    }

    public function storeVideo(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'youtube_url' => 'required|url|max:255',
        ]);

        $validated['youtube_embed_url'] = $this->youtubeEmbedUrl($validated['youtube_url']);

        VideoPublik::create($validated);

        return back()->with('success', 'Video publik berhasil ditambahkan.');
    }

    public function updateVideo(Request $request, int $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'youtube_url' => 'required|url|max:255',
        ]);

        $validated['youtube_embed_url'] = $this->youtubeEmbedUrl($validated['youtube_url']);

        VideoPublik::findOrFail($id)->update($validated);

        return back()->with('success', 'Video publik berhasil diperbarui.');
    }

    public function destroyVideo(int $id)
    {
        VideoPublik::findOrFail($id)->delete();

        return back()->with('success', 'Video publik berhasil dihapus.');
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

    private function youtubeEmbedUrl(string $url): string
    {
        $parts = parse_url($url);
        $host = strtolower($parts['host'] ?? '');
        $path = trim($parts['path'] ?? '', '/');
        parse_str($parts['query'] ?? '', $query);

        $videoId = null;
        if (str_contains($host, 'youtu.be')) {
            $videoId = explode('/', $path)[0] ?? null;
        } elseif (str_contains($host, 'youtube.com')) {
            if (str_starts_with($path, 'shorts/')) {
                $videoId = explode('/', substr($path, 7))[0] ?? null;
            } elseif (($query['v'] ?? null) !== null) {
                $videoId = $query['v'];
            } elseif (str_starts_with($path, 'embed/')) {
                $videoId = explode('/', substr($path, 6))[0] ?? null;
            }
        }

        if (! preg_match('/^[A-Za-z0-9_-]{6,20}$/', (string) $videoId)) {
            throw ValidationException::withMessages([
                'youtube_url' => 'Link YouTube tidak valid.',
            ]);
        }

        return 'https://www.youtube.com/embed/' . $videoId;
    }
}
