<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Berita - SIRAPI</title>
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

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-8 space-y-8">
        @php
            $beritaItems = ($berita ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator
                ? $berita->getCollection()
                : collect($berita ?? []);
            $imageUrl = function ($path) {
                if (! $path) {
                    return asset('foto/Suratlogo.png');
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
            <nav class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-2">
                <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 dark:text-gray-200 font-semibold">Berita</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">Semua Berita</h1>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">Kabar terbaru seputar Diskominfo Kabupaten Bogor</p>
                </div>

                <form method="GET" action="{{ route('publik.berita') }}" class="relative w-full md:w-72">
                    <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="Cari berita atau sumber" class="w-full bg-gray-200/70 dark:bg-[#152420] border border-transparent dark:border-[#284c43] text-gray-800 dark:text-white placeholder-gray-400 rounded-full py-2 pl-4 pr-20 text-xs focus:ring-2 focus:ring-ijo-tua focus:outline-none">
                    <button type="submit" class="absolute right-1 top-1 bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white text-xs font-bold px-4 py-1.5 rounded-full transition-colors cursor-pointer">Cari</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($beritaItems as $item)
                <article class="bg-white dark:bg-[#152420] rounded-3xl overflow-hidden border border-gray-100 dark:border-[#233a34] shadow-xs flex flex-col justify-between hover:shadow-md transition-all">
                    <div>
                        <div class="h-48 bg-[#6A9C95] relative p-4 bg-cover bg-center" style="background-image: url('{{ $imageUrl($item->gambar) }}')">
                            <span class="bg-white dark:bg-[#0f1c19] text-gray-800 dark:text-slate-100 text-[11px] font-bold px-3 py-1 rounded-full shadow-xs border border-transparent dark:border-[#284c43]">Berita</span>
                        </div>
                        <div class="p-6 space-y-2">
                            <p class="text-xs text-gray-400 dark:text-gray-400 font-mono">{{ $item->tanggal?->translatedFormat('d F Y') ?? '-' }}</p>
                            <h3 class="font-bold text-base text-gray-900 dark:text-white leading-snug hover:text-ijo-semitua dark:hover:text-emerald-400 transition-colors">
                                <a href="{{ route('publik.berita.detail', $item->id_berita) }}">{{ $item->judul }}</a>
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-300 leading-relaxed line-clamp-2">
                                {{ \Illuminate\Support\Str::limit(strip_tags($item->isi_berita), 110) }}
                            </p>
                        </div>
                    </div>
                    <div class="px-6 pb-6 pt-2">
                        <a href="{{ route('publik.berita.detail', $item->id_berita) }}" class="text-xs font-bold text-ijo-tua dark:text-emerald-400 hover:text-ijo-semitua dark:hover:text-emerald-300 inline-flex items-center space-x-1">
                            <span>Baca Selengkapnya</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </article>
            @empty
                <div class="lg:col-span-3 md:col-span-2 bg-white dark:bg-[#152420] rounded-2xl p-8 border border-gray-100 dark:border-[#233a34] shadow-xs text-center">
                    <h3 class="font-bold text-gray-900 dark:text-white">Belum ada berita di database</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Data berita akan tampil di sini setelah admin menambahkan berita.</p>
                </div>
            @endforelse
        </div>

        @if (($berita ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator)
            <div class="pt-6">
                {{ $berita->links() }}
            </div>
        @endif
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
