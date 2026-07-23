@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Dashboard</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Ringkasan aktivitas agenda dan kunjungan.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Agenda Hari Ini</p>
                <p class="mt-3 text-3xl font-black text-[#35635b]">{{ number_format($totalAgendaHariIni ?? 0) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#f3f7f6] p-2.5 shrink-0">
                <img src="{{ asset('foto/Agendahariini.png') }}" alt="Agenda Hari Ini" class="w-full h-full object-contain">
            </div>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Ruang Rapat</p>
                <p class="mt-3 text-3xl font-black text-[#35635b]">{{ number_format($totalRuangRapat ?? 0) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#f3f7f6] p-2.5 shrink-0">
                <img src="{{ asset('foto/Ruanganlogo.png') }}" alt="Ruang Rapat" class="w-full h-full object-contain">
            </div>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Kunjungan</p>
                <p class="mt-3 text-3xl font-black text-[#35635b]">{{ number_format($totalKunjungan ?? 0) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#f3f7f6] p-2.5 shrink-0">
                <img src="{{ asset('foto/Pengunjunglogo.png') }}" alt="Kunjungan" class="w-full h-full object-contain">
            </div>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Masukkan Baru</p>
                <p class="mt-3 text-3xl font-black text-[#35635b]">{{ number_format($totalMasukkanBaru ?? 0) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-[#f3f7f6] p-2.5 shrink-0">
                <img src="{{ asset('foto/Suratlogo.png') }}" alt="Masukkan Baru" class="w-full h-full object-contain">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <section class="lg:col-span-2 bg-white border border-gray-100 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-gray-800">Agenda Terdekat</h2>
                <a href="{{ route('admin.agenda.lihat') }}" class="text-sm font-bold text-[#35635b] hover:underline">Lihat semua</a>
            </div>

            <div class="space-y-3">
                @forelse ($agendaTerdekat as $item)
                    @php
                        $tanggalAgenda = \Carbon\Carbon::parse($item->tanggal);
                        $labelTanggal = $tanggalAgenda->isToday()
                            ? 'Hari ini'
                            : ($tanggalAgenda->isTomorrow() ? 'Besok' : $tanggalAgenda->translatedFormat('d M Y'));
                    @endphp
                    <div class="flex items-center justify-between rounded-xl bg-[#f3f7f6] px-4 py-3">
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $item->nama_agenda }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ $item->lokasi ?: 'Lokasi belum diisi' }} - {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }} WIB</p>
                        </div>
                        <span class="rounded-full bg-[#35635b]/10 px-3 py-1 text-xs font-bold text-[#35635b] whitespace-nowrap">{{ $labelTanggal }}</span>
                    </div>
                @empty
                    <div class="rounded-xl bg-[#f3f7f6] px-4 py-6 text-center text-sm font-semibold text-gray-500">
                        Belum ada agenda terdekat.
                    </div>
                @endforelse
            </div>
        </section>

        <section class="bg-white border border-gray-100 rounded-2xl p-6 shadow-xs">
            <h2 class="text-lg font-bold text-gray-800 mb-5">Aktivitas Terbaru</h2>
            <div class="space-y-4">
                @forelse ($aktivitasTerbaru as $aktivitas)
                    <div>
                        <p class="text-sm font-bold text-gray-800">{{ $aktivitas['judul'] }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ $aktivitas['deskripsi'] }} - {{ optional($aktivitas['waktu'])->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-sm font-semibold text-gray-500">Belum ada aktivitas terbaru.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection
