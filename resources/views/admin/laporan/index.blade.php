@extends('admin.layout.app')

@section('title', 'Laporan')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Laporan</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola dan cetak laporan absensi rapat.</p>
        </div>

        <a href="{{ url('/admin/laporan/cetak') }}" class="bg-[#35635b] hover:bg-[#2b4f49] text-white font-bold py-2.5 px-5 rounded-xl transition shadow-xs self-start sm:self-auto">
            Cetak Laporan
        </a>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-xs">
        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Total Logbook</p>
        <p class="mt-3 text-3xl font-black text-[#35635b]">{{ $totalLogbook }}</p>
    </div>
</div>
@endsection
