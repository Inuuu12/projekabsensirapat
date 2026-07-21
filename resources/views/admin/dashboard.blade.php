@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <!-- Header Title -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Dashboard</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Selamat datang kembali, Admin!</p>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        
        <!-- LEFT COLUMN (2/3 width) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Top Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <!-- Card 1: Agenda Hari Ini -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-xs border border-gray-100 flex flex-col justify-between h-36">
                    <div class="flex justify-between items-start">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">Hari Ini</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">AGENDA HARI INI</p>
                        <p class="text-3xl font-black text-[#35635b] mt-0.5">12</p>
                    </div>
                </div>
                
                <!-- Card 2: Ruangan -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-xs border border-gray-100 flex flex-col justify-between h-36">
                    <div class="flex justify-between items-start">
                        <div class="w-10 h-10 rounded-xl bg-[#e6efed] flex items-center justify-center text-[#35635b]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V5"></path></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">RUANGAN</p>
                        <p class="text-3xl font-black text-[#35635b] mt-0.5">8</p>
                    </div>
                </div>
            </div>

            <!-- Agenda Terdekat Section -->
            <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-xs border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-800">Agenda Terdekat</h2>
                    <a href="{{ route('admin.agenda.lihat') }}" class="text-xs sm:text-sm font-bold text-[#35635b] hover:underline flex items-center gap-1">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                
                <div class="space-y-4">
                    @for ($i = 0; $i < 4; $i++)
                    <div class="bg-[#c8dbd5]/50 hover:bg-[#c8dbd5]/80 transition p-4 sm:p-5 rounded-2xl flex items-center justify-between gap-4 cursor-pointer">
                        <div class="flex items-center gap-4 min-w-0">
                            <!-- Date Badge -->
                            <div class="bg-[#a3c6bc] px-3.5 py-2.5 rounded-xl text-center shrink-0 min-w-[60px]">
                                <p class="text-[10px] font-black text-[#22443e] uppercase leading-tight">OKT</p>
                                <p class="text-xl font-black text-[#22443e] leading-none mt-0.5">27</p>
                            </div>
                            <!-- Agenda Details -->
                            <div class="min-w-0">
                                <h3 class="font-bold text-gray-800 text-sm sm:text-base truncate">Sosialisasi Pajak Daerah 2024</h3>
                                <p class="text-xs text-gray-600 my-1 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    13:00 - 16:00 WIB
                                </p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="bg-[#b7cdc6] text-[#22443e] text-[11px] font-semibold px-2.5 py-0.5 rounded-full">Eksternal</span>
                                    <span class="bg-[#d9e6e2] text-[#22443e] text-[11px] font-semibold px-2.5 py-0.5 rounded-full">Aula Cibinong</span>
                                </div>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN (1/3 width) -->
        <div class="space-y-6">
            
            <!-- Top 3 Instansi Card -->
            <div class="bg-[#c8dbd5] p-6 rounded-2xl shadow-xs text-[#22443e]">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-9 h-9 rounded-xl bg-[#35635b]/15 flex items-center justify-center text-[#22443e]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <span class="text-xs font-bold text-[#22443e] bg-white/40 px-2.5 py-1 rounded-full">Bulan Ini</span>
                </div>
                
                <h3 class="text-xs font-black uppercase tracking-wider leading-relaxed mb-4">
                    TOP 3 INSTANSI<br>UNDANGAN AGENDA TERBANYAK
                </h3>
                
                <ul class="space-y-3 font-semibold text-sm">
                    <li class="flex justify-between items-center bg-white/40 px-3.5 py-2 rounded-xl">
                        <span>1. Dinas Kehutanan</span>
                        <span class="bg-[#35635b]/20 px-2.5 py-0.5 rounded-lg text-xs font-bold">24</span>
                    </li>
                    <li class="flex justify-between items-center bg-white/40 px-3.5 py-2 rounded-xl">
                        <span>2. Dinas Lingkungan Hidup</span>
                        <span class="bg-[#35635b]/20 px-2.5 py-0.5 rounded-lg text-xs font-bold">18</span>
                    </li>
                    <li class="flex justify-between items-center bg-white/40 px-3.5 py-2 rounded-xl">
                        <span>3. Universitas Pakuan</span>
                        <span class="bg-[#35635b]/20 px-2.5 py-0.5 rounded-lg text-xs font-bold">12</span>
                    </li>
                </ul>
            </div>

            <!-- Aktivitas Terbaru (Timeline) -->
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
                <h2 class="text-base font-bold text-gray-800 mb-6">Aktivitas Terbaru</h2>
                
                <div class="relative border-l-2 border-gray-100 ml-3 space-y-6">
                    <div class="ml-6 relative">
                        <span class="absolute flex items-center justify-center w-3.5 h-3.5 bg-[#35635b] rounded-full -left-[1.95rem] top-1 ring-4 ring-white"></span>
                        <h3 class="text-sm font-bold text-gray-800">Data pegawai diperbarui</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Oleh: Budi Santoso • 10 menit lalu</p>
                    </div>
                    <div class="ml-6 relative">
                        <span class="absolute flex items-center justify-center w-3.5 h-3.5 bg-gray-400 rounded-full -left-[1.95rem] top-1 ring-4 ring-white"></span>
                        <h3 class="text-sm font-bold text-gray-800">Agenda rapat ditambahkan</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Oleh: Siti Aminah • 1 jam lalu</p>
                    </div>
                    <div class="ml-6 relative">
                        <span class="absolute flex items-center justify-center w-3.5 h-3.5 bg-gray-400 rounded-full -left-[1.95rem] top-1 ring-4 ring-white"></span>
                        <h3 class="text-sm font-bold text-gray-800">Laporan bulanan diunduh</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Oleh: Admin • 3 jam lalu</p>
                    </div>
                    <div class="ml-6 relative">
                        <span class="absolute flex items-center justify-center w-3.5 h-3.5 bg-[#35635b] rounded-full -left-[1.95rem] top-1 ring-4 ring-white"></span>
                        <h3 class="text-sm font-bold text-gray-800">Data pegawai diperbarui</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Oleh: Budi Santoso • 10 menit lalu</p>
                    </div>
                    <div class="ml-6 relative">
                        <span class="absolute flex items-center justify-center w-3.5 h-3.5 bg-gray-400 rounded-full -left-[1.95rem] top-1 ring-4 ring-white"></span>
                        <h3 class="text-sm font-bold text-gray-800">Agenda rapat ditambahkan</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Oleh: Siti Aminah • 1 jam lalu</p>
                    </div>
                    <div class="ml-6 relative">
                        <span class="absolute flex items-center justify-center w-3.5 h-3.5 bg-gray-400 rounded-full -left-[1.95rem] top-1 ring-4 ring-white"></span>
                        <h3 class="text-sm font-bold text-gray-800">Laporan bulanan diunduh</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Oleh: Admin • 3 jam lalu</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection