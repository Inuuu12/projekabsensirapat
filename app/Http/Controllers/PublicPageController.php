<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\DataMasukan;
use App\Models\DokumenNotulen;
use App\Models\Kunjungan;
use App\Models\Logbook;
use App\Models\Pegawai;
use App\Models\QRCode;
use App\Models\UlangTahun;
use App\Models\VideoPublik;
use App\Services\NewsApiService;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PublicPageController extends Controller
{
    private const PUBLIC_TIMEZONE = 'Asia/Jakarta';

    public function index(NewsApiService $newsService)
    {
        $today = Carbon::today(self::PUBLIC_TIMEZONE);
        $agendaHariIni = $this->queryOrDefault(fn () => Agenda::whereDate('tanggal', $today)
            ->orderBy('waktu')
            ->take(3)
            ->get(), collect());
        $totalAgendaHariIni = $this->queryOrDefault(fn () => Agenda::whereDate('tanggal', $today)->count(), 0);
        $agendaTerbaru = $this->queryOrDefault(fn () => Agenda::query()
            ->whereDate('tanggal', '>=', $today)
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->take(3)
            ->get(), collect());
        $agendaBeranda = $agendaHariIni->isNotEmpty() ? $agendaHariIni : $agendaTerbaru;
        $agendaBerandaLabel = $agendaHariIni->isNotEmpty() ? 'Agenda Hari Ini' : 'Agenda Terdekat';
        $agendaBerandaDescription = $agendaHariIni->isNotEmpty()
            ? $today->translatedFormat('l, d F Y') . ' • ' . $totalAgendaHariIni . ' kegiatan terjadwal'
            : 'Belum ada agenda hari ini, menampilkan agenda terdekat';
        $beritaTerbaru = $newsService->getLatest(3);
        $galeri = $this->queryOrDefault(fn () => $this->dokumentasiAgendaGaleri()->take(3), collect());
        $totalGaleri = $this->queryOrDefault(fn () => $this->dokumentasiAgendaGaleri()->count(), 0);
        $ulangTahun = $this->queryOrDefault(fn () => UlangTahun::tampilkanUlangTahunPegawai(), collect());
        $ulangTahunHariIni = $ulangTahun->first(fn ($item) => $item->tanggal?->format('m-d') === $today->format('m-d'));
        $masukan = $this->queryOrDefault(fn () => DataMasukan::latest('id_datamasukan')->take(5)->get(), collect());
        $videoTerbaru = $this->queryOrDefault(fn () => VideoPublik::latest()->latest('id_video')->first());
        $youtubeEmbedUrl = $videoTerbaru?->youtube_embed_url ?? $this->defaultYoutubeEmbedUrl();

        return view('publik.beranda.index', compact(
            'agendaHariIni',
            'agendaBeranda',
            'agendaBerandaLabel',
            'agendaBerandaDescription',
            'totalAgendaHariIni',
            'agendaTerbaru',
            'beritaTerbaru',
            'galeri',
            'totalGaleri',
            'ulangTahun',
            'ulangTahunHariIni',
            'masukan',
            'videoTerbaru',
            'youtubeEmbedUrl'
        ));
    }

    public function agenda(Request $request)
    {
        $today = Carbon::today(self::PUBLIC_TIMEZONE);
        $keyword = $request->query('keyword');
        $agenda = $this->queryOrDefault(fn () => Agenda::query()
            ->whereDate('tanggal', '>=', $today)
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($search) use ($keyword) {
                    $search->where('nama_agenda', 'like', "%{$keyword}%")
                        ->orWhere('lokasi', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->get(), collect());

        return view('publik.agenda.index', compact('agenda', 'keyword'));
    }

    public function agendaDetail(?int $id = null)
    {
        $today = Carbon::today(self::PUBLIC_TIMEZONE);
        $agenda = $this->queryOrDefault(fn () => $id
            ? Agenda::findOrFail($id)
            : Agenda::whereDate('tanggal', '>=', $today)->orderBy('tanggal')->orderBy('waktu')->first());
        $qrCode = $agenda
            ? $this->queryOrDefault(fn () => QRCode::where('id_agenda', $agenda->id_agenda)->first())
            : null;
        $dokumenList = $agenda
            ? $this->queryOrDefault(fn () => DokumenNotulen::where('id_agenda', $agenda->id_agenda)->get(), collect())
            : collect();

        $notulen = $dokumenList->firstWhere('jenis_dokumen', 'notulen');
        $dokumentasi = $dokumenList->where('jenis_dokumen', 'dokumentasi')->values();

        return view('publik.agenda.detail', compact('agenda', 'qrCode', 'notulen', 'dokumentasi'));
    }

    public function lampiranAgenda(int $id)
    {
        $agenda = Agenda::findOrFail($id);
        $lampiran = trim((string) $agenda->lampiran);

        abort_if($lampiran === '', 404);

        $path = $this->publicStoragePath($lampiran);

        if ($path === null) {
            return redirect()->away($lampiran);
        }

        abort_if(str_contains($path, '..') || ! Storage::disk('public')->exists($path), 404);

        $fileUrl = route('publik.agenda.lampiran.file', $agenda->id_agenda, false);
        $fileName = basename($path);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true);
        $isPdf = $extension === 'pdf';

        return view('publik.agenda.lampiran', compact('agenda', 'fileUrl', 'fileName', 'extension', 'isImage', 'isPdf'));
    }

    public function fileLampiranAgenda(int $id)
    {
        $agenda = Agenda::findOrFail($id);
        $lampiran = trim((string) $agenda->lampiran);

        abort_if($lampiran === '', 404);

        $path = $this->publicStoragePath($lampiran);

        if ($path === null) {
            return redirect()->away($lampiran);
        }

        abort_if(str_contains($path, '..') || ! Storage::disk('public')->exists($path), 404);

        return Storage::disk('public')->response($path, basename($path));
    }

    public function berita(Request $request, NewsApiService $newsService)
    {
        $keyword = $request->query('keyword');
        $sumber = $request->query('sumber', 'semua');

        $allNews = $newsService->getNews([
            'keyword' => $keyword,
            'sumber' => $sumber,
        ]);

        $currentPage = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 9;
        $currentPageItems = $allNews->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $berita = new LengthAwarePaginator(
            $currentPageItems,
            $allNews->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        $availableSources = $newsService->getAvailableSources();

        return view('publik.berita.index', compact('berita', 'keyword', 'sumber', 'availableSources'));
    }

    public function beritaDetail(NewsApiService $newsService, ?string $id = null)
    {
        $berita = $newsService->findNews($id);

        $beritaTerkait = $newsService->getNews()
            ->filter(fn ($item) => (string) $item->id_berita !== (string) ($berita?->id_berita ?? ''))
            ->take(4);

        return view('publik.berita.detail', compact('berita', 'beritaTerkait'));
    }

    public function galeri()
    {
        $galeri = $this->queryOrDefault(fn () => $this->dokumentasiAgendaGaleri(), collect());

        return view('publik.galeri.index', compact('galeri'));
    }

    public function video(NewsApiService $newsService)
    {
        $videoList = $this->queryOrDefault(fn () => VideoPublik::latest()->latest('id_video')->get(), collect());
        $videoUtama = $videoList->first();
        $youtubeEmbedUrl = $videoUtama?->youtube_embed_url ?? $this->defaultYoutubeEmbedUrl();
        $youtubeChannelUrl = 'https://www.youtube.com/channel/UCJlX_73GqPvJlerJFN4cRgA';
        $today = Carbon::today(self::PUBLIC_TIMEZONE);
        $agendaTerbaru = $this->queryOrDefault(fn () => Agenda::whereDate('tanggal', '>=', $today)->orderBy('tanggal')->orderBy('waktu')->take(6)->get(), collect());
        $beritaTerbaru = $newsService->getLatest(6);

        return view('publik.video.index', compact('youtubeEmbedUrl', 'youtubeChannelUrl', 'videoUtama', 'videoList', 'agendaTerbaru', 'beritaTerbaru'));
    }

    public function ulangTahun()
    {
        $today = Carbon::today(self::PUBLIC_TIMEZONE);
        $ulangTahun = $this->queryOrDefault(fn () => UlangTahun::tampilkanUlangTahunPegawai(), collect());
        $ulangTahunHariIni = $ulangTahun->first(fn ($item) => $item->tanggal?->format('m-d') === $today->format('m-d'));

        return view('publik.ulang_tahun.index', compact('ulangTahun', 'ulangTahunHariIni'));
    }

    public function masukan()
    {
        $aduans = $this->queryOrDefault(fn () => DataMasukan::latest('id_datamasukan')->get(), collect());

        return view('publik.masukan.index', compact('aduans'));
    }

    public function petaSitus()
    {
        return view('publik.sitemap.index');
    }

    public function riwayatAduan()
    {
        $masukan = $this->queryOrDefault(fn () => DataMasukan::latest('id_datamasukan')->paginate(10), collect());

        return view('publik.masukan.riwayat', compact('masukan'));
    }

    public function cuacaApi()
    {
        try {
            $response = Http::timeout(8)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => -6.481,
                'longitude' => 106.854,
                'timezone' => 'Asia/Jakarta',
                'forecast_days' => 3,
                'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,weather_code,wind_speed_10m,wind_direction_10m,precipitation,cloud_cover',
                'daily' => 'weather_code,temperature_2m_max,temperature_2m_min,precipitation_sum,wind_speed_10m_max',
            ]);

            if (! $response->successful()) {
                throw new \RuntimeException('Open-Meteo request failed.');
            }

            $data = $response->json();
            $current = $data['current'] ?? [];
            $daily = $data['daily'] ?? [];

            return response()->json([
                'success' => true,
                'source' => 'Open-Meteo',
                'attribution' => 'Weather data by Open-Meteo.com',
                'location' => 'Cibinong, Kabupaten Bogor',
                'updated_at' => $current['time'] ?? now()->toIso8601String(),
                'current' => [
                    'temperature' => $current['temperature_2m'] ?? null,
                    'apparent_temperature' => $current['apparent_temperature'] ?? null,
                    'humidity' => $current['relative_humidity_2m'] ?? null,
                    'weather_code' => $current['weather_code'] ?? null,
                    'condition' => $this->weatherCodeLabel($current['weather_code'] ?? null),
                    'wind_speed' => $current['wind_speed_10m'] ?? null,
                    'wind_direction' => $current['wind_direction_10m'] ?? null,
                    'precipitation' => $current['precipitation'] ?? null,
                    'cloud_cover' => $current['cloud_cover'] ?? null,
                ],
                'daily' => collect($daily['time'] ?? [])->map(fn ($date, $index) => [
                    'date' => $date,
                    'condition' => $this->weatherCodeLabel($daily['weather_code'][$index] ?? null),
                    'weather_code' => $daily['weather_code'][$index] ?? null,
                    'temperature_max' => $daily['temperature_2m_max'][$index] ?? null,
                    'temperature_min' => $daily['temperature_2m_min'][$index] ?? null,
                    'precipitation_sum' => $daily['precipitation_sum'][$index] ?? null,
                    'wind_speed_max' => $daily['wind_speed_10m_max'][$index] ?? null,
                ])->values(),
            ]);
        } catch (\Throwable) {
            return response()->json([
                'success' => false,
                'source' => 'Open-Meteo',
                'location' => 'Cibinong, Kabupaten Bogor',
                'updated_at' => now()->toIso8601String(),
                'current' => [
                    'temperature' => null,
                    'apparent_temperature' => null,
                    'humidity' => null,
                    'weather_code' => null,
                    'condition' => 'Data API belum tersedia',
                    'wind_speed' => null,
                    'wind_direction' => null,
                    'precipitation' => null,
                    'cloud_cover' => null,
                ],
                'daily' => [],
                'message' => 'API cuaca belum bisa diakses.',
            ]);
        }
    }

    public function presensiPegawai(Request $request)
    {
        $agenda = $this->agendaPresensi($request);

        return view('pegawai.presensi_wajah.index', compact('agenda'));
    }

    public function presensiTamu(Request $request)
    {
        $agenda = $this->agendaPresensi($request);

        return view('publik.presensi.tamu', compact('agenda'));
    }

    public function formKunjungan()
    {
        $pegawaiList = $this->queryOrDefault(fn () => Pegawai::orderBy('nama_pegawai')->get(), collect());

        return view('publik.kunjungan.index', compact('pegawaiList'));
    }

    public function simpanKunjungan(Request $request)
    {
        $namaPegawai = $request->input('nama_pegawai') ?: $request->input('nama_pejabat');
        $request->merge(['nama_pegawai' => $namaPegawai]);

        $validated = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nama_pengunjung' => 'required|string|max:255',
            'asal_instansi' => 'required|string|max:255',
            'nomorhp_pengunjung' => 'required|string|max:13|regex:/^[0-9]+$/',
            'email_pengunjung' => 'required|email|max:255',
            'keperluan' => 'required|string',
        ], [
            'nama_pegawai.required' => 'Pilih pihak / pegawai yang ingin Anda tuju.',
            'nama_pengunjung.required' => 'Nama lengkap tamu wajib diisi.',
            'asal_instansi.required' => 'Instansi / asal wajib diisi.',
            'nomorhp_pengunjung.required' => 'No. HP / WhatsApp wajib diisi.',
            'email_pengunjung.required' => 'Alamat email wajib diisi.',
            'email_pengunjung.email' => 'Format email tidak valid.',
            'keperluan.required' => 'Keperluan kunjungan wajib diisi.',
        ]);

        $now = $this->nowWib();
        $validated['nama_pejabat'] = $validated['nama_pegawai'];
        $validated['tanggal_kunjungan'] = $now->toDateString();
        $validated['waktu'] = $now->format('H:i:s');
        $validated['id_admin'] = $this->queryOrDefault(fn () => Admin::first()?->id_admin);

        try {
            Kunjungan::create($validated);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                // If legacy DB schema unique index exists on email_pengunjung, fallback
                $validated['email_pengunjung'] = $validated['email_pengunjung'] . '.' . time();
                Kunjungan::create($validated);
            } else {
                throw $e;
            }
        }

        return back()->with('success', 'Form kunjungan Anda telah berhasil dikirim. Terima kasih!');
    }

    public function qrHadir(Agenda $agenda)
    {
        if ($agenda->status_qr !== 'aktif') {
            return view('publik.presensi.qr_result', [
                'success' => false,
                'agenda' => $agenda,
                'message' => 'QR presensi agenda ini belum diaktifkan oleh admin.',
            ]);
        }

        if ($agenda->status_label === Agenda::STATUS_MENDATANG) {
            return view('publik.presensi.qr_result', [
                'success' => false,
                'agenda' => $agenda,
                'message' => 'Presensi belum dibuka. Agenda rapat baru dimulai pada pukul ' . (substr((string) $agenda->waktu, 0, 5) ?: '-') . ' WIB (' . ($agenda->tanggal?->translatedFormat('d F Y') ?? '-') . ').',
            ]);
        }

        if ($agenda->status_label === Agenda::STATUS_SELESAI) {
            return view('publik.presensi.qr_result', [
                'success' => false,
                'agenda' => $agenda,
                'message' => 'Presensi untuk agenda rapat ini telah ditutup karena waktu rapat telah berakhir.',
            ]);
        }

        $qrWindow = $this->qrWindow($agenda);
        if (! $this->nowWib()->betweenIncluded($qrWindow['start'], $qrWindow['end'])) {
            return view('publik.presensi.qr_result', [
                'success' => false,
                'agenda' => $agenda,
                'message' => 'QR presensi hanya aktif pada ' . $qrWindow['start']->translatedFormat('d F Y H:i') . ' sampai ' . $qrWindow['end']->translatedFormat('H:i') . ' WIB.',
            ]);
        }

        if (Auth::guard('pegawai')->check()) {
            $pegawaiUser = Auth::guard('pegawai')->user();
            if (! $agenda->canPegawaiPresensi($pegawaiUser)) {
                return view('publik.presensi.qr_result', [
                    'success' => false,
                    'agenda' => $agenda,
                    'message' => 'Presensi ditolak. Agenda surat masuk ini hanya dikhususkan untuk pegawai yang ditugaskan (' . ($agenda->ditugaskan ?: '-') . ').',
                ]);
            }
            if (! $agenda->isPegawaiSudahHadir($pegawaiUser) && $agenda->isKuotaPenuh()) {
                return view('publik.presensi.qr_result', [
                    'success' => false,
                    'agenda' => $agenda,
                    'message' => 'Presensi ditolak karena kuota peserta agenda ini sudah penuh.',
                ]);
            }
        } elseif ($agenda->isKuotaPenuh()) {
            return view('publik.presensi.qr_result', [
                'success' => false,
                'agenda' => $agenda,
                'message' => 'Presensi ditolak karena kuota peserta agenda ini sudah penuh.',
            ]);
        }

        $qrCode = $this->queryOrDefault(fn () => QRCode::where('id_agenda', $agenda->id_agenda)->first());

        if (! $qrCode) {
            return view('publik.presensi.qr_result', [
                'success' => false,
                'agenda' => $agenda,
                'message' => 'QR presensi belum dibuat oleh admin.',
            ]);
        }

        Logbook::create([
            'id_agenda' => $agenda->id_agenda,
            'catatan' => 'Hadir lewat Scan QR pegawai.',
            'waktu_isi' => $this->nowWib(),
        ]);

        return view('publik.presensi.qr_result', [
            'success' => true,
            'agenda' => $agenda,
            'message' => 'Scan QR berhasil, kehadiran sudah dicatat.',
        ]);
    }

    private function queryOrDefault(callable $query, mixed $default = null): mixed
    {
        try {
            return $query();
        } catch (QueryException) {
            return $default;
        }
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

    private function agendaPresensi(Request $request): ?Agenda
    {
        $id = $request->query('agenda_id');
        $today = Carbon::today(self::PUBLIC_TIMEZONE);

        return $this->queryOrDefault(fn () => Agenda::query()
            ->when($id, fn ($query) => $query->whereKey($id))
            ->whereDate('tanggal', '>=', $today)
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->first());
    }

    private function publicStoragePath(string $path): ?string
    {
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $urlPath = parse_url($path, PHP_URL_PATH);

            if (! is_string($urlPath) || $urlPath === '') {
                return null;
            }

            $path = rawurldecode($urlPath);

            if (! str_starts_with(ltrim($path, '/'), 'storage/')) {
                return null;
            }
        }

        $path = str_replace('\\', '/', trim($path));
        $path = ltrim($path, '/');

        foreach (['storage/', 'public/'] as $prefix) {
            if (str_starts_with($path, $prefix)) {
                $path = substr($path, strlen($prefix));
            }
        }

        return ltrim($path, '/') ?: null;
    }

    private function qrWindow(Agenda $agenda): array
    {
        $date = $agenda->tanggal?->toDateString() ?? Carbon::today(self::PUBLIC_TIMEZONE)->toDateString();
        $startTime = substr((string) $agenda->waktu, 0, 5) ?: '00:00';
        $endTime = substr((string) $agenda->waktu_selesai, 0, 5);
        $start = Carbon::parse($date . ' ' . $startTime, self::PUBLIC_TIMEZONE);
        $end = $endTime ? Carbon::parse($date . ' ' . $endTime, self::PUBLIC_TIMEZONE) : $start->copy()->addHour();

        if ($end->lessThanOrEqualTo($start)) {
            $end = $start->copy()->addHour();
        }

        return compact('start', 'end');
    }

    private function nowWib(): Carbon
    {
        return Carbon::now(self::PUBLIC_TIMEZONE);
    }

    private function defaultYoutubeEmbedUrl(): string
    {
        return 'https://www.youtube.com/embed/videoseries?list=UUJlX_73GqPvJlerJFN4cRgA';
    }

    private function weatherCodeLabel(mixed $code): string
    {
        return match ((int) $code) {
            0 => 'Cerah',
            1, 2 => 'Cerah Berawan',
            3 => 'Berawan',
            45, 48 => 'Berkabut',
            51, 53, 55 => 'Gerimis',
            61, 63, 65 => 'Hujan',
            66, 67 => 'Hujan Es',
            71, 73, 75, 77 => 'Salju',
            80, 81, 82 => 'Hujan Lokal',
            85, 86 => 'Hujan Salju',
            95 => 'Badai Petir',
            96, 99 => 'Badai Petir dengan Es',
            default => 'Tidak diketahui',
        };
    }

    public function presensiPegawaiPilih(Request $request)
    {
        $agendaId = $request->input('agenda_id');
        $agenda = Agenda::find($agendaId);
        if (!$agenda) {
            return redirect()->route('publik.agenda')->withErrors(['agenda' => 'Agenda tidak ditemukan.']);
        }
        return view('pegawai.presensi_pilih.index', compact('agenda'));
    }

    public function presensiPegawaiWajah(Request $request)
    {
        $agendaId = $request->input('agenda_id');
        $agenda = Agenda::find($agendaId);
        if (!$agenda) {
            return redirect()->route('publik.agenda')->withErrors(['agenda' => 'Agenda tidak ditemukan.']);
        }
        return view('pegawai.presensi_wajah.index', compact('agenda'));
    }
}
