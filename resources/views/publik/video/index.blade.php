<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Video - SIRAPI</title>
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
            $agendaItems = collect($agendaTerbaru ?? []);
            $beritaItems = collect($beritaTerbaru ?? []);
        @endphp

        <div class="space-y-3">
            <nav class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-2">
                <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 dark:text-gray-200 font-semibold">Video</span>
            </nav>

            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">Semua Video</h1>
                <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">Publikasi video resmi terkait kegiatan dan informasi dari YouTube</p>
            </div>
        </div>

        <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-8 bg-black rounded-3xl overflow-hidden shadow-md aspect-video border border-transparent dark:border-[#233a34]">
                <iframe
                    class="w-full h-full"
                    src="{{ $youtubeEmbedUrl }}"
                    title="Video YouTube Channel"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                </iframe>
            </div>

            <aside class="lg:col-span-4 bg-white dark:bg-[#152420] rounded-3xl p-6 border border-gray-100 dark:border-[#233a34] shadow-xs space-y-4 transition-colors">
                <h2 class="font-bold text-sm text-gray-900 dark:text-white">Sumber Video</h2>
                <p class="text-xs text-gray-500 dark:text-gray-300 leading-relaxed">Video otomatis diputar langsung dari playlist unggahan resmi kanal YouTube.</p>
                <a href="{{ $youtubeChannelUrl }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 text-white text-xs font-bold px-4 py-2 rounded-full shadow-xs">
                    Buka Kanal YouTube
                </a>
            </aside>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-[#152420] rounded-3xl p-6 border border-gray-100 dark:border-[#233a34] shadow-xs space-y-4 transition-colors">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold text-sm text-gray-900 dark:text-white">Agenda Terbaru</h2>
                    <a href="{{ route('publik.agenda') }}" class="text-xs font-bold text-ijo-tua dark:text-emerald-400 hover:underline">Lihat Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse ($agendaItems as $agenda)
                        <a href="{{ route('publik.agenda.detail', $agenda->id_agenda) }}" class="block rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-4 hover:bg-ijo-sangatmuda dark:hover:bg-[#1b3832] transition-colors">
                            <h3 class="text-xs font-bold text-gray-900 dark:text-white">{{ $agenda->nama_agenda }}</h3>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">{{ $agenda->tanggal?->translatedFormat('d F Y') ?? '-' }} &bull; {{ substr((string) $agenda->waktu, 0, 5) ?: '-' }} WIB</p>
                        </a>
                    @empty
                        <p class="rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-4 text-xs text-gray-500 dark:text-gray-400">Belum ada agenda di database.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-[#152420] rounded-3xl p-6 border border-gray-100 dark:border-[#233a34] shadow-xs space-y-4 transition-colors">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold text-sm text-gray-900 dark:text-white">Berita Terbaru</h2>
                    <a href="{{ route('publik.berita') }}" class="text-xs font-bold text-ijo-tua dark:text-emerald-400 hover:underline">Lihat Semua</a>
                </div>

                <div class="space-y-3">
                    @forelse ($beritaItems as $berita)
                        <a href="{{ route('publik.berita.detail', $berita->id_berita) }}" class="block rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-4 hover:bg-ijo-sangatmuda dark:hover:bg-[#1b3832] transition-colors">
                            <h3 class="text-xs font-bold text-gray-900 dark:text-white">{{ $berita->judul }}</h3>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1">{{ $berita->tanggal?->translatedFormat('d F Y') ?? '-' }} &bull; {{ $berita->sumber ?? '-' }}</p>
                        </a>
                    @empty
                        <p class="rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-4 text-xs text-gray-500 dark:text-gray-400">Belum ada berita di database.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    @include('publik.layout.footer')
</body>
</html>
