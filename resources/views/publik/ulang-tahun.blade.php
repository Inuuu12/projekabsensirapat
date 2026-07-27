<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulang Tahun Pegawai - Diskominfo Kabupaten Bogor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ijo-tua': '#14524E',
                        'ijo-semitua': '#1F7A6F',
                        'ijo-muda': '#5FA79C',
                        'ijo-sangatmuda': '#DCF1E6',
                        'oren-utama': '#D89B3C',
                        'oren-muda': '#FBEBD1',
                        'oren-tua': '#B87A1E',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8F7F4] font-sans antialiased text-gray-800 flex flex-col min-h-screen">
    @include('publik.layout_publik.navbarpublik')

    <main class="flex-grow container mx-auto px-6 lg:px-12 py-8 space-y-8 max-w-7xl">
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

                if (str_starts_with($path, 'foto/') || str_starts_with($path, 'uploads/')) {
                    return asset($path);
                }

                return asset('storage/' . $path);
            };
        @endphp

        <div class="space-y-4">
            <nav class="text-xs text-gray-500 flex items-center space-x-2">
                <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 font-semibold">Ulang Tahun</span>
            </nav>

            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Ulang Tahun Pegawai</h1>
                <p class="text-xs text-gray-500 mt-1">Data ulang tahun pegawai Diskominfo Kabupaten Bogor dari database</p>
            </div>
        </div>

        @if ($utama)
            <section class="bg-ijo-tua rounded-3xl p-6 md:p-8 text-white relative overflow-hidden shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="absolute top-0 left-0 bg-oren-utama text-white text-[10px] font-bold uppercase tracking-wider px-4 py-1.5 rounded-br-2xl">
                    {{ $ulangTahunHariIni ? 'Ulang Tahun Hari Ini' : 'Ulang Tahun Terdekat' }}
                </div>

                <div class="flex items-center space-x-5 pt-4 md:pt-0">
                    @if ($imageUrl($utama->gambar))
                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-cover bg-center border-2 border-white/20 shrink-0 shadow-inner" style="background-image: url('{{ $imageUrl($utama->gambar) }}')"></div>
                    @else
                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-ijo-muda/40 border-2 border-white/20 flex items-center justify-center text-xl md:text-2xl font-bold text-white shrink-0 shadow-inner">
                            {{ $initial($utama->nama) }}
                        </div>
                    @endif
                    <div class="space-y-1">
                        <h2 class="text-xl md:text-2xl font-extrabold text-white">{{ $utama->nama }}</h2>
                        <p class="text-xs text-gray-200/90 font-medium">Pegawai Diskominfo Kabupaten Bogor</p>
                        <p class="text-xs text-oren-muda font-mono pt-1">{{ $utama->tanggal?->translatedFormat('d F') ?? '-' }}</p>
                    </div>
                </div>
            </section>
        @endif

        <section class="space-y-4 pt-2">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Daftar Ulang Tahun</h3>
                <p class="text-xs text-gray-500">{{ $ulangTahunItems->count() }} data pegawai tersedia</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @forelse ($ulangTahunItems as $pegawai)
                    <article class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-3 hover:shadow-md transition-shadow">
                        @if ($imageUrl($pegawai->gambar))
                            <div class="w-14 h-14 rounded-full bg-cover bg-center shadow-sm" style="background-image: url('{{ $imageUrl($pegawai->gambar) }}')"></div>
                        @else
                            <div class="w-14 h-14 rounded-full bg-ijo-tua flex items-center justify-center text-white font-bold text-base shadow-sm">
                                {{ $initial($pegawai->nama) }}
                            </div>
                        @endif
                        <div class="space-y-0.5 w-full">
                            <h4 class="font-bold text-sm text-gray-900 truncate">{{ $pegawai->nama }}</h4>
                            <p class="text-[11px] text-gray-400">Pegawai Diskominfo</p>
                        </div>
                        <div class="w-full pt-2 border-t border-gray-50">
                            <span class="{{ $pegawai->is($ulangTahunHariIni) ? 'bg-oren-muda text-oren-tua' : 'bg-ijo-sangatmuda text-ijo-tua' }} text-xs font-bold px-4 py-1.5 rounded-full inline-block">
                                {{ $pegawai->tanggal?->translatedFormat('d F') ?? '-' }}
                            </span>
                        </div>
                    </article>
                @empty
                    <div class="lg:col-span-4 sm:col-span-2 bg-white rounded-2xl p-8 border border-gray-100 shadow-sm text-center">
                        <h3 class="font-bold text-gray-900">Belum ada data ulang tahun di database</h3>
                        <p class="text-xs text-gray-500 mt-2">Data akan tampil setelah admin menambahkan ulang tahun pegawai.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
