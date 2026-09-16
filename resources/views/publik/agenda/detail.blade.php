<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Agenda - RAPID</title>
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
    @php
        $agendaAktif = $agenda ?? null;
        $lampiranFileUrl = $agendaAktif?->lampiran
            ? route('publik.agenda.lampiran.file', $agendaAktif->id_agenda)
            : null;
        $lampiranUrl = $lampiranFileUrl;
        $lampiranExtension = strtolower(pathinfo((string) $agendaAktif?->lampiran, PATHINFO_EXTENSION));
        $isImageLampiran = in_array($lampiranExtension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true);
        $isPdfLampiran = $lampiranExtension === 'pdf';
        $lampiranPreviewable = $isImageLampiran || $isPdfLampiran;
        $qrPayloadPegawai = $qrCode?->qr_codepath ?: ($agendaAktif ? route('publik.presensi.pegawai', ['agenda_id' => $agendaAktif->id_agenda]) : null);
        $qrImageUrlPegawai = $qrPayloadPegawai ? 'https://api.qrserver.com/v1/create-qr-code/?size=280x280&data=' . urlencode($qrPayloadPegawai) : null;
        $qrImageUrl = $qrImageUrlPegawai;

        $qrPayloadTamu = $agendaAktif ? route('publik.presensi.tamu', ['agenda_id' => $agendaAktif->id_agenda]) : null;
        $qrImageUrlTamu = $qrPayloadTamu ? 'https://api.qrserver.com/v1/create-qr-code/?size=280x280&data=' . urlencode($qrPayloadTamu) : null;

        $kategoriSurat = strtolower((string) ($agendaAktif?->kategori_surat ?? 'internal'));
        $isSuratInternal = $kategoriSurat === 'internal';
        $isSuratMasuk = $kategoriSurat === 'masuk';
        $isSuratKeluar = $kategoriSurat === 'keluar';
        $allowsTamu = $isSuratKeluar;
    @endphp

    @include('publik.layout.navbarpublik')

    <main class="flex-grow w-full {{ $isSuratKeluar ? 'max-w-7xl' : 'max-w-6xl' }} mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <div class="space-y-3">

            <a href="{{ route('publik.agenda') }}" class="inline-flex items-center space-x-1 text-xs font-bold text-ijo-tua dark:text-emerald-400 hover:underline">
                <span>Kembali ke Semua Agenda</span>
            </a>
        </div>

        @if ($agendaAktif)
            <div class="space-y-3 border-b border-gray-200/60 dark:border-[#233a34] pb-6">
                <div>
                    <span class="bg-ijo-sangatmuda dark:bg-[#0f1c19] text-ijo-tua dark:text-emerald-400 border border-transparent dark:border-[#284c43] text-[10px] font-bold px-3 py-1 rounded-full uppercase inline-block mb-2">
                        {{ $agendaAktif->status_label }}
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
                        {{ $agendaAktif->nama_agenda }}
                    </h1>
                </div>

                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600 dark:text-gray-300 font-medium pt-1">
                    <span>{{ substr((string) $agendaAktif->waktu, 0, 5) ?: '-' }} WIB</span>
                    <span>{{ $agendaAktif->tanggal?->translatedFormat('l, d F Y') ?? '-' }}</span>
                    <span>{{ $agendaAktif->lokasi_display ?? '-' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <section class="{{ $isSuratKeluar ? 'lg:col-span-6' : 'lg:col-span-7' }} space-y-8">
                    <div class="space-y-2">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Deskripsi Kegiatan</h3>
                        <div class="bg-white dark:bg-[#152420] rounded-2xl p-5 border border-gray-100 dark:border-[#233a34] shadow-xs text-xs text-gray-600 dark:text-gray-300 leading-relaxed space-y-2.5">
                            <div class="flex items-center justify-between gap-2">
                                <p><span class="font-bold text-gray-800 dark:text-white">Kategori Surat:</span> {{ ucfirst($agendaAktif->kategori_surat ?? 'Internal') }}</p>
                                @if ($isSuratInternal)
                                    <span class="bg-blue-50 dark:bg-sky-950/60 text-blue-700 dark:text-sky-300 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full border border-blue-100 dark:border-sky-800/40">Khusus Pegawai</span>
                                @elseif ($isSuratMasuk)
                                    <span class="bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full border border-amber-100 dark:border-amber-800/40">Pegawai Ditugaskan</span>
                                @else
                                    <span class="bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full border border-emerald-100 dark:border-emerald-800/40">Pegawai & Tamu</span>
                                @endif
                            </div>
                            <p><span class="font-bold text-gray-800 dark:text-white">Dinas Penyelenggara:</span> <span class="font-extrabold text-[#35635b] dark:text-emerald-400">{{ $agendaAktif->dinas?->nama_dinas ?? 'Dinas Komunikasi dan Informatika' }}</span></p>
                            <p><span class="font-bold text-gray-800 dark:text-white">Asal Surat / Pengaju:</span> {{ $agendaAktif->asal_surat ?? '-' }}</p>
                            <p><span class="font-bold text-gray-800 dark:text-white">Ditugaskan:</span> {{ $agendaAktif->ditugaskan ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-4 h-4 text-ijo-tua dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span>Surat Undangan / Lampiran</span>
                            </h3>
                            @if ($lampiranUrl)
                                <span class="bg-[#35635b]/10 dark:bg-emerald-400/10 text-[#35635b] dark:text-emerald-400 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">
                                    {{ $lampiranExtension ? strtoupper($lampiranExtension) : 'BERKAS' }}
                                </span>
                            @endif
                        </div>

                        @if ($lampiranUrl)
                            @if ($isImageLampiran)
                                <!-- PREVIEW GAMBAR INTERAKTIF DENGAN ZOOM IN / ZOOM OUT & PAN -->
                                <div class="bg-white dark:bg-[#152420] rounded-2xl border border-gray-100 dark:border-[#233a34] shadow-xs overflow-hidden transition-colors">
                                    <!-- Toolbar Atas Gambar -->
                                    <div class="flex flex-wrap items-center justify-between gap-2.5 px-4 py-3 bg-gray-50/90 dark:bg-[#0f1c19] border-b border-gray-100 dark:border-[#233a34]">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 font-extrabold text-[10px] flex items-center justify-center shrink-0 border border-emerald-200/60 dark:border-emerald-800/40 uppercase">
                                                {{ $lampiranExtension ?: 'IMG' }}
                                            </div>
                                            <div class="min-w-0">
                                                <h4 class="text-xs font-bold text-gray-900 dark:text-white truncate max-w-[180px] sm:max-w-xs" title="{{ basename($agendaAktif->lampiran) }}">
                                                    {{ basename($agendaAktif->lampiran) }}
                                                </h4>
                                                <p class="text-[10px] text-gray-400 dark:text-gray-400 leading-none mt-0.5">Lampiran Foto/Gambar • Bebas Zoom & Geser</p>
                                            </div>
                                        </div>

                                        <!-- Tombol Kontrol Zoom & Aksi -->
                                        <div class="flex items-center gap-1 sm:gap-1.5 shrink-0">
                                            <!-- Zoom Out -->
                                            <button type="button" id="btn-inline-zoom-out" onclick="inlineZoomLampiran(-0.25)" class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg bg-white dark:bg-[#1b3832] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-[#23473f] text-gray-700 dark:text-gray-200 transition shadow-2xs cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed" title="Perkecil (Zoom Out)">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M20 12H4"></path></svg>
                                            </button>

                                            <!-- Reset Scale Indicator -->
                                            <button type="button" onclick="inlineResetLampiran()" class="flex h-7 px-2 sm:h-8 sm:px-2.5 items-center justify-center rounded-lg bg-white dark:bg-[#1b3832] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-[#23473f] text-gray-700 dark:text-gray-200 text-[10px] sm:text-xs font-bold transition shadow-2xs cursor-pointer" title="Reset Skala Zoom (100%)">
                                                <span id="inline-lampiran-scale">100%</span>
                                            </button>

                                            <!-- Zoom In -->
                                            <button type="button" id="btn-inline-zoom-in" onclick="inlineZoomLampiran(0.25)" class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg bg-white dark:bg-[#1b3832] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-[#23473f] text-gray-700 dark:text-gray-200 transition shadow-2xs cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed" title="Perbesar (Zoom In)">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"></path></svg>
                                            </button>

                                            <div class="h-4 w-px bg-gray-200 dark:bg-[#284c43] mx-0.5"></div>

                                            <!-- Layar Penuh (Modal Zoom) -->
                                            <button type="button" onclick="openImagePreview('{{ $lampiranFileUrl }}', 'Surat Undangan - {{ addslashes($agendaAktif->nama_agenda) }}', '{{ $agendaAktif->tanggal?->translatedFormat('l, d F Y') ?? '-' }}')" class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg bg-[#35635b]/10 dark:bg-emerald-400/10 hover:bg-[#35635b]/20 dark:hover:bg-emerald-400/20 text-[#35635b] dark:text-emerald-400 border border-[#35635b]/20 dark:border-emerald-400/20 transition shadow-2xs cursor-pointer" title="Perbesar Layar Penuh">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                            </button>

                                            <!-- Unduh -->
                                            <a href="{{ $lampiranFileUrl }}" download class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg bg-gray-100 dark:bg-[#1b3832] hover:bg-gray-200 dark:hover:bg-[#23473f] text-gray-700 dark:text-gray-200 transition shadow-2xs" title="Unduh Berkas Lampiran">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3M7 10l5 5m0 0l5-5m-5 5V3"></path></svg>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Viewport Display Gambar Interaktif -->
                                    <div id="inline-lampiran-viewport" class="relative overflow-hidden min-h-[320px] sm:min-h-[420px] max-h-[540px] bg-[#f5f8f7] dark:bg-[#091210] flex items-center justify-center p-3 sm:p-4 select-none touch-none cursor-default">
                                        <img id="inline-lampiran-img" 
                                             src="{{ $lampiranFileUrl }}" 
                                             alt="Lampiran {{ $agendaAktif->nama_agenda }}" 
                                             ondragstart="return false;"
                                             class="max-h-[300px] sm:max-h-[400px] max-w-full rounded-xl object-contain shadow-xs origin-center will-change-transform select-none pointer-events-auto cursor-zoom-in">
                                    </div>

                                    <!-- Footer Tips & Quick Info -->
                                    <div class="px-4 py-2.5 bg-gray-50/70 dark:bg-[#0d1c18] border-t border-gray-100 dark:border-[#233a34] flex flex-wrap items-center justify-between gap-2 text-[11px] text-gray-500 dark:text-gray-400 select-none">
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-[#35635b] dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="hidden sm:inline">Tips: Klik tombol zoom (+/-) atau scroll mouse. Saat diperbesar, geser gambar untuk melihat detail.</span>
                                            <span class="sm:hidden">Tips: Zoom dengan (+/-) atau geser foto saat diperbesar.</span>
                                        </span>
                                        <button type="button" onclick="openImagePreview('{{ $lampiranFileUrl }}', 'Surat Undangan - {{ addslashes($agendaAktif->nama_agenda) }}', '{{ $agendaAktif->tanggal?->translatedFormat('l, d F Y') ?? '-' }}')" class="font-bold text-[#35635b] dark:text-emerald-400 hover:underline cursor-pointer">
                                            Buka Layar Penuh ↗
                                        </button>
                                    </div>
                                </div>
                            @elseif ($isPdfLampiran)
                                <!-- PREVIEW PDF INTERAKTIF TERTANAM LANGSUNG DI HALAMAN -->
                                <div class="bg-white dark:bg-[#152420] rounded-2xl border border-gray-100 dark:border-[#233a34] shadow-xs overflow-hidden transition-colors">
                                    <!-- Toolbar Atas PDF -->
                                    <div class="flex items-center justify-between gap-3 px-4 py-3 bg-gray-50/90 dark:bg-[#0f1c19] border-b border-gray-100 dark:border-[#233a34]">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <div class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-950/60 text-red-600 dark:text-red-300 font-extrabold text-[10px] flex items-center justify-center shrink-0 border border-red-200/60 dark:border-red-800/40 uppercase">
                                                PDF
                                            </div>
                                            <div class="min-w-0">
                                                <h4 class="text-xs font-bold text-gray-900 dark:text-white truncate max-w-[200px] sm:max-w-xs" title="{{ basename($agendaAktif->lampiran) }}">
                                                    {{ basename($agendaAktif->lampiran) }}
                                                </h4>
                                                <p class="text-[10px] text-gray-400 dark:text-gray-400 leading-none mt-0.5">Dokumen Surat Undangan Resmi</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-1.5 shrink-0">
                                            <!-- Tab Baru -->
                                            <a href="{{ $lampiranFileUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 rounded-lg bg-white dark:bg-[#1b3832] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-[#23473f] px-2.5 py-1.5 text-xs font-bold text-gray-700 dark:text-gray-200 transition shadow-2xs" title="Buka di tab baru">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                <span class="hidden sm:inline">Tab Baru</span>
                                            </a>
                                            <!-- Unduh -->
                                            <a href="{{ $lampiranFileUrl }}" download class="inline-flex items-center gap-1 rounded-lg bg-ijo-tua dark:bg-[#107050] hover:bg-ijo-semitua dark:hover:bg-[#0c5940] px-2.5 py-1.5 text-xs font-bold text-white transition shadow-2xs" title="Unduh file PDF">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3M7 10l5 5m0 0l5-5m-5 5V3"></path></svg>
                                                <span class="hidden sm:inline">Unduh</span>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Embed PDF Viewport -->
                                    <div class="w-full bg-gray-100 dark:bg-[#091210] p-1 sm:p-2">
                                        <iframe src="{{ $lampiranFileUrl }}#toolbar=1&navpanes=0" title="Lampiran {{ $agendaAktif->nama_agenda }}" class="h-[480px] sm:h-[580px] w-full rounded-xl border border-gray-200 dark:border-[#233a34] bg-white dark:bg-[#152420]"></iframe>
                                    </div>

                                    <!-- Footer Info PDF -->
                                    <div class="px-4 py-2 bg-gray-50/70 dark:bg-[#0d1c18] border-t border-gray-100 dark:border-[#233a34] flex items-center justify-between text-[11px] text-gray-500 dark:text-gray-400 select-none">
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-[#35635b] dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span>Gunakan tombol kontrol zoom (+/-) pada dokumen PDF di atas untuk memperbesar isi surat.</span>
                                        </span>
                                    </div>
                                </div>
                            @else
                                <!-- DOKUMEN LAIN (WORD/EXCEL/DLL) -->
                                <div class="bg-white dark:bg-[#152420] rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-[#233a34] shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex items-center space-x-3.5 min-w-0">
                                        <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-200 font-bold text-[11px] flex items-center justify-center shrink-0 border border-amber-200 dark:border-amber-700/40 uppercase">
                                            {{ strtoupper($lampiranExtension ?: 'BERKAS') }}
                                        </div>
                                        <div class="min-w-0">
                                            <h5 class="text-xs font-bold text-gray-900 dark:text-white truncate">{{ basename($agendaAktif->lampiran) }}</h5>
                                            <p class="text-[10px] text-gray-400 dark:text-gray-400 mt-0.5">Berkas lampiran surat undangan agenda</p>
                                        </div>
                                    </div>
                                    <a href="{{ $lampiranFileUrl }}" download class="shrink-0 inline-flex items-center justify-center space-x-1.5 bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-xs transition">
                                        <span>Unduh Berkas</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3M7 10l5 5m0 0l5-5m-5 5V3"></path></svg>
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="bg-white dark:bg-[#152420] rounded-2xl p-5 border border-gray-100 dark:border-[#233a34] shadow-xs text-xs text-gray-500 dark:text-gray-400 text-center flex flex-col items-center justify-center py-8">
                                <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="font-medium">Belum ada surat undangan / lampiran untuk agenda ini.</p>
                            </div>
                        @endif
                    </div>

                    @if ($notulen)
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-ijo-tua dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <span>Notulen Rapat</span>
                                </h3>
                                <span class="bg-blue-50 dark:bg-sky-950/60 text-blue-700 dark:text-sky-300 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-blue-100 dark:border-sky-800/40 uppercase">Dokumen Resmi</span>
                            </div>
                            <div class="bg-white dark:bg-[#152420] rounded-2xl p-4 border border-gray-100 dark:border-[#233a34] shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="flex items-center space-x-3.5 min-w-0">
                                    <div class="w-11 h-11 rounded-xl bg-red-50 dark:bg-red-950/50 text-red-600 dark:text-red-300 font-bold text-[11px] flex items-center justify-center shrink-0 border border-red-100 dark:border-red-800/40 uppercase">
                                        {{ strtoupper(pathinfo($notulen->file_path, PATHINFO_EXTENSION) ?: 'PDF') }}
                                    </div>
                                    <div class="min-w-0">
                                        <h5 class="text-xs font-bold text-gray-900 dark:text-white truncate">{{ $notulen->nama_file }}</h5>
                                        <p class="text-[10px] text-gray-400 mt-0.5">Dokumen hasil notulensi kegiatan rapat</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $notulen->file_path) }}" target="_blank" rel="noopener" class="shrink-0 inline-flex items-center justify-center space-x-1.5 bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-xs transition">
                                    <span>Buka Notulen</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if ($dokumentasi && $dokumentasi->isNotEmpty())
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-ijo-tua dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Dokumentasi Kegiatan</span>
                                </h3>
                                <span class="text-[11px] font-semibold text-gray-400">{{ $dokumentasi->count() }} Foto</span>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach ($dokumentasi as $item)
                                    <div class="group relative rounded-2xl overflow-hidden border border-gray-100 dark:border-[#233a34] bg-gray-100 dark:bg-[#152420] shadow-xs aspect-[4/3] cursor-pointer" onclick="openImagePreview('{{ asset('storage/' . $item->file_path) }}', 'Dokumentasi - {{ addslashes($item->nama_file) }}', '{{ $agendaAktif->tanggal?->translatedFormat('l, d F Y') ?? '-' }}')">
                                        <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->nama_file }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-2.5">
                                            <p class="text-[10px] font-bold text-white truncate">{{ $item->nama_file }}</p>
                                            <span class="text-[9px] text-white/80 font-medium">Klik untuk memperbesar</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </section>

                <aside class="{{ $isSuratKeluar ? 'lg:col-span-6' : 'lg:col-span-5' }} space-y-5">
                    <div class="bg-white dark:bg-[#152420] rounded-xl p-6 border border-gray-100 dark:border-[#233a34] shadow-lg hover:shadow-xl transition-all duration-300 space-y-4">
                        <h4 class="font-bold text-sm text-gray-900 dark:text-white">Informasi Kegiatan</h4>
                        <div class="space-y-3 text-xs divide-y divide-gray-100 dark:divide-[#233a34]">
                            <div class="pt-1">
                                <p class="text-[10px] uppercase font-semibold text-gray-400">Waktu</p>
                                <p class="font-bold text-gray-800 dark:text-gray-200 mt-0.5">{{ substr((string) $agendaAktif->waktu, 0, 5) ?: '-' }} WIB</p>
                            </div>
                            <div class="pt-3">
                                <p class="text-[10px] uppercase font-semibold text-gray-400">Tanggal</p>
                                <p class="font-bold text-gray-800 dark:text-gray-200 mt-0.5">{{ $agendaAktif->tanggal?->translatedFormat('l, d F Y') ?? '-' }}</p>
                            </div>
                            <div class="pt-3">
                                <p class="text-[10px] uppercase font-semibold text-gray-400">Lokasi</p>
                                <p class="font-bold text-gray-800 dark:text-gray-200 mt-0.5">{{ $agendaAktif->lokasi_display ?? '-' }}</p>
                            </div>
                            @if (!empty($agendaAktif->ditugaskan))
                                <div class="pt-3">
                                    <p class="text-[10px] uppercase font-semibold text-gray-400">Ditugaskan Kepada</p>
                                    <p class="font-bold text-[#35635b] dark:text-emerald-400 mt-0.5">{{ $agendaAktif->ditugaskan }}</p>
                                </div>
                            @endif
                            @if (strtolower((string) ($agendaAktif->kategori_surat ?? '')) !== 'masuk')
                                <div class="pt-3">
                                    <p class="text-[10px] uppercase font-semibold text-gray-400">Kuota</p>
                                    <p class="font-bold text-gray-800 dark:text-gray-200 mt-0.5 flex items-center justify-between">
                                        <span>{{ $agendaAktif->kuota ?? 0 }} Peserta</span>
                                        @if ($agendaAktif->isKuotaPenuh())
                                            <span class="text-[10px] font-bold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-950/40 px-2.5 py-0.5 rounded-full border border-red-200 dark:border-red-800">Penuh</span>
                                        @endif
                                    </p>
                                </div>
                            @elseif (!empty($agendaAktif->ditugaskan))
                                <div class="pt-3">
                                    <p class="text-[10px] uppercase font-semibold text-gray-400">Ditugaskan Kepada</p>
                                    <p class="font-bold text-gray-800 dark:text-gray-200 mt-0.5">{{ $agendaAktif->ditugaskan }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div id="presensi-section" class="bg-white dark:bg-[#152420] rounded-xl p-6 border border-gray-100 dark:border-[#233a34] shadow-lg hover:shadow-xl transition-all duration-300 space-y-5">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <h4 class="font-bold text-sm text-gray-900 dark:text-white">Presensi Agenda</h4>
                                <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">
                                    @if ($isSuratKeluar)
                                        Scan kode QR kehadiran (Pegawai / Tamu)
                                    @elseif ($isSuratMasuk)
                                        Presensi pegawai yang ditugaskan
                                    @else
                                        Presensi khusus pegawai internal
                                    @endif
                                </p>
                            </div>
                            <span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $agendaAktif->status_label === 'Selesai' ? 'bg-amber-100 dark:bg-amber-950/50 text-amber-800 dark:text-amber-200' : ($agendaAktif->isKuotaPenuh() ? 'bg-red-100 dark:bg-red-950/50 text-red-800 dark:text-red-200' : ($agendaAktif->status_label === 'Mendatang' ? 'bg-blue-100 dark:bg-blue-950/60 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-800/50' : ($agendaAktif->status_qr === 'aktif' && $qrImageUrl ? 'bg-ijo-sangatmuda dark:bg-[#0f1c19] text-ijo-tua dark:text-emerald-400 border border-transparent dark:border-[#284c43]' : 'bg-gray-100 dark:bg-white/10 text-gray-500 dark:text-gray-400'))) }}">
                                {{ $agendaAktif->status_label === 'Selesai' ? 'Selesai' : ($agendaAktif->isKuotaPenuh() ? 'Kuota Penuh' : ($agendaAktif->status_label === 'Mendatang' ? '(Mendatang)' : ($agendaAktif->status_qr === 'aktif' && $qrImageUrl ? 'Aktif' : 'Belum aktif'))) }}
                            </span>
                        </div>

                        @if (session('success'))
                            <div class="rounded-2xl bg-ijo-sangatmuda dark:bg-[#0f1c19] border border-ijo-muda/40 dark:border-[#284c43] text-ijo-tua dark:text-emerald-400 px-4 py-3 text-xs font-bold flex items-center space-x-2">
                                <svg class="w-4 h-4 text-ijo-tua dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 text-xs space-y-1">
                                <p class="font-bold">Terjadi kesalahan:</p>
                                <ul class="list-disc list-inside space-y-0.5 text-[11px]">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($agendaAktif->status_label === 'Selesai')
                            <div class="rounded-2xl border border-amber-200 dark:border-amber-800/60 bg-amber-50 dark:bg-amber-950/40 p-5 text-center space-y-2">
                                <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/60 text-amber-600 dark:text-amber-300">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 11 0 0118 0z" /></svg>
                                </div>
                                <h5 class="text-xs font-extrabold text-amber-900 dark:text-amber-200">Agenda Rapat Telah Selesai</h5>
                                <p class="text-[11px] font-medium text-amber-700 dark:text-amber-300 leading-tight">Presensi tidak lagi dapat dilakukan karena waktu pelaksanaan agenda rapat telah berakhir.</p>
                            </div>
                        @elseif ($agendaAktif->status_label === 'Mendatang')
                            <div class="rounded-2xl border border-blue-200/80 dark:border-blue-800/50 bg-blue-50/70 dark:bg-blue-950/30 p-6 text-center space-y-4">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-300 shadow-xs border border-blue-200/50 dark:border-blue-800/40">
                                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                </div>
                                <div class="space-y-1">
                                    <h5 class="text-sm font-extrabold text-blue-950 dark:text-blue-200">Presensi Belum Dibuka (Terkunci)</h5>
                                    <p class="text-xs font-medium text-blue-700 dark:text-blue-300 leading-relaxed max-w-xs mx-auto">
                                        Presensi akan terbuka otomatis saat rapat dimulai pada pukul <span class="font-extrabold underline decoration-blue-400">{{ substr((string) $agendaAktif->waktu, 0, 5) }} WIB</span> ({{ $agendaAktif->tanggal?->translatedFormat('d F Y') }}).
                                    </p>
                                </div>
                                <div class="pt-1">
                                    <div class="inline-flex w-full items-center justify-center rounded-xl bg-gray-200/80 dark:bg-[#10201c] border border-gray-300/60 dark:border-[#233a34] text-gray-500 dark:text-gray-400 px-4 py-2.5 text-xs font-bold cursor-not-allowed select-none">
                                        <svg class="w-4 h-4 mr-1.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                        <span>Presensi Terkunci</span>
                                    </div>
                                </div>
                            </div>
                        @elseif ($agendaAktif->isKuotaPenuh())
                            <div class="rounded-2xl border border-red-200 dark:border-red-800/60 bg-red-50 dark:bg-red-950/40 p-5 text-center space-y-2">
                                <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/60 text-red-600 dark:text-red-300">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                </div>
                                <h5 class="text-xs font-extrabold text-red-900 dark:text-red-200">Kuota Presensi Penuh</h5>
                                <p class="text-[11px] font-medium text-red-700 dark:text-red-300 leading-tight">Presensi untuk agenda ini telah ditutup karena kuota maksimal peserta telah terpenuhi.</p>
                            </div>
                        @else
                            @if ($isSuratKeluar)
                                <!-- Dual QR Code Bersebelahan (Pegawai & Tamu) -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <!-- QR Absen Pegawai -->
                                    <div class="bg-gray-50/80 dark:bg-[#0f1c19] rounded-2xl p-3 border border-gray-100 dark:border-[#233a34] text-center flex flex-col justify-between space-y-3">
                                        <div class="space-y-0.5">
                                            <p class="text-[11px] font-extrabold text-gray-800 dark:text-gray-100">QR Absen Pegawai</p>
                                            <p class="text-[10px] text-gray-400">Scan untuk presensi pegawai</p>
                                        </div>

                                        @if ($agendaAktif->status_qr === 'aktif' && $qrImageUrlPegawai)
                                            <div class="rounded-xl border border-gray-100 dark:border-[#233a34] bg-white p-2.5 shadow-xs">
                                                <img src="{{ $qrImageUrlPegawai }}" alt="QR Presensi Pegawai {{ $agendaAktif->nama_agenda }}" class="mx-auto h-36 w-36 sm:h-40 sm:w-40 rounded-lg object-contain">
                                            </div>
                                        @else
                                            <div class="rounded-xl border border-dashed border-gray-200 dark:border-[#233a34] bg-white dark:bg-[#152420] p-4 text-center my-auto">
                                                <p class="text-[11px] font-semibold text-gray-500 dark:text-gray-400">QR pegawai belum diaktifkan.</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- QR Absen Tamu -->
                                    <div class="bg-gray-50/80 dark:bg-[#0f1c19] rounded-2xl p-3 border border-gray-100 dark:border-[#233a34] text-center flex flex-col justify-between space-y-3">
                                        <div class="space-y-0.5">
                                            <p class="text-[11px] font-extrabold text-gray-800 dark:text-gray-100">QR Absen Tamu</p>
                                            <p class="text-[10px] text-gray-400">Scan untuk presensi tamu</p>
                                        </div>

                                        @if ($agendaAktif->status_qr === 'aktif' && $qrImageUrlTamu)
                                            <div class="rounded-xl border border-gray-100 dark:border-[#233a34] bg-white p-2.5 shadow-xs">
                                                <img src="{{ $qrImageUrlTamu }}" alt="QR Presensi Tamu {{ $agendaAktif->nama_agenda }}" class="mx-auto h-36 w-36 sm:h-40 sm:w-40 rounded-lg object-contain">
                                            </div>
                                        @else
                                            <div class="rounded-xl border border-dashed border-gray-200 dark:border-[#233a34] bg-white dark:bg-[#152420] p-4 text-center my-auto">
                                                <p class="text-[11px] font-semibold text-gray-500 dark:text-gray-400">QR tamu belum diaktifkan.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <!-- Single QR Code (Pegawai Internal / Ditugaskan) -->
                                <div id="panel-presensi-pegawai" class="space-y-4">
                                    <div class="bg-gray-50 dark:bg-[#0f1c19] rounded-2xl p-4 border border-gray-100 dark:border-[#233a34] text-center">
                                        <p class="text-[11px] font-semibold text-gray-700 dark:text-gray-200">
                                            @if ($isSuratInternal)
                                                QR Absen Pegawai Internal
                                            @elseif ($isSuratMasuk)
                                                QR Absen Pegawai Ditugaskan
                                            @else
                                                QR Absen Pegawai
                                            @endif
                                        </p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">
                                            @if ($isSuratInternal)
                                                Scan kode QR berikut untuk presensi pegawai internal Diskominfo
                                            @elseif ($isSuratMasuk)
                                                Scan kode QR berikut untuk absensi pegawai yang ditugaskan
                                            @else
                                                Scan kode QR berikut untuk melakukan absensi pegawai
                                            @endif
                                        </p>
                                    </div>

                                    @if ($agendaAktif->status_qr === 'aktif' && $qrImageUrlPegawai)
                                        <div class="rounded-2xl border border-gray-100 dark:border-[#233a34] bg-gray-50 dark:bg-[#0f1c19] p-4 text-center">
                                            <div class="inline-block rounded-2xl bg-white p-3 shadow-xs border border-gray-100 dark:border-[#284c43]">
                                                <img src="{{ $qrImageUrlPegawai }}" alt="QR Presensi Pegawai {{ $agendaAktif->nama_agenda }}" class="mx-auto h-52 w-52 rounded-xl object-contain">
                                            </div>
                                        </div>
                                    @else
                                        <div class="rounded-2xl border border-dashed border-gray-200 dark:border-[#233a34] bg-gray-50 dark:bg-[#0f1c19] p-5 text-center">
                                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">QR presensi pegawai belum diaktifkan admin untuk agenda ini.</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="bg-ijo-sangatmuda/60 dark:bg-[#152420] rounded-xl p-6 border border-ijo-sangatmuda dark:border-[#233a34] text-center space-y-2 flex flex-col items-center justify-center min-h-[140px]">
                        <div class="w-8 h-8 rounded-full bg-ijo-tua dark:bg-[#107050] text-white flex items-center justify-center text-xs">PIN</div>
                        <div>
                            <h5 class="font-bold text-xs text-gray-900 dark:text-white">{{ $agendaAktif->lokasi_display ?? 'Lokasi belum diisi' }}</h5>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">Lokasi Pelaksanaan Kegiatan</p>
                        </div>
                    </div>
                </aside>
            </div>
        @else
            <div class="bg-white dark:bg-[#152420] rounded-2xl p-8 border border-gray-100 dark:border-[#233a34] shadow-xs text-center">
                <h1 class="font-bold text-gray-900 dark:text-white">Agenda tidak ditemukan</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Tambahkan agenda di admin agar detail agenda bisa tampil.</p>
            </div>
        @endif
    </main>

    {{-- Modal Preview Foto & Lampiran dengan Fitur Zoom In, Zoom Out, dan Drag Pan --}}
    @include('publik.layout.image-preview-modal')

    @include('publik.layout.footer')

    <script>
        function openDokumentasiModal(imgSrc, title) {
            const modal = document.getElementById('dokumentasi-modal');
            const modalImg = document.getElementById('dokumentasi-modal-img');
            const modalTitle = document.getElementById('dokumentasi-modal-title');
            if (modal && modalImg) {
                modalImg.src = imgSrc;
                if (modalTitle) modalTitle.textContent = title;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeDokumentasiModal() {
            const modal = document.getElementById('dokumentasi-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function previewTamuImage(event) {
            const input = event.target;
            const preview = document.getElementById('tamu-foto-preview');
            const placeholder = document.getElementById('tamu-upload-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (preview) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    if (placeholder) {
                        placeholder.classList.add('opacity-0');
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

        /* --- SCRIPT KONTROL ZOOM IN / ZOOM OUT & DRAG PAN LAMPIRAN INLINE --- */
        let inlineLampiranScale = 1.0;
        const inlineLampiranMinScale = 1.0;
        const inlineLampiranMaxScale = 3.5;
        let inlineLampiranTranslateX = 0;
        let inlineLampiranTranslateY = 0;
        let isDraggingInlineLampiran = false;
        let inlineStartX = 0;
        let inlineStartY = 0;
        let inlineLastTranslateX = 0;
        let inlineLastTranslateY = 0;
        let inlineHasMoved = false;

        function inlineZoomLampiran(delta) {
            const newScale = Math.min(Math.max(Number((inlineLampiranScale + delta).toFixed(2)), inlineLampiranMinScale), inlineLampiranMaxScale);
            if (newScale === inlineLampiranScale) return;
            inlineLampiranScale = newScale;
            if (inlineLampiranScale <= inlineLampiranMinScale) {
                inlineLampiranTranslateX = 0;
                inlineLampiranTranslateY = 0;
            }
            applyInlineLampiranTransform(true);
        }

        function inlineResetLampiran() {
            inlineLampiranScale = 1.0;
            inlineLampiranTranslateX = 0;
            inlineLampiranTranslateY = 0;
            applyInlineLampiranTransform(true);
        }

        function applyInlineLampiranTransform(smooth = true) {
            const img = document.getElementById('inline-lampiran-img');
            const container = document.getElementById('inline-lampiran-viewport');
            const scaleEl = document.getElementById('inline-lampiran-scale');
            const btnOut = document.getElementById('btn-inline-zoom-out');
            const btnIn = document.getElementById('btn-inline-zoom-in');

            if (!img) return;

            if (inlineLampiranScale <= inlineLampiranMinScale) {
                inlineLampiranScale = inlineLampiranMinScale;
                inlineLampiranTranslateX = 0;
                inlineLampiranTranslateY = 0;
                if (container) container.style.cursor = 'default';
                img.style.cursor = 'zoom-in';
            } else {
                if (container) container.style.cursor = isDraggingInlineLampiran ? 'grabbing' : 'grab';
                img.style.cursor = isDraggingInlineLampiran ? 'grabbing' : 'grab';
            }

            img.style.transition = smooth ? 'transform 0.18s cubic-bezier(0.16, 1, 0.3, 1)' : 'none';
            img.style.transform = `translate(${inlineLampiranTranslateX}px, ${inlineLampiranTranslateY}px) scale(${inlineLampiranScale})`;

            const percentText = `${Math.round(inlineLampiranScale * 100)}%`;
            if (scaleEl) scaleEl.textContent = percentText;

            if (btnOut) btnOut.disabled = (inlineLampiranScale <= inlineLampiranMinScale);
            if (btnIn) btnIn.disabled = (inlineLampiranScale >= inlineLampiranMaxScale);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('inline-lampiran-viewport');
            const img = document.getElementById('inline-lampiran-img');

            if (container && img) {
                // Wheel Zoom (Scroll mouse untuk zoom)
                container.addEventListener('wheel', (e) => {
                    e.preventDefault();
                    inlineZoomLampiran(e.deltaY < 0 ? 0.25 : -0.25);
                }, { passive: false });

                // Drag Start
                const startDrag = (clientX, clientY) => {
                    if (inlineLampiranScale <= inlineLampiranMinScale) return;
                    isDraggingInlineLampiran = true;
                    inlineHasMoved = false;
                    inlineStartX = clientX;
                    inlineStartY = clientY;
                    inlineLastTranslateX = inlineLampiranTranslateX;
                    inlineLastTranslateY = inlineLampiranTranslateY;
                    container.style.cursor = 'grabbing';
                    img.style.cursor = 'grabbing';
                };

                // Drag Move
                const moveDrag = (clientX, clientY) => {
                    if (!isDraggingInlineLampiran || inlineLampiranScale <= inlineLampiranMinScale) return;
                    const deltaX = clientX - inlineStartX;
                    const deltaY = clientY - inlineStartY;
                    if (Math.abs(deltaX) > 4 || Math.abs(deltaY) > 4) {
                        inlineHasMoved = true;
                    }

                    const boundX = (container.clientWidth * (inlineLampiranScale - 1)) / 1.6 + 50;
                    const boundY = (container.clientHeight * (inlineLampiranScale - 1)) / 1.6 + 50;

                    inlineLampiranTranslateX = Math.max(-boundX, Math.min(boundX, inlineLastTranslateX + deltaX));
                    inlineLampiranTranslateY = Math.max(-boundY, Math.min(boundY, inlineLastTranslateY + deltaY));

                    applyInlineLampiranTransform(false);
                };

                // Drag End
                const endDrag = () => {
                    if (isDraggingInlineLampiran) {
                        isDraggingInlineLampiran = false;
                        container.style.cursor = inlineLampiranScale > inlineLampiranMinScale ? 'grab' : 'default';
                        img.style.cursor = inlineLampiranScale > inlineLampiranMinScale ? 'grab' : 'zoom-in';
                        applyInlineLampiranTransform(true);
                    }
                };

                // Mouse Events
                container.addEventListener('mousedown', (e) => {
                    startDrag(e.clientX, e.clientY);
                });
                window.addEventListener('mousemove', (e) => {
                    moveDrag(e.clientX, e.clientY);
                });
                window.addEventListener('mouseup', endDrag);

                // Touch Events (Mobile)
                container.addEventListener('touchstart', (e) => {
                    if (e.touches.length === 1) {
                        startDrag(e.touches[0].clientX, e.touches[0].clientY);
                    }
                }, { passive: true });

                container.addEventListener('touchmove', (e) => {
                    if (e.touches.length === 1) {
                        moveDrag(e.touches[0].clientX, e.touches[0].clientY);
                    }
                }, { passive: true });

                container.addEventListener('touchend', endDrag);

                // Double Click untuk Toggle Zoom Cepat (100% <-> 200%)
                container.addEventListener('dblclick', (e) => {
                    if (inlineLampiranScale > 1.0) {
                        inlineResetLampiran();
                    } else {
                        inlineZoomLampiran(1.0);
                    }
                });

                // Klik gambar untuk buka modal layar penuh jika tidak sedang digeser
                img.addEventListener('click', (e) => {
                    if (!inlineHasMoved && inlineLampiranScale <= 1.05) {
                        openImagePreview(img.src, 'Surat Undangan - ' + @json($agendaAktif?->nama_agenda ?? 'Agenda'), @json($agendaAktif?->tanggal?->translatedFormat('l, d F Y') ?? '-'));
                    }
                });
            }
        });
    </script>
</body>
</html>
