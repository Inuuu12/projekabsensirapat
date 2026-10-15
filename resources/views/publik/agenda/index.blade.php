<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Agenda Kegiatan - RAPID</title>
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
<body class="bg-[#F8F7F4] dark:bg-[#0d1614] font-sans antialiased text-gray-800 dark:text-slate-100 flex flex-col min-h-screen transition-colors duration-200 overflow-x-hidden">
    @include('publik.layout.navbarpublik')

    <main class="flex-grow w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        @php
            $agendaItems = collect($agenda ?? []);
            $agendaGroups = $agendaItems->groupBy(fn ($item) => $item->tanggal?->translatedFormat('l, d F Y') ?? 'Tanpa tanggal');
        @endphp

        <!-- Header Title Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">Semua Agenda Kegiatan</h1>
                <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">Informasi lengkap kegiatan dan agenda seluruh perangkat daerah Kabupaten Bogor</p>
            </div>

            <form method="GET" action="{{ route('publik.agenda') }}" class="relative w-full md:w-72">
                <input type="hidden" name="tab" value="{{ $tab ?? 'semua' }}">
                <input type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="Cari agenda atau lokasi" class="w-full bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] text-gray-800 dark:text-white placeholder-gray-400 rounded-full py-2 pl-4 pr-20 text-xs focus:ring-2 focus:ring-ijo-tua focus:outline-none shadow-2xs">
                <button type="submit" class="absolute right-1 top-1 bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white text-xs font-bold px-4 py-1.5 rounded-full transition-colors cursor-pointer">Cari</button>
            </form>
        </div>

        <!-- Card Container Pembungkus Agenda (Konsisten dengan Card di Landing Page) -->
        <div class="bg-white dark:bg-[#152420] rounded-2xl border border-gray-100 dark:border-[#233a34] shadow-sm p-5 md:p-6 space-y-6">

            <!-- Tab Filter Agenda -->
            <div class="flex items-center gap-2 overflow-x-auto pb-4 border-b border-gray-100 dark:border-[#233a34]">
                <a href="{{ route('publik.agenda', array_filter(['tab' => 'semua', 'keyword' => $keyword])) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-colors shrink-0 {{ ($tab ?? 'semua') === 'semua' ? 'bg-ijo-tua text-white dark:bg-[#107050]' : 'bg-gray-100 dark:bg-[#0f1c19] text-gray-600 dark:text-gray-300 hover:bg-gray-200/80 dark:hover:bg-[#1e342e]' }}">
                    Semua Agenda ({{ $agendaItems->count() }})
                </a>
                <a href="{{ route('publik.agenda', array_filter(['tab' => 'hari-ini', 'keyword' => $keyword])) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-colors shrink-0 {{ ($tab ?? '') === 'hari-ini' ? 'bg-ijo-tua text-white dark:bg-[#107050]' : 'bg-gray-100 dark:bg-[#0f1c19] text-gray-600 dark:text-gray-300 hover:bg-gray-200/80 dark:hover:bg-[#1e342e]' }}">
                    Hari Ini
                </a>
                <a href="{{ route('publik.agenda', array_filter(['tab' => 'mendatang', 'keyword' => $keyword])) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-colors shrink-0 {{ ($tab ?? '') === 'mendatang' ? 'bg-ijo-tua text-white dark:bg-[#107050]' : 'bg-gray-100 dark:bg-[#0f1c19] text-gray-600 dark:text-gray-300 hover:bg-gray-200/80 dark:hover:bg-[#1e342e]' }}">
                    Mendatang
                </a>
                <a href="{{ route('publik.agenda', array_filter(['tab' => 'selesai', 'keyword' => $keyword])) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-colors shrink-0 {{ ($tab ?? '') === 'selesai' ? 'bg-ijo-tua text-white dark:bg-[#107050]' : 'bg-gray-100 dark:bg-[#0f1c19] text-gray-600 dark:text-gray-300 hover:bg-gray-200/80 dark:hover:bg-[#1e342e]' }}">
                    Selesai
                </a>
            </div>

            <!-- List Agenda Berdasarkan Tanggal -->
            <div class="space-y-6">
                @forelse ($agendaGroups as $tanggal => $items)
                    <section class="space-y-3">
                        <h3 class="text-xs font-bold text-gray-800 dark:text-gray-300 uppercase tracking-wide flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-ijo-tua dark:bg-emerald-400"></span>
                            <span>{{ $tanggal }}</span>
                        </h3>

                        @foreach ($items as $item)
                            @php
                                $isBerlangsung = $item->isBerlangsung();
                                $isSelesai = $item->isSelesai();
                            @endphp
                            <div class="rounded-2xl p-4 border flex flex-col md:flex-row md:items-center justify-between gap-4 transition-all duration-300 relative overflow-hidden
                                {{ $isBerlangsung 
                                    ? 'bg-gradient-to-br from-emerald-50/95 via-teal-50/90 to-white dark:from-[#132c25] dark:via-[#16382d] dark:to-[#12241f] border-2 border-emerald-500/90 dark:border-emerald-400/90 shadow-md ring-2 ring-emerald-500/20 dark:ring-emerald-400/30' 
                                    : ($isSelesai 
                                        ? 'bg-gray-100/70 dark:bg-[#0d1715]/70 border-gray-200/80 dark:border-[#1a2b27] opacity-80 hover:opacity-100 shadow-xs' 
                                        : 'bg-[#F8F7F4] dark:bg-[#0f1c19] border-gray-200/70 dark:border-[#233a34] shadow-xs hover:shadow-md hover:-translate-y-0.5 hover:border-gray-300 dark:hover:border-[#284c43]') }}">
                                
                                <div class="flex items-center space-x-4">
                                    <div class="{{ $isBerlangsung ? 'bg-emerald-600 text-white font-bold shadow-xs' : ($isSelesai ? 'bg-gray-200 dark:bg-gray-800 text-gray-500 dark:text-gray-400' : 'bg-ijo-sangatmuda dark:bg-[#132320] text-ijo-tua dark:text-emerald-400 border border-transparent dark:border-[#284c43]') }} rounded-xl px-4 py-3 text-center shrink-0 w-24">
                                        <p class="text-xs font-bold">{{ substr((string) $item->waktu, 0, 5) ?: '-' }}</p>
                                        <p class="text-[10px] opacity-75">WIB</p>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-xs font-bold text-[#35635b] dark:text-emerald-400 flex items-center gap-1">{{ $item->dinas?->nama_dinas ?? 'Dinas Komunikasi dan Informatika' }}</p>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h4 class="font-bold text-sm {{ $isBerlangsung ? 'text-emerald-950 dark:text-white' : ($isSelesai ? 'text-gray-600 dark:text-gray-400' : 'text-gray-900 dark:text-white') }}">{{ $item->nama_agenda }}</h4>
                                            @if (strtolower((string) ($item->kategori_surat ?? 'internal')) === 'internal')
                                                <span class="inline-flex items-center text-[10px] font-bold text-blue-700 dark:text-sky-300 bg-blue-50 dark:bg-sky-950/60 px-2 py-0.5 rounded-md border border-blue-100 dark:border-sky-800/40">Khusus Pegawai</span>
                                            @elseif (strtolower((string) ($item->kategori_surat ?? '')) === 'masuk')
                                                <span class="inline-flex items-center text-[10px] font-bold text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/60 px-2 py-0.5 rounded-md border border-amber-100 dark:border-amber-800/40">Pegawai Ditugaskan</span>
                                            @else
                                                <span class="inline-flex items-center text-[10px] font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-md border border-emerald-100 dark:border-emerald-800/40">Pegawai & Tamu</span>
                                            @endif
                                        </div>
                                        <p class="text-xs {{ $isSelesai ? 'text-gray-400 dark:text-gray-400' : 'text-gray-500 dark:text-gray-300' }}">{{ $item->lokasi_display ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between md:justify-end space-x-4 shrink-0">
                                    <div class="text-right">
                                        @if ($isBerlangsung)
                                            <span class="bg-emerald-500/15 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 border border-emerald-500/30 dark:border-emerald-400/30 font-bold text-[10px] px-2.5 py-1 rounded-lg inline-flex items-center space-x-1.5">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-500 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-600 dark:bg-emerald-400"></span>
                                                </span>
                                                <span>Berlangsung</span>
                                            </span>
                                        @elseif ($isSelesai)
                                            <span class="bg-gray-200 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border border-gray-300/60 dark:border-gray-700 font-medium text-[10px] px-3 py-1 rounded-full inline-block">Selesai</span>
                                        @else
                                            <span class="bg-ijo-sangatmuda dark:bg-[#0f1c19] text-ijo-tua dark:text-emerald-400 border border-transparent dark:border-[#284c43] text-[10px] font-bold px-3 py-1 rounded-full inline-block">{{ $item->status_label }}</span>
                                        @endif

                                        @if (strtolower((string) ($item->kategori_surat ?? '')) !== 'masuk')
                                            <p class="text-[10px] {{ $isSelesai ? 'text-gray-400 dark:text-gray-500' : 'text-gray-400 dark:text-gray-400' }} mt-1">{{ $item->kuota ?? 0 }} Peserta</p>
                                        @endif
                                    </div>
                                    <a href="{{ route('publik.agenda.detail', $item->id_agenda) }}" class="{{ $isBerlangsung ? 'bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-xs' : ($isSelesai ? 'bg-gray-200 dark:bg-[#1a2925] text-gray-600 dark:text-gray-300 hover:bg-gray-300' : 'bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 text-white') }} text-xs font-bold px-4 py-2 rounded-xl transition-colors">
                                        {{ $isBerlangsung ? 'Ikuti ' : 'Detail' }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </section>
                @empty
                    <div class="py-12 text-center text-gray-500 dark:text-gray-400 text-sm">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-gray-100 dark:bg-[#0f1c19] flex items-center justify-center text-gray-400 dark:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white">Belum ada agenda</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Data agenda akan tampil di sini setelah admin menambahkan agenda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    @include('publik.layout.footer')
</body>
</html>
