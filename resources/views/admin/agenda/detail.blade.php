@extends('admin.layout.app')

@section('title', 'Detail Agenda')

@section('content')
@php
    $notulen = $dokumen->firstWhere('jenis_dokumen', 'notulen');
    $dokumentasiItems = $dokumen->where('jenis_dokumen', 'dokumentasi')->values();
    $waktuMulai = substr((string) $agenda->waktu, 0, 5);
    $waktuSelesai = $agenda->waktu_selesai ? substr((string) $agenda->waktu_selesai, 0, 5) : null;
    $qrPayload = $qrCode?->qr_codepath;
    $qrImageUrl = $qrPayload ? 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=' . urlencode($qrPayload) : null;
    $lokasiAgenda = $agenda->lokasi ?: ($ruang->nama_ruang ?? 'Ruang Rapat');
@endphp

<div class="max-w-[1440px] mx-auto space-y-8 pb-12">
    <!-- Header -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] dark:text-white tracking-tight">Detail Agenda</h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Informasi agenda, berkas dokumen, QR code, dan rekap log kehadiran real-time.</p>
        </div>
        <a href="{{ route('admin.agenda.lihat', ['kategori_surat' => $agenda->kategori_surat ?? 'internal']) }}" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-gray-200 dark:border-[#233a34] bg-white dark:bg-[#152420] px-4 text-xs font-bold text-gray-700 dark:text-gray-200 transition hover:bg-gray-50 dark:hover:bg-white/5 shadow-2xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Daftar Agenda</span>
        </a>
    </div>

    <!-- Grid Informasi Utama & QR Code -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Kolom Kiri (7 Kolom): Info Agenda & Dokumen -->
        <section class="lg:col-span-7 space-y-6">
            <!-- Card Detail Agenda -->
            <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-3xl p-6 sm:p-7 shadow-xs transition-colors space-y-5">
                <div class="flex items-center justify-between">
                    <span class="inline-flex rounded-lg border px-3 py-1 text-xs font-extrabold tracking-wider uppercase {{ $agenda->status_badge_class }}">
                        {{ $agenda->status_label }}
                    </span>
                    <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                        Kategori: <strong class="text-gray-700 dark:text-gray-300">{{ ucfirst($agenda->kategori_surat ?? 'internal') }}</strong>
                    </span>
                </div>

                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-white leading-snug">{{ $agenda->nama_agenda }}</h2>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs pt-3 border-t border-gray-100 dark:border-[#233a34]">
                    <div class="space-y-1">
                        <dt class="font-semibold text-gray-400 dark:text-gray-400 uppercase text-[10px] tracking-wider">Tanggal Kegiatan</dt>
                        <dd class="font-bold text-gray-800 dark:text-slate-100 text-sm">{{ $agenda->tanggal?->translatedFormat('d F Y') ?? '-' }}</dd>
                    </div>
                    <div class="space-y-1">
                        <dt class="font-semibold text-gray-400 dark:text-gray-400 uppercase text-[10px] tracking-wider">Waktu Pelaksanaan</dt>
                        <dd class="font-bold text-gray-800 dark:text-slate-100 text-sm">{{ $waktuMulai ?: '-' }}{{ $waktuSelesai ? ' - ' . $waktuSelesai : '' }} WIB</dd>
                    </div>
                    <div class="sm:col-span-2 space-y-1">
                        <dt class="font-semibold text-gray-400 dark:text-gray-400 uppercase text-[10px] tracking-wider">Tempat / Lokasi</dt>
                        <dd class="font-bold text-gray-800 dark:text-slate-100 text-sm flex items-center gap-1.5">
                            <span class="text-emerald-600 dark:text-emerald-400">📍</span>
                            <span>{{ $lokasiAgenda }}</span>
                        </dd>
                    </div>
                    <div class="space-y-1">
                        <dt class="font-semibold text-gray-400 dark:text-gray-400 uppercase text-[10px] tracking-wider">Asal Surat / Penyelenggara</dt>
                        <dd class="font-bold text-gray-800 dark:text-slate-100 text-xs">{{ $agenda->asal_surat ?: 'Bidang Informasi Publik' }}</dd>
                    </div>
                    <div class="space-y-1">
                        <dt class="font-semibold text-gray-400 dark:text-gray-400 uppercase text-[10px] tracking-wider">Kuota Maksimal</dt>
                        <dd class="font-bold text-gray-800 dark:text-slate-100 text-xs">{{ $agenda->kuota ? $agenda->kuota . ' Peserta' : 'Tidak Dibatasi' }}</dd>
                    </div>
                    @if ($agenda->lampiran)
                        <div class="sm:col-span-2 space-y-1 pt-2 border-t border-gray-100 dark:border-[#233a34]">
                            <dt class="font-semibold text-gray-400 dark:text-gray-400 uppercase text-[10px] tracking-wider">Berkas Lampiran Surat</dt>
                            <dd class="mt-1">
                                <button type="button" onclick="openDocumentPreview('{{ asset('storage/' . $agenda->lampiran) }}', 'Lampiran Surat - {{ addslashes($agenda->nama_agenda) }}', '{{ addslashes(basename($agenda->lampiran)) }}')" class="inline-flex items-center gap-2 font-bold text-xs text-[#35635b] dark:text-emerald-400 hover:underline bg-emerald-50/60 dark:bg-emerald-950/40 border border-emerald-200/60 dark:border-emerald-800/40 px-3 py-1.5 rounded-xl cursor-pointer">
                                    <img src="{{ asset('assets/foto/Lampiranlogo.png') }}" alt="Lampiran" class="w-3.5 h-3.5 object-contain">
                                    <span>Lihat Berkas Lampiran Surat ({{ basename($agenda->lampiran) }})</span>
                                </button>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Notulen & Dokumentasi Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Notulen -->
                <div class="border-2 border-dashed border-gray-200 dark:border-[#233a34] p-5 rounded-3xl bg-white dark:bg-[#152420] transition-colors flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-bold text-gray-800 dark:text-white uppercase tracking-wider">Notulen Agenda</p>
                            @if ($notulen)
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            @endif
                        </div>
                        @if ($notulen)
                            <p class="mt-2 truncate text-xs font-semibold text-[#35635b] dark:text-emerald-400 bg-emerald-50/60 dark:bg-emerald-950/40 p-2 rounded-xl border border-emerald-200/50 dark:border-emerald-800/40">{{ $notulen->nama_file }}</p>
                            <div class="mt-3 flex items-center gap-2">
                                <button type="button" onclick="openDocumentPreview('{{ asset('storage/' . $notulen->file_path) }}', 'Notulen - {{ addslashes($agenda->nama_agenda) }}', '{{ addslashes($notulen->nama_file) }}')" class="rounded-xl bg-[#35635b] dark:bg-[#107050] hover:bg-[#2b4f49] dark:hover:bg-[#0c5940] px-3.5 py-1.5 text-xs font-bold text-white transition cursor-pointer">Lihat</button>
                                <button type="button" onclick="openDeleteModal('{{ route('admin.agenda.dokumen.destroy', [$agenda->id_agenda, $notulen->id_dokumen]) }}', 'Hapus Notulen?', 'Apakah Anda yakin ingin menghapus notulen agenda ini?')" class="flex h-8 w-8 items-center justify-center rounded-xl bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer" title="Hapus Notulen">
                                    <img src="{{ asset('assets/foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                </button>
                            </div>
                        @else
                            <p class="text-xs text-gray-400 dark:text-gray-400 mt-2">Belum ada dokumen notulen diunggah.</p>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('admin.agenda.dokumen.store', $agenda->id_agenda) }}" enctype="multipart/form-data" class="mt-4 space-y-2.5">
                        @csrf
                        <input type="hidden" name="jenis_dokumen" value="notulen">
                        <input name="dokumen" type="file" accept=".pdf,.doc,.docx" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] px-3 py-2 text-xs text-gray-700 dark:text-gray-300 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:bg-gray-200 dark:file:bg-gray-800 file:text-gray-700 dark:file:text-gray-300">
                        <button type="submit" class="w-full rounded-xl bg-[#04733f] dark:bg-[#107050] hover:bg-[#035f35] dark:hover:bg-[#0c5940] py-2 text-xs font-bold text-white transition cursor-pointer">
                            {{ $notulen ? 'Ganti Notulen' : 'Unggah Notulen' }}
                        </button>
                    </form>
                </div>

                <!-- Dokumentasi -->
                <div class="border-2 border-dashed border-gray-200 dark:border-[#233a34] p-5 rounded-3xl bg-white dark:bg-[#152420] transition-colors flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-bold text-gray-800 dark:text-white uppercase tracking-wider">Dokumentasi Foto</p>
                            @if ($dokumentasiItems->isNotEmpty())
                                <span class="bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $dokumentasiItems->count() }} Foto</span>
                            @endif
                        </div>
                        @if ($dokumentasiItems->isNotEmpty())
                            <div class="mt-3 space-y-2 max-h-36 overflow-y-auto pr-1">
                                @foreach ($dokumentasiItems as $dokumentasi)
                                    <div class="flex items-center justify-between gap-2 rounded-xl bg-gray-50 dark:bg-[#1a2d29] border border-gray-100 dark:border-[#233a34] px-3 py-1.5">
                                        <p class="min-w-0 truncate text-xs font-semibold text-[#35635b] dark:text-emerald-400">{{ $dokumentasi->nama_file }}</p>
                                        <div class="flex shrink-0 gap-1.5">
                                            <button type="button" onclick="openDocumentPreview('{{ asset('storage/' . $dokumentasi->file_path) }}', 'Dokumentasi - {{ addslashes($agenda->nama_agenda) }}', '{{ addslashes($dokumentasi->nama_file) }}')" class="rounded-lg bg-[#35635b] dark:bg-[#107050] hover:bg-[#2b4f49] dark:hover:bg-[#0c5940] px-2.5 py-1 text-[11px] font-bold text-white transition cursor-pointer">Lihat</button>
                                            <button type="button" onclick="openDeleteModal('{{ route('admin.agenda.dokumen.destroy', [$agenda->id_agenda, $dokumentasi->id_dokumen]) }}', 'Hapus Dokumentasi?', 'Apakah Anda yakin ingin menghapus foto dokumentasi ini?')" class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer" title="Hapus Dokumentasi">
                                                <img src="{{ asset('assets/foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-gray-400 dark:text-gray-400 mt-2">Belum ada dokumentasi foto.</p>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('admin.agenda.dokumen.store', $agenda->id_agenda) }}" enctype="multipart/form-data" class="mt-4 space-y-2.5">
                        @csrf
                        <input type="hidden" name="jenis_dokumen" value="dokumentasi">
                        <input name="dokumen[]" type="file" accept=".jpg,.jpeg,.png,.webp" multiple required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] px-3 py-2 text-xs text-gray-700 dark:text-gray-300 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:bg-gray-200 dark:file:bg-gray-800 file:text-gray-700 dark:file:text-gray-300">
                        <button type="submit" class="w-full rounded-xl bg-[#04733f] dark:bg-[#107050] hover:bg-[#035f35] dark:hover:bg-[#0c5940] py-2 text-xs font-bold text-white transition cursor-pointer">
                            Unggah Foto Dokumentasi
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Kolom Kanan (5 Kolom): QR Code Presensi -->
        <section class="lg:col-span-5 space-y-6">
            <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-3xl p-6 sm:p-7 shadow-xs transition-colors space-y-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-bold text-gray-800 dark:text-white tracking-wide uppercase">QR Presensi Agenda</h2>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Pindai QR ini untuk akses presensi peserta.</p>
                    </div>
                    <span class="rounded-full px-3 py-1 text-xs font-extrabold {{ $agenda->status_label === 'Selesai' ? 'bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300' : ($agenda->status_qr === 'aktif' ? 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300' : 'bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-300') }}">
                        {{ $agenda->status_label === 'Selesai' ? 'Selesai' : ($agenda->status_qr === 'aktif' ? 'Aktif' : 'Nonaktif') }}
                    </span>
                </div>

                @if ($agenda->status_label === 'Selesai')
                    <div class="rounded-2xl border border-amber-200 dark:border-amber-800/60 bg-amber-50 dark:bg-amber-950/40 p-6 text-center space-y-2">
                        <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/60 text-amber-600 dark:text-amber-300">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 11 0 0118 0z" /></svg>
                        </div>
                        <p class="text-xs font-extrabold text-amber-900 dark:text-amber-200">Agenda Rapat Telah Selesai</p>
                        <p class="text-[11px] font-medium text-amber-700 dark:text-amber-300">QR Code dinonaktifkan otomatis karena agenda rapat telah berakhir.</p>
                    </div>
                @elseif ($qrImageUrl)
                    <div class="flex flex-col items-center gap-4">
                        <div class="p-3 bg-white rounded-2xl border border-gray-200 dark:border-[#233a34] shadow-xs">
                            <img src="{{ $qrImageUrl }}" alt="QR Presensi {{ $agenda->nama_agenda }}" class="h-56 w-56 object-contain rounded-xl">
                        </div>
                        <div class="w-full rounded-2xl bg-gray-50 dark:bg-[#1a2d29] border border-gray-200/60 dark:border-[#233a34] p-3 text-center">
                            <p class="break-all text-[11px] font-mono font-medium text-gray-500 dark:text-gray-400">{{ $qrPayload }}</p>
                        </div>
                        <a href="{{ $qrPayload }}" target="_blank" rel="noopener" class="inline-flex w-full items-center justify-center rounded-xl bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] px-4 py-3 text-xs font-bold text-white transition shadow-2xs">
                            Buka Halaman Presensi &rarr;
                        </a>
                    </div>
                @else
                    <div class="rounded-2xl border border-dashed border-gray-200 dark:border-[#233a34] bg-gray-50 dark:bg-[#1a2d29] p-6 text-center space-y-3">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-300">QR belum dibuat untuk agenda ini.</p>
                        <a href="{{ url('/admin/agenda/' . $agenda->id_agenda . '/generate-qr') }}" class="inline-flex items-center justify-center rounded-xl bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] px-4 py-2.5 text-xs font-bold text-white transition shadow-2xs">
                            Generate QR Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <!-- SEKSI TABEL REKAP KEHADIRAN (FULL-WIDTH, LUAS, & RAPI) -->
    <section class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-3xl p-6 sm:p-8 shadow-xs transition-colors space-y-6">
        <!-- Table Header & Counter Badges -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-100 dark:border-[#233a34] pb-5">
            <div>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-extrabold text-gray-900 dark:text-white">Rekap Kehadiran Peserta & Tamu</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Log presensi terverifikasi lengkap dengan waktu dan lokasi kehadiran real-time.</p>
                    </div>
                </div>
            </div>

            <!-- Stats Pills -->
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300 text-xs font-extrabold shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Total: {{ $pesertaHadir->count() }} Hadir</span>
                </span>
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800/60 text-blue-800 dark:text-blue-300 text-xs font-bold">
                    <span>Pegawai: {{ $pesertaPegawai->count() }}</span>
                </span>
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800/60 text-amber-800 dark:text-amber-300 text-xs font-bold">
                    <span>Tamu: {{ $pesertaTamu->count() }}</span>
                </span>
            </div>
        </div>

        <!-- Tabel Presensi Luas & Responsif -->
        <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-[#233a34]">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 dark:bg-[#1a2d29] text-gray-500 dark:text-gray-300 uppercase tracking-wider text-[11px] border-b border-gray-200/80 dark:border-[#233a34]">
                        <th class="py-3.5 px-4 font-bold text-center w-12">No</th>
                        <th class="py-3.5 px-4 font-bold min-w-[200px]">Nama Peserta</th>
                        <th class="py-3.5 px-4 font-bold w-28">Kategori</th>
                        <th class="py-3.5 px-4 font-bold min-w-[180px]">Jabatan & Instansi</th>
                        <th class="py-3.5 px-4 font-bold min-w-[170px]">Waktu Hadir</th>
                        <th class="py-3.5 px-4 font-bold min-w-[220px]">Lokasi Terupdate (GPS)</th>
                        <th class="py-3.5 px-4 font-bold text-center w-24">Status</th>
                        <th class="py-3.5 px-4 font-bold text-center w-28">Bukti</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#233a34] text-gray-700 dark:text-slate-200 bg-white dark:bg-[#152420]">
                    @forelse ($pesertaHadir as $index => $peserta)
                        @php
                            $isPegawai = strtolower($peserta->tipe_peserta) === 'pegawai';
                            $waktuHadir = $peserta->created_at ? \Carbon\Carbon::parse($peserta->created_at) : null;
                        @endphp
                        <tr class="hover:bg-gray-50/70 dark:hover:bg-[#1a2d29]/60 transition-colors">
                            <!-- 1. No -->
                            <td class="py-4 px-4 text-center font-bold text-gray-400 dark:text-gray-500">
                                {{ $index + 1 }}
                            </td>

                            <!-- 2. Nama & Avatar -->
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 {{ $isPegawai ? 'bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-300' : 'bg-amber-100 dark:bg-amber-950/80 text-amber-700 dark:text-amber-300' }}">
                                        {{ strtoupper(substr($peserta->nama, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-extrabold text-sm text-gray-900 dark:text-white truncate">{{ $peserta->nama }}</p>
                                        <p class="text-[11px] text-gray-400 dark:text-gray-400">ID Peserta #{{ $index + 1 }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- 3. Kategori Peserta -->
                            <td class="py-4 px-4">
                                @if ($isPegawai)
                                    <span class="inline-flex items-center gap-1 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60 px-2.5 py-1 rounded-lg text-[10px] font-extrabold">
                                        <svg class="w-3 h-3 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                        <span>Pegawai</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60 px-2.5 py-1 rounded-lg text-[10px] font-extrabold">
                                        <svg class="w-3 h-3 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path></svg>
                                        <span>Tamu</span>
                                    </span>
                                @endif
                            </td>

                            <!-- 4. Jabatan & Instansi -->
                            <td class="py-4 px-4">
                                <p class="font-bold text-gray-800 dark:text-gray-200 text-xs leading-snug">{{ $peserta->jabatan ?: '-' }}</p>
                                <p class="text-[11px] text-gray-400 dark:text-gray-400 mt-0.5">{{ $peserta->instansi ?: 'Dinas Komunikasi & Informatika' }}</p>
                            </td>

                            <!-- 5. Waktu Hadir Real-Time -->
                            <td class="py-4 px-4">
                                @if ($waktuHadir)
                                    <div class="flex items-center space-x-2 text-gray-800 dark:text-gray-200 font-bold">
                                        <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 11 0 0118 0z"></path></svg>
                                        <span>{{ $waktuHadir->format('H:i:s') }} WIB</span>
                                    </div>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-400 mt-0.5 ml-5.5 font-medium">{{ $waktuHadir->translatedFormat('d M Y') }}</p>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- 6. Lokasi Terupdate (Murni Teks Alamat Hasil Pelacakan) -->
                            <td class="py-4 px-4">
                                <p class="text-xs font-medium text-gray-800 dark:text-gray-200 leading-relaxed max-w-md">
                                    {{ $peserta->lokasi_presensi ?: 'Dinas Komunikasi dan Informasi Kabupaten Bogor, Jalan Tegar Beriman, Pakansari, Cibinong, Bogor, Jawa Barat, 16915, Indonesia' }}
                                </p>
                            </td>

                            <!-- 7. Status Hadir -->
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center gap-1 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60 px-3 py-1 rounded-full text-[10px] font-extrabold shadow-2xs">
                                    <svg class="w-2.5 h-2.5 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    <span>Hadir</span>
                                </span>
                            </td>

                            <!-- 8. Bukti / Foto Scan Wajah & Swafoto -->
                            <td class="py-4 px-4 text-center">
                                @if (!empty($peserta->foto_bukti))
                                    <div class="inline-flex items-center gap-2">
                                        <div class="relative group cursor-pointer" onclick="openDocumentPreview('{{ asset('storage/' . $peserta->foto_bukti) }}', 'Bukti Presensi {{ $isPegawai ? 'Scan Wajah' : 'Swafoto' }} - {{ addslashes($peserta->nama) }}', '{{ addslashes(basename($peserta->foto_bukti)) }}')">
                                            <img src="{{ asset('storage/' . $peserta->foto_bukti) }}" alt="Bukti {{ $peserta->nama }}" class="w-10 h-10 rounded-xl object-cover border-2 border-emerald-300 dark:border-emerald-700/60 shadow-xs group-hover:scale-105 transition">
                                            <div class="absolute inset-0 bg-black/20 rounded-xl opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                                                <svg class="w-4 h-4 text-white drop-shadow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </div>
                                        </div>
                                        <button type="button" onclick="openDocumentPreview('{{ asset('storage/' . $peserta->foto_bukti) }}', 'Bukti Presensi {{ $isPegawai ? 'Scan Wajah' : 'Swafoto' }} - {{ addslashes($peserta->nama) }}', '{{ addslashes(basename($peserta->foto_bukti)) }}')" class="text-left hidden sm:block">
                                            <span class="block text-[11px] font-bold text-emerald-700 dark:text-emerald-400 hover:underline cursor-pointer">Lihat Foto</span>
                                            <span class="block text-[9px] font-medium text-gray-400">{{ $isPegawai ? 'Scan Wajah' : 'Swafoto' }}</span>
                                        </button>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-gray-400 bg-gray-100 dark:bg-gray-800/60 px-2 py-0.5 rounded-md">
                                        <span>Tanpa Foto</span>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-400 dark:text-gray-500">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800/60 text-gray-400 flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <p class="font-bold text-sm text-gray-600 dark:text-gray-300">Belum ada peserta atau tamu yang hadir</p>
                                    <p class="text-xs text-gray-400">Data kehadiran akan muncul secara otomatis saat peserta melakukan presensi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
