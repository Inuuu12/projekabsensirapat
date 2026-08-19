<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\DokumenNotulen;
use App\Models\Galeri;
use App\Models\UlangTahun;
use App\Models\VideoPublik;
use App\Services\NewsFetcherService;
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
        $galeri = $this->dokumentasiAgendaGaleri();
        $ulangTahun = UlangTahun::tampilkanUlangTahunPegawai();
        $video = VideoPublik::latest()->latest('id_video')->get();

        return view('admin.publik.index', compact('admin', 'berita', 'galeri', 'ulangTahun', 'video'));
    }

    public function fetchLinkMeta(Request $request, NewsFetcherService $fetcher)
    {
        $request->validate(['url' => 'required|url']);

        try {
            $meta = $fetcher->fetchOpenGraph($request->input('url'));
            return response()->json(['success' => true, 'data' => $meta]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function syncBerita(NewsFetcherService $fetcher)
    {
        try {
            $count = $fetcher->syncPemkabBogorNews();
            return back()->with('success', $count > 0 
                ? "Berhasil menyinkronkan {$count} berita terbaru dari Diskominfo Kab. Bogor & Tribunnews Bogor." 
                : 'Daftar berita dari Diskominfo & Tribunnews Bogor sudah versi terbaru.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyinkronkan berita: ' . $e->getMessage());
        }
    }

    public function storeBerita(Request $request, NewsFetcherService $fetcher)
    {
        if ($request->filled('url')) {
            try {
                $meta = $fetcher->fetchOpenGraph($request->input('url'));
                Berita::create([
                    'judul' => $meta['judul'],
                    'isi_berita' => $meta['isi_berita'],
                    'tanggal' => $meta['tanggal'],
                    'gambar' => $meta['gambar'],
                    'sumber' => $meta['sumber'],
                ]);
                return back()->with('success', 'Berita dari link berhasil ditambahkan.');
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengambil berita dari link: ' . $e->getMessage());
            }
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi_berita' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'gambar_url' => 'nullable|string|max:1000',
            'sumber' => 'required|string|max:255',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->storePublicImage($request, 'gambar', 'berita');
        } elseif (!empty($validated['gambar_url'])) {
            $validated['gambar'] = $validated['gambar_url'];
        } else {
            $validated['gambar'] = 'foto/Suratlogo.png';
        }
        unset($validated['gambar_url']);

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
