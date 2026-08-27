<?php

namespace App\Http\Controllers;

use App\Models\DokumenNotulen;
use App\Models\Galeri;
use App\Models\UlangTahun;
use App\Models\VideoPublik;
use App\Services\NewsApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminPublikController extends Controller
{
    public function index(NewsApiService $newsService)
    {
        $admin = Auth::guard('admin')->user();
        $berita = $newsService->getNews();
        $galeri = $this->dokumentasiAgendaGaleri();
        $ulangTahun = UlangTahun::tampilkanUlangTahunPegawai();
        $video = VideoPublik::latest()->latest('id_video')->get();

        return view('admin.publik.index', compact('admin', 'berita', 'galeri', 'ulangTahun', 'video'));
    }

    public function refreshBerita(NewsApiService $newsService)
    {
        try {
            $count = $newsService->refreshCache();
            return back()->with('success', "Berhasil memperbarui {$count} berita Indonesia terkini dari Live API.");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui feed berita: ' . $e->getMessage());
        }
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

    private function dokumentasiAgendaGaleri()
    {
        return DokumenNotulen::with('agenda')
            ->where('jenis_dokumen', 'dokumentasi')
            ->latest('id_dokumen')
            ->get()
            ->filter(fn ($item) => in_array(strtolower(pathinfo((string) $item->file_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp'], true))
            ->values();
    }
}
