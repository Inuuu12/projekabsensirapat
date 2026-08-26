<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Publik - SIRAPI</title>
    @include('publik.layout_publik.theme_script')
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
</head>
<body class="bg-[#F8F7F4] dark:bg-[#0d1614] font-sans antialiased text-gray-800 dark:text-slate-100 flex flex-col min-h-screen transition-colors duration-200">
    @include('publik.layout_publik.navbarpublik')

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
            $imageUrl = function ($path, $fallback = 'foto/Suratlogo.png') {
                if (! $path) {
                    return asset($fallback);
                }

                if (filter_var($path, FILTER_VALIDATE_URL)) {
                    return $path;
                }

                $path = ltrim($path, '/');

                if (str_starts_with($path, 'foto/') || str_starts_with($path, 'uploads/')) {
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
                $aduan->id_datamasukan => [
                    'nama_pengadu' => $aduan->nama_pengadu,
                    'email' => $maskEmail($aduan->email),
                    'isi_aduan' => $aduan->isi_aduan,
                    'balasan_admin' => $aduan->balasan_admin ?: 'Belum ada balasan dari admin.',
                    'status' => $aduan->status ?? 'Pending',
                    'tanggal' => $aduan->created_at ? \Carbon\Carbon::parse($aduan->created_at)->translatedFormat('d F Y, H:i') : '-',
                ],
            ])->all();
        @endphp

        <!-- 1. Running Text Info Terkini -->
        <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs p-3 flex items-center space-x-3 border border-gray-100 dark:border-[#233a34] transition-colors">
            <span class="bg-ijo-tua dark:bg-[#107050] text-white dark:text-emerald-100 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shrink-0">
                INFO TERKINI
            </span>
            <marquee class="text-xs font-medium text-gray-700 dark:text-gray-300">
                {{ $infoItems->isNotEmpty() ? $infoItems->join(' • ') : 'Belum ada info terbaru di database.' }}
            </marquee>
        </div>

        <!-- 2. Header Grid (Widget Cuaca & Banner Ulang Tahun Pegawai Hari Ini) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <button type="button" id="open-weather-modal" class="lg:col-span-6 bg-ijo-tua dark:bg-[#152420] text-white rounded-3xl p-6 flex items-center justify-between shadow-md border border-transparent dark:border-[#233a34] text-left hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer">
                <div>
                    <p id="home-weather-location" class="text-xs text-gray-200 dark:text-gray-300">Cibinong, Kab. Bogor</p>
                    <h2 id="home-weather-temp" class="text-4xl font-extrabold mt-1 text-white dark:text-emerald-400">-</h2>
                    <p id="home-weather-condition" class="text-xs text-gray-200 dark:text-gray-300 mt-1">Memuat data cuaca API...</p>
                    <p id="home-weather-humidity" class="text-[10px] text-gray-300 dark:text-gray-400 mt-2">Kelembapan - • Klik untuk detail </p>
                </div>
                <div class="text-5xl">☁</div>
            </button>

            <a href="#ulang-tahun-pegawai" class="lg:col-span-6 bg-white dark:bg-[#152420] rounded-3xl p-6 border border-gray-100 dark:border-[#233a34] shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-2xl bg-ijo-semitua dark:bg-[#1b3832] text-white dark:text-emerald-400 font-extrabold text-lg flex items-center justify-center shrink-0 border border-transparent dark:border-emerald-500/30">
                        {{ $initial($ulangTahunUtama?->nama) }}
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-base">🎂</span>
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm">
                                {{ $ulangTahunUtama?->nama ? $ulangTahunUtama->nama . ($ulangTahunHariIni ? ' berulang tahun hari ini!' : ' berulang tahun terdekat') : 'Belum ada data ulang tahun' }}
                            </h3>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">{{ $ulangTahunUtama?->tanggal?->translatedFormat('d F') ?? 'Data akan tampil setelah tanggal lahir pegawai diisi' }}</p>
                    </div>
                </div>
                <div class="flex flex-col items-end space-y-2 shrink-0">
                    <span class="bg-oren-muda dark:bg-amber-950/60 text-oren-tua dark:text-amber-300 dark:border dark:border-amber-700/40 text-[10px] font-bold px-3 py-1 rounded-full">{{ $ulangTahunHariIni ? 'Hari Ini!' : 'Terdekat' }}</span>
                </div>
            </a>
        </div>

        <!-- Banner Kunjungan Pejabat -->
        <div class="bg-white dark:bg-[#152420] rounded-3xl p-5 md:p-6 border border-gray-100 dark:border-[#233a34] shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4 md:gap-6 hover:shadow-md transition-all">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-ijo-sangatmuda dark:bg-[#1b3832] text-ijo-tua dark:text-emerald-400 flex items-center justify-center shrink-0 shadow-inner border border-transparent dark:border-emerald-500/20">
                    <svg class="w-6 h-6 md:w-7 md:h-7" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-gray-900 dark:text-white text-sm md:text-base leading-snug">Ingin Bertemu Kami?</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-0.5">Daftarkan kunjungan Anda</p>
                </div>
            </div>
            <a href="{{ route('publik.form-kunjungan') }}" class="w-full md:w-auto inline-flex items-center justify-center space-x-2 text-xs md:text-sm font-bold text-white bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 px-6 py-3 rounded-full transition-all shadow-xs shrink-0 group">
                <span>Isi Form Kunjungan </span>
                <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
            </a>
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
                    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] text-gray-800 dark:text-white rounded-2xl p-5 flex flex-col justify-between space-y-4 shadow-xs">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-300">
                                <span>{{ substr((string) $agenda->waktu, 0, 5) ?: '-' }} WIB</span>
                                <span class="bg-gray-100 dark:bg-[#1b3832] text-gray-700 dark:text-emerald-300 text-[10px] font-medium px-2.5 py-0.5 rounded-full border border-transparent dark:border-emerald-500/20">{{ $agenda->status_label }}</span>
                            </div>
                            <h4 class="font-bold text-sm leading-snug text-gray-900 dark:text-white">{{ $agenda->nama_agenda }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-300">{{ $agenda->lokasi ?? '-' }}</p>
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
                    <div class="md:col-span-3 bg-white dark:bg-[#152420] rounded-2xl p-8 text-center text-gray-500 dark:text-gray-400 text-sm border border-gray-100 dark:border-[#233a34]">
                        Belum ada agenda kegiatan.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- 4. Section Video Dokumentasi & Galeri Foto -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Dokumentasi Video</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-300">{{ $videoTerbaru->judul ?? 'Publikasi video resmi terkait Diskominfo' }}</p>
                    </div>
                    <a href="{{ route('publik.video') }}" class="text-xs font-bold text-ijo-tua dark:text-emerald-400 hover:underline">Lihat Semua &rarr;</a>
                </div>
                <div class="h-64 md:h-80 w-full bg-black rounded-3xl overflow-hidden shadow-xs border border-transparent dark:border-[#233a34]">
                    <iframe class="w-full h-full" src="{{ $youtubeEmbedUrl }}" title="Video Diskominfo Kabupaten Bogor" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>

            <div class="lg:col-span-4 space-y-4 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Galeri Foto</h3>
                    <a href="{{ route('publik.galeri') }}" class="text-xs font-bold text-ijo-tua dark:text-emerald-400 hover:underline">Lihat Semua &rarr;</a>
                </div>
                <div class="grid grid-cols-2 gap-4 flex-grow">
                    @forelse ($galeriItems->take(4) as $item)
                        <div class="h-28 md:h-36 rounded-2xl overflow-hidden shadow-xs bg-gray-200 dark:bg-[#152420] border border-transparent dark:border-[#233a34] group relative">
                            <img src="{{ $imageUrl($item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @empty
                        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl flex-1 shadow-xs flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold text-sm col-span-2 p-6">
                            Belum ada foto galeri
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- 5. Section Berita Terkini & Widget Ulang Tahun Pegawai List -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Berita Terkini</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-300">Kabar terbaru seputar Diskominfo Kabupaten Bogor</p>
                    </div>
                    <a href="{{ route('publik.berita') }}" class="text-xs font-semibold text-gray-700 dark:text-gray-200 bg-gray-200 dark:bg-[#152420] dark:border dark:border-[#284c43] hover:bg-gray-300 dark:hover:bg-[#1b3832] px-4 py-1.5 rounded-full transition-colors">
                        Selengkapnya
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse ($beritaItems->take(2) as $berita)
                        <div class="bg-white dark:bg-[#152420] rounded-3xl overflow-hidden shadow-xs border border-gray-100 dark:border-[#233a34] flex flex-col justify-between transition-colors">
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
                                <a href="{{ route('publik.berita.detail', $berita->id_berita) }}" class="inline-flex items-center justify-center space-x-1.5 text-xs font-bold text-white bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 px-4 py-2.5 rounded-2xl transition-all shadow-xs">
                                    <span>Baca Selengkapnya</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-2 bg-white dark:bg-[#152420] rounded-3xl p-6 border border-gray-100 dark:border-[#233a34] text-sm font-medium text-gray-500 dark:text-gray-400">
                            Belum ada berita terkini di database.
                        </div>
                    @endforelse
                </div>
            </div>

            <div id="ulang-tahun-pegawai" class="lg:col-span-4 bg-white dark:bg-[#152420] rounded-3xl p-6 border border-gray-100 dark:border-[#233a34] shadow-xs space-y-4 flex flex-col justify-between scroll-mt-24 transition-colors">
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="text-base">🎂</span>
                        <h3 class="font-bold text-gray-900 dark:text-white text-sm">Ulang Tahun Pegawai</h3>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-300">Jangan lupa ucapkan selamat ke rekan kerja</p>

                    <div class="mt-4 space-y-3">
                        @forelse ($ulangTahunItems->take(3) as $pegawai)
                            <div class="{{ $pegawai->is($ulangTahunHariIni) ? 'bg-oren-muda dark:bg-amber-950/40 border border-transparent dark:border-amber-700/40' : 'bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34]' }} rounded-2xl p-3 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-ijo-tua dark:bg-[#1b3832] text-white dark:text-emerald-400 font-bold text-xs flex items-center justify-center shrink-0 border border-transparent dark:border-emerald-500/30">
                                        {{ $initial($pegawai->nama) }}
                                    </div>
                                    <div>
                                        <h5 class="text-xs font-bold text-gray-900 dark:text-white">{{ $pegawai->nama }}</h5>
                                        <p class="text-[10px] text-gray-500 dark:text-gray-300">{{ $pegawai->tanggal?->translatedFormat('d F') ?? '-' }}</p>
                                        @if ($pegawai->is($ulangTahunHariIni))
                                            <span class="bg-oren-tua text-white text-[9px] font-bold px-2 py-0.5 rounded-full mt-0.5 inline-block">Hari Ini!</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-oren-tua dark:text-amber-400">{{ $pegawai->tanggal?->translatedFormat('d M') ?? '-' }}</span>
                            </div>
                        @empty
                            <p class="rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-3 text-xs text-gray-500 dark:text-gray-400">Belum ada pegawai yang memiliki tanggal lahir.</p>
                        @endforelse
                    </div>
                </div>

                <div class="border-t border-gray-100 dark:border-[#233a34] pt-3">
                    <a href="{{ route('publik.ulang-tahun') }}" class="w-full inline-flex items-center justify-center space-x-1.5 text-xs font-bold text-white bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 px-4 py-2.5 rounded-2xl transition-all shadow-xs">
                        <span>Lihat Semua Pegawai</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 6. Section daftar Aduan -->
        <section class="bg-white dark:bg-[#152420] rounded-3xl p-6 border border-gray-100 dark:border-[#233a34] shadow-xs space-y-4 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Daftar Aduan</h3>
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
                            <tr class="home-aduan-row cursor-pointer hover:bg-gray-50/80 dark:hover:bg-white/5 transition" data-aduan-id="{{ $aduan->id_datamasukan }}" title="Klik untuk melihat detail aduan">
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
                    <span>&rarr;</span>
                </a>
            </div>
        </section>
    </main>

    <div id="home-aduan-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-4">
        <div class="w-full max-w-2xl rounded-3xl bg-white dark:bg-[#152420] text-gray-800 dark:text-slate-100 shadow-xl overflow-hidden border border-transparent dark:border-[#233a34]">
            <div class="bg-ijo-tua dark:bg-[#0f1c19] text-white p-6 flex items-start justify-between gap-4 border-b border-transparent dark:border-[#233a34]">
                <div>       
                    <p class="text-xs uppercase tracking-wider text-white/70 dark:text-emerald-400 font-bold">Detail Aduan</p>
                    <h2 id="home-aduan-title" class="text-xl font-extrabold mt-1 text-white">-</h2>
                    <p id="home-aduan-date" class="text-xs text-white/70 dark:text-gray-300 mt-1">-</p>
                </div>
                <button type="button" id="home-aduan-close" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 dark:bg-white/5 dark:hover:bg-white/10 flex items-center justify-center text-lg font-bold cursor-pointer">x</button>
            </div>

            <div class="p-6 space-y-5">
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

    <div id="weather-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-4">
        <div class="w-full max-w-2xl rounded-3xl bg-white dark:bg-[#152420] text-gray-800 dark:text-slate-100 shadow-xl overflow-hidden border border-transparent dark:border-[#233a34]">
            <div class="bg-ijo-tua dark:bg-[#0f1c19] text-white p-6 flex items-start justify-between gap-4 border-b border-transparent dark:border-[#233a34]">
                <div>
                    <p class="text-xs uppercase tracking-wider text-white/70 dark:text-emerald-400 font-bold">Cuaca API</p>
                    <h2 id="weather-location" class="text-xl font-extrabold mt-1 text-white">Cibinong, Kabupaten Bogor</h2>
                    <p id="weather-updated" class="text-xs text-white/70 dark:text-gray-300 mt-1">Memuat data...</p>
                </div>
                <button type="button" id="close-weather-modal" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 dark:bg-white/5 dark:hover:bg-white/10 flex items-center justify-center text-lg font-bold cursor-pointer">x</button>
            </div>

            <div class="p-6 space-y-5">
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

    @include('publik.layout_publik.footer')
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
    </script>
</body>
</html>
