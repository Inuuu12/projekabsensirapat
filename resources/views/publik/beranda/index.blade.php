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
</head>
<body class="bg-[#F8F7F4] dark:bg-[#0d1614] font-sans antialiased text-gray-800 dark:text-slate-100 flex flex-col min-h-screen transition-colors duration-200">
    @include('publik.layout.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-6 space-y-8">
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

        <!-- Header Grid (Ingin Bertemu Kami & Widget Cuaca API Teks Hitam) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            <!-- Sisi Kiri: Banner Kunjungan Pejabat / Ingin Bertemu Kami (75% / col-span-9) -->
            <div class="lg:col-span-9 bg-white dark:bg-[#152420] rounded-xl p-5 md:p-6 border border-gray-100 dark:border-[#233a34] shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-ijo-sangatmuda dark:bg-[#1b3832] text-ijo-tua dark:text-emerald-400 flex items-center justify-center shrink-0 shadow-inner border border-transparent dark:border-emerald-500/20">
                        <svg class="w-6 h-6 md:w-7 md:h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-black text-gray-900 dark:text-white text-base md:text-lg leading-snug">Ingin Bertemu Kami?</h3>
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-300 mt-1 max-w-xl">
                            Ajukan pendaftaran kunjungan kerja, audiensi, atau konsultasi resmi secara mudah dengan jajaran pimpinan & pejabat Pemerintah Kabupaten Bogor.
                        </p>
                    </div>
                </div>
                <a href="{{ route('publik.form-kunjungan') }}" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 text-xs md:text-sm font-bold text-white bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 px-5 py-3 rounded-full transition-all shadow-xs shrink-0 group whitespace-nowrap">
                    <span>Isi Form Kunjungan</span>
                </a>
            </div>

            <!-- Sisi Kanan: Informasi Cuaca (25% / col-span-3 - Tanpa Card Container) -->
            <button type="button" id="open-weather-modal" class="lg:col-span-3 flex items-center justify-between p-4 md:p-5 text-left transition-opacity hover:opacity-85 cursor-pointer">
                <div>
                    <p id="home-weather-location" class="text-xs font-semibold text-gray-600 dark:text-gray-300">Cibinong, Kab. Bogor</p>
                    <h2 id="home-weather-temp" class="text-3xl md:text-4xl font-black mt-1 text-gray-900 dark:text-emerald-400">-</h2>
                    <p id="home-weather-condition" class="text-xs font-bold text-gray-800 dark:text-gray-200 mt-1">Memuat data cuaca API...</p>
                    <p id="home-weather-humidity" class="text-[10px] font-semibold text-gray-500 dark:text-gray-400 mt-2">Kelembapan - • Klik untuk detail </p>
                </div>
                <div class="text-4xl md:text-5xl shrink-0 text-gray-800 dark:text-emerald-400">☁</div>
            </button>
        </div>

        <!-- 3. Section Agenda Hari Ini -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $agendaBerandaLabel ?? 'Agenda Hari Ini' }}</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-300">{{ $agendaBerandaDescription ?? (now()->translatedFormat('l, d F Y') . ' &bull; ' . ($totalAgendaHariIni ?? $agendaItems->count()) . ' kegiatan terjadwal') }}</p>
                </div>
                <a href="{{ route('publik.agenda') }}" class="text-xs font-semibold text-gray-700 dark:text-gray-200 bg-gray-200 dark:bg-[#152420] dark:border dark:border-[#284c43] hover:bg-gray-300 dark:hover:bg-[#1b3832] px-4 py-1.5 rounded-full transition-colors">
                    Selengkapnya
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($agendaItems as $agenda)
                    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] text-gray-800 dark:text-white rounded-xl p-5 flex flex-col justify-between space-y-4 shadow-md hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-300">
                                <span>{{ substr((string) $agenda->waktu, 0, 5) ?: '-' }} WIB</span>
                                <span class="bg-gray-100 dark:bg-[#1b3832] text-gray-700 dark:text-emerald-300 text-[10px] font-medium px-2.5 py-0.5 rounded-full border border-transparent dark:border-emerald-500/20">{{ $agenda->status_label }}</span>
                            </div>
                            <div class="space-y-1">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <h4 class="font-bold text-sm leading-snug text-gray-900 dark:text-white">{{ $agenda->nama_agenda }}</h4>
                                    @if (strtolower((string) ($agenda->kategori_surat ?? 'internal')) === 'internal')
                                        <span class="inline-flex items-center text-[9px] font-bold text-blue-700 dark:text-sky-300 bg-blue-50 dark:bg-sky-950/60 px-2 py-0.5 rounded-md border border-blue-100 dark:border-sky-800/40">Khusus Pegawai</span>
                                    @elseif (strtolower((string) ($agenda->kategori_surat ?? '')) === 'masuk')
                                        <span class="inline-flex items-center text-[9px] font-bold text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/60 px-2 py-0.5 rounded-md border border-amber-100 dark:border-amber-800/40">Pegawai Ditugaskan</span>
                                    @else
                                        <span class="inline-flex items-center text-[9px] font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-md border border-emerald-100 dark:border-emerald-800/40">Pegawai & Tamu</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-300">{{ $agenda->lokasi_display ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-100 dark:border-[#233a34] pt-3 text-xs">
                            @if (strtolower((string) ($agenda->kategori_surat ?? '')) !== 'masuk')
                                <span class="bg-oren-muda dark:bg-amber-950/60 text-oren-tua dark:text-amber-300 dark:border dark:border-amber-700/40 font-bold px-3 py-1 rounded-full text-[10px]">{{ $agenda->kuota ?? 0 }} Peserta</span>
                            @else
                                <span></span>
                            @endif
                            <a href="{{ route('publik.agenda.detail', $agenda->id_agenda) }}" class="bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#1b3832] dark:border dark:border-[#284c43] text-white dark:text-emerald-300 px-3 py-1 rounded-lg text-[10px] font-semibold transition-colors hover:bg-[#2b4f49] dark:hover:bg-[#23423b]">Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-3 bg-white dark:bg-[#152420] rounded-xl p-8 text-center text-gray-500 dark:text-gray-400 text-sm border border-gray-100 dark:border-[#233a34]">
                        Belum ada agenda kegiatan.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- 4. Section Peta Sebaran Agenda & Kunjungan Kerja (Kabupaten Bogor) -->
        <section class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span>Peta Sebaran Agenda & Kunjungan Kerja</span>
                        <span class="bg-ijo-sangatmuda dark:bg-[#1b3832] text-ijo-tua dark:text-emerald-300 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full border border-ijo-tua/20 dark:border-emerald-500/30">GIS Kabupaten Bogor</span>
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-0.5">Pemetaan wilayah 40 Kecamatan di Kabupaten Bogor beserta sebaran titik kegiatan & kunjungan kerja.</p>
                </div>
                <div class="flex items-center space-x-2 shrink-0">
                    <button type="button" id="btn-reset-map-view" class="text-xs font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-[#1b3832] px-3.5 py-1.5 rounded-full transition-all shadow-xs inline-flex items-center space-x-1.5">
                        <span>🎯 Reset Tampilan Peta</span>
                    </button>
                </div>
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
                    <div class="relative w-full h-[460px] md:h-[500px] rounded-xl overflow-hidden border border-gray-200/80 dark:border-[#284c43] shadow-inner flex-grow">
                        <div id="beranda-map" class="w-full h-full z-0 bg-[#e5e3df] dark:bg-[#121f1c]"></div>

                        <!-- Overlay Legend -->
                        <div class="absolute bottom-3 left-3 z-[400] bg-white/95 dark:bg-[#152420]/95 backdrop-blur-md border border-gray-200/80 dark:border-[#233a34] rounded-xl p-3 shadow-lg text-[11px] space-y-1.5 pointer-events-auto max-w-[240px]">
                            <p class="font-bold text-gray-900 dark:text-white text-xs border-b border-gray-100 dark:border-[#284c43] pb-1">Keterangan Peta</p>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-[#10b981] border border-emerald-700 shrink-0"></span>
                                <span class="text-gray-700 dark:text-gray-300">Batas Kecamatan Kab. Bogor</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-emerald-600 text-white text-[9px] flex items-center justify-center font-bold shrink-0">🏛️</span>
                                <span class="text-gray-700 dark:text-gray-300">Kantor Camat & Bupati</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-[#D89B3C] text-white text-[9px] flex items-center justify-center font-bold shrink-0">📋</span>
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
                                <h4 class="font-extrabold text-gray-900 dark:text-white text-base leading-snug">Rapat Dinas & Instansi</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Daftar agenda kegiatan di Pemkab Bogor</p>
                            </div>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        </div>

                        <!-- 3 List Rapat Terbaru -->
                        <div class="space-y-3">
                            @forelse ($agendaItems->take(3) as $agenda)
                                <div class="bg-[#F8F7F4] dark:bg-[#0f1c19] border border-gray-200/70 dark:border-[#233a34] rounded-xl p-3.5 space-y-2 hover:border-ijo-tua dark:hover:border-emerald-500/50 transition-all duration-200 group">
                                    <div class="flex items-center justify-between gap-2 text-[10px]">
                                        <span class="bg-amber-100 dark:bg-amber-950/70 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800/50 font-bold px-2 py-0.5 rounded-full">
                                            {{ $agenda->status_label }}
                                        </span>
                                        <span class="text-gray-500 dark:text-gray-400 font-medium">
                                            🕒 {{ substr((string) $agenda->waktu, 0, 5) }} WIB
                                        </span>
                                    </div>

                                    <div>
                                        <h5 class="font-bold text-gray-900 dark:text-white text-xs leading-snug line-clamp-2 group-hover:text-ijo-tua dark:group-hover:text-emerald-400 transition-colors">
                                            {{ $agenda->nama_agenda }}
                                        </h5>
                                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                                            <span>📍</span>
                                            <span class="truncate">{{ $agenda->lokasi_display ?? 'Diskominfo Kab. Bogor' }}</span>
                                        </p>
                                    </div>

                                    <div class="pt-2 border-t border-gray-200/50 dark:border-[#233a34] flex items-center justify-between text-[11px]">
                                        <span class="text-gray-400 dark:text-gray-400">
                                            📅 {{ $agenda->tanggal ? \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('d M Y') : '-' }}
                                        </span>
                                        <a href="{{ route('publik.agenda.detail', $agenda->id_agenda) }}" class="font-bold text-ijo-tua dark:text-emerald-400 hover:underline">
                                            Detail &rarr;
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
                            <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. Section Berita Terkini -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Berita Terkini</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-300">Kabar terbaru seputar Diskominfo Kabupaten Bogor</p>
                </div>
                <a href="{{ route('publik.berita') }}" class="text-xs font-semibold text-gray-700 dark:text-gray-200 bg-gray-200 dark:bg-[#152420] dark:border dark:border-[#284c43] hover:bg-gray-300 dark:hover:bg-[#1b3832] px-4 py-1.5 rounded-full transition-colors">
                    Selengkapnya
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($beritaItems->take(3) as $berita)
                    <div class="bg-white dark:bg-[#152420] rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-0.5 border border-gray-100 dark:border-[#233a34] flex flex-col justify-between transition-all duration-300">
                        <div>
                            <div class="h-40 bg-ijo-muda bg-cover bg-center relative p-4" style="background-image: url('{{ $imageUrl($berita->gambar) }}')">
                                <span class="bg-white text-ijo-tua font-bold text-[10px] px-3 py-1 rounded-full shadow-xs">Berita</span>
                            </div>
                            <div class="p-5 space-y-2">
                                <p class="text-[10px] text-gray-400 dark:text-gray-400 font-semibold">{{ $berita->tanggal?->translatedFormat('d F Y') ?? '-' }}</p>
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm leading-snug">{{ $berita->judul }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-300 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($berita->isi_berita), 90) }}</p>
                            </div>
                        </div>
                        <div class="p-5 pt-0">
                            <a href="{{ route('publik.berita.detail', $berita->id_berita) }}" class="inline-flex items-center justify-center space-x-1.5 text-xs font-bold text-white bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 px-4 py-2.5 rounded-xl transition-all shadow-xs">
                                <span>Baca Selengkapnya</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-3 bg-white dark:bg-[#152420] rounded-xl p-6 border border-gray-100 dark:border-[#233a34] text-sm font-medium text-gray-500 dark:text-gray-400 text-center">
                        Belum ada berita terkini di database.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- 6. Section daftar Aduan -->
        <section class="bg-white dark:bg-[#152420] rounded-xl p-6 border border-gray-100 dark:border-[#233a34] shadow-md hover:shadow-xl space-y-4 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Aduan</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-300">Aspirasi, masukan, dan tindak lanjut pengaduan masyarakat seputar layanan Diskominfo Kabupaten Bogor</p>
                </div>
                <a href="{{ route('publik.riwayat-aduan') }}" class="text-xs font-semibold text-gray-700 dark:text-gray-200 bg-gray-200 dark:bg-[#152420] dark:border dark:border-[#284c43] hover:bg-gray-300 dark:hover:bg-[#1b3832] px-4 py-1.5 rounded-full transition-colors">
                    Selengkapnya
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-[#0f1c19] text-gray-500 dark:text-gray-300 uppercase text-[10px] tracking-wider">
                            <th class="p-3 rounded-l-xl">NAMA PENGADU</th>
                            <th class="p-3">ISI ADUAN</th>
                            <th class="p-3">BALASAN ADMIN</th>
                            <th class="p-3 text-center">STATUS</th>
                            <th class="p-3 text-right rounded-r-xl">TANGGAL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-[#233a34] font-medium text-gray-700 dark:text-gray-200">
                        @forelse ($masukanItems as $aduan)
                            <tr class="home-aduan-row cursor-pointer hover:bg-gray-50/80 dark:hover:bg-white/5 transition" data-aduan-id="{{ $aduan->id_dataaduan }}" title="Klik untuk melihat detail aduan">
                                <td class="p-3 font-bold text-gray-900 dark:text-white">{{ $aduan->nama_pengadu }}</td>
                                <td class="p-3 text-gray-500 dark:text-gray-300">{{ \Illuminate\Support\Str::limit($aduan->isi_aduan, 55) }}</td>
                                <td class="p-3 text-gray-500 dark:text-gray-300">{{ $aduan->balasan_admin ? \Illuminate\Support\Str::limit($aduan->balasan_admin, 55) : 'Belum ada balasan' }}</td>
                                <td class="p-3 text-center">
                                    <span class="{{ $statusClass($aduan->status) }} font-bold px-3 py-1 rounded-full text-[10px]">{{ $aduan->status ?? 'Pending' }}</span>
                                </td>
                                <td class="p-3 text-right text-gray-400 dark:text-gray-400">{{ $aduan->created_at ? \Carbon\Carbon::parse($aduan->created_at)->translatedFormat('d M') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-5 text-center text-gray-500 dark:text-gray-400">Belum ada aduan di database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end pt-2 border-t border-gray-100 dark:border-[#233a34]">
                <a href="{{ route('publik.masukan') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-white bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 px-5 py-2.5 rounded-2xl transition-all shadow-xs">
                    <span>Buat Aduan Baru</span>
                </a>
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
                : 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';

            const map = L.map('beranda-map', {
                center: [centerLat, centerLng],
                zoom: defaultZoom,
                zoomControl: true,
                scrollWheelZoom: false
            });

            let currentTileLayer = L.tileLayer(getTileUrl(isDark), {
                attribution: '&copy; OpenStreetMap &copy; CARTO',
                subdomains: 'abcd',
                maxZoom: 19
            }).addTo(map);

            let geojsonLayer;

            const updateMapTheme = (dark) => {
                map.removeLayer(currentTileLayer);
                currentTileLayer = L.tileLayer(getTileUrl(dark), {
                    attribution: '&copy; OpenStreetMap &copy; CARTO',
                    subdomains: 'abcd',
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
            fetch('{{ asset("admin_kec.json") }}')
                .then(res => res.json())
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

            // Dynamic Icon Sizer based on Zoom Level
            const getIconConfigForZoom = (zoom) => {
                if (zoom <= 8) return { size: 18, font: 'text-[9px]', innerSize: 'w-4.5 h-4.5' };
                if (zoom === 9) return { size: 22, font: 'text-[10px]', innerSize: 'w-5.5 h-5.5' };
                if (zoom === 10) return { size: 28, font: 'text-xs', innerSize: 'w-7 h-7' };
                if (zoom === 11) return { size: 34, font: 'text-xs', innerSize: 'w-8.5 h-8.5' };
                if (zoom === 12) return { size: 40, font: 'text-sm', innerSize: 'w-10 h-10' };
                if (zoom === 13) return { size: 46, font: 'text-base', innerSize: 'w-11 h-11' };
                return { size: 52, font: 'text-lg', innerSize: 'w-13 h-13' };
            };

            // Custom Leaflet Marker Icon Builder with Zoom-scaling support
            const createCustomIcon = (iconEmoji = '📍', bgClass = 'bg-[#35635b]', zoom = defaultZoom) => {
                const cfg = getIconConfigForZoom(zoom);
                return L.divIcon({
                    className: 'custom-map-pin',
                    html: `
                        <div class="relative flex items-center justify-center">
                            <div class="${cfg.innerSize} rounded-full ${bgClass} text-white flex items-center justify-center ${cfg.font} shadow-md border-2 border-white dark:border-[#152420] transition-all duration-200 hover:scale-125">
                                ${iconEmoji}
                            </div>
                        </div>
                    `,
                    iconSize: [cfg.size, cfg.size],
                    iconAnchor: [cfg.size / 2, cfg.size / 2],
                    popupAnchor: [0, -cfg.size / 2]
                });
            };

            const updateAllMarkerSizes = () => {
                const currentZoom = map.getZoom();
                allMarkers.forEach(m => {
                    m.marker.setIcon(createCustomIcon(m.iconEmoji, m.bgClass, currentZoom));
                });
            };

            map.on('zoomend', updateAllMarkerSizes);

            // Load 41 Government Points (Kantor Bupati & 40 Kantor Camat) from /app_md_mapgovpoint.csv
            fetch('{{ asset("app_md_mapgovpoint.csv") }}')
                .then(res => res.text())
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
                                const isCamatOrBupati = name.toLowerCase().includes('camat') || name.toLowerCase().includes('bupati');
                                const isDinas = name.toLowerCase().includes('dinas') || name.toLowerCase().includes('badan') || name.toLowerCase().includes('sekretariat');

                                let icon = isCamatOrBupati ? '🏛️' : '🏢';
                                let bgClass = 'bg-emerald-600';
                                let badge = 'Kantor Pemerintahan / Camat';

                                const currentZoom = map.getZoom();
                                const marker = L.marker([lat, lng], {
                                    icon: createCustomIcon(icon, bgClass, currentZoom)
                                }).addTo(map);

                                allMarkers.push({ marker: marker, iconEmoji: icon, bgClass: bgClass });

                                marker.bindPopup(`
                                    <div class="p-2 font-sans max-w-[230px]">
                                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-extrabold px-2 py-0.5 rounded-full">${badge}</span>
                                        <h4 class="font-bold text-xs text-gray-900 mt-1.5 leading-snug">${name}</h4>
                                        <p class="text-[11px] text-gray-600 mt-1 leading-normal">📍 ${addr}</p>
                                        <a href="{{ route('publik.form-kunjungan') }}" class="inline-block mt-2 text-[10px] font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] px-2.5 py-1 rounded transition-colors">Isi Form Kunjungan &rarr;</a>
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
                        lat: -6.4795 + ((Math.sin({{ $loop->index + 1 }}) * 0.08)),
                        lng: 106.8252 + ((Math.cos({{ $loop->index + 1 }}) * 0.08))
                    },
                @endforeach
            ];

            agendaLocations.forEach(item => {
                const iconEmoji = item.kategori === 'internal' ? '📋' : '🤝';
                const bgClass = item.kategori === 'internal' ? 'bg-[#35635b]' : 'bg-[#D89B3C]';
                const currentZoom = map.getZoom();

                const marker = L.marker([item.lat, item.lng], {
                    icon: createCustomIcon(iconEmoji, bgClass, currentZoom)
                }).addTo(map);

                allMarkers.push({ marker: marker, iconEmoji: iconEmoji, bgClass: bgClass });

                marker.bindPopup(`
                    <div class="p-2 font-sans max-w-[220px]">
                        <span class="bg-amber-100 text-amber-800 text-[10px] font-extrabold px-2 py-0.5 rounded-full">Agenda Kegiatan</span>
                        <h4 class="font-bold text-xs text-gray-900 mt-1 leading-snug">${item.nama}</h4>
                        <p class="text-[11px] text-gray-600 mt-1">📍 ${item.lokasi}</p>
                        <p class="text-[10px] text-gray-500 mt-0.5">🕒 ${item.waktu}</p>
                        <a href="${item.detailUrl}" class="inline-block mt-2 text-[10px] font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] px-2.5 py-1 rounded transition-colors">Detail Agenda &rarr;</a>
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
</body>
</html>
