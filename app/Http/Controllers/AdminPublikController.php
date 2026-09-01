<?php

namespace App\Http\Controllers;

use App\Models\DokumenNotulen;
use App\Models\Galeri;
use App\Models\UlangTahun;
use App\Services\NewsApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AdminPublikController extends Controller
{
    public function index(NewsApiService $newsService)
    {
        $admin = Auth::guard('admin')->user();
        $berita = $newsService->getNews();
        $galeri = $this->dokumentasiAgendaGaleri();
        $ulangTahun = UlangTahun::tampilkanUlangTahunPegawai();
        $youtubeChannelUrl = Cache::get('sirapi_youtube_channel_url', config('sirapi.youtube_channel_url', 'https://youtube.com/@kabupatenbogor?si=PAPn9ARUMrvRwMYy'));
        $youtubePlaylistId = Cache::get('sirapi_youtube_playlist_id', config('sirapi.youtube_playlist_id', 'UUJlX_73GqPvJlerJFN4cRgA'));
        $youtubeEmbedUrl = 'https://www.youtube.com/embed/videoseries?list=' . $youtubePlaylistId;

        return view('admin.publik.index', compact('admin', 'berita', 'galeri', 'ulangTahun', 'youtubeChannelUrl', 'youtubePlaylistId', 'youtubeEmbedUrl'));
    }

    public function updateYoutube(Request $request)
    {
        $validated = $request->validate([
            'youtube_channel_url' => 'required|url|max:255',
            'youtube_playlist_id' => 'required|string|max:100',
        ]);

        $playlistId = trim($validated['youtube_playlist_id']);
        if (str_starts_with($playlistId, 'UC') && strlen($playlistId) === 24) {
            $playlistId = 'UU' . substr($playlistId, 2);
        }

        Cache::forever('sirapi_youtube_channel_url', trim($validated['youtube_channel_url']));
        Cache::forever('sirapi_youtube_playlist_id', $playlistId);

        return back()->with('success', 'Pengaturan Channel YouTube Publik berhasil disimpan.');
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

    private function dokumentasiAgendaGaleri()
    {
        $dokumentasi = DokumenNotulen::with('agenda')
            ->where('jenis_dokumen', 'dokumentasi')
            ->latest('id_dokumen')
            ->get()
            ->filter(fn ($item) => in_array(strtolower(pathinfo((string) $item->file_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp'], true));

        $galeri = Galeri::latest('id_galeri')->get()->map(function ($item) {
            $item->file_path = $item->gambar;
            return $item;
        });

        return $dokumentasi->concat($galeri)->values();
    }
}
