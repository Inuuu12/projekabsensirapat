<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto Kegiatan - SIRAPI</title>
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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8F7F4] font-sans antialiased text-gray-800 flex flex-col min-h-screen">
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
                <nav class="text-xs text-gray-500 flex items-center space-x-2">
                    <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
                    <span>/</span>
                    <span class="text-gray-800 font-semibold">Galeri</span>
                </nav>

                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Galeri Foto Kegiatan</h1>
                    <p class="text-xs text-gray-500 mt-1">Dokumentasi visual kegiatan Diskominfo Kabupaten Bogor dari database</p>
                </div>
            </div>

            <div class="bg-ijo-tua text-white text-xs font-bold px-4 py-2 rounded-full self-start md:self-auto shadow-sm">
                {{ $galeriItems->count() }} Foto
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($galeriItems as $foto)
                <article class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                    <div class="aspect-[4/3] bg-ijo-sangatmuda bg-cover bg-center" style="background-image: url('{{ $imageUrl($foto->file_path ?? $foto->gambar) }}')"></div>
                    <div class="p-4 flex items-center justify-between">
                        <span class="truncate text-xs font-bold text-gray-900">{{ $foto->agenda?->nama_agenda ?? 'Dokumentasi Kegiatan' }}</span>
                        <span class="ml-3 shrink-0 text-[11px] text-gray-400 font-mono">{{ optional($foto->agenda?->tanggal ?? $foto->tanggal ?? $foto->created_at)->translatedFormat('d M Y') ?? '-' }}</span>
                    </div>
                </article>
            @empty
                <div class="lg:col-span-3 sm:col-span-2 bg-white rounded-2xl p-8 border border-gray-100 shadow-sm text-center">
                    <h3 class="font-bold text-gray-900">Belum ada foto</h3>
                    <p class="text-xs text-gray-500 mt-2">Galeri akan tampil setelah admin menambahkan dokumentasi.</p>
                </div>
            @endforelse
        </div>
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
