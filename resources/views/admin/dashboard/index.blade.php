@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Header Section -->
    <div>
        <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Dashboard</h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">Selamat datang kembali di SIRAPI. Pantau analitik agenda dan laporan kegiatan {{ Auth::guard('admin')->user()?->getInstansiInfo()['singkatan'] ?? 'Diskominfo' }}.</p>
    </div>

    <!-- 1. Top Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        
        <!-- Card 1: Agenda Hari Ini -->
        <div class="relative overflow-hidden bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs flex flex-col justify-between transition-all hover:border-emerald-500/50 hover:shadow-md group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Agenda Hari Ini</span>
            </div>
            <div class="mt-3">
                <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">{{ number_format($totalAgendaHariIni ?? 0) }}</p>
                
            </div>
        </div>

        <!-- Card 2: Ruangan Rapat -->
        <div class="relative overflow-hidden bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs flex flex-col justify-between transition-all hover:border-cyan-500/50 hover:shadow-md group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ruang Rapat</span>
            </div>
            <div class="mt-3">
                <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">{{ number_format($totalRuangRapat ?? 0) }}</p>
            </div>
        </div>

        <!-- Card 3: Kunjungan Tamu -->
        <div class="relative overflow-hidden bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs flex flex-col justify-between transition-all hover:border-indigo-500/50 hover:shadow-md group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kunjungan</span>
            </div>
            <div class="mt-3">
                <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">{{ number_format($totalKunjungan ?? 0) }}</p>
            </div>
        </div>

        <!-- Card 4: Aduan & Masukan -->
        <div class="relative overflow-hidden bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs flex flex-col justify-between transition-all hover:border-amber-500/50 hover:shadow-md group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aduan Baru</span>
            </div>
            <div class="mt-3">
                <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">{{ number_format($totalAduanBaru ?? $totalMasukkanBaru ?? 0) }}</p>
            </div>
        </div>

    </div>

    <!-- 2. Main Analytics & Agenda Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Area: Overview Monthly Area Spline Chart + Agenda Terdekat -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Card 1: Overview Monthly Area Spline Chart (Jan - Des) -->
            <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 sm:p-6 shadow-xs transition-colors">
                
                <!-- Card Header with Filters -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-100 dark:border-[#233a34]">
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-gray-900 dark:text-white flex items-center gap-2">
                            <span>Laporan Agenda</span>
                        </h2>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <!-- Dropdown Filter Tahun -->
                        <div class="relative">
                            <select id="filter-year-select" onchange="handleYearChange(this.value)" class="h-8 sm:h-9 appearance-none rounded-xl border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] pl-3 pr-8 text-xs font-bold text-gray-800 dark:text-white outline-none focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] cursor-pointer shadow-2xs">
                                @foreach ($availableYears as $yr)
                                    <option value="{{ $yr }}" {{ $yr == $selectedYear ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                                @endforeach
                            </select>
                            <svg class="pointer-events-none absolute right-2.5 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>

                        <!-- Category Pills Switcher -->
                        <div class="inline-flex rounded-xl bg-gray-100 dark:bg-[#0f1c19] p-1 border border-transparent dark:border-[#284c43] text-xs">
                            <button type="button" onclick="switchChartCategory('semua')" id="btn-cat-semua" class="cat-pill rounded-lg px-2.5 py-1 text-xs font-bold transition-all bg-white dark:bg-[#1b3832] text-[#35635b] dark:text-emerald-300 shadow-xs cursor-pointer">Semua</button>
                            <button type="button" onclick="switchChartCategory('internal')" id="btn-cat-internal" class="cat-pill rounded-lg px-2.5 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all cursor-pointer">Internal</button>
                            <button type="button" onclick="switchChartCategory('masuk')" id="btn-cat-masuk" class="cat-pill rounded-lg px-2.5 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all cursor-pointer">Masuk</button>
                            <button type="button" onclick="switchChartCategory('keluar')" id="btn-cat-keluar" class="cat-pill rounded-lg px-2.5 py-1 text-xs font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all cursor-pointer">Keluar</button>
                        </div>
                    </div>
                </div>

                <!-- ApexCharts Area Spline Chart Element -->
                <div class="mt-4">
                    <div id="monthly-agenda-chart" class="w-full min-h-[300px] sm:min-h-[340px]"></div>
                </div>

            </div>

            <!-- Card 2: Agenda Terdekat -->
            <section class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-6 shadow-xs transition-colors">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-800 dark:text-white">Agenda Terdekat</h2>
                    </div>
                    <a href="{{ route('admin.agenda.lihat') }}" class="text-xs sm:text-sm font-bold text-[#35635b] dark:text-emerald-400 hover:underline">Lihat semua</a>
                </div>

                <div class="space-y-3">
                    @forelse ($agendaTerdekat as $item)
                        @php
                            $tanggalAgenda = \Carbon\Carbon::parse($item->tanggal);
                            $labelTanggal = $tanggalAgenda->isToday()
                                ? 'Hari ini'
                                : ($tanggalAgenda->isTomorrow() ? 'Besok' : $tanggalAgenda->translatedFormat('d M Y'));
                            $katSurat = strtolower((string)($item->kategori_surat ?? 'internal'));
                            $katBadgeClass = $katSurat === 'internal' 
                                ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300' 
                                : ($katSurat === 'masuk' ? 'bg-sky-100 text-sky-800 dark:bg-sky-950/80 dark:text-sky-300' : 'bg-purple-100 text-purple-800 dark:bg-purple-950/80 dark:text-purple-300');
                        @endphp
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 rounded-xl bg-[#f3f7f6] dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] p-3.5 sm:px-4 sm:py-3 transition hover:border-[#35635b]/30">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 text-[9.5px] font-extrabold rounded-md {{ $katBadgeClass }} uppercase tracking-wider">
                                        {{ $katSurat }}
                                    </span>
                                    <p class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white truncate">{{ $item->nama_agenda }}</p>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 truncate">
                                    📍 {{ $item->lokasi_display ?? $item->lokasi ?: 'Lokasi belum diisi' }} • 🕒 {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }} WIB
                                </p>
                            </div>
                            @if ($item->isBerlangsung())
                                <span class="self-start sm:self-center rounded-full bg-emerald-600 text-white px-2.5 py-0.5 text-[11px] font-black whitespace-nowrap inline-flex items-center gap-1.5 shadow-xs">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                                    </span>
                                    <span>Live</span>
                                </span>
                            @else
                                <span class="self-start sm:self-center rounded-full bg-[#35635b]/10 dark:bg-emerald-400/10 px-3 py-1 text-xs font-bold text-[#35635b] dark:text-emerald-400 whitespace-nowrap">{{ $labelTanggal }}</span>
                            @endif
                        </div>
                    @empty
                        <div class="rounded-xl bg-[#f3f7f6] dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] px-4 py-8 text-center text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400">
                            Belum ada agenda terdekat.
                        </div>
                    @endforelse
                </div>
            </section>

        </div>

        <!-- Right Area: Donut Chart, Ringkasan Performa & Aktivitas Terbaru -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Card A: Donut Chart (Traffic Sources equivalent) -->
            <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 sm:p-6 shadow-xs transition-colors">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-[#233a34]">
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-gray-900 dark:text-white">Kategori Surat</h3>
                    </div>
                </div>

                <!-- Donut Chart Container -->
                <div class="py-2">
                    <div id="category-donut-chart" class="flex items-center justify-center"></div>
                </div>

                <!-- Custom Donut Legend with Values and Percentages -->
                <div class="space-y-2.5 pt-2 border-t border-gray-100 dark:border-[#233a34]">
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#10b981]"></span>
                            <span class="font-bold text-gray-800 dark:text-gray-200">Surat Internal</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span id="donut-count-internal" class="text-gray-500 dark:text-gray-400 font-medium">{{ $chartPayload['donut']['counts']['internal'] }} agenda</span>
                            <span id="donut-pct-internal" class="font-extrabold text-gray-900 dark:text-white w-10 text-right">{{ $chartPayload['donut']['percentages']['internal'] }}%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#0ea5e9]"></span>
                            <span class="font-bold text-gray-800 dark:text-gray-200">Surat Masuk</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span id="donut-count-masuk" class="text-gray-500 dark:text-gray-400 font-medium">{{ $chartPayload['donut']['counts']['masuk'] }} agenda</span>
                            <span id="donut-pct-masuk" class="font-extrabold text-gray-900 dark:text-white w-10 text-right">{{ $chartPayload['donut']['percentages']['masuk'] }}%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#8b5cf6]"></span>
                            <span class="font-bold text-gray-800 dark:text-gray-200">Surat Keluar</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span id="donut-count-keluar" class="text-gray-500 dark:text-gray-400 font-medium">{{ $chartPayload['donut']['counts']['keluar'] }} agenda</span>
                            <span id="donut-pct-keluar" class="font-extrabold text-gray-900 dark:text-white w-10 text-right">{{ $chartPayload['donut']['percentages']['keluar'] }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card B: Ringkasan Laporan Bulanan (Monthly Goals equivalent) -->
            <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 sm:p-6 shadow-xs transition-colors space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-[#233a34]">
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-gray-900 dark:text-white">Ringkasan Laporan</h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Statistik capaian agenda tahun <span class="label-selected-year-display font-bold">{{ $selectedYear }}</span></p>
                    </div>
                </div>

                <!-- Goal 1: Tingkat Agenda Selesai -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-gray-800 dark:text-gray-200">Tingkat Agenda Selesai</span>
                        <span id="goal-pct-selesai" class="font-extrabold text-[#35635b] dark:text-emerald-400">{{ $chartPayload['metrics']['persenSelesai'] }}%</span>
                    </div>
                    <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-[#0f1c19]">
                        <div id="goal-bar-selesai" class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-400 transition-all duration-500" style="width: {{ $chartPayload['metrics']['persenSelesai'] }}%"></div>
                    </div>
                    <p id="goal-text-selesai" class="text-[11px] text-gray-500 dark:text-gray-400">
                        {{ $chartPayload['metrics']['totalSelesai'] }} dari {{ $chartPayload['metrics']['totalAgendaTahun'] }} agenda telah diselesaikan
                    </p>
                </div>

                <!-- Goal 2: Bulan Terpadat -->
                <div class="pt-2 border-t border-gray-50 dark:border-[#233a34] space-y-1">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-gray-800 dark:text-gray-200">Aktivitas Terpadat</span>
                        <span id="goal-peak-badge" class="px-2 py-0.5 rounded-md bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 text-[10px] font-bold">
                            {{ $chartPayload['metrics']['peakMonthName'] }}
                        </span>
                    </div>
                    <p id="goal-peak-text" class="text-[11px] text-gray-500 dark:text-gray-400">
                        Puncak kegiatan sebanyak <strong id="goal-peak-strong" class="text-gray-800 dark:text-white">{{ $chartPayload['metrics']['peakMonthCount'] }}</strong> agenda rapat.
                    </p>
                </div>
            </div>

            <!-- Card C: Aktivitas Terbaru -->
            <section class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-6 shadow-xs transition-colors">
                <h2 class="text-base sm:text-lg font-bold text-gray-800 dark:text-white mb-1">Aktivitas Terbaru</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-5">Log pencatatan data pada sistem</p>
                <div class="space-y-4">
                    @forelse ($aktivitasTerbaru as $aktivitas)
                        <div class="border-b border-gray-50 dark:border-[#233a34] pb-3 last:border-0 last:pb-0">
                            <p class="text-xs sm:text-sm font-bold text-gray-800 dark:text-white">{{ $aktivitas['judul'] }}</p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 line-clamp-1">{{ $aktivitas['deskripsi'] }}</p>
                            <span class="inline-block mt-0.5 text-[10px] text-gray-400 dark:text-gray-500 font-medium">{{ optional($aktivitas['waktu'])->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-xs sm:text-sm font-semibold text-gray-500 dark:text-gray-400 py-4 text-center">Belum ada aktivitas terbaru.</p>
                    @endforelse
                </div>
            </section>

        </div>

    </div>

</div>

@push('scripts')
<style>
    /* ========================================================
       PREMIUM APEXCHARTS TOOLBAR STYLING (SIRAPI THEME)
       ======================================================== */
    #monthly-agenda-chart .apexcharts-toolbar {
        z-index: 10 !important;
        top: 2px !important;
        right: 12px !important;
        padding: 3px 6px !important;
        border-radius: 10px !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px -1px rgba(0, 0, 0, 0.04) !important;
        display: flex !important;
        align-items: center !important;
        gap: 3px !important;
    }
    .dark #monthly-agenda-chart .apexcharts-toolbar {
        background: #152420 !important;
        border-color: #233a34 !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35) !important;
    }

    /* Individual tool buttons */
    #monthly-agenda-chart .apexcharts-toolbar > div {
        width: 26px !important;
        height: 26px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 7px !important;
        margin: 0 !important;
        padding: 0 !important;
        background: transparent !important;
        border: 1px solid transparent !important;
        transition: all 0.18s ease !important;
        cursor: pointer !important;
    }

    /* SVG icon default styles (all toolbar icons are stroke-based: +, -, zoom, pan, reset) */
    #monthly-agenda-chart .apexcharts-toolbar > div svg {
        fill: none !important;
        stroke: #64748b !important;
        color: #64748b !important;
        width: 14px !important;
        height: 14px !important;
        transition: all 0.18s ease !important;
    }
    .dark #monthly-agenda-chart .apexcharts-toolbar > div svg {
        fill: none !important;
        stroke: #9ca3af !important;
        color: #9ca3af !important;
    }

    /* Hover state */
    #monthly-agenda-chart .apexcharts-toolbar > div:hover {
        background: #ecfdf5 !important;
        border-color: #a7f3d0 !important;
    }
    .dark #monthly-agenda-chart .apexcharts-toolbar > div:hover {
        background: #1b3832 !important;
        border-color: #284c43 !important;
    }
    #monthly-agenda-chart .apexcharts-toolbar > div:hover svg {
        fill: none !important;
        stroke: #059669 !important;
        color: #059669 !important;
        transform: scale(1.1) !important;
    }
    .dark #monthly-agenda-chart .apexcharts-toolbar > div:hover svg {
        fill: none !important;
        stroke: #34d399 !important;
        color: #34d399 !important;
    }

    /* Active / Selected tool state (Overrides the harsh ApexCharts blue #008FFB) */
    #monthly-agenda-chart .apexcharts-toolbar > div.apexcharts-selected,
    #monthly-agenda-chart .apexcharts-toolbar > div.apexcharts-selected:hover,
    #monthly-agenda-chart .apexcharts-theme-light .apexcharts-pan-icon.apexcharts-selected,
    #monthly-agenda-chart .apexcharts-theme-light .apexcharts-zoom-icon.apexcharts-selected {
        background: #d1fae5 !important;
        border-color: #6ee7b7 !important;
        color: #047857 !important;
    }
    .dark #monthly-agenda-chart .apexcharts-toolbar > div.apexcharts-selected,
    .dark #monthly-agenda-chart .apexcharts-toolbar > div.apexcharts-selected:hover,
    .dark #monthly-agenda-chart .apexcharts-theme-dark .apexcharts-pan-icon.apexcharts-selected,
    .dark #monthly-agenda-chart .apexcharts-theme-dark .apexcharts-zoom-icon.apexcharts-selected {
        background: #1b3832 !important;
        border-color: #059669 !important;
        color: #34d399 !important;
    }
    #monthly-agenda-chart .apexcharts-toolbar > div.apexcharts-selected svg,
    #monthly-agenda-chart .apexcharts-toolbar > div.apexcharts-selected svg path,
    #monthly-agenda-chart .apexcharts-toolbar > div.apexcharts-selected svg circle,
    #monthly-agenda-chart .apexcharts-theme-light .apexcharts-pan-icon.apexcharts-selected svg,
    #monthly-agenda-chart .apexcharts-theme-light .apexcharts-zoom-icon.apexcharts-selected svg,
    #monthly-agenda-chart .apexcharts-theme-light .apexcharts-pan-icon.apexcharts-selected svg path,
    #monthly-agenda-chart .apexcharts-theme-light .apexcharts-zoom-icon.apexcharts-selected svg path,
    #monthly-agenda-chart .apexcharts-theme-light .apexcharts-zoom-icon.apexcharts-selected svg circle {
        fill: none !important;
        stroke: #047857 !important;
        color: #047857 !important;
    }
    .dark #monthly-agenda-chart .apexcharts-toolbar > div.apexcharts-selected svg,
    .dark #monthly-agenda-chart .apexcharts-toolbar > div.apexcharts-selected svg path,
    .dark #monthly-agenda-chart .apexcharts-toolbar > div.apexcharts-selected svg circle,
    .dark #monthly-agenda-chart .apexcharts-theme-dark .apexcharts-pan-icon.apexcharts-selected svg,
    .dark #monthly-agenda-chart .apexcharts-theme-dark .apexcharts-zoom-icon.apexcharts-selected svg,
    .dark #monthly-agenda-chart .apexcharts-theme-dark .apexcharts-pan-icon.apexcharts-selected svg path,
    .dark #monthly-agenda-chart .apexcharts-theme-dark .apexcharts-zoom-icon.apexcharts-selected svg path,
    .dark #monthly-agenda-chart .apexcharts-theme-dark .apexcharts-zoom-icon.apexcharts-selected svg circle {
        fill: none !important;
        stroke: #34d399 !important;
        color: #34d399 !important;
    }

    /* Pastikan tombol reset zoom selalu tampil di toolbar (jangan disembunyikan oleh .apexcharts-hide bawaan ApexCharts) */
    #monthly-agenda-chart .apexcharts-reset-icon,
    #monthly-agenda-chart .apexcharts-reset-icon.apexcharts-hide {
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Reset button specific SVG styling - keeps circular restart arrow crisp and clean */
    #monthly-agenda-chart .apexcharts-reset-icon svg {
        fill: none !important;
        stroke: #64748b !important;
        color: #64748b !important;
        stroke-width: 2.3 !important;
        stroke-linecap: round !important;
        stroke-linejoin: round !important;
    }
    .dark #monthly-agenda-chart .apexcharts-reset-icon svg {
        fill: none !important;
        stroke: #9ca3af !important;
        color: #9ca3af !important;
    }
    #monthly-agenda-chart .apexcharts-reset-icon:hover svg {
        fill: none !important;
        stroke: #059669 !important;
        color: #059669 !important;
    }
    .dark #monthly-agenda-chart .apexcharts-reset-icon:hover svg {
        fill: none !important;
        stroke: #34d399 !important;
        color: #34d399 !important;
    }
