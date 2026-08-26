@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] dark:text-white tracking-tight">Dashboard</h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-300 mt-1">Ringkasan aktivitas agenda dan kunjungan.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4 transition-colors">
            <div>
                <p class="text-[11px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Agenda Hari Ini</p>
                <p class="mt-3 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ number_format($totalAgendaHariIni ?? 0) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#f3f7f6] dark:bg-white/10 p-2.5 shrink-0">
                <img src="{{ asset('foto/Agendahariini.png') }}" alt="Agenda Hari Ini" class="w-full h-full object-contain">
            </div>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4 transition-colors">
            <div>
                <p class="text-[11px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ruang Rapat</p>
                <p class="mt-3 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ number_format($totalRuangRapat ?? 0) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#f3f7f6] dark:bg-white/10 p-2.5 shrink-0">
                <img src="{{ asset('foto/Ruanganlogo.png') }}" alt="Ruang Rapat" class="w-full h-full object-contain">
            </div>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4 transition-colors">
            <div>
                <p class="text-[11px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kunjungan</p>
                <p class="mt-3 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ number_format($totalKunjungan ?? 0) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#f3f7f6] dark:bg-white/10 p-2.5 shrink-0">
                <img src="{{ asset('foto/Pengunjunglogo.png') }}" alt="Kunjungan" class="w-full h-full object-contain">
            </div>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4 transition-colors">
            <div>
                <p class="text-[11px] font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Masukkan Baru</p>
                <p class="mt-3 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ number_format($totalMasukkanBaru ?? 0) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#f3f7f6] dark:bg-white/10 p-2.5 shrink-0">
                <img src="{{ asset('foto/Suratlogo.png') }}" alt="Masukkan Baru" class="w-full h-full object-contain">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <section class="lg:col-span-2 bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-6 shadow-xs transition-colors">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Agenda Terdekat</h2>
                <a href="{{ route('admin.agenda.lihat') }}" class="text-sm font-bold text-[#35635b] dark:text-emerald-400 hover:underline">Lihat semua</a>
            </div>

            <div class="space-y-3">
                @forelse ($agendaTerdekat as $item)
                    @php
                        $tanggalAgenda = \Carbon\Carbon::parse($item->tanggal);
                        $labelTanggal = $tanggalAgenda->isToday()
                            ? 'Hari ini'
                            : ($tanggalAgenda->isTomorrow() ? 'Besok' : $tanggalAgenda->translatedFormat('d M Y'));
                    @endphp
                    <div class="flex items-center justify-between rounded-xl bg-[#f3f7f6] dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] px-4 py-3">
                        <div>
                            <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $item->nama_agenda }}</p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">{{ $item->lokasi ?: 'Lokasi belum diisi' }} - {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }} WIB</p>
                        </div>
                        <span class="rounded-full bg-[#35635b]/10 dark:bg-emerald-400/10 px-3 py-1 text-xs font-bold text-[#35635b] dark:text-emerald-400 whitespace-nowrap">{{ $labelTanggal }}</span>
                    </div>
                @empty
                    <div class="rounded-xl bg-[#f3f7f6] dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] px-4 py-6 text-center text-sm font-semibold text-gray-500 dark:text-gray-400">
                        Belum ada agenda terdekat.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-6 shadow-xs transition-colors">
            <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-5">Aktivitas Terbaru</h2>
            <div class="space-y-4">
                @forelse ($aktivitasTerbaru as $aktivitas)
                    <div class="border-b border-gray-50 dark:border-[#233a34] pb-3 last:border-0 last:pb-0">
                        <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $aktivitas['judul'] }}</p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">{{ $aktivitas['deskripsi'] }} - {{ optional($aktivitas['waktu'])->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Belum ada aktivitas terbaru.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection
