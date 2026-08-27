<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Agenda Kegiatan - SIRAPI</title>
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
            $agendaItems = collect($agenda ?? []);
            $agendaGroups = $agendaItems->groupBy(fn ($item) => $item->tanggal?->translatedFormat('l, d F Y') ?? 'Tanpa tanggal');
        @endphp

        <div class="space-y-4">
            <nav class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-2">
                <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 dark:text-gray-200 font-semibold">Agenda</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">Semua Agenda Kegiatan</h1>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">Informasi lengkap kegiatan dan agenda seluruh perangkat daerah Kabupaten Bogor</p>
                </div>

                <form method="GET" action="{{ route('publik.agenda') }}" class="relative w-full md:w-72">
                    <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="Cari agenda atau lokasi" class="w-full bg-gray-200/70 dark:bg-[#152420] border border-transparent dark:border-[#284c43] text-gray-800 dark:text-white placeholder-gray-400 rounded-full py-2 pl-4 pr-20 text-xs focus:ring-2 focus:ring-ijo-tua focus:outline-none">
                    <button type="submit" class="absolute right-1 top-1 bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white text-xs font-bold px-4 py-1.5 rounded-full transition-colors cursor-pointer">Cari</button>
                </form>
            </div>
        </div>

        <div class="space-y-8">
            @forelse ($agendaGroups as $tanggal => $items)
                <section class="space-y-3">
                    <h3 class="text-xs font-bold text-gray-800 dark:text-gray-300 uppercase tracking-wide">{{ $tanggal }}</h3>

                    @foreach ($items as $item)
                        <div class="bg-white dark:bg-[#152420] rounded-2xl p-4 border border-gray-100 dark:border-[#233a34] shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-gray-200 dark:hover:border-[#284c43] transition-colors">
                            <div class="flex items-center space-x-4">
                                <div class="bg-ijo-sangatmuda dark:bg-[#0f1c19] text-ijo-tua dark:text-emerald-400 border border-transparent dark:border-[#284c43] rounded-xl px-4 py-3 text-center shrink-0 w-24">
                                    <p class="text-xs font-bold">{{ substr((string) $item->waktu, 0, 5) ?: '-' }}</p>
                                    <p class="text-[10px] opacity-75">WIB</p>
                                </div>
                                <div class="space-y-1">
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">{{ $item->nama_agenda }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-300">{{ $item->lokasi_display ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between md:justify-end space-x-4 shrink-0">
                                <div class="text-right">
                                    <span class="bg-ijo-sangatmuda dark:bg-[#0f1c19] text-ijo-tua dark:text-emerald-400 border border-transparent dark:border-[#284c43] text-[10px] font-bold px-3 py-1 rounded-full inline-block">{{ $item->status_label }}</span>
                                    @if (strtolower((string) ($item->kategori_surat ?? '')) !== 'masuk')
                                        <p class="text-[10px] text-gray-400 dark:text-gray-400 mt-1">{{ $item->kuota ?? 0 }} Peserta</p>
                                    @endif
                                </div>
                                <a href="{{ route('publik.agenda.detail', $item->id_agenda) }}" class="bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 text-white text-xs font-bold px-4 py-2 rounded-xl transition-colors">
                                    Detail &rsaquo;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </section>
            @empty
                <div class="bg-white dark:bg-[#152420] rounded-2xl p-8 border border-gray-100 dark:border-[#233a34] shadow-xs text-center">
                    <h3 class="font-bold text-gray-900 dark:text-white">Belum ada agenda</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Data agenda akan tampil di sini setelah admin menambahkan agenda.</p>
                </div>
            @endforelse
        </div>
    </main>

    @include('publik.layout.footer')
</body>
</html>
