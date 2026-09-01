<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tamu Rapat - SIRAPI</title>
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
                        'ijo-sangatmuda': '#e3eeea',
                    }
                }
            }
        }
    </script>
    <!-- Leaflet CSS & JS for Live Real-Time Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        .custom-live-marker {
            width: 22px;
            height: 22px;
            background: #10b981;
            border: 3px solid #ffffff;
            border-radius: 50%;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.4);
            animation: live-marker-pulse 1.8s infinite;
        }
        @keyframes live-marker-pulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 14px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
    </style>
</head>
<body class="bg-[#F8F7F4] dark:bg-[#0d1614] font-sans antialiased text-gray-800 dark:text-slate-100 flex flex-col min-h-screen transition-colors duration-200">
    @include('publik.layout.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-12 flex items-center justify-center">
        @php
            $agendaAktif = $agenda ?? null;
            $routeParams = $agendaAktif ? ['agenda_id' => $agendaAktif->id_agenda] : [];
        @endphp

        <div class="bg-white dark:bg-[#152420] border border-gray-200/80 dark:border-[#233a34] rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-lg relative space-y-6 transition-colors">
            <div class="flex items-center justify-between">
                <a href="{{ $agendaAktif ? route('publik.agenda.detail', $agendaAktif->id_agenda) : route('publik.agenda') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-ijo-semitua dark:text-emerald-400 hover:underline">
                    <span>&larr;</span>
                    <span>Kembali</span>
                </a>

                <span class="bg-gray-100 dark:bg-[#0f1c19] text-gray-600 dark:text-gray-300 text-[11px] font-bold px-3 py-1 rounded-full border border-transparent dark:border-[#284c43]">Tamu Rapat</span>
            </div>

            <div class="space-y-1">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">Form Tamu Rapat</h1>
                <p class="text-xs text-gray-500 dark:text-gray-300 font-medium">{{ $agendaAktif?->nama_agenda ?? 'Belum ada agenda tersedia' }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-400">{{ substr((string) $agendaAktif?->waktu, 0, 5) ?: '-' }} WIB &bull; {{ $agendaAktif?->lokasi_display ?? '-' }}</p>
            </div>

            <hr class="border-gray-100 dark:border-[#233a34]">

            @if (session('success'))
                <div class="rounded-2xl bg-ijo-sangatmuda dark:bg-[#0f1c19] text-ijo-tua dark:text-emerald-400 border border-transparent dark:border-[#284c43] px-4 py-3 text-xs font-bold shadow-xs">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-2xl bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800 px-4 py-3 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($agendaAktif && $agendaAktif->status_label === 'Selesai')
                <div class="rounded-2xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/40 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/60 text-amber-600 dark:text-amber-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 11 0 0118 0" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-amber-900 dark:text-amber-200">Agenda Rapat Telah Selesai</h3>
                    <p class="text-xs font-medium text-amber-700 dark:text-amber-300 leading-relaxed">Presensi untuk agenda rapat ini telah ditutup karena waktu pelaksanaan rapat telah berakhir.</p>
                </div>
            @elseif ($agendaAktif && $agendaAktif->status_label === 'Mendatang')
                <div class="rounded-2xl border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-950/40 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/60 text-blue-600 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-blue-900 dark:text-blue-200">Presensi Belum Dibuka (Terkunci)</h3>
                    <p class="text-xs font-medium text-blue-700 dark:text-blue-300 leading-relaxed">
                        Presensi tamu untuk agenda ini masih terkunci dan baru dapat diisi saat rapat dimulai pada pukul <strong>{{ substr((string) $agendaAktif->waktu, 0, 5) }} WIB</strong> ({{ $agendaAktif->tanggal?->translatedFormat('d F Y') }}).
                    </p>
                </div>
            @elseif ($agendaAktif && strtolower((string) ($agendaAktif->kategori_surat ?? '')) !== 'keluar')
                <div class="rounded-2xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/40 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/60 text-amber-600 dark:text-amber-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-amber-900 dark:text-amber-200">Presensi Tamu Tidak Tersedia</h3>
                    <p class="text-xs font-medium text-amber-700 dark:text-amber-300 leading-relaxed">
                        Agenda ini merupakan agenda <strong>{{ strtolower((string) ($agendaAktif->kategori_surat ?? '')) === 'internal' ? 'Surat Internal' : 'Surat Masuk' }}</strong> yang hanya diperuntukkan bagi Pegawai internal. Presensi tamu hanya tersedia untuk agenda <strong>Surat Keluar</strong>.
                    </p>
                </div>
            @elseif ($agendaAktif && $agendaAktif->isKuotaPenuh())
                <div class="rounded-2xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950/40 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/60 text-red-600 dark:text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-red-900 dark:text-red-200">Kuota Presensi Penuh</h3>
                    <p class="text-xs font-medium text-red-700 dark:text-red-300 leading-relaxed">Pendaftaran kehadiran tamu telah ditutup karena kuota maksimal peserta agenda ini telah terpenuhi.</p>
                </div>
            @elseif ($agendaAktif)
                <!-- WRAPPER FORM PRESENSI TAMU -->
                <div id="tamu-form-wrapper" class="space-y-6">
                    <!-- Live Real-Time Location Proof Card Box for Guest -->
                    <div id="tamu-location-box" class="rounded-2xl border border-emerald-200 dark:border-emerald-800/60 bg-emerald-50/40 dark:bg-emerald-950/20 p-4 space-y-3 shadow-2xs">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                                <span class="text-xs font-extrabold text-emerald-800 dark:text-emerald-300">Bukti Lokasi Presensi Tamu (Real-Time)</span>
                            </div>
                            <span id="tamu-time-badge" class="text-[10px] font-bold text-gray-500 dark:text-gray-400 bg-white/80 dark:bg-[#152420] px-2.5 py-0.5 rounded-full border border-gray-200/60 dark:border-[#233a34]">
                                Memuat waktu...
                            </span>
                        </div>

                        <!-- Real-Time Address Details -->
                        <div class="space-y-1">
                            <p id="tamu-address-text" class="text-xs font-bold text-gray-900 dark:text-white leading-snug">
                                Sedang melacak posisi & alamat GPS Anda...
                            </p>
                            <p id="tamu-region-text" class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">
                                📍 Wilayah: Mendeteksi...
                            </p>
                        </div>

                        <!-- Interactive Leaflet Mini-Map -->
                        <div id="tamu-map-container" class="relative rounded-xl overflow-hidden border border-emerald-200/80 dark:border-[#233a34] bg-gray-100 dark:bg-[#152420] h-36 w-full z-0 shadow-inner">
                            <div id="tamu-live-map" class="h-full w-full"></div>
                        </div>
                    </div>

                    <!-- Notifikasi Error Form Dinamis -->
                    <div id="tamu-error-alert" class="hidden rounded-2xl bg-red-50 dark:bg-red-950/50 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800 p-4 text-xs font-semibold space-y-1">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-bold">Mohon Periksa Kembali:</span>
                        </div>
                        <p id="tamu-error-text" class="text-[11px] ml-6"></p>
                    </div>

                    <form id="tamu-presensi-form" action="{{ route('publik.tamu.hadir') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <input type="hidden" name="id_agenda" value="{{ $agendaAktif->id_agenda }}">
                        <input type="hidden" name="lokasi_presensi" id="tamu-lokasi-presensi-input" value="">
                        <input type="hidden" name="foto_captured" id="tamu-foto-captured-input" value="">

                        <!-- 1. Foto / Swafoto (Live Capture & Fallback Upload) -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold text-gray-800 dark:text-gray-200">Foto Presensi / Swafoto *</label>
                                
                                <!-- Toggle Mode Button -->
                                <div class="inline-flex rounded-xl bg-gray-100 dark:bg-[#0f1c19] p-0.5 border border-gray-200/60 dark:border-[#284c43]">
                                    <button type="button" id="tab-btn-camera" onclick="switchPhotoMode('camera')" class="px-2.5 py-1 text-[10px] font-extrabold rounded-lg transition-all bg-white dark:bg-[#152420] text-emerald-700 dark:text-emerald-400 shadow-2xs cursor-pointer">
                                        📸 Kamera
                                    </button>
                                    <button type="button" id="tab-btn-upload" onclick="switchPhotoMode('upload')" class="px-2.5 py-1 text-[10px] font-bold rounded-lg transition-all text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white cursor-pointer">
                                        📁 Upload File
                                    </button>
                                </div>
                            </div>

                            <!-- OPSI A: LIVE CAMERA CAPTURE -->
                            <div id="camera-capture-container" class="space-y-2.5">
                                <div class="relative w-full rounded-2xl overflow-hidden aspect-[4/3] bg-gray-100 dark:bg-[#0f1c19] border-2 border-dashed border-gray-300 dark:border-[#284c43] flex items-center justify-center shadow-inner">
                                    <!-- Live Video Element (Default Hidden) -->
                                    <video id="tamu-live-video" class="hidden w-full h-full object-cover" autoplay muted playsinline style="transform: scaleX(-1);"></video>
                                    
                                    <!-- Live Preview Image Element -->
                                    <img id="tamu-live-preview" class="hidden absolute inset-0 w-full h-full object-cover" alt="Hasil Foto Swafoto" />
                                    
                                    <!-- Placeholder Awal Sebelum Kamera Dinyalakan -->
                                    <div id="camera-idle-placeholder" class="flex flex-col items-center justify-center p-5 text-center space-y-2 text-gray-500 dark:text-gray-400">
                                        <div class="w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mx-auto shadow-2xs">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-800 dark:text-gray-200">Swafoto Presensi Tamu</p>
                                            <p class="text-[10.5px] text-gray-400 dark:text-gray-500 mt-0.5">Klik tombol di bawah untuk meminta akses kamera dan mengambil foto swafoto.</p>
                                        </div>
                                    </div>

                                    <!-- Camera Loading Overlay -->
                                    <div id="camera-loading-overlay" class="hidden absolute inset-0 bg-gray-900/90 flex flex-col items-center justify-center text-white p-4 text-center z-10">
                                        <svg class="animate-spin h-6 w-6 text-emerald-400 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                        <p class="text-xs font-semibold">Menghubungkan ke kamera...</p>
                                    </div>

                                    <!-- Camera Error Overlay -->
                                    <div id="camera-error-overlay" class="hidden absolute inset-0 bg-red-950/95 flex flex-col items-center justify-center text-white p-5 text-center space-y-2 z-10">
                                        <div class="w-10 h-10 rounded-full bg-red-900/80 text-red-300 flex items-center justify-center mx-auto">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        </div>
                                        <p class="text-xs font-bold" id="camera-error-msg">Kamera tidak dapat diakses</p>
                                        <p class="text-[11px] text-gray-300">Silakan izinkan akses kamera di browser atau gunakan opsi Upload File.</p>
                                        <div class="flex gap-2 justify-center mt-1">
                                            <button type="button" onclick="startLiveCamera()" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition cursor-pointer">
                                                Coba Lagi
                                            </button>
                                            <button type="button" onclick="switchPhotoMode('upload')" class="px-3 py-1.5 rounded-xl bg-white text-red-900 text-xs font-extrabold shadow-sm transition hover:bg-gray-100 cursor-pointer">
                                                Upload File &rarr;
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Badge Konfirmasi Foto Berhasil Diambil -->
                                <div id="photo-taken-badge" class="hidden rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 p-2.5 text-center">
                                    <p class="text-xs font-extrabold text-emerald-700 dark:text-emerald-300 flex items-center justify-center gap-1.5">
                                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Foto swafoto berhasil diambil!</span>
                                    </p>
                                </div>

                                <!-- Camera Action Controls -->
                                <div class="flex items-center gap-2">
                                    <!-- Tombol 1: Buka Kamera (Saat Awal) -->
                                    <button type="button" id="btn-open-camera" onclick="startLiveCamera()" class="flex-1 py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span>Buka Kamera</span>
                                    </button>

                                    <!-- Tombol 2: Jepret / Ambil Foto (Saat Kamera Aktif) -->
                                    <button type="button" id="btn-snap-photo" onclick="captureLivePhoto()" class="hidden flex-1 py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span>Ambil Foto</span>
                                    </button>

                                    <!-- Tombol 3: Foto Ulang (Setelah Foto Diambil) -->
                                    <button type="button" id="btn-retake-photo" onclick="retakeLivePhoto()" class="hidden flex-1 py-2.5 px-4 rounded-xl border border-emerald-600 dark:border-emerald-500 bg-white dark:bg-[#152420] text-emerald-700 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 text-xs font-extrabold transition flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        <span>Ambil Ulang Foto</span>
                                    </button>
                                </div>
                            </div>

                            <!-- OPSI B: FILE UPLOAD FALLBACK -->
                            <div id="file-upload-container" class="hidden space-y-2">
                                <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 dark:border-[#284c43] rounded-2xl cursor-pointer bg-[#EAE8E1]/40 dark:bg-[#0f1c19] hover:bg-[#EAE8E1]/80 dark:hover:bg-[#152420] transition-all relative overflow-hidden group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4" id="upload-placeholder">
                                        <svg class="w-7 h-7 mb-1.5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-xs text-gray-700 dark:text-gray-200 font-bold">Pilih / Unggah Berkas Foto</p>
                                        <p class="text-[10px] text-gray-400 dark:text-gray-400 mt-0.5">PNG, JPG atau JPEG (Maks. 5MB)</p>
                                    </div>
                                    <img id="foto-preview" class="hidden absolute inset-0 w-full h-full object-cover rounded-2xl" alt="Preview Unggahan" />
                                    <input type="file" name="foto" id="foto-input" accept="image/*" class="hidden" onchange="previewUploadedImage(event)" />
                                </label>
                                <p class="text-[11px] text-gray-400 dark:text-gray-500 text-center">Gunakan opsi ini bila perangkat atau browser mengalami kendala saat mengakses kamera.</p>
                            </div>
                        </div>

                        <!-- 2. Nama Lengkap -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-800 dark:text-gray-200">Nama Lengkap *</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap" class="w-full bg-[#EAE8E1]/60 dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] focus:border-ijo-semitua dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#152420] text-xs rounded-2xl px-4 py-3.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                        </div>

                        <!-- 3. NIK (Nomer Induk Karyawan) -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-800 dark:text-gray-200">NIK (Nomor Induk Karyawan/Pegawai) *</label>
                            <input type="text" name="nik" value="{{ old('nik') }}" required pattern="[0-9]+" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Masukkan NIK/NIP karyawan" class="w-full bg-[#EAE8E1]/60 dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] focus:border-ijo-semitua dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#152420] text-xs rounded-2xl px-4 py-3.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                        </div>

                        <!-- 4. Jabatan -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-800 dark:text-gray-200">Jabatan *</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan') }}" required placeholder="Contoh: Staf IT / Kepala Bidang" class="w-full bg-[#EAE8E1]/60 dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] focus:border-ijo-semitua dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#152420] text-xs rounded-2xl px-4 py-3.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                        </div>

                        <!-- 5. No. HP / WhatsApp -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-800 dark:text-gray-200">No. HP / WhatsApp *</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" required pattern="[0-9]+" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="08xx-xxxx-xxxx" class="w-full bg-[#EAE8E1]/60 dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] focus:border-ijo-semitua dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#152420] text-xs rounded-2xl px-4 py-3.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                        </div>

                        <!-- 6. Asal Instansi -->
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-800 dark:text-gray-200">Instansi / Asal *</label>
                            <input type="text" name="asal_instansi" value="{{ old('asal_instansi') }}" required placeholder="Contoh: Dinas Pendidikan Kab. Bogor" class="w-full bg-[#EAE8E1]/60 dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] focus:border-ijo-semitua dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#152420] text-xs rounded-2xl px-4 py-3.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                        </div>

                        <div class="pt-4">
                            <button type="submit" id="btn-submit-tamu" class="w-full bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 text-white font-bold text-xs py-3.5 rounded-2xl transition-colors flex items-center justify-center space-x-2 shadow-xs cursor-pointer">
                                <span>Kirim Data Presensi</span>
                                <span>&rarr;</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- STATE: TELAH MENGISI FORM KEHADIRAN (HANYA UCAPAN & INFORMASI TEREKAM) -->
                <div id="tamu-success-state" class="hidden rounded-2xl bg-emerald-50/70 dark:bg-[#0f1c19] border border-emerald-200 dark:border-emerald-800/60 p-6 sm:p-8 text-center space-y-4 transition-all">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 dark:bg-emerald-900/60 text-emerald-600 dark:text-emerald-300 flex items-center justify-center mx-auto shadow-xs">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    
                    <div class="space-y-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-[10px] font-extrabold uppercase tracking-wider border border-emerald-200 dark:border-emerald-800">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Telah Mengisi Form Kehadiran</span>
                        </span>
                        
                        <h2 class="text-xl font-extrabold text-gray-900 dark:text-white pt-1">Presensi Telah Terekam</h2>
                        
                        <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed max-w-sm mx-auto">
                            Terima kasih, <strong id="success-nama" class="text-gray-900 dark:text-white">Tamu</strong>. Tanggapan dan data kehadiran Anda pada agenda <strong class="text-gray-900 dark:text-white">{{ $agendaAktif->nama_agenda }}</strong> telah berhasil terekam ke dalam sistem.
                        </p>
                    </div>
                </div>
            @else
                <div class="rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-gray-100 dark:border-[#233a34] p-5 text-center">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Agenda belum tersedia</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Tambahkan agenda di admin terlebih dahulu sebelum mengisi daftar hadir tamu.</p>
                </div>
            @endif
        </div>
    </main>
    @include('publik.layout.footer')

    <!-- Script Live Camera Capture & Fallback Upload & GPS Tracking -->
    <script>
        let currentPhotoMode = 'camera';
        let cameraStream = null;

        function switchPhotoMode(mode) {
            currentPhotoMode = mode;
            const cameraContainer = document.getElementById('camera-capture-container');
            const uploadContainer = document.getElementById('file-upload-container');
            const tabBtnCamera = document.getElementById('tab-btn-camera');
            const tabBtnUpload = document.getElementById('tab-btn-upload');

            if (mode === 'camera') {
                cameraContainer.classList.remove('hidden');
                uploadContainer.classList.add('hidden');

                tabBtnCamera.className = "px-2.5 py-1 text-[10px] font-extrabold rounded-lg transition-all bg-white dark:bg-[#152420] text-emerald-700 dark:text-emerald-400 shadow-2xs cursor-pointer";
                tabBtnUpload.className = "px-2.5 py-1 text-[10px] font-bold rounded-lg transition-all text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white cursor-pointer";
            } else {
                cameraContainer.classList.add('hidden');
                uploadContainer.classList.remove('hidden');

                tabBtnUpload.className = "px-2.5 py-1 text-[10px] font-extrabold rounded-lg transition-all bg-white dark:bg-[#152420] text-emerald-700 dark:text-emerald-400 shadow-2xs cursor-pointer";
                tabBtnCamera.className = "px-2.5 py-1 text-[10px] font-bold rounded-lg transition-all text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white cursor-pointer";

                stopLiveCamera();
            }
        }

        async function startLiveCamera() {
            const video = document.getElementById('tamu-live-video');
            const placeholder = document.getElementById('camera-idle-placeholder');
            const preview = document.getElementById('tamu-live-preview');
            const badge = document.getElementById('photo-taken-badge');
            const loadingOverlay = document.getElementById('camera-loading-overlay');
            const errorOverlay = document.getElementById('camera-error-overlay');
            const errorMsg = document.getElementById('camera-error-msg');
            const btnOpen = document.getElementById('btn-open-camera');
            const btnSnap = document.getElementById('btn-snap-photo');
            const btnRetake = document.getElementById('btn-retake-photo');

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                if (loadingOverlay) loadingOverlay.classList.add('hidden');
                if (errorOverlay) errorOverlay.classList.remove('hidden');
                if (errorMsg) errorMsg.textContent = "Browser Anda tidak mendukung fitur akses kamera langsung.";
                return;
            }

            try {
                if (loadingOverlay) loadingOverlay.classList.remove('hidden');
                if (errorOverlay) errorOverlay.classList.add('hidden');
                if (placeholder) placeholder.classList.add('hidden');
                if (preview) preview.classList.add('hidden');
                if (badge) badge.classList.add('hidden');

                if (cameraStream) {
                    cameraStream.getTracks().forEach(t => t.stop());
                    cameraStream = null;
                }

                cameraStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "user",
                        width: { ideal: 640 },
                        height: { ideal: 480 }
                    },
                    audio: false
                });

                video.srcObject = cameraStream;
                video.classList.remove('hidden');
                video.onloadedmetadata = () => {
                    if (loadingOverlay) loadingOverlay.classList.add('hidden');
                    if (btnOpen) btnOpen.classList.add('hidden');
                    if (btnSnap) btnSnap.classList.remove('hidden');
                    if (btnRetake) btnRetake.classList.add('hidden');
                };
            } catch (err) {
                console.error("Camera error:", err);
                if (loadingOverlay) loadingOverlay.classList.add('hidden');
                if (errorOverlay) errorOverlay.classList.remove('hidden');
                let message = "Kamera tidak dapat diakses.";
                if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                    message = "Izin akses kamera ditolak oleh browser. Silakan berikan izin akses kamera pada peramban Anda.";
                } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
                    message = "Perangkat kamera tidak ditemukan pada perangkat ini.";
                }
                if (errorMsg) errorMsg.textContent = message;
            }
        }

        function stopLiveCamera() {
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
                cameraStream = null;
            }
        }

        function captureLivePhoto() {
            const video = document.getElementById('tamu-live-video');
            const preview = document.getElementById('tamu-live-preview');
            const btnSnap = document.getElementById('btn-snap-photo');
            const btnRetake = document.getElementById('btn-retake-photo');
            const btnOpen = document.getElementById('btn-open-camera');
            const badge = document.getElementById('photo-taken-badge');
            const inputCaptured = document.getElementById('tamu-foto-captured-input');

            if (!video || !cameraStream) return;

            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth || 640;
            canvas.height = video.videoHeight || 480;
            const ctx = canvas.getContext('2d');

            // Mirror capture agar swafoto natural
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            const dataUrl = canvas.toDataURL('image/jpeg', 0.88);
            inputCaptured.value = dataUrl;

            preview.src = dataUrl;
            preview.classList.remove('hidden');
            video.classList.add('hidden');

            // Matikan stream kamera setelah foto didapatkan
            stopLiveCamera();

            if (btnSnap) btnSnap.classList.add('hidden');
            if (btnOpen) btnOpen.classList.add('hidden');
            if (btnRetake) btnRetake.classList.remove('hidden');
            if (badge) badge.classList.remove('hidden');
        }

        function retakeLivePhoto() {
            const inputCaptured = document.getElementById('tamu-foto-captured-input');
            const preview = document.getElementById('tamu-live-preview');
            const badge = document.getElementById('photo-taken-badge');

            inputCaptured.value = "";
            preview.src = "";
            preview.classList.add('hidden');
            if (badge) badge.classList.add('hidden');

            startLiveCamera();
        }

        function previewUploadedImage(event) {
            const input = event.target;
            const preview = document.getElementById('foto-preview');
            const placeholder = document.getElementById('upload-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('opacity-0');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        /* ========================================================
           TAMU LIVE LOCATION & MAP SCRIPT
        ======================================================== */
        let tamuMap = null;
        let tamuMarker = null;
        let tamuCircle = null;

        async function fetchTamuReadableAddress(lat, lng) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
                    headers: { 'Accept-Language': 'id-ID,id;q=0.9,en;q=0.8' }
                });
                if (response.ok) {
                    const data = await response.json();
                    const addr = data.address || {};
                    const road = addr.road || addr.street || addr.neighbourhood || addr.suburb || addr.village || addr.city_district || '';
                    const district = addr.city_district || addr.district || addr.suburb || addr.town || addr.village || '';
                    const city = addr.city || addr.regency || addr.county || 'Kabupaten Bogor';
                    const state = addr.state || 'Jawa Barat';
                    
                    const fullAddress = data.display_name ? data.display_name : [road, district, city, state].filter(Boolean).join(', ');
                    const regionSummary = [district, city, state].filter(Boolean).join(', ');

                    return {
                        full: fullAddress,
                        region: regionSummary || "Kabupaten Bogor, Jawa Barat"
                    };
                }
            } catch (e) {
                console.warn("Nominatim reverse geocode error:", e);
            }

            try {
                const res = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=id`);
                if (res.ok) {
                    const data = await res.json();
                    const full = [data.locality, data.city, data.principalSubdivision, data.countryName].filter(Boolean).join(', ');
                    return {
                        full: full || "Kabupaten Bogor, Jawa Barat",
                        region: [data.city, data.principalSubdivision].filter(Boolean).join(', ') || "Kabupaten Bogor"
                    };
                }
            } catch (e) {}

            return {
                full: "Area Kantor / Lokasi Kegiatan, Kabupaten Bogor, Jawa Barat",
                region: "Kabupaten Bogor, Jawa Barat"
            };
        }

        function initOrUpdateTamuMap(lat, lng, accuracy = 25) {
            const mapContainer = document.getElementById('tamu-map-container');
            if (mapContainer) mapContainer.classList.remove('hidden');

            if (!tamuMap) {
                tamuMap = L.map('tamu-live-map', {
                    zoomControl: false,
                    attributionControl: false
                }).setView([lat, lng], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }).addTo(tamuMap);

                const pulseIcon = L.divIcon({
                    className: 'custom-live-marker',
                    iconSize: [22, 22],
                    iconAnchor: [11, 11]
                });

                tamuMarker = L.marker([lat, lng], { icon: pulseIcon }).addTo(tamuMap);
                tamuMarker.bindPopup("<b>📍 Lokasi Presensi Tamu</b>").openPopup();

                tamuCircle = L.circle([lat, lng], {
                    radius: accuracy || 25,
                    color: '#10b981',
                    fillColor: '#10b981',
                    fillOpacity: 0.15,
                    weight: 1
                }).addTo(tamuMap);
            } else {
                tamuMap.setView([lat, lng], 16);
                if (tamuMarker) tamuMarker.setLatLng([lat, lng]);
                if (tamuCircle) {
                    tamuCircle.setLatLng([lat, lng]);
                    tamuCircle.setRadius(accuracy || 25);
                }
            }

            setTimeout(() => {
                if (tamuMap) tamuMap.invalidateSize();
            }, 250);
        }

        async function updateTamuLiveLocationUI(coords) {
            const addressText = document.getElementById('tamu-address-text');
            const regionText = document.getElementById('tamu-region-text');
            const timeBadge = document.getElementById('tamu-time-badge');
            const inputLokasi = document.getElementById('tamu-lokasi-presensi-input');

            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
            if (timeBadge) timeBadge.textContent = timeString;

            initOrUpdateTamuMap(coords.latitude, coords.longitude, coords.accuracy);

            const addressData = await fetchTamuReadableAddress(coords.latitude, coords.longitude);
            if (addressText) addressText.textContent = addressData.full;
            if (regionText) regionText.textContent = `📍 ${addressData.region}`;
            if (inputLokasi) inputLokasi.value = addressData.full;
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    async function (position) {
                        const coords = {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude,
                            accuracy: position.coords.accuracy
                        };
                        await updateTamuLiveLocationUI(coords);
                    },
                    function (error) {
                        const addressText = document.getElementById('tamu-address-text');
                        if (addressText) addressText.textContent = "Izin lokasi diperlukan untuk memverifikasi lokasi kehadiran.";
                    },
                    { enableHighAccuracy: true, timeout: 12000, maximumAge: 0 }
                );
            }

            /* ========================================================
               FORM PRESENSI TAMU AJAX SUBMIT & REDIRECT
            ======================================================== */
            const presensiForm = document.getElementById('tamu-presensi-form');
            if (presensiForm) {
                presensiForm.addEventListener('submit', async function (e) {
                    e.preventDefault();

                    const errorAlert = document.getElementById('tamu-error-alert');
                    const errorAlertText = document.getElementById('tamu-error-text');
                    const btnSubmit = document.getElementById('btn-submit-tamu');
                    const capturedInput = document.getElementById('tamu-foto-captured-input');
                    const fileInput = document.getElementById('foto-input');

                    if (errorAlert) errorAlert.classList.add('hidden');

                    // Validasi foto (kamera atau upload)
                    const hasCaptured = capturedInput && capturedInput.value && capturedInput.value.length > 50;
                    const hasFile = fileInput && fileInput.files && fileInput.files.length > 0;

                    if (!hasCaptured && !hasFile) {
                        if (errorAlert && errorAlertText) {
                            errorAlertText.textContent = "Silakan ambil foto swafoto melalui kamera atau unggah file foto terlebih dahulu.";
                            errorAlert.classList.remove('hidden');
                            errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        } else {
                            alert("Silakan ambil foto swafoto atau upload file foto terlebih dahulu.");
                        }
                        return;
                    }

                    btnSubmit.disabled = true;
                    btnSubmit.innerHTML = `<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg> <span>Menyimpan Kehadiran...</span>`;

                    try {
                        const formData = new FormData(presensiForm);
                        const response = await fetch(presensiForm.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            stopLiveCamera();

                            // Sembunyikan form dan tampilkan status telah mengisi (seperti Google Form)
                            const wrapper = document.getElementById('tamu-form-wrapper');
                            const successCard = document.getElementById('tamu-success-state');
                            const nameEl = document.getElementById('success-nama');

                            if (nameEl) nameEl.textContent = result.nama || presensiForm.nama.value || 'Tamu';
                            if (wrapper) wrapper.classList.add('hidden');
                            if (successCard) {
                                successCard.classList.remove('hidden');
                                successCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        } else {
                            btnSubmit.disabled = false;
                            btnSubmit.innerHTML = `<span>Kirim Data Presensi</span><span>&rarr;</span>`;
                            if (errorAlert && errorAlertText) {
                                errorAlertText.textContent = result.message || "Terjadi kesalahan saat menyimpan data presensi.";
                                errorAlert.classList.remove('hidden');
                                errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            } else {
                                alert(result.message || "Gagal menyimpan presensi.");
                            }
                        }
                    } catch (err) {
                        console.error("Presensi form error:", err);
                        btnSubmit.disabled = false;
                        btnSubmit.innerHTML = `<span>Kirim Data Presensi</span><span>&rarr;</span>`;
                        if (errorAlert && errorAlertText) {
                            errorAlertText.textContent = "Gagal terhubung ke server. Silakan coba lagi.";
                            errorAlert.classList.remove('hidden');
                        } else {
                            alert("Gagal terhubung ke server.");
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
