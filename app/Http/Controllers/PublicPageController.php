<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Berita;
use App\Models\DataMasukan;
use App\Models\DokumenNotulen;
use App\Models\Logbook;
use App\Models\QRCode;
use App\Models\UlangTahun;
use App\Models\VideoPublik;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PublicPageController extends Controller
{
    private const PUBLIC_TIMEZONE = 'Asia/Jakarta';

    public function index()
    {
        $today = Carbon::today(self::PUBLIC_TIMEZONE);
        $agendaHariIni = $this->queryOrDefault(fn () => Agenda::whereDate('tanggal', $today)
            ->orderBy('waktu')
            ->take(3)
            ->get(), collect());
        $totalAgendaHariIni = $this->queryOrDefault(fn () => Agenda::whereDate('tanggal', $today)->count(), 0);
        $agendaTerbaru = $this->queryOrDefault(fn () => Agenda::query()
            ->orderByRaw('tanggal >= ? desc', [$today->toDateString()])
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->take(3)
            ->get(), collect());
        $agendaBeranda = $agendaHariIni->isNotEmpty() ? $agendaHariIni : $agendaTerbaru;
        $agendaBerandaLabel = $agendaHariIni->isNotEmpty() ? 'Agenda Hari Ini' : 'Agenda Terdekat';
        $agendaBerandaDescription = $agendaHariIni->isNotEmpty()
            ? $today->translatedFormat('l, d F Y') . ' • ' . $totalAgendaHariIni . ' kegiatan terjadwal'
            : 'Belum ada agenda hari ini, menampilkan agenda terdekat dari database';
        $beritaTerbaru = $this->queryOrDefault(fn () => Berita::latest('tanggal')->latest('id_berita')->take(3)->get(), collect());
        $galeri = $this->queryOrDefault(fn () => $this->dokumentasiAgendaGaleri()->take(3), collect());
        $totalGaleri = $this->queryOrDefault(fn () => $this->dokumentasiAgendaGaleri()->count(), 0);
        $ulangTahun = $this->queryOrDefault(fn () => UlangTahun::tampilkanUlangTahunPegawai(), collect());
        $ulangTahunHariIni = $ulangTahun->first(fn ($item) => $item->tanggal?->format('m-d') === $today->format('m-d'));
        $masukan = $this->queryOrDefault(fn () => DataMasukan::latest('id_datamasukan')->take(5)->get(), collect());
        $videoTerbaru = $this->queryOrDefault(fn () => VideoPublik::latest()->latest('id_video')->first());
        $youtubeEmbedUrl = $videoTerbaru?->youtube_embed_url ?? $this->defaultYoutubeEmbedUrl();

        return view('publik.index', compact(
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
        $keyword = $request->query('keyword');
        $agenda = $this->queryOrDefault(fn () => Agenda::query()
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($search) use ($keyword) {
                    $search->where('nama_agenda', 'like', "%{$keyword}%")
                        ->orWhere('lokasi', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->get(), collect());

        return view('publik.agenda', compact('agenda', 'keyword'));
    }

    public function agendaDetail(?int $id = null)
    {
        $agenda = $this->queryOrDefault(fn () => $id
            ? Agenda::findOrFail($id)
            : Agenda::orderBy('tanggal')->orderBy('waktu')->first());

        return view('publik.agenda-detail', compact('agenda'));
    }

    public function berita(Request $request)
    {
        $keyword = $request->query('keyword');
        $berita = $this->queryOrDefault(fn () => Berita::query()
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($search) use ($keyword) {
                    $search->where('judul', 'like', "%{$keyword}%")
                        ->orWhere('isi_berita', 'like', "%{$keyword}%")
                        ->orWhere('sumber', 'like', "%{$keyword}%");
                });
            })
            ->latest('tanggal')
            ->latest('id_berita')
            ->paginate(6)
            ->withQueryString(), collect());

        return view('publik.berita', compact('berita', 'keyword'));
    }

    public function beritaDetail(?int $id = null)
    {
        $berita = $this->queryOrDefault(fn () => $id
            ? Berita::findOrFail($id)
            : Berita::latest('tanggal')->latest('id_berita')->first());
        $beritaTerkait = $this->queryOrDefault(fn () => Berita::when($berita, fn ($query) => $query->whereKeyNot($berita->getKey()))
            ->latest('tanggal')
            ->latest('id_berita')
            ->take(3)
            ->get(), collect());

        return view('publik.berita-detail', compact('berita', 'beritaTerkait'));
    }

    public function galeri()
    {
        $galeri = $this->queryOrDefault(fn () => $this->dokumentasiAgendaGaleri(), collect());

        return view('publik.galeri', compact('galeri'));
    }

    public function video()
    {
        $videoList = $this->queryOrDefault(fn () => VideoPublik::latest()->latest('id_video')->get(), collect());
        $videoUtama = $videoList->first();
        $youtubeEmbedUrl = $videoUtama?->youtube_embed_url ?? $this->defaultYoutubeEmbedUrl();
        $youtubeChannelUrl = 'https://www.youtube.com/channel/UCJlX_73GqPvJlerJFN4cRgA';
        $agendaTerbaru = $this->queryOrDefault(fn () => Agenda::latest('tanggal')->latest('waktu')->take(6)->get(), collect());
        $beritaTerbaru = $this->queryOrDefault(fn () => Berita::latest('tanggal')->latest('id_berita')->take(6)->get(), collect());

        return view('publik.video', compact('youtubeEmbedUrl', 'youtubeChannelUrl', 'videoUtama', 'videoList', 'agendaTerbaru', 'beritaTerbaru'));
    }

    public function ulangTahun()
    {
        $today = Carbon::today(self::PUBLIC_TIMEZONE);
        $ulangTahun = $this->queryOrDefault(fn () => UlangTahun::tampilkanUlangTahunPegawai(), collect());
        $ulangTahunHariIni = $ulangTahun->first(fn ($item) => $item->tanggal?->format('m-d') === $today->format('m-d'));

        return view('publik.ulang-tahun', compact('ulangTahun', 'ulangTahunHariIni'));
    }

    public function masukan()
    {
        return view('publik.masukan');
    }

    public function petaSitus()
    {
        return view('publik.peta-sitemap');
    }

    public function riwayatAduan()
    {
        $masukan = $this->queryOrDefault(fn () => DataMasukan::latest('id_datamasukan')->paginate(10), collect());

        return view('publik.riwayat-aduan', compact('masukan'));
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

    public function presensiPilih(Request $request)
    {
        $agenda = $this->agendaPresensi($request);

        return view('publik.presensi-pilih', compact('agenda'));
    }

    public function presensiPegawai(Request $request)
    {
        $agenda = $this->agendaPresensi($request);
        $qrCode = $agenda
            ? $this->queryOrDefault(fn () => QRCode::where('id_agenda', $agenda->id_agenda)->first())
            : null;
        $qrWindow = $agenda ? $this->qrWindow($agenda) : null;
        $qrSedangBerlangsung = $qrWindow ? $this->nowWib()->betweenIncluded($qrWindow['start'], $qrWindow['end']) : false;
        $qrWindowLabel = $qrWindow
            ? $qrWindow['start']->translatedFormat('d F Y H:i') . ' - ' . $qrWindow['end']->translatedFormat('H:i') . ' WIB'
            : null;

        return view('publik.presensi-pegawai', compact('agenda', 'qrCode', 'qrSedangBerlangsung', 'qrWindowLabel'));
    }

    public function presensiTamu(Request $request)
    {
        $agenda = $this->agendaPresensi($request);

        return view('publik.presensi-tamu', compact('agenda'));
    }

    public function qrHadir(Agenda $agenda)
    {
        if ($agenda->status_qr !== 'aktif') {
            return view('publik.presensi-qr-result', [
                'success' => false,
                'agenda' => $agenda,
                'message' => 'QR presensi agenda ini belum diaktifkan oleh admin.',
            ]);
        }

        $qrWindow = $this->qrWindow($agenda);
        if (! $this->nowWib()->betweenIncluded($qrWindow['start'], $qrWindow['end'])) {
            return view('publik.presensi-qr-result', [
                'success' => false,
                'agenda' => $agenda,
                'message' => 'QR presensi hanya aktif pada ' . $qrWindow['start']->translatedFormat('d F Y H:i') . ' sampai ' . $qrWindow['end']->translatedFormat('H:i') . ' WIB.',
            ]);
        }

        $qrCode = $this->queryOrDefault(fn () => QRCode::where('id_agenda', $agenda->id_agenda)->first());

        if (! $qrCode) {
            return view('publik.presensi-qr-result', [
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

        return view('publik.presensi-qr-result', [
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

        return $this->queryOrDefault(fn () => Agenda::query()
            ->when($id, fn ($query) => $query->whereKey($id))
            ->orderByRaw('tanggal >= ? desc', [Carbon::today(self::PUBLIC_TIMEZONE)->toDateString()])
            ->orderBy('tanggal')
            ->orderBy('waktu')
            ->first());
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
}
