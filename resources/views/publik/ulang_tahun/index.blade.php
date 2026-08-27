<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulang Tahun Pegawai - SIRAPI</title>
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
                        'oren-muda': '#FBEBD1',
                        'oren-tua': '#B87A1E',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8F7F4] dark:bg-[#0d1614] font-sans antialiased text-gray-800 dark:text-slate-100 flex flex-col min-h-screen transition-colors duration-200">
    @include('publik.layout.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-8 space-y-8">
        @php
            $ulangTahunItems = collect($ulangTahun ?? []);
            $utama = $ulangTahunHariIni ?? $ulangTahunItems->first();
            $initial = fn ($name) => collect(explode(' ', trim((string) $name)))->filter()->take(2)->map(fn ($word) => strtoupper(substr($word, 0, 1)))->join('') ?: 'DB';
            $imageUrl = function ($path) {
                if (! $path) {
                    return null;
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
        @endphp

        <div class="space-y-4">
            <nav class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-2">
                <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 dark:text-gray-200 font-semibold">Ulang Tahun</span>
            </nav>

            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">Ulang Tahun Pegawai</h1>
                <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">Data ulang tahun pegawai Diskominfo Kabupaten Bogor dari database</p>
            </div>
        </div>

        @if ($utama)
            <section class="bg-ijo-tua dark:bg-[#152420] border border-transparent dark:border-[#233a34] rounded-3xl p-6 md:p-8 text-white relative overflow-hidden shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="absolute top-0 left-0 bg-oren-utama dark:bg-[#d97706] text-white text-[10px] font-bold uppercase tracking-wider px-4 py-1.5 rounded-br-2xl shadow-xs">
                    {{ $ulangTahunHariIni ? 'Ulang Tahun Hari Ini' : 'Ulang Tahun Terdekat' }}
                </div>

                <div class="flex items-center space-x-5 pt-4 md:pt-0">
                    @if ($imageUrl($utama->gambar))
                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-cover bg-center border-2 border-white/20 dark:border-emerald-500/30 shrink-0 shadow-inner" style="background-image: url('{{ $imageUrl($utama->gambar) }}')"></div>
                    @else
                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-ijo-muda/40 dark:bg-[#1b3832] border-2 border-white/20 dark:border-emerald-500/30 flex items-center justify-center text-xl md:text-2xl font-bold text-white dark:text-emerald-400 shrink-0 shadow-inner">
                            {{ $initial($utama->nama) }}
                        </div>
                    @endif
                    <div class="space-y-1">
                        <h2 class="text-xl md:text-2xl font-extrabold text-white">{{ $utama->nama }}</h2>
                        <p class="text-xs text-gray-200/90 dark:text-gray-300 font-medium">Pegawai Diskominfo Kabupaten Bogor</p>
                        <p class="text-xs text-oren-muda dark:text-amber-300 font-mono pt-1">{{ $utama->tanggal?->translatedFormat('d F') ?? '-' }}</p>
                    </div>
                </div>
            </section>
        @endif

        <section class="space-y-4 pt-2">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Ulang Tahun</h3>
                <p class="text-xs text-gray-500 dark:text-gray-300">{{ $ulangTahunItems->count() }} data pegawai tersedia</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @forelse ($ulangTahunItems as $pegawai)
                    <article class="bg-white dark:bg-[#152420] rounded-2xl p-5 border border-gray-100 dark:border-[#233a34] shadow-xs flex flex-col items-center text-center space-y-3 hover:shadow-md transition-all">
                        @if ($imageUrl($pegawai->gambar))
                            <div class="w-14 h-14 rounded-full bg-cover bg-center shadow-xs border border-transparent dark:border-[#284c43]" style="background-image: url('{{ $imageUrl($pegawai->gambar) }}')"></div>
                        @else
                            <div class="w-14 h-14 rounded-full bg-ijo-tua dark:bg-[#1b3832] text-white dark:text-emerald-400 border border-transparent dark:border-emerald-500/30 flex items-center justify-center font-bold text-base shadow-xs">
                                {{ $initial($pegawai->nama) }}
                            </div>
                        @endif
                        <div class="space-y-0.5 w-full">
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white truncate">{{ $pegawai->nama }}</h4>
                            <p class="text-[11px] text-gray-400 dark:text-gray-400">Pegawai Diskominfo</p>
                        </div>
                        <div class="w-full pt-2 border-t border-gray-50 dark:border-[#233a34]">
                            <span class="{{ $pegawai->is($ulangTahunHariIni) ? 'bg-oren-muda dark:bg-amber-950/50 text-oren-tua dark:text-amber-200 dark:border dark:border-amber-700/40' : 'bg-ijo-sangatmuda dark:bg-[#0f1c19] text-ijo-tua dark:text-emerald-400 border border-transparent dark:border-[#284c43]' }} text-xs font-bold px-4 py-1.5 rounded-full inline-block">
                                {{ $pegawai->tanggal?->translatedFormat('d F') ?? '-' }}
                            </span>
                        </div>
                    </article>
                @empty
                    <div class="lg:col-span-4 sm:col-span-2 bg-white dark:bg-[#152420] rounded-2xl p-8 border border-gray-100 dark:border-[#233a34] shadow-xs text-center">
                        <h3 class="font-bold text-gray-900 dark:text-white">Belum ada data ulang tahun pegawai</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Data akan tampil setelah tanggal lahir pegawai diisi oleh admin.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    @include('publik.layout.footer')
</body>
</html>