</style>
<!-- Load ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    let chartPayload = @json($chartPayload);
    let currentCategory = 'semua';
    let splineChart = null;
    let donutChart = null;

    function isDarkMode() {
        return document.documentElement.classList.contains('dark');
    }

    function resetChartZoom() {
        const icon = document.querySelector('#monthly-agenda-chart .apexcharts-reset-icon');
        if (icon) {
            icon.dispatchEvent(new MouseEvent('click', { bubbles: true }));
        }
        if (splineChart) {
            splineChart.updateOptions({
                xaxis: {
                    min: undefined,
                    max: undefined
                }
            });
        }
    }

    function initSplineChart() {
        const isDark = isDarkMode();
        const activeSeriesData = chartPayload.series[currentCategory] || chartPayload.series.semua;

        const options = {
            chart: {
                id: 'monthly-agenda-spline',
                type: 'area',
                height: 320,
                toolbar: {
                    show: true,
                    offsetX: 0,
                    offsetY: 2,
                    tools: {
                        download: false,
                        selection: false,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M12.8 11.2L9.2 7.6L13.4 4.6A8.2 8.2 0 1 1 5.4 9.2"/></svg>'
                    },
                    autoSelected: 'zoom'
                },
                zoom: {
                    enabled: true,
                    type: 'x',
                    autoScaleYaxis: true
                },
                fontFamily: 'Poppins, sans-serif',
                background: 'transparent',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 600,
                }
            },
            series: [{
                name: getCategoryLabel(currentCategory),
                data: activeSeriesData
            }],
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: [getCategoryColor(currentCategory)]
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 90, 100],
                    colorStops: [
                        { offset: 0, color: getCategoryColor(currentCategory), opacity: 0.45 },
                        { offset: 100, color: getCategoryColor(currentCategory), opacity: 0.0 }
                    ]
                }
            },
            colors: [getCategoryColor(currentCategory)],
            xaxis: {
                categories: chartPayload.bulanLabels,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: {
                        colors: isDark ? '#9ca3af' : '#64748b',
                        fontSize: '11px',
                        fontWeight: 600
                    }
                }
            },
            yaxis: {
                min: 0,
                forceNiceScale: true,
                labels: {
                    formatter: function (val) {
                        return Math.round(val);
                    },
                    style: {
                        colors: isDark ? '#9ca3af' : '#64748b',
                        fontSize: '11px',
                        fontWeight: 600
                    }
                }
            },
            grid: {
                borderColor: isDark ? '#233a34' : '#f1f5f9',
                strokeDashArray: 4,
                padding: { top: 0, right: 10, bottom: 0, left: 10 }
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                x: {
                    formatter: function(val, opts) {
                        const idx = opts.dataPointIndex;
                        return chartPayload.bulanNamesFull[idx] || val;
                    }
                },
                y: {
                    formatter: function(val) {
                        return val + ' Agenda';
                    }
                }
            }
        };

        const container = document.getElementById('monthly-agenda-chart');
        if (container) {
            container.innerHTML = '';
            splineChart = new ApexCharts(container, options);
            splineChart.render();

            container.addEventListener('dblclick', function(e) {
                if (e.target.closest('.apexcharts-toolbar')) return;
                resetChartZoom();
            });

            // Pastikan klik tombol reset zoom selalu mereset tampilan grafik
            container.addEventListener('click', function(e) {
                const resetBtn = e.target.closest('.apexcharts-reset-icon');
                if (resetBtn && splineChart) {
                    splineChart.updateOptions({
                        xaxis: {
                            min: undefined,
                            max: undefined
                        }
                    });
                }
            });
        }
    }

    function initDonutChart() {
        const isDark = isDarkMode();
        const donut = chartPayload.donut;

        const options = {
            chart: {
                type: 'donut',
                height: 230,
                background: 'transparent',
                fontFamily: 'Poppins, sans-serif'
            },
            series: donut.series,
            labels: donut.labels,
            colors: ['#10b981', '#0ea5e9', '#8b5cf6'],
            stroke: {
                colors: [isDark ? '#152420' : '#ffffff'],
                width: 3
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '76%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '11px',
                                fontWeight: 600,
                                color: isDark ? '#9ca3af' : '#64748b',
                                offsetY: -2
                            },
                            value: {
                                show: true,
                                fontSize: '24px',
                                fontWeight: 900,
                                color: isDark ? '#ffffff' : '#0f172a',
                                offsetY: 6,
                                formatter: function(val) {
                                    return val;
                                }
                            },
                            total: {
                                show: true,
                                label: 'Total Agenda',
                                color: isDark ? '#9ca3af' : '#64748b',
                                formatter: function() {
                                    return donut.total;
                                }
                            }
                        }
                    }
                }
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: {
                    formatter: function(val) {
                        return val + ' Agenda';
                    }
                }
            }
        };

        const container = document.getElementById('category-donut-chart');
        if (container) {
            container.innerHTML = '';
            donutChart = new ApexCharts(container, options);
            donutChart.render();
        }
    }

    function getCategoryLabel(cat) {
        switch(cat) {
            case 'internal': return 'Surat Internal';
            case 'masuk': return 'Surat Masuk';
            case 'keluar': return 'Surat Keluar';
            default: return 'Semua Agenda';
        }
    }

    function getCategoryColor(cat) {
        switch(cat) {
            case 'internal': return '#10b981';
            case 'masuk': return '#0ea5e9';
            case 'keluar': return '#8b5cf6';
            default: return '#10b981';
        }
    }

    function switchChartCategory(cat) {
        currentCategory = cat;
        resetChartZoom();
        
        // Update styling of pills
        document.querySelectorAll('.cat-pill').forEach(btn => {
            btn.classList.remove('bg-white', 'dark:bg-[#1b3832]', 'text-[#35635b]', 'dark:text-emerald-300', 'shadow-xs', 'font-bold');
            btn.classList.add('font-medium', 'text-gray-600', 'dark:text-gray-400');
        });

        const activeBtn = document.getElementById('btn-cat-' + cat);
        if (activeBtn) {
            activeBtn.classList.remove('font-medium', 'text-gray-600', 'dark:text-gray-400');
            activeBtn.classList.add('bg-white', 'dark:bg-[#1b3832]', 'text-[#35635b]', 'dark:text-emerald-300', 'shadow-xs', 'font-bold');
        }

        const data = chartPayload.series[cat] || chartPayload.series.semua;
        const color = getCategoryColor(cat);

        if (splineChart) {
            splineChart.updateOptions({
                stroke: { colors: [color] },
                colors: [color],
                fill: {
                    colorStops: [
                        { offset: 0, color: color, opacity: 0.45 },
                        { offset: 100, color: color, opacity: 0.0 }
                    ]
                }
            });
            splineChart.updateSeries([{
                name: getCategoryLabel(cat),
                data: data
            }]);
        }
    }

    async function handleYearChange(year) {
        try {
            const url = `{{ route('admin.dashboard') }}?tahun=${year}`;
            const res = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const json = await res.json();
            if (json.success && json.data) {
                chartPayload = json.data;
                updateDashboardDOM(year);
                initSplineChart();
                initDonutChart();
                window.history.pushState({}, '', url);
                return;
            }
        } catch (e) {
            console.log('Fallback to full navigation for year filter');
        }
        window.location.href = `{{ route('admin.dashboard') }}?tahun=${year}`;
    }

    function updateDashboardDOM(year) {
        document.querySelectorAll('.label-selected-year-display').forEach(el => {
            el.textContent = year;
        });

        const m = chartPayload.metrics;
        const d = chartPayload.donut;

        if (document.getElementById('stat-total-agenda')) document.getElementById('stat-total-agenda').textContent = m.totalAgendaTahun;
        if (document.getElementById('stat-peak-month')) document.getElementById('stat-peak-month').textContent = m.peakMonthName;
        if (document.getElementById('stat-avg-month')) document.getElementById('stat-avg-month').textContent = m.rataRataBulanan;
        if (document.getElementById('stat-completed')) document.getElementById('stat-completed').textContent = m.totalSelesai;

        if (document.getElementById('donut-count-internal')) document.getElementById('donut-count-internal').textContent = d.counts.internal + ' agenda';
        if (document.getElementById('donut-pct-internal')) document.getElementById('donut-pct-internal').textContent = d.percentages.internal + '%';

        if (document.getElementById('donut-count-masuk')) document.getElementById('donut-count-masuk').textContent = d.counts.masuk + ' agenda';
        if (document.getElementById('donut-pct-masuk')) document.getElementById('donut-pct-masuk').textContent = d.percentages.masuk + '%';

        if (document.getElementById('donut-count-keluar')) document.getElementById('donut-count-keluar').textContent = d.counts.keluar + ' agenda';
        if (document.getElementById('donut-pct-keluar')) document.getElementById('donut-pct-keluar').textContent = d.percentages.keluar + '%';

        if (document.getElementById('goal-pct-selesai')) document.getElementById('goal-pct-selesai').textContent = m.persenSelesai + '%';
        if (document.getElementById('goal-bar-selesai')) document.getElementById('goal-bar-selesai').style.width = m.persenSelesai + '%';
        if (document.getElementById('goal-text-selesai')) document.getElementById('goal-text-selesai').textContent = `${m.totalSelesai} dari ${m.totalAgendaTahun} agenda telah diselesaikan`;

        if (document.getElementById('goal-peak-badge')) document.getElementById('goal-peak-badge').textContent = m.peakMonthName;
        if (document.getElementById('goal-peak-strong')) document.getElementById('goal-peak-strong').textContent = m.peakMonthCount;
    }

    // Handle Sirapi Dark / Light Theme Toggle in Realtime
    window.addEventListener('sirapi-theme-changed', function(e) {
        const isDark = e.detail.theme === 'dark';
        if (splineChart) {
            splineChart.updateOptions({
                theme: { mode: isDark ? 'dark' : 'light' },
                grid: { borderColor: isDark ? '#233a34' : '#f1f5f9' },
                xaxis: { labels: { style: { colors: isDark ? '#9ca3af' : '#64748b' } } },
                yaxis: { labels: { style: { colors: isDark ? '#9ca3af' : '#64748b' } } },
            });
        }
        if (donutChart) {
            donutChart.updateOptions({
                theme: { mode: isDark ? 'dark' : 'light' },
                stroke: { colors: [isDark ? '#152420' : '#ffffff'] },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                total: {
                                    color: isDark ? '#9ca3af' : '#64748b'
                                },
                                value: {
                                    color: isDark ? '#ffffff' : '#0f172a'
                                }
                            }
                        }
                    }
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        initSplineChart();
        initDonutChart();
    });
</script>
@endpush
@endsection

