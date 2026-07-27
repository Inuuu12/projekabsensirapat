<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Video - SIRAPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ijo-tua': '#14524E',
                        'ijo-semitua': '#1F7A6F',
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
            $agendaItems = collect($agendaTerbaru ?? []);
            $beritaItems = collect($beritaTerbaru ?? []);
        @endphp

        <div class="space-y-3">
            <nav class="text-xs text-gray-500 flex items-center space-x-2">
                <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 font-semibold">Video</span>
            </nav>

            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Semua Video</h1>
                <p class="text-xs text-gray-500 mt-1">Publikasi video resmi terkait Diskominfo dan Kabupaten Bogor dari YouTube</p>
            </div>
        </div>

        <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-8 bg-black rounded-3xl overflow-hidden shadow-md aspect-video">
                <iframe
                    class="w-full h-full"
                    src="{{ $youtubeEmbedUrl }}"
                    title="Video Diskominfo Kabupaten Bogor"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                </iframe>
            </div>

            <aside class="lg:col-span-4 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                <h2 class="font-bold text-sm text-gray-900">Sumber Video</h2>
                <p class="text-xs text-gray-500 leading-relaxed">Video ditampilkan dari kanal YouTube resmi Kabupaten Bogor/Diskominfo. Tidak ada tabel video di database project ini, jadi konten video tidak dibuat sebagai dummy lokal.</p>
                <a href="{{ $youtubeChannelUrl }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center bg-ijo-tua hover:bg-ijo-semitua text-white text-xs font-bold px-4 py-2 rounded-full">
                    Buka Kanal YouTube
                </a>
            </aside>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold text-sm text-gray-900">Agenda Terbaru</h2>
                    <a href="{{ route('publik.agenda') }}" class="text-xs font-bold text-ijo-tua hover:underline">Lihat Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse ($agendaItems as $agenda)
                        <a href="{{ route('publik.agenda.detail', $agenda->id_agenda) }}" class="block rounded-2xl bg-gray-50 p-4 hover:bg-ijo-sangatmuda transition-colors">
                            <h3 class="text-xs font-bold text-gray-900">{{ $agenda->nama_agenda }}</h3>
                            <p class="text-[11px] text-gray-500 mt-1">{{ $agenda->tanggal?->translatedFormat('d F Y') ?? '-' }} &bull; {{ substr((string) $agenda->waktu, 0, 5) ?: '-' }} WIB</p>
                        </a>
                    @empty
                        <p class="rounded-2xl bg-gray-50 p-4 text-xs text-gray-500">Belum ada agenda di database.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold text-sm text-gray-900">Berita Terbaru</h2>
                    <a href="{{ route('publik.berita') }}" class="text-xs font-bold text-ijo-tua hover:underline">Lihat Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse ($beritaItems as $berita)
                        <a href="{{ route('publik.berita.detail', $berita->id_berita) }}" class="block rounded-2xl bg-gray-50 p-4 hover:bg-ijo-sangatmuda transition-colors">
                            <h3 class="text-xs font-bold text-gray-900">{{ $berita->judul }}</h3>
                            <p class="text-[11px] text-gray-500 mt-1">{{ $berita->tanggal?->translatedFormat('d F Y') ?? '-' }} &bull; {{ $berita->sumber ?? '-' }}</p>
                        </a>
                    @empty
                        <p class="rounded-2xl bg-gray-50 p-4 text-xs text-gray-500">Belum ada berita di database.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
