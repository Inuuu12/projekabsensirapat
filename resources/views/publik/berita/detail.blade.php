<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita - SIRAPI</title>
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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8F7F4] dark:bg-[#0d1614] font-sans antialiased text-gray-800 dark:text-slate-100 flex flex-col min-h-screen transition-colors duration-200">
    @include('publik.layout.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-8 space-y-6">
        @php
            $beritaAktif = $berita ?? null;
            $terkaitItems = collect($beritaTerkait ?? []);
            $imageUrl = function ($path) {
                if (! $path) {
                    return asset('assets/foto/Suratlogo.png');
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

        <nav class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-2 flex-wrap">
            <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
            <span>/</span>
            <a href="{{ route('publik.berita') }}" class="hover:underline">Berita</a>
            <span>/</span>
            <span class="text-gray-800 dark:text-gray-200 font-semibold truncate max-w-xs md:max-w-md">{{ $beritaAktif?->judul ?? 'Detail berita' }}</span>
        </nav>

        <div>
            <a href="{{ route('publik.berita') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-ijo-tua dark:text-emerald-400 hover:text-ijo-semitua transition-colors">
                <span>&larr;</span>
                <span>Kembali ke Berita</span>
            </a>
        </div>

        @if ($beritaAktif)
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <article class="lg:col-span-8 space-y-6">
                    <div class="w-full h-72 md:h-[400px] bg-[#6A9C95] bg-cover bg-center rounded-3xl relative p-6 shadow-xs overflow-hidden flex items-start border border-transparent dark:border-[#233a34]" style="background-image: url('{{ $imageUrl($beritaAktif->gambar) }}')">
                        <span class="bg-white dark:bg-[#0f1c19] text-gray-800 dark:text-slate-100 text-xs font-bold px-4 py-1.5 rounded-full shadow-xs border border-transparent dark:border-[#284c43]">Berita</span>
                    </div>

                    <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400 font-mono">
                        <span>{{ $beritaAktif->tanggal?->translatedFormat('d F Y') ?? '-' }}</span>
                        <span>&bull;</span>
                        <span>Sumber: {{ $beritaAktif->sumber ?? '-' }}</span>
                    </div>

                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
                        {{ $beritaAktif->judul }}
                    </h1>

                    <hr class="border-gray-200 dark:border-[#233a34] my-4">

                    <div class="space-y-4 text-xs md:text-sm text-gray-700 dark:text-gray-200 leading-relaxed">
                        {!! nl2br(e($beritaAktif->isi_berita)) !!}
                    </div>

                    @if (!empty($beritaAktif->url) && !($beritaAktif->is_internal ?? false))
                        <div class="pt-4 border-t border-gray-100 dark:border-[#233a34] flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gray-50 dark:bg-[#0f1c19] p-5 rounded-2xl">
                            <div>
                                <p class="text-xs font-bold text-gray-800 dark:text-white">Baca artikel selengkapnya di portal resmi</p>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Diterbitkan oleh: <span class="font-bold text-ijo-tua dark:text-emerald-400">{{ $beritaAktif->sumber ?? '-' }}</span></p>
                            </div>
                            <a href="{{ $beritaAktif->url }}" target="_blank" rel="noopener noreferrer" class="shrink-0 inline-flex items-center justify-center space-x-2 bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-xs transition">
                                <span>Buka di {{ $beritaAktif->sumber ?? 'Portal Berita' }}</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    @endif
                </article>

                <aside class="lg:col-span-4 space-y-6">
                    <div class="bg-white dark:bg-[#152420] rounded-3xl p-6 border border-gray-100 dark:border-[#233a34] shadow-xs space-y-4">
                        <h3 class="font-bold text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-[#233a34] pb-3">Informasi Artikel</h3>
                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between items-center gap-4">
                                <span class="text-gray-400 dark:text-gray-400 uppercase font-semibold text-[10px] tracking-wider">Tanggal</span>
                                <span class="font-bold text-gray-800 dark:text-gray-200 text-right">{{ $beritaAktif->tanggal?->translatedFormat('d F Y') ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center gap-4">
                                <span class="text-gray-400 dark:text-gray-400 uppercase font-semibold text-[10px] tracking-wider">Sumber</span>
                                <span class="font-bold text-gray-800 dark:text-gray-200 text-right">{{ $beritaAktif->sumber ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#152420] rounded-3xl p-6 border border-gray-100 dark:border-[#233a34] shadow-xs space-y-4">
                        <h3 class="font-bold text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-[#233a34] pb-3">Berita Terkait</h3>

                        <div class="space-y-4">
                            @forelse ($terkaitItems as $item)
                                <div class="flex space-x-3 items-center group">
                                    <div class="w-16 h-16 bg-[#3B7A75] bg-cover bg-center rounded-2xl shrink-0 border border-transparent dark:border-[#284c43]" style="background-image: url('{{ $imageUrl($item->gambar) }}')"></div>
                                    <div class="space-y-1">
                                        <p class="text-[10px] text-gray-400 font-mono">{{ $item->tanggal?->translatedFormat('d M Y') ?? '-' }}</p>
                                        <h4 class="text-xs font-bold text-gray-900 dark:text-white group-hover:text-ijo-semitua dark:group-hover:text-emerald-400 transition-colors line-clamp-2">
                                            <a href="{{ route('publik.berita.detail', $item->id_berita) }}">{{ $item->judul }}</a>
                                        </h4>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500 dark:text-gray-400">Belum ada berita terkait di database.</p>
                            @endforelse
                        </div>

                        <div class="pt-2 text-center">
                            <a href="{{ route('publik.berita') }}" class="text-xs font-bold text-ijo-tua dark:text-emerald-400 hover:text-ijo-semitua dark:hover:text-emerald-300 inline-flex items-center space-x-1">
                                <span>Lihat Semua Berita</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        @else
            <div class="bg-white dark:bg-[#152420] rounded-2xl p-8 border border-gray-100 dark:border-[#233a34] shadow-xs text-center">
                <h1 class="font-bold text-gray-900 dark:text-white">Berita tidak ditemukan</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Tambahkan berita di admin agar detail berita bisa tampil.</p>
            </div>
        @endif
    </main>

    @include('publik.layout.footer')
</body>
</html>
