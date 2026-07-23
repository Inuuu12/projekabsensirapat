<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\DataMasukan;
use App\Models\Kunjungan;
use App\Models\RuangRapat;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();

        $totalAgendaHariIni = Agenda::whereDate('tanggal', $today)->count();
        $totalRuangRapat = RuangRapat::count();
        $totalKunjungan = Kunjungan::whereDate('tanggal_kunjungan', $today)->count();
        $totalMasukkanBaru = DataMasukan::whereIn('status', ['Pending', 'Menunggu'])->count();

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
            ->merge(DataMasukan::latest('created_at')->take(3)->get()->map(fn ($item) => [
                'judul' => 'Masukkan diterima',
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
            'totalMasukkanBaru',
            'agendaTerdekat',
            'aktivitasTerbaru'
        ));
    }

    public function layout()
    {
        return $this->dashboard();
    }
}
