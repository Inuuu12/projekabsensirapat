<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\DataAduan;
use App\Models\Kunjungan;
use App\Models\RuangRapat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $today = Carbon::today();
        $currentYear = (int) Carbon::now()->year;

        // Top Stat Cards
        $totalAgendaHariIni = Agenda::whereDate('tanggal', $today)->count();
        $totalRuangRapat = RuangRapat::count();
        $totalKunjungan = Kunjungan::whereDate('tanggal_kunjungan', $today)->count();
        $totalAduanBaru = DataAduan::whereIn('status', ['Pending', 'Menunggu'])->count();
        $totalMasukkanBaru = $totalAduanBaru;

        // Tahun untuk Filter
        $availableYears = Agenda::selectRaw('YEAR(tanggal) as yr')
            ->whereNotNull('tanggal')
            ->distinct()
            ->pluck('yr')
            ->map(fn($y) => (int)$y)
            ->filter(fn($y) => $y > 2000)
            ->push($currentYear)
            ->unique()
            ->sortDesc()
            ->values();

        $selectedYear = (int) $request->query('tahun', $currentYear);
        if (!$availableYears->contains($selectedYear)) {
            $selectedYear = $currentYear;
        }

        // Ambil semua agenda pada tahun terpilih
        $agendasInYear = Agenda::whereYear('tanggal', $selectedYear)->get();

        // 12 Bulan: Jan - Des
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $bulanNamesFull = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $chartDataSemua = array_fill(0, 12, 0);
        $chartDataInternal = array_fill(0, 12, 0);
        $chartDataMasuk = array_fill(0, 12, 0);
        $chartDataKeluar = array_fill(0, 12, 0);

        foreach ($agendasInYear as $agenda) {
            $month = (int) Carbon::parse($agenda->tanggal)->format('n'); // 1-12
            $idx = $month - 1;
            if ($idx >= 0 && $idx < 12) {
                $chartDataSemua[$idx]++;
                $kat = strtolower((string)($agenda->kategori_surat ?? 'internal'));
                if ($kat === 'internal') {
                    $chartDataInternal[$idx]++;
                } elseif ($kat === 'masuk') {
                    $chartDataMasuk[$idx]++;
                } elseif ($kat === 'keluar') {
                    $chartDataKeluar[$idx]++;
                }
            }
        }

        // Distribusi Kategori Surat untuk Donut Chart
        $countInternal = array_sum($chartDataInternal);
        $countMasuk = array_sum($chartDataMasuk);
        $countKeluar = array_sum($chartDataKeluar);
        $totalAgendaTahun = array_sum($chartDataSemua);

        $donutCategories = [
            'labels' => ['Surat Internal', 'Surat Masuk', 'Surat Keluar'],
            'series' => [$countInternal, $countMasuk, $countKeluar],
            'total' => $totalAgendaTahun,
            'percentages' => [
                'internal' => $totalAgendaTahun > 0 ? round(($countInternal / $totalAgendaTahun) * 100, 1) : 0,
                'masuk' => $totalAgendaTahun > 0 ? round(($countMasuk / $totalAgendaTahun) * 100, 1) : 0,
                'keluar' => $totalAgendaTahun > 0 ? round(($countKeluar / $totalAgendaTahun) * 100, 1) : 0,
            ],
            'counts' => [
                'internal' => $countInternal,
                'masuk' => $countMasuk,
                'keluar' => $countKeluar,
            ],
        ];

        // Metrik Ringkasan Tahunan & Bulanan
        $maxCount = !empty($chartDataSemua) ? max($chartDataSemua) : 0;
        $peakMonthIndex = !empty($chartDataSemua) ? array_search($maxCount, $chartDataSemua) : 0;
        $peakMonthName = $maxCount > 0 ? $bulanNamesFull[$peakMonthIndex] : 'Belum Ada';

        $rataRataBulanan = round($totalAgendaTahun / 12, 1);

        // Agenda Selesai vs Mendatang di tahun tersebut
        $totalSelesai = $agendasInYear->filter(fn($a) => $a->isSelesai())->count();
        $persenSelesai = $totalAgendaTahun > 0 ? round(($totalSelesai / $totalAgendaTahun) * 100) : 0;

        $chartPayload = [
            'selectedYear' => $selectedYear,
            'bulanLabels' => $bulanLabels,
            'bulanNamesFull' => $bulanNamesFull,
            'series' => [
                'semua' => $chartDataSemua,
                'internal' => $chartDataInternal,
                'masuk' => $chartDataMasuk,
                'keluar' => $chartDataKeluar,
            ],
            'donut' => $donutCategories,
            'metrics' => [
                'totalAgendaTahun' => $totalAgendaTahun,
                'peakMonthName' => $peakMonthName,
                'peakMonthCount' => $maxCount,
                'rataRataBulanan' => $rataRataBulanan,
                'totalSelesai' => $totalSelesai,
                'persenSelesai' => $persenSelesai,
            ],
        ];

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $chartPayload,
            ]);
        }

        $agendaTerdekat = Agenda::whereDate('tanggal', '>=', $today)
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu', 'asc')
            ->take(4)
            ->get();

        $aktivitasTerbaru = collect()
            ->merge(Agenda::latest('created_at')->take(3)->get()->map(fn ($item) => [
                'judul' => 'Agenda ditambahkan',
                'deskripsi' => $item->nama_agenda,
                'waktu' => $item->created_at,
            ]))
            ->merge(Kunjungan::latest('created_at')->take(3)->get()->map(fn ($item) => [
                'judul' => 'Kunjungan ditambahkan',
                'deskripsi' => $item->nama_pengunjung ?: $item->asal_instansi ?: 'Kunjungan baru',
                'waktu' => $item->created_at,
            ]))
            ->merge(DataAduan::latest('created_at')->take(3)->get()->map(fn ($item) => [
                'judul' => 'Aduan diterima',
                'deskripsi' => $item->nama_pengadu,
                'waktu' => $item->created_at,
            ]))
            ->sortByDesc('waktu')
            ->take(5)
            ->values();

        return view('admin.dashboard.index', compact(
            'totalAgendaHariIni',
            'totalRuangRapat',
            'totalKunjungan',
            'totalAduanBaru',
            'totalMasukkanBaru',
            'agendaTerdekat',
            'aktivitasTerbaru',
            'availableYears',
            'selectedYear',
            'chartPayload'
        ));
    }

    public function layout(Request $request)
    {
        return $this->dashboard($request);
    }
}
