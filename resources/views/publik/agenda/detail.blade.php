<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Agenda - SIRAPI</title>
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
            $agendaAktif = $agenda ?? null;
            $lampiranUrl = $agendaAktif?->lampiran
                ? route('publik.agenda.lampiran', $agendaAktif->id_agenda, false)
                : null;
            $lampiranExtension = strtolower(pathinfo((string) $agendaAktif?->lampiran, PATHINFO_EXTENSION));
            $lampiranPreviewable = in_array($lampiranExtension, ['pdf', 'jpg', 'jpeg', 'png'], true);
            $qrPayload = $qrCode?->qr_codepath;
            $qrImageUrl = $qrPayload ? 'https://api.qrserver.com/v1/create-qr-code/?size=280x280&data=' . urlencode($qrPayload) : null;
            $isSuratMasuk = strtolower((string) ($agendaAktif?->kategori_surat ?? '')) === 'masuk';
        @endphp

        <div class="space-y-3">
            <nav class="text-xs text-gray-500 dark:text-gray-400 flex items-center space-x-2">
                <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
                <span>/</span>
                <a href="{{ route('publik.agenda') }}" class="hover:underline">Agenda</a>
                <span>/</span>
                <span class="text-gray-800 dark:text-gray-200 font-semibold truncate">{{ $agendaAktif?->nama_agenda ?? 'Detail agenda' }}</span>
            </nav>

            <a href="{{ route('publik.agenda') }}" class="inline-flex items-center space-x-1 text-xs font-bold text-ijo-tua dark:text-emerald-400 hover:underline">
                <span>&larr;</span>
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
                <section class="lg:col-span-7 space-y-8">
                    <div class="space-y-2">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Deskripsi Kegiatan</h3>
                        <div class="bg-white dark:bg-[#152420] rounded-2xl p-5 border border-gray-100 dark:border-[#233a34] shadow-xs text-xs text-gray-600 dark:text-gray-300 leading-relaxed space-y-2">
                            <p><span class="font-bold text-gray-800 dark:text-white">Kategori:</span> {{ $agendaAktif->kategori_surat ?? '-' }}</p>
                            <p><span class="font-bold text-gray-800 dark:text-white">Asal Surat:</span> {{ $agendaAktif->asal_surat ?? '-' }}</p>
                            <p><span class="font-bold text-gray-800 dark:text-white">Ditugaskan:</span> {{ $agendaAktif->ditugaskan ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Surat Undangan / Lampiran</h3>
                        @if ($lampiranUrl)
                            <button type="button" id="open-lampiran-modal" class="w-full bg-white dark:bg-[#152420] rounded-2xl p-3.5 border border-gray-100 dark:border-[#233a34] shadow-xs flex items-center space-x-3.5 text-left hover:border-gray-300 dark:hover:border-[#284c43] transition-colors cursor-pointer">
                                <div class="w-10 h-10 rounded-xl bg-oren-muda dark:bg-amber-950/50 text-oren-tua dark:text-amber-200 font-bold text-[10px] flex items-center justify-center shrink-0 uppercase border border-transparent dark:border-amber-700/40">FILE</div>
                                <div class="overflow-hidden min-w-0">
                                    <h5 class="text-xs font-bold text-gray-900 dark:text-white truncate">{{ basename($agendaAktif->lampiran) }}</h5>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-400 mt-0.5">Lihat file surat undangan / lampiran agenda</p>
                                </div>
                            </button>
                        @else
                            <p class="bg-white dark:bg-[#152420] rounded-2xl p-5 border border-gray-100 dark:border-[#233a34] shadow-xs text-xs text-gray-500 dark:text-gray-400">Belum ada surat undangan / lampiran untuk agenda ini.</p>
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
                                    <div class="group relative rounded-2xl overflow-hidden border border-gray-100 dark:border-[#233a34] bg-gray-100 dark:bg-[#152420] shadow-xs aspect-[4/3] cursor-pointer" onclick="openDokumentasiModal('{{ asset('storage/' . $item->file_path) }}', '{{ addslashes($item->nama_file) }}')">
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

                <aside class="lg:col-span-5 space-y-5">
                    <div class="bg-white dark:bg-[#152420] rounded-3xl p-6 border border-gray-100 dark:border-[#233a34] shadow-xs space-y-4">
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

                    <div id="presensi-section" class="bg-white dark:bg-[#152420] rounded-3xl p-6 border border-gray-100 dark:border-[#233a34] shadow-xs space-y-5">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <h4 class="font-bold text-sm text-gray-900 dark:text-white">Presensi Agenda</h4>
                                <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ $isSuratMasuk ? 'Presensi pegawai yang ditugaskan' : 'Pilih kategori kehadiran Anda' }}
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
                            @if (! $isSuratMasuk)
                                <!-- Tombol Pilihan Jenis Presensi (Hanya jika bukan Surat Masuk) -->
                                <div class="grid grid-cols-2 gap-2 bg-[#F4F3EE] dark:bg-[#0f1c19] border border-transparent dark:border-[#233a34] p-1.5 rounded-2xl">
                                    <button type="button" id="tab-btn-pegawai" onclick="switchPresensiTab('pegawai')" class="py-2.5 px-3 rounded-xl text-xs font-bold transition-all flex items-center justify-center space-x-2 bg-ijo-tua dark:bg-[#107050] text-white shadow-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        <span>Presensi Pegawai</span>
                                    </button>
                                    <button type="button" id="tab-btn-tamu" onclick="switchPresensiTab('tamu')" class="py-2.5 px-3 rounded-xl text-xs font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all flex items-center justify-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <span>Presensi Tamu</span>
                                    </button>
                                </div>
                            @endif

                            <!-- Panel Presensi Pegawai (QR Code) -->
                            <div id="panel-presensi-pegawai" class="space-y-4">
                                <div class="bg-gray-50 dark:bg-[#0f1c19] rounded-2xl p-4 border border-gray-100 dark:border-[#233a34] text-center">
                                    <p class="text-[11px] font-semibold text-gray-700 dark:text-gray-200">QR Absen Pegawai</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">Scan kode QR berikut untuk melakukan absensi pegawai</p>
                                </div>

                                @if ($agendaAktif->status_qr === 'aktif' && $qrImageUrl)
                                    <div class="rounded-2xl border border-gray-100 dark:border-[#233a34] bg-gray-50 dark:bg-[#0f1c19] p-4 text-center">
                                        <div class="inline-block rounded-2xl bg-white p-3 shadow-xs border border-gray-100 dark:border-[#284c43]">
                                            <img src="{{ $qrImageUrl }}" alt="QR Presensi {{ $agendaAktif->nama_agenda }}" class="mx-auto h-52 w-52 rounded-xl object-contain">
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ $qrPayload ?: route('publik.presensi.pegawai', ['agenda_id' => $agendaAktif->id_agenda]) }}" class="inline-flex w-full items-center justify-center rounded-xl bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 px-4 py-2.5 text-xs font-bold text-white shadow-xs transition">
                                                <span>Buka Presensi Pegawai</span>
                                                <span class="ml-1.5">&rarr;</span>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="rounded-2xl border border-dashed border-gray-200 dark:border-[#233a34] bg-gray-50 dark:bg-[#0f1c19] p-5 text-center">
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">QR presensi pegawai belum diaktifkan admin untuk agenda ini.</p>
                                    </div>
                                @endif
                            </div>

                            @if (! $isSuratMasuk)
                                <!-- Panel Presensi Tamu (Formulir Kehadiran - Hanya untuk Non-Surat Masuk) -->
                                <div id="panel-presensi-tamu" class="hidden space-y-4">
                                    <div class="bg-gray-50 dark:bg-[#0f1c19] rounded-2xl p-4 border border-gray-100 dark:border-[#233a34]">
                                        <p class="text-[11px] font-bold text-gray-800 dark:text-white">Formulir Kehadiran Tamu</p>
                                        <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Silakan isi data kehadiran Anda di bawah ini:</p>
                                    </div>

                                    <form action="{{ route('publik.tamu.hadir') }}" method="POST" enctype="multipart/form-data" class="space-y-3.5">
                                        @csrf
                                        <input type="hidden" name="id_agenda" value="{{ $agendaAktif->id_agenda }}">

                                        <!-- Foto / Swafoto -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-200">Foto / Swafoto Tamu <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                            <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-200 dark:border-[#284c43] rounded-2xl cursor-pointer bg-gray-50 dark:bg-[#0f1c19] hover:bg-gray-100 dark:hover:bg-[#152420] transition-all relative overflow-hidden group">
                                                <div class="flex flex-col items-center justify-center p-3 text-center" id="tamu-upload-placeholder">
                                                    <svg class="w-6 h-6 mb-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <p class="text-[11px] text-gray-600 dark:text-gray-300 font-semibold">Ambil / Unggah Foto</p>
                                                    <p class="text-[9px] text-gray-400">PNG, JPG, WebP (Maks. 5MB)</p>
                                                </div>
                                                <img id="tamu-foto-preview" class="hidden absolute inset-0 w-full h-full object-cover rounded-2xl" />
                                                <input type="file" name="foto" id="tamu-foto-input" accept="image/*" capture="user" class="hidden" onchange="previewTamuImage(event)" />
                                            </label>
                                        </div>

                                        <!-- Nama Lengkap -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-200">Nama Lengkap *</label>
                                            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap" class="w-full bg-gray-50 dark:bg-[#0f1c19] border border-gray-200 dark:border-[#284c43] focus:border-ijo-semitua focus:bg-white dark:focus:bg-[#152420] text-xs rounded-xl px-3.5 py-2.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                                        </div>

                                        <!-- NIK / NIP -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-200">NIK / Nomor Induk <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                            <input type="text" name="nik" value="{{ old('nik') }}" pattern="[0-9]+" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Masukkan NIK/NIP" class="w-full bg-gray-50 dark:bg-[#0f1c19] border border-gray-200 dark:border-[#284c43] focus:border-ijo-semitua focus:bg-white dark:focus:bg-[#152420] text-xs rounded-xl px-3.5 py-2.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                                        </div>

                                        <!-- Jabatan -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-200">Jabatan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                            <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Kepala Bidang / Staf" class="w-full bg-gray-50 dark:bg-[#0f1c19] border border-gray-200 dark:border-[#284c43] focus:border-ijo-semitua focus:bg-white dark:focus:bg-[#152420] text-xs rounded-xl px-3.5 py-2.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                                        </div>

                                        <!-- No. HP / WhatsApp -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-200">No. HP / WhatsApp *</label>
                                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required pattern="[0-9]+" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="08xxxxxxxxxx" class="w-full bg-gray-50 dark:bg-[#0f1c19] border border-gray-200 dark:border-[#284c43] focus:border-ijo-semitua focus:bg-white dark:focus:bg-[#152420] text-xs rounded-xl px-3.5 py-2.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                                        </div>

                                        <!-- Instansi / Asal -->
                                        <div class="space-y-1">
                                            <label class="block text-[11px] font-bold text-gray-700 dark:text-gray-200">Instansi / Asal *</label>
                                            <input type="text" name="asal_instansi" value="{{ old('asal_instansi') }}" required placeholder="Contoh: Dinas Kominfo / Umum" class="w-full bg-gray-50 dark:bg-[#0f1c19] border border-gray-200 dark:border-[#284c43] focus:border-ijo-semitua focus:bg-white dark:focus:bg-[#152420] text-xs rounded-xl px-3.5 py-2.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                                        </div>

                                        <div class="pt-2">
                                            <button type="submit" class="w-full bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 text-white font-bold text-xs py-3 rounded-xl transition-all flex items-center justify-center space-x-2 shadow-xs cursor-pointer">
                                                <span>Kirim Kehadiran Tamu</span>
                                                <span>&rarr;</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="bg-ijo-sangatmuda/60 dark:bg-[#152420] rounded-3xl p-6 border border-ijo-sangatmuda dark:border-[#233a34] text-center space-y-2 flex flex-col items-center justify-center min-h-[140px]">
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

    @if ($lampiranUrl)
        <div id="lampiran-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-3 sm:p-4">
            <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-5xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl sm:max-h-[calc(100vh-2rem)] border border-transparent dark:border-[#233a34]">
                <div class="flex items-center justify-between gap-4 bg-ijo-tua dark:bg-[#0f1c19] px-5 py-4 text-white sm:px-6 border-b border-transparent dark:border-[#233a34]">
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-white/70 dark:text-emerald-400">Lampiran Agenda</p>
                        <h3 class="truncate text-sm font-extrabold text-white">{{ basename($agendaAktif->lampiran) }}</h3>
                    </div>
                    <button type="button" id="close-lampiran-modal" class="inline-flex h-9 shrink-0 items-center justify-center rounded-lg bg-white/10 dark:bg-white/5 px-4 text-xs font-bold text-white transition hover:bg-white/20 dark:hover:bg-white/10 cursor-pointer">
                        Kembali
                    </button>
                </div>

                <div class="min-h-0 flex-1 bg-gray-100 dark:bg-[#0f1c19] p-3 sm:p-4">
                    @if ($lampiranPreviewable)
                        <iframe src="{{ $lampiranUrl }}" title="Lampiran {{ $agendaAktif->nama_agenda }}" class="h-[70vh] w-full rounded-xl border border-gray-200 dark:border-[#233a34] bg-white dark:bg-[#152420]"></iframe>
                    @else
                        <div class="flex h-[45vh] flex-col items-center justify-center rounded-xl bg-white dark:bg-[#152420] p-6 text-center border border-gray-100 dark:border-[#233a34]">
                            <h4 class="text-sm font-extrabold text-gray-900 dark:text-white">Preview tidak tersedia</h4>
                            <p class="mt-2 max-w-md text-xs text-gray-500 dark:text-gray-400">Format file ini tidak bisa ditampilkan langsung di halaman. Gunakan tombol unduh untuk melihat lampiran.</p>
                            <a href="{{ $lampiranUrl }}" download class="mt-4 rounded-xl bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] px-5 py-2.5 text-xs font-bold text-white transition shadow-xs">Unduh Lampiran</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Dokumentasi Foto Viewer -->
    <div id="dokumentasi-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/85 p-4 backdrop-blur-xs transition-opacity" onclick="closeDokumentasiModal()">
        <div class="relative max-w-4xl w-full max-h-[90vh] flex flex-col items-center" onclick="event.stopPropagation()">
            <button type="button" onclick="closeDokumentasiModal()" class="absolute -top-10 right-0 text-white/90 hover:text-white flex items-center space-x-1.5 text-xs font-bold bg-white/20 hover:bg-white/30 px-3.5 py-1.5 rounded-full transition" title="Tutup">
                <span>Tutup</span>
                <span class="text-base leading-none">&times;</span>
            </button>
            <img id="dokumentasi-modal-img" src="" alt="Dokumentasi" class="max-h-[78vh] w-auto max-w-full rounded-2xl object-contain shadow-2xl border border-white/10 bg-black/50">
            <p id="dokumentasi-modal-title" class="text-xs font-medium text-white/90 mt-3 text-center truncate max-w-xl"></p>
        </div>
    </div>

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

        function switchPresensiTab(type) {
            const btnPegawai = document.getElementById('tab-btn-pegawai');
            const btnTamu = document.getElementById('tab-btn-tamu');
            const panelPegawai = document.getElementById('panel-presensi-pegawai');
            const panelTamu = document.getElementById('panel-presensi-tamu');

            if (!btnPegawai || !btnTamu || !panelPegawai || !panelTamu) return;

            if (type === 'pegawai') {
                btnPegawai.className = 'py-2.5 px-3 rounded-xl text-xs font-bold transition-all flex items-center justify-center space-x-2 bg-ijo-tua text-white shadow-sm';
                btnTamu.className = 'py-2.5 px-3 rounded-xl text-xs font-semibold text-gray-600 hover:text-gray-900 transition-all flex items-center justify-center space-x-2';
                panelPegawai.classList.remove('hidden');
                panelTamu.classList.add('hidden');
            } else {
                btnTamu.className = 'py-2.5 px-3 rounded-xl text-xs font-bold transition-all flex items-center justify-center space-x-2 bg-ijo-tua text-white shadow-sm';
                btnPegawai.className = 'py-2.5 px-3 rounded-xl text-xs font-semibold text-gray-600 hover:text-gray-900 transition-all flex items-center justify-center space-x-2';
                panelTamu.classList.remove('hidden');
                panelPegawai.classList.add('hidden');
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

        document.addEventListener('DOMContentLoaded', function() {
            const isSuratMasuk = {{ $isSuratMasuk ? 'true' : 'false' }};
            if (!isSuratMasuk) {
                const urlParams = new URLSearchParams(window.location.search);
                const hasTamuParam = urlParams.get('presensi') === 'tamu' || window.location.hash === '#presensi-tamu';
                @if ($errors->any() || session('success'))
                    switchPresensiTab('tamu');
                @else
                    if (hasTamuParam) {
                        switchPresensiTab('tamu');
                    }
                @endif
            }
        });
    </script>

    @if ($lampiranUrl)
        <script>
            const lampiranModal = document.getElementById('lampiran-modal');
            const openLampiranModal = document.getElementById('open-lampiran-modal');
            const closeLampiranModal = document.getElementById('close-lampiran-modal');

            function hideLampiranModal() {
                lampiranModal?.classList.add('hidden');
                lampiranModal?.classList.remove('flex');
            }

            openLampiranModal?.addEventListener('click', () => {
                lampiranModal?.classList.remove('hidden');
                lampiranModal?.classList.add('flex');
            });

            closeLampiranModal?.addEventListener('click', hideLampiranModal);

            lampiranModal?.addEventListener('click', (event) => {
                if (event.target === lampiranModal) {
                    hideLampiranModal();
                }
            });
        </script>
    @endif
</body>
</html>
