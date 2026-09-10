<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Publik - RAPID</title>
    @include('publik.layout.theme_script')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'ijo-tua': '#35635b',
                        'ijo-semitua': '#2b4f49',
                        'ijo-muda': '#4e857b',
                        'ijo-sangatmuda': '#e3eeea',
                        'oren-utama': '#D89B3C',
                        'biru-muda': '#DCEEF5',
                        'biru-tua': '#1E6E8C',
                        'oren-muda': '#FBEBD1',
                        'oren-tua': '#B87A1E',
                    }
                }
            }
        }
    </script>
    <!-- Leaflet CSS & JS for GIS Map Sebaran -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        .leaflet-popup-content-wrapper {
            border-radius: 16px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15) !important;
        }
        .leaflet-popup-content {
            margin: 14px 16px !important;
            line-height: 1.4 !important;
        }
        .leaflet-container a.leaflet-popup-btn,
        .leaflet-popup-content a {
            color: #ffffff !important;
            text-decoration: none !important;
        }
        .leaflet-container a.leaflet-popup-btn:hover,
        .leaflet-popup-content a:hover {
            color: #ffffff !important;
            opacity: 0.92;
        }

        /* ===== HERO BANNER FULL-WIDTH BREAKOUT ===== */
        .hero-fullwidth-breakout {
            width: 100vw;
            position: relative;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            margin-top: -2rem !important;
            /* Pastikan tidak ada gap kanan akibat scrollbar */
            box-sizing: border-box;
        }

        /* ===== HERO BUTTON: Primary (Lihat Agenda) ===== */
        .hero-btn-primary {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            font-size: 0.9rem;
            font-weight: 800;
            color: #ffffff;
            background: linear-gradient(135deg, #35635b 0%, #2b4f49 50%, #1e3934 100%);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 9999px;
            cursor: pointer;
            text-decoration: none;
            overflow: hidden;
            transition: transform 0.25s cubic-bezier(.34,1.56,.64,1), box-shadow 0.25s ease;
            box-shadow: 0 4px 20px rgba(53,99,91,0.45), 0 0 0 0 rgba(255,255,255,0);
            letter-spacing: 0.01em;
        }
        .hero-btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.22) 50%, transparent 60%);
            background-size: 200% 100%;
            background-position: -100% 0;
            transition: background-position 0.5s ease;
            border-radius: inherit;
        }
        .hero-btn-primary:hover::before {
            background-position: 200% 0;
        }
        .hero-btn-primary:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 8px 32px rgba(53,99,91,0.6), 0 0 0 4px rgba(255,255,255,0.12);
        }
        .hero-btn-primary:active {
            transform: translateY(0px) scale(0.98);
        }

        /* ===== HERO BUTTON: Ghost (Peserta Magang) ===== */
        .hero-btn-ghost {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 13px 32px;
            font-size: 0.9rem;
            font-weight: 800;
            color: #ffffff;
            background: rgba(255,255,255,0.08);
            border: 1.5px solid rgba(255,255,255,0.35);
            border-radius: 9999px;
            cursor: pointer;
            text-decoration: none;
            overflow: hidden;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: transform 0.25s cubic-bezier(.34,1.56,.64,1), box-shadow 0.25s ease, background 0.25s ease, border-color 0.25s ease;
            box-shadow: 0 2px 12px rgba(0,0,0,0.25), inset 0 1px 0 rgba(255,255,255,0.15);
            letter-spacing: 0.01em;
        }
        .hero-btn-ghost::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.12) 50%, transparent 60%);
            background-size: 200% 100%;
            background-position: -100% 0;
            transition: background-position 0.5s ease;
            border-radius: inherit;
        }
        .hero-btn-ghost:hover::before {
            background-position: 200% 0;
        }
        .hero-btn-ghost:hover {
            transform: translateY(-3px) scale(1.03);
            background: rgba(255,255,255,0.16);
            border-color: rgba(255,255,255,0.55);
            box-shadow: 0 8px 28px rgba(0,0,0,0.3), 0 0 0 4px rgba(255,255,255,0.06), inset 0 1px 0 rgba(255,255,255,0.2);
        }
        .hero-btn-ghost:active {
            transform: translateY(0px) scale(0.98);
        }

        /* ===== HERO FLOATING BADGE ===== */
        @keyframes hero-badge-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.85; }
        }
        .hero-live-badge {
            animation: hero-badge-pulse 2.5s ease-in-out infinite;
        }

        /* ===== HERO CONTENT FADE-IN ===== */
        @keyframes heroFadeUp {
            from { opacity: 0; transform: translateY(45px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .hero-fade-up-1 { animation: heroFadeUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .hero-fade-up-2 { animation: heroFadeUp 1.2s 0.25s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .hero-fade-up-3 { animation: heroFadeUp 1.2s 0.5s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .hero-fade-up-4 { animation: heroFadeUp 1.2s 0.75s cubic-bezier(0.16, 1, 0.3, 1) both; }

        /* ===== SCROLL REVEAL ANIMATION ===== */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(55px);
            transition: opacity 1.3s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 1.3s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .scroll-reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        /* Stagger children inside grid cards */
        .scroll-reveal-child {
            opacity: 0;
            transform: translateY(35px);
            transition: opacity 1.0s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 1.0s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .scroll-reveal-child.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-[#F8F7F4] dark:bg-[#0d1614] font-sans antialiased text-gray-800 dark:text-slate-100 flex flex-col min-h-screen transition-colors duration-200 overflow-x-hidden">
    @include('publik.layout.navbarpublik')

    <main class="flex-grow w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 pt-0 space-y-16 sm:space-y-20">
        @php
            $agendaItems = collect($agendaBeranda ?? $agendaHariIni ?? []);
            $agendaTerbaruItems = collect($agendaTerbaru ?? []);
            $beritaItems = collect($beritaTerbaru ?? []);
            $galeriItems = collect($galeri ?? []);
            $ulangTahunItems = collect($ulangTahun ?? []);
            $masukanItems = collect($masukan ?? []);
            $ulangTahunUtama = $ulangTahunHariIni ?? $ulangTahunItems->first();
            $infoItems = $agendaTerbaruItems->pluck('nama_agenda')->merge($beritaItems->pluck('judul'))->take(4);
            $initial = fn ($name) => collect(explode(' ', trim((string) $name)))->filter()->take(2)->map(fn ($word) => strtoupper(substr($word, 0, 1)))->join('') ?: 'DB';
            $imageUrl = function ($path, $fallback = 'assets/foto/Agendahariini.png') {
                if (! $path) {
                    return asset($fallback);
                }

                if (filter_var($path, FILTER_VALIDATE_URL)) {
                    return $path;
                }

                $path = ltrim($path, '/');

                if (str_starts_with($path, 'assets/foto/') || str_starts_with($path, 'foto/') || str_starts_with($path, 'uploads/')) {
                    return asset($path);
                }

                return asset('storage/' . $path);
            };
            $statusClass = fn ($status) => match (strtolower((string) $status)) {
                'selesai' => 'bg-ijo-sangatmuda dark:bg-emerald-950/60 text-ijo-tua dark:text-emerald-300 dark:border dark:border-emerald-800/40',
                'diproses', 'proses' => 'bg-biru-muda dark:bg-sky-950/60 text-biru-tua dark:text-sky-300 dark:border dark:border-sky-800/40',
                default => 'bg-oren-muda dark:bg-amber-950/60 text-oren-tua dark:text-amber-300 dark:border dark:border-amber-800/40',
            };
            $maskEmail = function ($email) {
                if (! $email || ! str_contains($email, '@')) {
                    return '-';
                }

                [$local, $domain] = explode('@', $email, 2);
                $visible = substr($local, 0, min(2, strlen($local)));

                return $visible . '***@' . $domain;
            };
            $aduanDetailItems = $masukanItems->mapWithKeys(fn ($aduan) => [
                $aduan->id_dataaduan => [
                    'nama_pengadu' => $aduan->nama_pengadu,
                    'email' => $maskEmail($aduan->email),
                    'isi_aduan' => $aduan->isi_aduan,
                    'balasan_admin' => $aduan->balasan_admin ?: 'Belum ada balasan dari admin.',
                    'status' => $aduan->status ?? 'Pending',
                    'tanggal' => $aduan->created_at ? \Carbon\Carbon::parse($aduan->created_at)->translatedFormat('d F Y, H:i') : '-',
                ],
            ])->all();
        @endphp
        <!-- 1. Hero Banner Riset & Magang - Full Width Breakout -->
        <div class="hero-fullwidth-breakout">
        <section class="relative overflow-hidden shadow-2xl min-h-[480px] sm:min-h-[560px] md:min-h-[620px] flex items-center justify-center text-center group bg-[#0a0f1c]">
            <!-- Background Image with blur -->
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat transition-transform duration-[8s] ease-out group-hover:scale-110"
                 style="background-image: url('{{ asset('assets/foto/hero-bg.jpg') }}'); transform-origin: center center; filter: blur(2px) brightness(0.7); transform: scale(1.05);"></div>

            <!-- Strong dark overlay to reduce image visibility -->
            <div class="absolute inset-0 bg-[#060c1a]/65"></div>
            <!-- Cinematic Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-[#060c1a]/50 via-[#0a1628]/60 to-[#060c1a]/88"></div>
            <!-- Left/Right Vignette -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#060c1a]/60 via-transparent to-[#060c1a]/60"></div>
            <!-- Bottom fade -->
            <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-[#060c1a]/90 to-transparent"></div>

            <!-- Subtle Grid Pattern -->
            <div class="absolute inset-0 opacity-[0.04]" style="background-image: linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 60px 60px;"></div>

            <!-- Content -->
            <div class="relative z-10 max-w-3xl mx-auto px-6 sm:px-10 md:px-14 py-16 space-y-6 sm:space-y-7">



                <h1 class="hero-fade-up-2 text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white tracking-tight leading-[1.12] drop-shadow-lg">
                    RAPID Kab. Bogor<br class="hidden sm:block"/>
                    Rapat & Presensi Integrasi Dashboard
                </h1>

                <p class="hero-fade-up-3 text-sm sm:text-base text-slate-200/80 font-medium leading-relaxed max-w-xl mx-auto drop-shadow">
                    Sistem informasi terintegrasi untuk pengelolaan agenda rapat, presensi digital, dan transparansi informasi di lingkungan Pemerintah Kabupaten Bogor.
                </p>

                <!-- Action Buttons -->
                <div class="hero-fade-up-4 pt-2 flex items-center justify-center">
                    <!-- Button: Lihat Agenda (Primary Green Centered) -->
                    <a href="#section-layanan-data"
                       onclick="event.preventDefault(); const el = document.getElementById('section-layanan-data'); if(el) { const y = el.getBoundingClientRect().top + window.pageYOffset - 90; window.scrollTo({top: y, behavior: 'smooth'}); }"
                       class="hero-btn-primary">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Lihat Agenda</span>
                    </a>
                </div>

                <!-- Stats Bar -->
                <div class="hero-fade-up-4 pt-4 flex items-center justify-center gap-6 sm:gap-10 border-t border-white/10 mt-2">
                    <div class="text-center">
                        <p class="text-xl sm:text-2xl font-black text-white">40+</p>
                        <p class="text-[10px] sm:text-xs text-white/55 font-semibold uppercase tracking-wider">Kecamatan</p>
                    </div>
                    <div class="h-8 w-px bg-white/15"></div>
                    <div class="text-center">
                        <p class="text-xl sm:text-2xl font-black text-white">{{ $agendaItems->count() }}+</p>
                        <p class="text-[10px] sm:text-xs text-white/55 font-semibold uppercase tracking-wider">Agenda Aktif</p>
                    </div>
                    <div class="h-8 w-px bg-white/15"></div>
                    <div class="text-center">
                        <p class="text-xl sm:text-2xl font-black text-white">{{ $beritaItems->count() }}+</p>
                        <p class="text-[10px] sm:text-xs text-white/55 font-semibold uppercase tracking-wider">Berita Terkini</p>
                    </div>
                </div>
            </div>
        </section>
        </div>

        <!-- Header Grid (Ingin Bertemu Kami & Widget Cuaca) -->
        <div id="section-layanan-data" class="scroll-reveal grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
            <!-- Sisi Kiri: Banner Kunjungan -->
            <div class="lg:col-span-8 relative overflow-hidden bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 md:p-6 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 md:w-12 md:h-12 rounded-xl bg-ijo-sangatmuda dark:bg-[#1b3832] text-ijo-tua dark:text-emerald-400 flex items-center justify-center shrink-0 border border-ijo-tua/15 dark:border-emerald-500/20">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-ijo-tua dark:text-emerald-400 text-[10px] font-bold uppercase tracking-widest">Layanan Kunjungan Resmi</p>
                        <h3 class="font-bold text-gray-900 dark:text-white text-lg md:text-xl leading-snug mt-0.5">Ingin Bertemu Kami?</h3>
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-1 max-w-lg leading-relaxed">
                            Ajukan pendaftaran kunjungan kerja, audiensi, atau konsultasi resmi dengan jajaran pimpinan Pemkab Bogor.
                        </p>
                    </div>
                </div>
                <a href="{{ route('publik.form-kunjungan') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 text-xs md:text-sm font-bold text-white bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] px-5 py-3 rounded-full transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5 shrink-0 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Isi Form Kunjungan</span>
                </a>
            </div>

            <!-- Sisi Kanan: Cuaca -->
            <button type="button" id="open-weather-modal" class="lg:col-span-4 relative overflow-hidden bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 md:p-6 text-left cursor-pointer hover:shadow-md hover:border-ijo-tua/30 dark:hover:border-emerald-700/40 transition-all duration-300 group">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-ijo-tua dark:bg-emerald-400 animate-pulse"></span>
                            <p id="home-weather-location" class="text-[11px] font-bold text-ijo-tua dark:text-emerald-400 tracking-wide uppercase">Cibinong, Kab. Bogor</p>
                        </div>
                        <h2 id="home-weather-temp" class="text-4xl md:text-5xl font-black mt-1 text-gray-900 dark:text-white tracking-tight">-</h2>
                        <p id="home-weather-condition" class="text-sm font-bold text-gray-700 dark:text-gray-200 mt-1">Memuat cuaca...</p>
                        <p id="home-weather-humidity" class="text-[11px] font-semibold text-gray-500 dark:text-gray-400 mt-2">
                            Kelembapan - &bull; Klik untuk detail
                        </p>
                    </div>
                    <div class="text-5xl md:text-6xl shrink-0 group-hover:scale-110 transition-transform duration-300">⛅</div>
                </div>
            </button>
        </div>

        <!-- 3. Section Agenda Hari Ini -->
        <section class="scroll-reveal space-y-5">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-ijo-sangatmuda dark:bg-[#1b3832] text-ijo-tua dark:text-emerald-400 flex items-center justify-center shrink-0 border border-ijo-tua/15 dark:border-emerald-500/20">
                        <svg class="w-4.5 h-4.5" style="width:1.1rem;height:1.1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white leading-tight truncate">{{ $agendaBerandaLabel ?? 'Agenda Hari Ini' }}</h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 truncate">{{ $agendaBerandaDescription ?? (now()->translatedFormat('l, d F Y') . ' &bull; ' . ($totalAgendaHariIni ?? $agendaItems->count()) . ' kegiatan') }}</p>
                    </div>
                </div>
                <a href="{{ route('publik.agenda') }}" class="shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-ijo-tua dark:text-emerald-400 bg-ijo-sangatmuda dark:bg-emerald-950/50 border border-ijo-tua/20 dark:border-emerald-800/40 hover:bg-ijo-tua hover:text-white dark:hover:bg-emerald-800/50 px-3.5 py-1.5 rounded-full transition-all whitespace-nowrap">
                    <span class="hidden sm:inline">Selengkapnya</span>
                    <span class="sm:hidden">Lihat</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($agendaItems as $agenda)
                    @php
                        $isBerlangsung = $agenda->isBerlangsung();
                        $isSelesai = $agenda->isSelesai();
                    @endphp
                    <div class="rounded-xl p-5 flex flex-col justify-between space-y-4 shadow-md transition-all duration-300 relative overflow-hidden
                        {{ $isBerlangsung 
                            ? 'bg-gradient-to-br from-emerald-50/95 via-teal-50/90 to-white dark:from-[#132c25] dark:via-[#16382d] dark:to-[#12241f] border-2 border-emerald-500/90 dark:border-emerald-400/90 shadow-emerald-500/10 dark:shadow-emerald-950/40 ring-2 ring-emerald-500/20 dark:ring-emerald-400/30 scale-[1.01]' 
                            : ($isSelesai 
                                ? 'bg-gray-100/70 dark:bg-[#0d1715]/70 border border-gray-200/80 dark:border-[#1a2b27] opacity-80 hover:opacity-100' 
                                : 'bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] hover:shadow-xl hover:-translate-y-0.5') }}">
                        
                        @if ($isBerlangsung)
                            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl pointer-events-none"></div>
                        @endif

                        <div class="space-y-2 relative z-10">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold {{ $isBerlangsung ? 'text-emerald-900 dark:text-emerald-300' : ($isSelesai ? 'text-gray-400 dark:text-gray-400' : 'text-gray-500 dark:text-gray-300') }}">
                                    🕒 {{ substr((string) $agenda->waktu, 0, 5) ?: '-' }} WIB
                                </span>

                                @if ($isBerlangsung)
                                    <span class="bg-emerald-600 text-white font-extrabold text-[10px] px-3 py-0.5 rounded-full inline-flex items-center space-x-1.5 shadow-xs">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                                        </span>
                                        <span>Berlangsung</span>
                                    </span>
                                @elseif ($isSelesai)
                                    <span class="bg-gray-200 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-300/60 dark:border-gray-700 font-medium text-[10px] px-2.5 py-0.5 rounded-full">
                                        Selesai
                                    </span>
                                @else
                                    <span class="bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-blue-200 dark:border-blue-800/40">
                                        {{ $agenda->status_label }}
                                    </span>
                                @endif
                            </div>

                            <div class="space-y-1">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <h4 class="font-bold text-sm leading-snug {{ $isBerlangsung ? 'text-emerald-950 dark:text-white' : ($isSelesai ? 'text-gray-600 dark:text-gray-400' : 'text-gray-900 dark:text-white') }}">
                                        {{ $agenda->nama_agenda }}
                                    </h4>
                                    @if (strtolower((string) ($agenda->kategori_surat ?? 'internal')) === 'internal')
                                        <span class="inline-flex items-center text-[9px] font-bold text-blue-700 dark:text-sky-300 bg-blue-50 dark:bg-sky-950/60 px-2 py-0.5 rounded-md border border-blue-100 dark:border-sky-800/40">Khusus Pegawai</span>
                                    @elseif (strtolower((string) ($agenda->kategori_surat ?? '')) === 'masuk')
                                        <span class="inline-flex items-center text-[9px] font-bold text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/60 px-2 py-0.5 rounded-md border border-amber-100 dark:border-amber-800/40">Pegawai Ditugaskan</span>
                                    @else
                                        <span class="inline-flex items-center text-[9px] font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-md border border-emerald-100 dark:border-emerald-800/40">Pegawai & Tamu</span>
                                    @endif
                                </div>
                                <p class="text-xs {{ $isSelesai ? 'text-gray-400 dark:text-gray-400' : 'text-gray-500 dark:text-gray-300' }}">📍 {{ $agenda->lokasi_display ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between border-t {{ $isBerlangsung ? 'border-emerald-200 dark:border-emerald-800/50' : 'border-gray-100 dark:border-[#233a34]' }} pt-3 text-xs relative z-10">
                            @if (strtolower((string) ($agenda->kategori_surat ?? '')) !== 'masuk')
                                <span class="bg-oren-muda dark:bg-amber-950/60 text-oren-tua dark:text-amber-300 dark:border dark:border-amber-700/40 font-bold px-3 py-1 rounded-full text-[10px]">{{ $agenda->kuota ?? 0 }} Peserta</span>
                            @else
                                <span></span>
                            @endif
                            <a href="{{ route('publik.agenda.detail', $agenda->id_agenda) }}" class="{{ $isBerlangsung ? 'bg-emerald-600 hover:bg-emerald-700 text-white font-bold' : ($isSelesai ? 'bg-gray-200 dark:bg-[#1a2925] text-gray-600 dark:text-gray-300 hover:bg-gray-300' : 'bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#1b3832] text-white dark:text-emerald-300') }} px-3.5 py-1 rounded-lg text-[10px] transition-colors">
                                {{ $isBerlangsung ? 'Ikuti / Detail' : 'Detail' }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-3 bg-white dark:bg-[#152420] rounded-xl p-8 text-center text-gray-500 dark:text-gray-400 text-sm border border-gray-100 dark:border-[#233a34]">
                        Belum ada agenda kegiatan.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- 4. Section Peta Sebaran -->
        <section class="scroll-reveal space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-ijo-sangatmuda dark:bg-[#1b3832] text-ijo-tua dark:text-emerald-400 flex items-center justify-center shrink-0 border border-ijo-tua/15 dark:border-emerald-500/20">
                        <svg style="width:1.1rem;height:1.1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white leading-tight">Peta Sebaran Agenda & Kunjungan Kerja</h3>
                            <span class="hidden sm:inline-flex bg-ijo-sangatmuda dark:bg-[#1b3832] text-ijo-tua dark:text-emerald-300 text-[9px] font-bold px-2 py-0.5 rounded-full border border-ijo-tua/20 dark:border-emerald-800/40 tracking-wide uppercase">GIS</span>
                        </div>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Pemetaan 40 Kecamatan Kabupaten Bogor beserta sebaran titik kegiatan.</p>
                    </div>
                </div>
                <button type="button" id="btn-reset-map-view" class="self-start sm:self-auto shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-ijo-sangatmuda hover:border-ijo-tua/30 dark:hover:bg-[#1b3832] px-3.5 py-2 rounded-full transition-all shadow-sm whitespace-nowrap">
                    <svg style="width:0.85rem;height:0.85rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Reset Peta
                </button>
            </div>

            <!-- Grid 2 Kolom: Peta (Kiri 8 Kolom) + Daftar Rapat Dinas (Kanan 4 Kolom) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                <!-- Sisi Kiri: Card Container Peta (lg:col-span-8) -->
                <div class="lg:col-span-8 bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-xl p-4 md:p-6 shadow-lg space-y-4 flex flex-col justify-between">
                    <!-- Summary Stats Strip -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                        <div class="bg-[#F8F7F4] dark:bg-[#0f1c19] border border-gray-200/60 dark:border-[#233a34] rounded-xl p-3 flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-ijo-tua text-white flex items-center justify-center font-black text-xs shrink-0 shadow-xs">🗺️</div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Batas Wilayah</p>
                                <p class="font-extrabold text-gray-900 dark:text-white text-xs">40 Kecamatan</p>
                            </div>
                        </div>
                        <div class="bg-[#F8F7F4] dark:bg-[#0f1c19] border border-gray-200/60 dark:border-[#233a34] rounded-xl p-3 flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-black text-xs shrink-0 shadow-xs">🏛️</div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Titik Instansi</p>
                                <p class="font-extrabold text-gray-900 dark:text-white text-xs" id="stat-gov-points-count">41 Kantor Camat</p>
                            </div>
                        </div>
                        <div class="bg-[#F8F7F4] dark:bg-[#0f1c19] border border-gray-200/60 dark:border-[#233a34] rounded-xl p-3 flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center font-black text-xs shrink-0 shadow-xs">📅</div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Agenda Rapat</p>
                                <p class="font-extrabold text-gray-900 dark:text-white text-xs">{{ $agendaItems->count() }} Kegiatan</p>
                            </div>
                        </div>
                        <div class="bg-[#F8F7F4] dark:bg-[#0f1c19] border border-gray-200/60 dark:border-[#233a34] rounded-xl p-3 flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-sky-600 text-white flex items-center justify-center font-black text-xs shrink-0 shadow-xs">🏢</div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pusat Pemkab</p>
                                <p class="font-extrabold text-gray-900 dark:text-white text-xs">Cibinong</p>
                            </div>
                        </div>
                    </div>

                    <!-- Leaflet Container -->
                    <div class="relative z-10 isolate w-full h-[460px] md:h-[500px] rounded-xl overflow-hidden border border-gray-200/80 dark:border-[#284c43] shadow-inner flex-grow">
                        <div id="beranda-map" class="w-full h-full z-0 bg-[#e5e3df] dark:bg-[#121f1c]"></div>

                        <!-- Overlay Legend -->
                        <div class="absolute bottom-3 left-3 z-20 bg-white/95 dark:bg-[#152420]/95 backdrop-blur-md border border-gray-200/80 dark:border-[#233a34] rounded-xl p-3 shadow-lg text-[11px] space-y-1.5 pointer-events-auto max-w-[245px]">
                            <p class="font-bold text-gray-900 dark:text-white text-xs border-b border-gray-100 dark:border-[#284c43] pb-1">Keterangan Peta</p>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-[#10b981] border border-emerald-700 shrink-0"></span>
                                <span class="text-gray-700 dark:text-gray-300">Batas Kecamatan Kab. Bogor</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="flex flex-col items-center shrink-0">
                                    <span class="w-3.5 h-3.5 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 relative overflow-hidden shadow-xs border border-white">
                                        <span class="absolute top-0.5 left-0.5 w-2 h-1 bg-white/70 rounded-full rotate-[-30deg] z-20"></span>
                                    </span>
                                    <span class="w-[2px] h-1.5 bg-gray-900"></span>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">Kantor Kecamatan (40 Titik)</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="flex flex-col items-center shrink-0">
                                    <span class="w-3.5 h-3.5 rounded-full bg-gradient-to-br from-red-500 to-red-700 relative overflow-hidden shadow-xs border border-white">
                                        <span class="absolute top-0.5 left-0.5 w-2 h-1 bg-white/70 rounded-full rotate-[-30deg] z-20"></span>
                                    </span>
                                    <span class="w-[2px] h-1.5 bg-gray-900"></span>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">Kantor Dinas & Pemkab</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="flex flex-col items-center shrink-0">
                                    <span class="w-3.5 h-3.5 rounded-full bg-gradient-to-br from-emerald-500 to-teal-700 relative overflow-hidden shadow-xs border border-white">
                                        <span class="absolute top-0.5 left-0.5 w-2 h-1 bg-white/70 rounded-full rotate-[-30deg] z-20"></span>
                                    </span>
                                    <span class="w-[2px] h-1.5 bg-gray-900"></span>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300">Titik Agenda Rapat Active</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan: Daftar Rapat Dinas / Instansi (lg:col-span-4) -->
                <div class="lg:col-span-4 bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-xl p-5 md:p-6 shadow-lg flex flex-col justify-between space-y-4">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-[#233a34] pb-3">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-base leading-snug">Rapat Dinas & Instansi</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Daftar agenda kegiatan di Pemkab Bogor</p>
                            </div>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        </div>

                        <!-- 3 List Rapat Terbaru -->
                        <div class="space-y-3">
                            @forelse ($agendaItems->take(3) as $agenda)
                                @php
                                    $isBerlangsung = $agenda->isBerlangsung();
                                    $isSelesai = $agenda->isSelesai();
                                @endphp
                                <div class="rounded-xl p-3.5 space-y-2 transition-all duration-200 group relative overflow-hidden
                                    {{ $isBerlangsung 
                                        ? 'bg-gradient-to-br from-emerald-50/95 via-teal-50/90 to-white dark:from-[#132c25] dark:via-[#16382d] dark:to-[#12241f] border-2 border-emerald-500/90 dark:border-emerald-400/90 shadow-sm' 
                                        : ($isSelesai 
                                            ? 'bg-gray-100/70 dark:bg-[#0d1715]/70 border border-gray-200/70 dark:border-[#1a2b27] opacity-85 hover:opacity-100' 
                                            : 'bg-[#F8F7F4] dark:bg-[#0f1c19] border border-gray-200/70 dark:border-[#233a34] hover:border-ijo-tua dark:hover:border-emerald-500/50') }}">
                                    
                                    <div class="flex items-center justify-between gap-2 text-[10px]">
                                        @if ($isBerlangsung)
                                            <span class="bg-emerald-600 text-white font-extrabold px-2.5 py-0.5 rounded-full inline-flex items-center space-x-1 shadow-xs">
                                                <span class="relative flex h-1.5 w-1.5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-white"></span>
                                                </span>
                                                <span>Berlangsung</span>
                                            </span>
                                        @elseif ($isSelesai)
                                            <span class="bg-gray-200 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-300/60 dark:border-gray-700 font-medium px-2 py-0.5 rounded-full">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="bg-amber-100 dark:bg-amber-950/70 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800/50 font-bold px-2 py-0.5 rounded-full">
                                                {{ $agenda->status_label }}
                                            </span>
                                        @endif

                                        <span class="{{ $isBerlangsung ? 'text-emerald-900 dark:text-emerald-300 font-bold' : ($isSelesai ? 'text-gray-400 dark:text-gray-400' : 'text-gray-500 dark:text-gray-400 font-medium') }}">
                                            🕒 {{ substr((string) $agenda->waktu, 0, 5) }} WIB
                                        </span>
                                    </div>

                                    <div>
                                        <h5 class="font-bold text-xs leading-snug line-clamp-2 transition-colors {{ $isBerlangsung ? 'text-emerald-950 dark:text-white group-hover:text-emerald-700' : ($isSelesai ? 'text-gray-600 dark:text-gray-400' : 'text-gray-900 dark:text-white group-hover:text-ijo-tua dark:group-hover:text-emerald-400') }}">
                                            {{ $agenda->nama_agenda }}
                                        </h5>
                                        <p class="text-[11px] {{ $isSelesai ? 'text-gray-400 dark:text-gray-400' : 'text-gray-500 dark:text-gray-400' }} mt-1 flex items-center gap-1">
                                            <span>📍</span>
                                            <span class="truncate">{{ $agenda->lokasi_display ?? 'Diskominfo Kab. Bogor' }}</span>
                                        </p>
                                    </div>

                                    <div class="pt-2 border-t {{ $isBerlangsung ? 'border-emerald-200 dark:border-emerald-800/50' : 'border-gray-200/50 dark:border-[#233a34]' }} flex items-center justify-between text-[11px]">
                                        <span class="{{ $isSelesai ? 'text-gray-400 dark:text-gray-400' : 'text-gray-500 dark:text-gray-400' }}">
                                            📅 {{ $agenda->tanggal ? \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('d M Y') : '-' }}
                                        </span>
                                        <a href="{{ route('publik.agenda.detail', $agenda->id_agenda) }}" class="font-bold {{ $isBerlangsung ? 'text-emerald-700 dark:text-emerald-300 hover:underline' : ($isSelesai ? 'text-gray-500 dark:text-gray-400 hover:underline' : 'text-ijo-tua dark:text-emerald-400 hover:underline') }}">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-[#F8F7F4] dark:bg-[#0f1c19] rounded-xl p-6 text-center text-xs text-gray-500 dark:text-gray-400 border border-gray-200/60 dark:border-[#233a34]">
                                    Belum ada rapat dinas terjadwal.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tombol Selengkapnya ke Halaman Agenda -->
                    <div class="pt-2">
                        <a href="{{ route('publik.agenda') }}" class="w-full inline-flex items-center justify-center space-x-2 text-xs font-bold text-white bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 py-3 rounded-xl transition-all shadow-xs group">
                            <span>Selengkapnya</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. Section Berita Terkini -->
        <section class="scroll-reveal space-y-5">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-ijo-sangatmuda dark:bg-[#1b3832] text-ijo-tua dark:text-emerald-400 flex items-center justify-center shrink-0 border border-ijo-tua/15 dark:border-emerald-500/20">
                        <svg style="width:1.1rem;height:1.1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white leading-tight">Berita Terkini</h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Kabar terbaru seputar Diskominfo Kabupaten Bogor</p>
                    </div>
                </div>
                <a href="{{ route('publik.berita') }}" class="shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-ijo-tua dark:text-emerald-400 bg-ijo-sangatmuda dark:bg-emerald-950/50 border border-ijo-tua/20 dark:border-emerald-800/40 hover:bg-ijo-tua hover:text-white dark:hover:bg-emerald-800/50 px-3.5 py-1.5 rounded-full transition-all whitespace-nowrap">
                    <span class="hidden sm:inline">Selengkapnya</span>
                    <span class="sm:hidden">Lihat</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @forelse ($beritaItems->take(3) as $berita)
                    <div class="group bg-white dark:bg-[#152420] rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 dark:border-[#233a34] flex flex-col transition-all duration-300 hover:-translate-y-1">
                        <!-- Image with overlay -->
                        <div class="relative h-44 overflow-hidden bg-gradient-to-br from-ijo-muda to-ijo-tua">
                            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105" style="background-image: url('{{ $imageUrl($berita->gambar) }}')"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center gap-1 bg-white/90 backdrop-blur-sm text-blue-700 font-bold text-[10px] px-2.5 py-1 rounded-full shadow">
                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/></svg>
                                    Berita
                                </span>
                            </div>
                            <div class="absolute bottom-3 left-3 right-3">
                                <p class="text-white/80 text-[10px] font-semibold">{{ $berita->tanggal?->translatedFormat('d F Y') ?? '-' }}</p>
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="p-5 flex flex-col flex-grow space-y-3">
                            <h4 class="font-bold text-gray-900 dark:text-white text-sm leading-snug group-hover:text-ijo-tua dark:group-hover:text-emerald-400 transition-colors line-clamp-2">{{ $berita->judul }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2 flex-grow">{{ \Illuminate\Support\Str::limit(strip_tags($berita->isi_berita), 100) }}</p>
                            <a href="{{ route('publik.berita.detail', $berita->id_berita) }}" class="mt-auto inline-flex items-center gap-1.5 text-xs font-bold text-ijo-tua dark:text-emerald-400 hover:gap-2.5 transition-all">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-3 bg-white dark:bg-[#152420] rounded-2xl p-8 border border-gray-100 dark:border-[#233a34] text-sm font-medium text-gray-500 dark:text-gray-400 text-center">
                        Belum ada berita terkini di database.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- 6. Section Daftar Aduan -->
        <section class="scroll-reveal space-y-5">
            <!-- Header -->
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-oren-muda dark:bg-amber-950/50 text-oren-tua dark:text-amber-400 flex items-center justify-center shrink-0 border border-oren-tua/20 dark:border-amber-700/30">
                        <svg style="width:1.1rem;height:1.1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white leading-tight">Daftar Aduan</h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Aspirasi & tindak lanjut pengaduan masyarakat Diskominfo Kab. Bogor</p>
                    </div>
                </div>
                <a href="{{ route('publik.riwayat-aduan') }}" class="shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-ijo-tua dark:text-emerald-400 bg-ijo-sangatmuda dark:bg-emerald-950/50 border border-ijo-tua/20 dark:border-emerald-800/40 hover:bg-ijo-tua hover:text-white dark:hover:bg-emerald-800/50 px-3.5 py-1.5 rounded-full transition-all whitespace-nowrap">
                    <span class="hidden sm:inline">Selengkapnya</span>
                    <span class="sm:hidden">Lihat</span>
                </a>
            </div>

            <!-- Table Card -->
            <div class="bg-white dark:bg-[#152420] rounded-2xl border border-gray-100 dark:border-[#233a34] shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-50 to-gray-100/50 dark:from-[#0f1c19] dark:to-[#111f1c] text-gray-500 dark:text-gray-400 uppercase text-[10px] tracking-widest border-b border-gray-100 dark:border-[#233a34]">
                                <th class="px-5 py-3.5 font-extrabold">Nama Pengadu</th>
                                <th class="px-5 py-3.5 font-extrabold">Isi Aduan</th>
                                <th class="px-5 py-3.5 font-extrabold">Balasan Admin</th>
                                <th class="px-5 py-3.5 font-extrabold text-center">Status</th>
                                <th class="px-5 py-3.5 font-extrabold text-right">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-[#1d2e2b] font-medium text-gray-700 dark:text-gray-200">
                            @forelse ($masukanItems as $aduan)
                                <tr class="home-aduan-row cursor-pointer hover:bg-ijo-sangatmuda/40 dark:hover:bg-white/[0.03] transition-colors duration-150" data-aduan-id="{{ $aduan->id_dataaduan }}" title="Klik untuk melihat detail aduan">
                                    <td class="px-5 py-3.5 font-bold text-gray-900 dark:text-white">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-ijo-sangatmuda dark:bg-[#1b3832] text-ijo-tua dark:text-emerald-400 text-[10px] font-black flex items-center justify-center shrink-0 border border-ijo-tua/20 dark:border-emerald-700/30">{{ strtoupper(substr($aduan->nama_pengadu, 0, 1)) }}</div>
                                            <span class="truncate max-w-[120px] sm:max-w-none">{{ $aduan->nama_pengadu }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-300 max-w-[140px] sm:max-w-[180px]"><span class="line-clamp-1">{{ \Illuminate\Support\Str::limit($aduan->isi_aduan, 50) }}</span></td>
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-300 max-w-[140px] sm:max-w-[180px] hidden md:table-cell"><span class="line-clamp-1">{{ $aduan->balasan_admin ? \Illuminate\Support\Str::limit($aduan->balasan_admin, 50) : 'Belum ada balasan' }}</span></td>
                                    <td class="px-5 py-3.5 text-center">
                                        <span class="{{ $statusClass($aduan->status) }} font-bold px-3 py-1 rounded-full text-[10px] whitespace-nowrap">{{ $aduan->status ?? 'Pending' }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right text-gray-400 dark:text-gray-400 whitespace-nowrap hidden sm:table-cell">{{ $aduan->created_at ? \Carbon\Carbon::parse($aduan->created_at)->translatedFormat('d M Y') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                            <p class="text-sm text-gray-400 dark:text-gray-500 font-medium">Belum ada aduan di database.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-5 py-4 bg-gray-50/60 dark:bg-[#0f1c19]/60 border-t border-gray-100 dark:border-[#233a34]">
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Klik baris untuk melihat detail aduan</p>
                </div>
            </div>
        </section>
    </main>

    <div id="home-aduan-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-3 sm:p-4 overflow-y-auto">
        <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col rounded-xl bg-white dark:bg-[#152420] text-gray-800 dark:text-slate-100 shadow-xl overflow-hidden border border-transparent dark:border-[#233a34]">
            <div class="bg-ijo-tua dark:bg-[#0f1c19] text-white p-5 sm:p-6 flex items-start justify-between gap-4 border-b border-transparent dark:border-[#233a34] shrink-0">
                <div>       
                    <p class="text-xs uppercase tracking-wider text-white/70 dark:text-emerald-400 font-bold">Detail Aduan</p>
                    <h2 id="home-aduan-title" class="text-lg sm:text-xl font-extrabold mt-1 text-white">-</h2>
                    <p id="home-aduan-date" class="text-xs text-white/70 dark:text-gray-300 mt-1">-</p>
                </div>
                <button type="button" id="home-aduan-close" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 dark:bg-white/5 dark:hover:bg-white/10 flex items-center justify-center text-lg font-bold cursor-pointer">x</button>
            </div>

            <div class="flex-1 min-h-0 overflow-y-auto p-5 sm:p-6 space-y-4 sm:space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                    <div class="rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-4">
                        <p class="text-[10px] uppercase font-bold text-gray-400 dark:text-gray-400">Nama</p>
                        <p id="home-aduan-name" class="mt-1 font-bold text-gray-900 dark:text-white">-</p>
                    </div>
                    <div class="rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-4">
                        <p class="text-[10px] uppercase font-bold text-gray-400 dark:text-gray-400">Email</p>
                        <p id="home-aduan-email" class="mt-1 font-bold text-gray-900 dark:text-white">-</p>
                    </div>
                    <div class="rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-4">
                        <p class="text-[10px] uppercase font-bold text-gray-400 dark:text-gray-400">Status</p>
                        <p id="home-aduan-status" class="mt-1 font-bold text-gray-900 dark:text-white">-</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#0f1c19] p-5">
                    <p class="text-[10px] uppercase font-bold text-gray-400 dark:text-gray-400">Isi Aduan</p>
                    <p id="home-aduan-body" class="mt-2 text-sm leading-relaxed text-gray-700 dark:text-gray-200 whitespace-pre-line">-</p>
                </div>

                <div class="rounded-2xl bg-ijo-sangatmuda dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-5">
                    <p class="text-[10px] uppercase font-bold text-ijo-tua dark:text-emerald-400">Balasan Admin</p>
                    <p id="home-aduan-reply" class="mt-2 text-sm leading-relaxed text-gray-800 dark:text-gray-100 whitespace-pre-line">-</p>
                </div>
            </div>
        </div>
    </div>

    <div id="weather-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-3 sm:p-4 overflow-y-auto">
        <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col rounded-xl bg-white dark:bg-[#152420] text-gray-800 dark:text-slate-100 shadow-xl overflow-hidden border border-transparent dark:border-[#233a34]">
            <div class="bg-ijo-tua dark:bg-[#0f1c19] text-white p-5 sm:p-6 flex items-start justify-between gap-4 border-b border-transparent dark:border-[#233a34] shrink-0">
                <div>
                    <p class="text-xs uppercase tracking-wider text-white/70 dark:text-emerald-400 font-bold">Cuaca API</p>
                    <h2 id="weather-location" class="text-lg sm:text-xl font-extrabold mt-1 text-white">Cibinong, Kabupaten Bogor</h2>
                    <p id="weather-updated" class="text-xs text-white/70 dark:text-gray-300 mt-1">Memuat data...</p>
                </div>
                <button type="button" id="close-weather-modal" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 dark:bg-white/5 dark:hover:bg-white/10 flex items-center justify-center text-lg font-bold cursor-pointer">x</button>
            </div>

            <div class="flex-1 min-h-0 overflow-y-auto p-5 sm:p-6 space-y-4 sm:space-y-5">
                <div id="weather-error" class="hidden rounded-2xl bg-oren-muda dark:bg-amber-950/50 text-oren-tua dark:text-amber-200 px-4 py-3 text-xs font-bold"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="rounded-2xl bg-ijo-sangatmuda dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-5">
                        <p class="text-[10px] uppercase font-bold text-ijo-tua dark:text-emerald-400">Suhu</p>
                        <p id="weather-temp" class="text-3xl font-extrabold text-ijo-tua dark:text-emerald-400 mt-1">-</p>
                        <p id="weather-condition" class="text-xs text-gray-600 dark:text-gray-300 mt-1">-</p>
                    </div>
                    <div class="rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-5">
                        <p class="text-[10px] uppercase font-bold text-gray-400 dark:text-gray-400">Kelembapan</p>
                        <p id="weather-humidity" class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">-</p>
                        <p id="weather-cloud" class="text-xs text-gray-500 dark:text-gray-300 mt-1">Awan -</p>
                    </div>
                    <div class="rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-5">
                        <p class="text-[10px] uppercase font-bold text-gray-400 dark:text-gray-400">Angin</p>
                        <p id="weather-wind" class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">-</p>
                        <p id="weather-rain" class="text-xs text-gray-500 dark:text-gray-300 mt-1">Hujan -</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Prakiraan 3 Hari</h3>
                    <div id="weather-daily" class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-3"></div>
                </div>

                <p id="weather-source" class="text-[11px] text-gray-400">Sumber: Open-Meteo</p>
            </div>
        </div>
    </div>

    @include('publik.layout.footer')
    <script>
        const homeAduanDetails = @json($aduanDetailItems);
        const homeAduanModal = document.getElementById('home-aduan-modal');
        const homeAduanClose = document.getElementById('home-aduan-close');
        const weatherModal = document.getElementById('weather-modal');
        const weatherOpen = document.getElementById('open-weather-modal');
        const weatherClose = document.getElementById('close-weather-modal');
        const weatherError = document.getElementById('weather-error');
        const weatherDaily = document.getElementById('weather-daily');
        let weatherLoaded = false;

        function setHomeAduanText(id, value) {
            const element = document.getElementById(id);
            if (element) {
                element.textContent = value || '-';
            }
        }

        document.querySelectorAll('.home-aduan-row').forEach((row) => {
            row.addEventListener('click', () => {
                const detail = homeAduanDetails[row.dataset.aduanId];

                if (!detail) {
                    return;
                }

                setHomeAduanText('home-aduan-title', detail.isi_aduan.length > 70 ? detail.isi_aduan.slice(0, 70) + '...' : detail.isi_aduan);
                setHomeAduanText('home-aduan-date', detail.tanggal);
                setHomeAduanText('home-aduan-name', detail.nama_pengadu);
                setHomeAduanText('home-aduan-email', detail.email);
                setHomeAduanText('home-aduan-status', detail.status);
                setHomeAduanText('home-aduan-body', detail.isi_aduan);
                setHomeAduanText('home-aduan-reply', detail.balasan_admin);

                homeAduanModal.classList.remove('hidden');
                homeAduanModal.classList.add('flex');
            });
        });

        homeAduanClose?.addEventListener('click', () => {
            homeAduanModal.classList.add('hidden');
            homeAduanModal.classList.remove('flex');
        });

        homeAduanModal?.addEventListener('click', (event) => {
            if (event.target === homeAduanModal) {
                homeAduanModal.classList.add('hidden');
                homeAduanModal.classList.remove('flex');
            }
        });

        function formatWeatherValue(value, suffix = '') {
            return value === null || value === undefined || value === '' ? '-' : `${value}${suffix}`;
        }

        function setText(id, value) {
            const element = document.getElementById(id);
            if (element) {
                element.textContent = value;
            }
        }

        async function loadWeather() {
            if (weatherLoaded) {
                return;
            }

            weatherLoaded = true;
            weatherError.classList.add('hidden');
            weatherDaily.innerHTML = '<div class="md:col-span-3 rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-4 text-xs text-gray-500 dark:text-gray-400">Memuat data cuaca dari API...</div>';

            try {
                const response = await fetch('{{ route('publik.cuaca.api') }}', { headers: { 'Accept': 'application/json' } });
                const payload = await response.json();
                const current = payload.current || {};

                if (!payload.success && payload.message) {
                    weatherError.textContent = payload.message;
                    weatherError.classList.remove('hidden');
                }

                setText('weather-location', payload.location || 'Cibinong, Kabupaten Bogor');
                setText('weather-updated', `Diperbarui: ${payload.updated_at || '-'}`);
                setText('weather-temp', formatWeatherValue(current.temperature, '°C'));
                setText('weather-condition', current.condition || '-');
                setText('weather-humidity', formatWeatherValue(current.humidity, '%'));
                setText('home-weather-location', payload.location || 'Cibinong, Kabupaten Bogor');
                setText('home-weather-temp', formatWeatherValue(current.temperature, '°C'));
                setText('home-weather-condition', current.condition || 'Data API belum tersedia');
                setText('home-weather-humidity', `Kelembapan ${formatWeatherValue(current.humidity, '%')} • Klik untuk detail `);
                setText('weather-cloud', `Awan ${formatWeatherValue(current.cloud_cover, '%')}`);
                setText('weather-wind', formatWeatherValue(current.wind_speed, ' km/jam'));
                setText('weather-rain', `Hujan ${formatWeatherValue(current.precipitation, ' mm')}`);
                setText('weather-source', `Sumber: ${payload.source || 'Open-Meteo'}${payload.attribution ? ' - ' + payload.attribution : ''}`);

                const daily = payload.daily || [];
                weatherDaily.innerHTML = daily.length
                    ? daily.map((item) => `
                        <div class="rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-4">
                            <p class="text-[10px] font-bold uppercase text-gray-400 dark:text-gray-400">${item.date || '-'}</p>
                            <h4 class="mt-1 text-sm font-extrabold text-gray-900 dark:text-white">${item.condition || '-'}</h4>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-300">${formatWeatherValue(item.temperature_min, '°C')} - ${formatWeatherValue(item.temperature_max, '°C')}</p>
                            <p class="mt-1 text-[11px] text-gray-400 dark:text-gray-400">Hujan ${formatWeatherValue(item.precipitation_sum, ' mm')}</p>
                        </div>
                    `).join('')
                    : '<div class="md:col-span-3 rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-4 text-xs text-gray-500 dark:text-gray-400">Prakiraan harian belum tersedia.</div>';
            } catch (error) {
                weatherLoaded = false;
                weatherDaily.innerHTML = '<div class="md:col-span-3 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-4 text-xs text-red-600 dark:text-red-400">Gagal memuat API cuaca.</div>';
            }
        }

        weatherOpen?.addEventListener('click', () => {
            weatherModal.classList.remove('hidden');
            weatherModal.classList.add('flex');
            loadWeather();
        });

        loadWeather();

        weatherClose?.addEventListener('click', () => {
            weatherModal.classList.add('hidden');
            weatherModal.classList.remove('flex');
        });

        weatherModal?.addEventListener('click', (event) => {
            if (event.target === weatherModal) {
                weatherModal.classList.add('hidden');
                weatherModal.classList.remove('flex');
            }
        });

        // Initializing Map Sebaran Agenda & Kunjungan Kerja (Kabupaten Bogor)
        document.addEventListener('DOMContentLoaded', function initKunkerMap() {
            const mapContainer = document.getElementById('beranda-map');
            if (!mapContainer || typeof L === 'undefined') return;

            const centerLat = -6.55;
            const centerLng = 106.82;
            const defaultZoom = 10;

            let isDark = document.documentElement.classList.contains('dark');
            const getTileUrl = (dark) => dark
                ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
                : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

            const map = L.map('beranda-map', {
                center: [centerLat, centerLng],
                zoom: defaultZoom,
                zoomControl: true,
                scrollWheelZoom: false
            });

            let currentTileLayer = L.tileLayer(getTileUrl(isDark), {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a>',
                subdomains: 'abc',
                maxZoom: 19
            }).addTo(map);

            let geojsonLayer;

            const updateMapTheme = (dark) => {
                map.removeLayer(currentTileLayer);
                currentTileLayer = L.tileLayer(getTileUrl(dark), {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a>',
                    subdomains: 'abc',
                    maxZoom: 19
                }).addTo(map);

                if (geojsonLayer) {
                    geojsonLayer.setStyle({
                        fillColor: dark ? '#10b981' : '#35635b',
                        color: dark ? '#10b981' : '#2b4f49',
                        fillOpacity: dark ? 0.25 : 0.18
                    });
                }
            };

            window.addEventListener('sirapi-theme-changed', (e) => {
                updateMapTheme(e.detail.theme === 'dark');
            });

            // Fetch Administrative GeoJSON of Kabupaten Bogor (40 Kecamatan)
            fetch("{{ asset('admin_kec.json') }}")
                .then(res => {
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    return res.json();
                })
                .then(data => {
                    geojsonLayer = L.geoJSON(data, {
                        style: function(feature) {
                            const dark = document.documentElement.classList.contains('dark');
                            return {
                                fillColor: dark ? '#10b981' : '#35635b',
                                weight: 1.5,
                                opacity: 0.7,
                                color: dark ? '#10b981' : '#2b4f49',
                                dashArray: '2',
                                fillOpacity: dark ? 0.25 : 0.18
                            };
                        },
                        onEachFeature: function(feature, layer) {
                            const kecName = feature.properties?.NKEC || 'Kecamatan';
                            layer.bindTooltip(`
                                <div class="px-1.5 py-0.5 font-sans">
                                    <p class="font-extrabold text-xs text-gray-900">Kec. ${kecName}</p>
                                    <p class="text-[10px] text-gray-500">Kabupaten Bogor</p>
                                </div>
                            `, { sticky: true });

                            layer.on({
                                mouseover: function(e) {
                                    const l = e.target;
                                    l.setStyle({
                                        weight: 2.5,
                                        color: '#D89B3C',
                                        dashArray: '',
                                        fillOpacity: 0.5,
                                        fillColor: '#D89B3C'
                                    });
                                    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                        l.bringToFront();
                                    }
                                },
                                mouseout: function(e) {
                                    if (geojsonLayer) geojsonLayer.resetStyle(e.target);
                                },
                                click: function(e) {
                                    map.fitBounds(e.target.getBounds());
                                }
                            });
                        }
                    }).addTo(map);
                })
                .catch(err => console.log('GeoJSON Map Notice:', err));

            let allMarkers = [];

            // Dynamic Pushpin Icon Sizer based on Zoom Level
            const getIconConfigForZoom = (zoom) => {
                if (zoom <= 8) return { headSize: 'w-[18px] h-[18px]', stickHeight: 'h-[10px]', width: 18, totalHeight: 28 };
                if (zoom === 9) return { headSize: 'w-[22px] h-[22px]', stickHeight: 'h-[12px]', width: 22, totalHeight: 34 };
                if (zoom === 10) return { headSize: 'w-[28px] h-[28px]', stickHeight: 'h-[15px]', width: 28, totalHeight: 43 };
                if (zoom === 11) return { headSize: 'w-[34px] h-[34px]', stickHeight: 'h-[18px]', width: 34, totalHeight: 52 };
                if (zoom === 12) return { headSize: 'w-[40px] h-[40px]', stickHeight: 'h-[21px]', width: 40, totalHeight: 61 };
                if (zoom === 13) return { headSize: 'w-[46px] h-[46px]', stickHeight: 'h-[24px]', width: 46, totalHeight: 70 };
                return { headSize: 'w-[52px] h-[52px]', stickHeight: 'h-[27px]', width: 52, totalHeight: 79 };
            };

            // Custom Leaflet Pushpin Marker Builder (Clean Glossy Sphere Ball + Needle Stick)
            const createCustomIcon = (bgClass = 'bg-gradient-to-br from-red-500 via-red-600 to-red-800', zoom = defaultZoom) => {
                const cfg = getIconConfigForZoom(zoom);
                return L.divIcon({
                    className: 'custom-pushpin-marker',
                    html: `
                        <div class="relative flex flex-col items-center justify-start transition-all duration-200 hover:scale-125 cursor-pointer drop-shadow-md group">
                            <!-- Round Clean Glossy Pushpin Ball -->
                            <div class="${cfg.headSize} rounded-full ${bgClass} shadow-lg border-2 border-white dark:border-[#152420] relative overflow-hidden shrink-0">
                                <!-- Glossy White Crescent Glare Arc -->
                                <span class="absolute top-[8%] left-[10%] w-[50%] h-[32%] bg-gradient-to-br from-white/90 via-white/40 to-transparent rounded-full rotate-[-35deg] pointer-events-none z-20"></span>
                            </div>
                            <!-- Pushpin Needle Stick Pointing Down to Coordinate -->
                            <div class="w-[3px] ${cfg.stickHeight} bg-gradient-to-b from-gray-900 via-gray-800 to-black rounded-b-full shadow-xs -mt-[1px]"></div>
                        </div>
                    `,
                    iconSize: [cfg.width, cfg.totalHeight],
                    iconAnchor: [cfg.width / 2, cfg.totalHeight],
                    popupAnchor: [0, -cfg.totalHeight]
                });
            };

            const updateAllMarkerSizes = () => {
                const currentZoom = map.getZoom();
                allMarkers.forEach(m => {
                    m.marker.setIcon(createCustomIcon(m.bgClass, currentZoom));
                });
            };

            map.on('zoomend', updateAllMarkerSizes);

            // Load 41 Government Points (Kantor Bupati & 40 Kantor Camat) from app_md_mapgovpoint.csv
            fetch("{{ asset('app_md_mapgovpoint.csv') }}")
                .then(res => {
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    return res.text();
                })
                .then(csvText => {
                    const lines = csvText.split('\n');
                    let validPointsCount = 0;
                    lines.slice(1).forEach(line => {
                        if (!line.trim()) return;
                        const parts = line.split(';').map(p => p.replace(/"/g, '').trim());
                        if (parts.length >= 4) {
                            const name = parts[0];
                            const addr = parts[1] || 'Kabupaten Bogor';
                            const lat = parseFloat(parts[2]);
                            const lng = parseFloat(parts[3]);

                            if (!isNaN(lat) && !isNaN(lng) && lat !== 0 && lng !== 0) {
                                validPointsCount++;
                                const nameLower = name.toLowerCase();
                                const isCamat = nameLower.includes('camat');

                                let bgClass = isCamat
                                    ? 'bg-gradient-to-br from-amber-500 via-orange-500 to-orange-700'
                                    : 'bg-gradient-to-br from-red-500 via-red-600 to-red-800';

                                let badge = isCamat ? 'Kantor Kecamatan' : 'Kantor Dinas & Pemkab';
                                let badgeClass = isCamat ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800';

                                const currentZoom = map.getZoom();
                                const marker = L.marker([lat, lng], {
                                    icon: createCustomIcon(bgClass, currentZoom)
                                }).addTo(map);

                                allMarkers.push({ marker: marker, bgClass: bgClass });

                                marker.bindPopup(`
                                    <div class="p-2 font-sans max-w-[230px]">
                                        <span class="${badgeClass} text-[10px] font-extrabold px-2 py-0.5 rounded-full">${badge}</span>
                                        <h4 class="font-bold text-xs text-gray-900 mt-1.5 leading-snug">${name}</h4>
                                        <p class="text-[11px] text-gray-600 mt-1 leading-normal">📍 ${addr}</p>
                                        <a href="{{ route('publik.form-kunjungan') }}" style="color: #ffffff !important; text-decoration: none !important;" class="leaflet-popup-btn inline-block mt-2.5 text-[11px] font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] px-3.5 py-1.5 rounded-xl transition-all shadow-xs">Isi Form Kunjungan</a>
                                    </div>
                                `);
                            }
                        }
                    });

                    const govCountEl = document.getElementById('stat-gov-points-count');
                    if (govCountEl && validPointsCount > 0) {
                        govCountEl.textContent = `${validPointsCount} Kantor Camat & Pemkab`;
                    }
                })
                .catch(err => console.log('CSV Gov Points Notice:', err));

            // Dynamic Agenda Markers from Database
            const agendaLocations = [
                @foreach ($agendaItems as $agenda)
                    {
                        nama: @json($agenda->nama_agenda),
                        lokasi: @json($agenda->lokasi_display ?? 'Cibinong, Kab. Bogor'),
                        waktu: @json(substr((string) $agenda->waktu, 0, 5) . ' WIB'),
                        kategori: @json(strtolower((string)($agenda->kategori_surat ?? 'internal'))),
                        detailUrl: @json(route('publik.agenda.detail', $agenda->id_agenda)),
                        lat: -6.4795 + ((Math.sin({{ $loop->index + 1 }}) * 0.018)),
                        lng: 106.8252 + ((Math.cos({{ $loop->index + 1 }}) * 0.018))
                    },
                @endforeach
            ];

            agendaLocations.forEach(item => {
                const bgClass = 'bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-700';
                const currentZoom = map.getZoom();

                const marker = L.marker([item.lat, item.lng], {
                    icon: createCustomIcon(bgClass, currentZoom)
                }).addTo(map);

                allMarkers.push({ marker: marker, bgClass: bgClass });

                marker.bindPopup(`
                    <div class="p-2 font-sans max-w-[220px]">
                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-extrabold px-2 py-0.5 rounded-full">Agenda Kegiatan</span>
                        <h4 class="font-bold text-xs text-gray-900 mt-1 leading-snug">${item.nama}</h4>
                        <p class="text-[11px] text-gray-600 mt-1">📍 ${item.lokasi}</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">🕒 ${item.waktu}</p>
                        <a href="${item.detailUrl}" style="color: #ffffff !important; text-decoration: none !important;" class="leaflet-popup-btn inline-block mt-2.5 text-[11px] font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] px-3.5 py-1.5 rounded-xl transition-all shadow-xs">Detail Agenda</a>
                    </div>
                `);
            });

            // Reset Zoom Button
            const btnReset = document.getElementById('btn-reset-map-view');
            if (btnReset) {
                btnReset.addEventListener('click', () => {
                    map.setView([centerLat, centerLng], defaultZoom);
                });
            }

            setTimeout(() => {
                map.invalidateSize();
            }, 300);
        });
    </script>
    @include('publik.layout.image-preview-modal')

    <!-- Scroll Reveal Observer -->
    <script>
    (function() {
        const revealEls = document.querySelectorAll('.scroll-reveal');
        if (!revealEls.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');

                    // Stagger children (cards inside grids)
                    const children = entry.target.querySelectorAll('.scroll-reveal-child');
                    children.forEach((child, i) => {
                        setTimeout(() => {
                            child.classList.add('is-visible');
                        }, i * 140);
                    });

                    observer.unobserve(entry.target); // Only animate once
                }
            });
        }, {
            threshold: 0.08,
            rootMargin: '0px 0px -40px 0px'
        });

        revealEls.forEach(el => observer.observe(el));
    })();
    </script>
</body>
</html>
