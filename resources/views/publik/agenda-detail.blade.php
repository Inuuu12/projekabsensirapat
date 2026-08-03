<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Agenda - SIRAPI</title>
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

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-8 space-y-8">
        @php
            $agendaAktif = $agenda ?? null;
            $presensiUrl = $agendaAktif
                ? route('publik.presensi.pilih', ['agenda_id' => $agendaAktif->id_agenda])
                : route('publik.presensi.pilih');
            $lampiranUrl = $agendaAktif?->lampiran
                ? route('publik.agenda.lampiran', $agendaAktif->id_agenda, false)
                : null;
        @endphp

        <div class="space-y-3">
            <nav class="text-xs text-gray-500 flex items-center space-x-2">
                <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
                <span>/</span>
                <a href="{{ route('publik.agenda') }}" class="hover:underline">Agenda</a>
                <span>/</span>
                <span class="text-gray-800 font-semibold truncate">{{ $agendaAktif?->nama_agenda ?? 'Detail agenda' }}</span>
            </nav>

            <a href="{{ route('publik.agenda') }}" class="inline-flex items-center space-x-1 text-xs font-bold text-ijo-tua hover:underline">
                <span>&larr;</span>
                <span>Kembali ke Semua Agenda</span>
            </a>
        </div>

        @if ($agendaAktif)
            <div class="space-y-3 border-b border-gray-200/60 pb-6">
                <div>
                    <span class="bg-ijo-sangatmuda text-ijo-tua text-[10px] font-bold px-3 py-1 rounded-full uppercase inline-block mb-2">
                        {{ $agendaAktif->status_label }}
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight">
                        {{ $agendaAktif->nama_agenda }}
                    </h1>
                </div>

                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600 font-medium pt-1">
                    <span>{{ substr((string) $agendaAktif->waktu, 0, 5) ?: '-' }} WIB</span>
                    <span>{{ $agendaAktif->tanggal?->translatedFormat('l, d F Y') ?? '-' }}</span>
                    <span>{{ $agendaAktif->lokasi ?? '-' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <section class="lg:col-span-7 space-y-8">
                    <div class="space-y-2">
                        <h3 class="text-sm font-bold text-gray-900">Deskripsi Kegiatan</h3>
                        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-xs text-gray-600 leading-relaxed space-y-2">
                            <p><span class="font-bold text-gray-800">Kategori:</span> {{ $agendaAktif->kategori_surat ?? '-' }}</p>
                            <p><span class="font-bold text-gray-800">Asal Surat:</span> {{ $agendaAktif->asal_surat ?? '-' }}</p>
                            <p><span class="font-bold text-gray-800">Ditugaskan:</span> {{ $agendaAktif->ditugaskan ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-sm font-bold text-gray-900">Lampiran</h3>
                        @if ($lampiranUrl)
                            <a href="{{ $lampiranUrl }}" target="_blank" rel="noopener" class="bg-white rounded-2xl p-3 border border-gray-100 shadow-sm flex items-center space-x-3 hover:border-gray-300 transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-oren-muda text-oren-tua font-bold text-[10px] flex items-center justify-center shrink-0 uppercase">FILE</div>
                                <div class="overflow-hidden">
                                    <h5 class="text-xs font-bold text-gray-900 truncate">{{ basename($agendaAktif->lampiran) }}</h5>
                                    <p class="text-[10px] text-gray-400">Buka lampiran agenda</p>
                                </div>
                            </a>
                        @else
                            <p class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-xs text-gray-500">Belum ada lampiran untuk agenda ini.</p>
                        @endif
                    </div>
                </section>

                <aside class="lg:col-span-5 space-y-5">
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                        <h4 class="font-bold text-sm text-gray-900">Informasi Kegiatan</h4>
                        <div class="space-y-3 text-xs divide-y divide-gray-100">
                            <div class="pt-1">
                                <p class="text-[10px] uppercase font-semibold text-gray-400">Waktu</p>
                                <p class="font-bold text-gray-800 mt-0.5">{{ substr((string) $agendaAktif->waktu, 0, 5) ?: '-' }} WIB</p>
                            </div>
                            <div class="pt-3">
                                <p class="text-[10px] uppercase font-semibold text-gray-400">Tanggal</p>
                                <p class="font-bold text-gray-800 mt-0.5">{{ $agendaAktif->tanggal?->translatedFormat('l, d F Y') ?? '-' }}</p>
                            </div>
                            <div class="pt-3">
                                <p class="text-[10px] uppercase font-semibold text-gray-400">Lokasi</p>
                                <p class="font-bold text-gray-800 mt-0.5">{{ $agendaAktif->lokasi ?? '-' }}</p>
                            </div>
                            <div class="pt-3">
                                <p class="text-[10px] uppercase font-semibold text-gray-400">Kuota</p>
                                <p class="font-bold text-gray-800 mt-0.5">{{ $agendaAktif->kuota ?? 0 }} Peserta</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ $presensiUrl }}" class="bg-ijo-tua text-white rounded-3xl p-5 shadow-md flex items-center space-x-4 hover:bg-ijo-semitua transition-colors">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-xl shrink-0">QR</div>
                        <div>
                            <h4 class="font-bold text-sm">Generate QR Presensi</h4>
                            <p class="text-[10px] text-gray-200 mt-0.5">Pilih Pegawai atau Tamu &rarr;</p>
                        </div>
                    </a>

                    <div class="bg-ijo-sangatmuda/60 rounded-3xl p-6 border border-ijo-sangatmuda text-center space-y-2 flex flex-col items-center justify-center min-h-[140px]">
                        <div class="w-8 h-8 rounded-full bg-ijo-tua text-white flex items-center justify-center text-xs">PIN</div>
                        <div>
                            <h5 class="font-bold text-xs text-gray-900">{{ $agendaAktif->lokasi ?? 'Lokasi belum diisi' }}</h5>
                            <p class="text-[10px] text-gray-500">Lokasi Pelaksanaan Kegiatan</p>
                        </div>
                    </div>
                </aside>
            </div>
        @else
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm text-center">
                <h1 class="font-bold text-gray-900">Agenda tidak ditemukan</h1>
                <p class="text-xs text-gray-500 mt-2">Tambahkan agenda di admin agar detail agenda bisa tampil.</p>
            </div>
        @endif
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
