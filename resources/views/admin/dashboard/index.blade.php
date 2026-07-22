@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Dashboard</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Ringkasan aktivitas agenda dan kunjungan.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Agenda Hari Ini</p>
            <p class="mt-3 text-3xl font-black text-[#35635b]">12</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Ruang Rapat</p>
            <p class="mt-3 text-3xl font-black text-[#35635b]">8</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Kunjungan</p>
            <p class="mt-3 text-3xl font-black text-[#35635b]">24</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Masukkan Baru</p>
            <p class="mt-3 text-3xl font-black text-[#35635b]">5</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <section class="lg:col-span-2 bg-white border border-gray-100 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-gray-800">Agenda Terdekat</h2>
                <a href="{{ route('admin.agenda.lihat') }}" class="text-sm font-bold text-[#35635b] hover:underline">Lihat semua</a>
            </div>

            <div class="space-y-3">
                @for ($i = 0; $i < 4; $i++)
                    <div class="flex items-center justify-between rounded-xl bg-[#f3f7f6] px-4 py-3">
                        <div>
                            <p class="text-sm font-bold text-gray-800">Rapat Koordinasi Internal</p>
                            <p class="mt-1 text-xs text-gray-500">Ruang Rapat Utama - 09:00 WIB</p>
                        </div>
                        <span class="rounded-full bg-[#35635b]/10 px-3 py-1 text-xs font-bold text-[#35635b]">Hari ini</span>
                    </div>
                @endfor
            </div>
        </section>

        <section class="bg-white border border-gray-100 rounded-2xl p-6 shadow-xs">
            <h2 class="text-lg font-bold text-gray-800 mb-5">Aktivitas Terbaru</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-bold text-gray-800">Agenda ditambahkan</p>
                    <p class="mt-1 text-xs text-gray-500">10 menit lalu</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">Data pegawai diperbarui</p>
                    <p class="mt-1 text-xs text-gray-500">1 jam lalu</p>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">Laporan dicetak</p>
                    <p class="mt-1 text-xs text-gray-500">3 jam lalu</p>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
