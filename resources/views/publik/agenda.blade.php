<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Agenda Kegiatan - Diskominfo Kabupaten Bogor</title>
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

    <main class="flex-grow container mx-auto px-4 md:px-12 py-8 space-y-8 max-w-7xl">
        @php
            $agendaItems = collect($agenda ?? []);
            $agendaGroups = $agendaItems->groupBy(fn ($item) => $item->tanggal?->translatedFormat('l, d F Y') ?? 'Tanpa tanggal');
        @endphp

        <div class="space-y-4">
            <nav class="text-xs text-gray-500 flex items-center space-x-2">
                <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 font-semibold">Agenda</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Semua Agenda Kegiatan</h1>
                    <p class="text-xs text-gray-500 mt-1">Jadwal kegiatan Diskominfo Kabupaten Bogor dari database</p>
                </div>

                <form method="GET" action="{{ route('publik.agenda') }}" class="relative w-full md:w-72">
                    <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="Cari agenda atau lokasi" class="w-full bg-gray-200/70 border-none rounded-full py-2 pl-4 pr-20 text-xs focus:ring-2 focus:ring-ijo-tua focus:outline-none">
                    <button type="submit" class="absolute right-1 top-1 bg-ijo-tua text-white text-xs font-bold px-4 py-1.5 rounded-full">Cari</button>
                </form>
            </div>
        </div>

        <div class="space-y-8">
            @forelse ($agendaGroups as $tanggal => $items)
                <section class="space-y-3">
                    <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wide">{{ $tanggal }}</h3>

                    @foreach ($items as $item)
                        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-gray-200 transition-colors">
                            <div class="flex items-center space-x-4">
                                <div class="bg-ijo-sangatmuda text-ijo-tua rounded-xl px-4 py-3 text-center shrink-0 w-24">
                                    <p class="text-xs font-bold">{{ substr((string) $item->waktu, 0, 5) ?: '-' }}</p>
                                    <p class="text-[10px] opacity-75">WIB</p>
                                </div>
                                <div class="space-y-1">
                                    <h4 class="font-bold text-sm text-gray-900">{{ $item->nama_agenda }}</h4>
                                    <p class="text-xs text-gray-500">{{ $item->lokasi ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between md:justify-end space-x-4 shrink-0">
                                <div class="text-right">
                                    <span class="bg-ijo-sangatmuda text-ijo-tua text-[10px] font-bold px-3 py-1 rounded-full inline-block">{{ $item->statusAgenda?->nama_status ?? 'Terjadwal' }}</span>
                                    <p class="text-[10px] text-gray-400 mt-1">{{ $item->kuota ?? 0 }} Peserta</p>
                                </div>
                                <a href="{{ route('publik.agenda.detail', $item->id_agenda) }}" class="bg-ijo-tua hover:bg-ijo-semitua text-white text-xs font-bold px-4 py-2 rounded-xl transition-colors">
                                    Detail &rsaquo;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </section>
            @empty
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm text-center">
                    <h3 class="font-bold text-gray-900">Belum ada agenda di database</h3>
                    <p class="text-xs text-gray-500 mt-2">Data agenda akan tampil di sini setelah admin menambahkan agenda.</p>
                </div>
            @endforelse
        </div>
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
