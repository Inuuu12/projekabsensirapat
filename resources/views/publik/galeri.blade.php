<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto Kegiatan - SIRAPI</title>
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
            $galeriItems = collect($galeri ?? []);
            $imageUrl = function ($path) {
                if (! $path) {
                    return asset('foto/Agendahariini.png');
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

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div class="space-y-3">
                <nav class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-2">
                    <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
                    <span>/</span>
                    <span class="text-gray-800 dark:text-gray-200 font-semibold">Galeri</span>
                </nav>

                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">Galeri Foto Kegiatan</h1>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">Dokumentasi visual kegiatan Diskominfo Kabupaten Bogor dari database</p>
                </div>
            </div>

            <div class="bg-ijo-tua dark:bg-[#107050] text-white text-xs font-bold px-4 py-2 rounded-full self-start md:self-auto shadow-xs border border-transparent dark:border-[#10b981]/30">
                {{ $galeriItems->count() }} Foto
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($galeriItems as $foto)
                <article class="bg-white dark:bg-[#152420] rounded-2xl overflow-hidden border border-gray-100 dark:border-[#233a34] shadow-xs transition-colors">
                    <div class="aspect-[4/3] bg-ijo-sangatmuda dark:bg-[#0f1c19] bg-cover bg-center" style="background-image: url('{{ $imageUrl($foto->file_path ?? $foto->gambar) }}')"></div>
                    <div class="p-4 flex items-center justify-between">
                        <span class="truncate text-xs font-bold text-gray-900 dark:text-white">{{ $foto->agenda?->nama_agenda ?? 'Dokumentasi Kegiatan' }}</span>
                        <span class="ml-3 shrink-0 text-[11px] text-gray-400 dark:text-gray-400 font-mono">{{ optional($foto->agenda?->tanggal ?? $foto->tanggal ?? $foto->created_at)->translatedFormat('d M Y') ?? '-' }}</span>
                    </div>
                </article>
            @empty
                <div class="lg:col-span-3 sm:col-span-2 bg-white dark:bg-[#152420] rounded-2xl p-8 border border-gray-100 dark:border-[#233a34] shadow-xs text-center">
                    <h3 class="font-bold text-gray-900 dark:text-white">Belum ada foto</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Galeri akan tampil setelah admin menambahkan dokumentasi.</p>
                </div>
            @endforelse
        </div>
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
