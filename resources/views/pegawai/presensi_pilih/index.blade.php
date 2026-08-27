<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Metode Presensi Pegawai - SIRAPI</title>
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
            <a href="{{ $agendaAktif ? route('publik.agenda.detail', $agendaAktif->id_agenda) : route('publik.agenda') }}" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-gray-100 dark:bg-[#0f1c19] hover:bg-gray-200 dark:hover:bg-white/10 flex items-center justify-center text-gray-500 dark:text-gray-300 font-bold transition-colors cursor-pointer" title="Kembali">
                &larr;
            </a>

            <div class="space-y-1">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">Metode Presensi</h1>
                <p class="text-xs text-gray-500 dark:text-gray-300 font-medium">Pegawai &bull; {{ $agendaAktif?->nama_agenda ?? 'Belum ada agenda tersedia' }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-400">{{ substr((string) $agendaAktif?->waktu, 0, 5) ?: '-' }} WIB &bull; {{ $agendaAktif?->lokasi ?? '-' }}</p>
                @if (strtolower((string) ($agendaAktif?->kategori_surat ?? '')) === 'masuk' && !empty($agendaAktif?->ditugaskan))
                    <div class="mt-2 inline-flex items-center gap-1.5 rounded-lg bg-ijo-sangatmuda dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] px-3 py-1 text-xs font-bold text-ijo-tua dark:text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <span>Ditugaskan: {{ $agendaAktif->ditugaskan }}</span>
                    </div>
                @endif
            </div>

            <hr class="border-gray-100 dark:border-[#233a34]">

            @if ($agendaAktif && $agendaAktif->status_label === 'Selesai')
                <div class="rounded-2xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/40 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/60 text-amber-600 dark:text-amber-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 11 0 0118 0" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-amber-900 dark:text-amber-200">Agenda Rapat Telah Selesai</h3>
                    <p class="text-xs font-medium text-amber-700 dark:text-amber-300 leading-relaxed">Presensi untuk agenda rapat ini telah ditutup karena waktu pelaksanaan rapat telah berakhir.</p>
                </div>
            @elseif ($agendaAktif && $agendaAktif->isKuotaPenuh())
                <div class="rounded-2xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950/40 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/60 text-red-600 dark:text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-red-900 dark:text-red-200">Kuota Presensi Penuh</h3>
                    <p class="text-xs font-medium text-red-700 dark:text-red-300 leading-relaxed">Presensi untuk agenda ini telah ditutup karena kuota maksimal peserta telah terpenuhi.</p>
                </div>
            @elseif ($agendaAktif)
                <!-- Card Verifikasi Lokasi Presensi (Live Real-Time Tracking) -->
                <div id="location-card" class="rounded-3xl border border-gray-200/90 dark:border-[#284c43] bg-[#f8faf9] dark:bg-[#0f1c19] p-4 sm:p-5 space-y-4 transition-all duration-300 shadow-xs">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center space-x-3">
                            <div id="location-icon-box" class="w-11 h-11 rounded-2xl bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 transition-colors shadow-2xs">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">Live Tracking Lokasi Presensi</h3>
                                <p class="text-[10px] sm:text-[11px] text-gray-500 dark:text-gray-400">Lacak lokasi tempat Anda secara real-time</p>
                            </div>
                        </div>

                        <span id="location-badge" class="inline-flex items-center gap-1.5 text-[10px] font-extrabold px-3 py-1 rounded-full bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60 shrink-0">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            <span id="badge-text">Belum Terlacak</span>
                        </span>
                    </div>

                    <!-- Interactive Live Mini-Map Container -->
                    <div id="map-container" class="hidden relative rounded-2xl overflow-hidden border border-gray-200 dark:border-[#233a34] bg-gray-100 dark:bg-[#152420] shadow-inner h-44 w-full z-0">
                        <div id="live-map" class="h-full w-full"></div>
                    </div>

                    <!-- Status Detail Box & Readable Address -->
                    <div id="location-info-box" class="rounded-2xl bg-white dark:bg-[#152420] border border-gray-200/70 dark:border-[#233a34] p-3.5 space-y-2 text-xs text-gray-600 dark:text-gray-300">
                        <div class="flex items-center justify-between text-gray-500 dark:text-gray-400 text-[11px]">
                            <span>Lokasi Agenda:</span>
                            <span class="font-bold text-gray-800 dark:text-gray-200 text-right">{{ $agendaAktif?->lokasi ?? 'Kantor / Ruang Rapat' }}</span>
                        </div>

                        <div id="untracked-msg-container" class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">
                            Klik tombol <strong>"Lacak Lokasi Real-Time"</strong> untuk mendeteksi alamat dan keberadaan posisi Anda secara langsung. Opsi presensi akan otomatis terbuka setelah lokasi terverifikasi.
                        </div>

                        <!-- Real-time Address Details (Muncul saat lokasi terlacak) -->
                        <div id="address-details" class="hidden space-y-2 pt-1 border-t border-gray-100 dark:border-[#233a34]">
                            <div class="space-y-1">
                                <div class="flex items-center justify-between text-[10px] font-bold text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        Alamat Lokasi Anda (Real-Time)
                                    </span>
                                    <span id="update-time" class="text-[10px] text-gray-400 font-normal">Baru saja</span>
                                </div>
                                <p id="realtime-address-text" class="text-xs font-bold text-gray-900 dark:text-white leading-snug">
                                    Sedang memuat alamat lengkap...
                                </p>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-1 text-[10px] text-gray-500 dark:text-gray-400 pt-1">
                                <span id="region-text" class="font-medium">📍 Wilayah: Memuat...</span>
                                <span id="accuracy-badge" class="inline-flex items-center gap-1 text-emerald-700 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded-md">
                                    <span>Akurat</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div>
                        <button type="button" id="btn-track-location" onclick="startRealtimeTracking()" class="w-full h-11 rounded-xl bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white text-xs font-bold transition-all shadow-xs flex items-center justify-center space-x-2 cursor-pointer active:scale-[0.99]">
                            <svg id="track-btn-icon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span id="track-btn-text">📍 Lacak Lokasi Real-Time Sekarang</span>
                        </button>
                    </div>
                </div>

                <!-- Pilihan Metode Presensi (Terkunci Sebelum Lokasi Valid) -->
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold text-gray-800 dark:text-gray-200">Pilih metode kehadiran</h3>
                        <span id="methods-status-tag" class="text-[10px] font-bold text-gray-400 dark:text-gray-500 flex items-center gap-1">
                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <span>Terkunci</span>
                        </span>
                    </div>

                    <div id="methods-list" class="grid grid-cols-1 gap-3.5">
                        <!-- Opsi 1: Scan Wajah -->
                        <a id="btn-scan-wajah" href="{{ route('publik.presensi.pegawai.wajah', $routeParams) }}" class="method-option pointer-events-none opacity-40 grayscale cursor-not-allowed border-2 border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] rounded-2xl p-5 text-center flex items-center space-x-4 transition-all duration-300 relative group overflow-hidden select-none">
                            <div class="w-14 h-14 rounded-full bg-gray-200 dark:bg-[#152420] text-gray-400 dark:text-gray-500 method-icon-bg flex items-center justify-center text-2xl shrink-0 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                            </div>
                            <div class="text-left flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white">Scan Wajah (Otomatis)</h4>
                                    <span class="lock-indicator text-[10px] font-bold text-gray-400 dark:text-gray-500 bg-gray-200/80 dark:bg-gray-800 px-2 py-0.5 rounded-md flex items-center gap-1">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                        <span>Terkunci</span>
                                    </span>
                                </div>
                                <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 leading-tight">Gunakan kamera untuk absen cepat</p>
                            </div>
                        </a>

                        <!-- Opsi 2: Login Manual -->
                        <a id="btn-login-manual" href="{{ route('pegawai.login', $routeParams) }}" class="method-option pointer-events-none opacity-40 grayscale cursor-not-allowed border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] rounded-2xl p-5 text-center flex items-center space-x-4 transition-all duration-300 relative group overflow-hidden select-none">
                            <div class="w-14 h-14 rounded-full bg-gray-200 dark:bg-[#152420] text-gray-400 dark:text-gray-500 method-icon-bg flex items-center justify-center text-xl shrink-0 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            </div>
                            <div class="text-left flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-bold text-sm text-gray-900 dark:text-white group-hover:text-ijo-tua dark:group-hover:text-emerald-400 transition-colors">Login Manual</h4>
                                    <span class="lock-indicator text-[10px] font-bold text-gray-400 dark:text-gray-500 bg-gray-200/80 dark:bg-gray-800 px-2 py-0.5 rounded-md flex items-center gap-1">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                        <span>Terkunci</span>
                                    </span>
                                </div>
                                <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 leading-tight">Masuk dengan email dan password</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            <div class="text-center mt-6">
                <a href="{{ $agendaAktif ? route('publik.agenda.detail', $agendaAktif->id_agenda) : route('publik.agenda') }}" class="text-xs font-semibold text-gray-400 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">Kembali ke Detail Agenda</a>
            </div>
        </div>
    </main>

    @include('publik.layout.footer')

    <!-- Script Live Real-Time Location Tracking, Map & Reverse Geocoding -->
    <script>
        const agendaId = "{{ $agendaAktif?->id_agenda ?? 0 }}";
        const sessionKey = 'presensi_loc_verified_' + agendaId;
        let map = null;
        let userMarker = null;
        let accuracyCircle = null;
        let watchId = null;

        async function fetchReadableAddress(lat, lng) {
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

            // Fallback: BigDataCloud Reverse Geocoding API
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

        function initOrUpdateMap(lat, lng, accuracy = 20) {
            const mapContainer = document.getElementById('map-container');
            if (mapContainer) mapContainer.classList.remove('hidden');

            if (!map) {
                map = L.map('live-map', {
                    zoomControl: false,
                    attributionControl: false
                }).setView([lat, lng], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }).addTo(map);

                // Custom glowing pulse icon
                const pulseIcon = L.divIcon({
                    className: 'custom-live-marker',
                    iconSize: [22, 22],
                    iconAnchor: [11, 11]
                });

                userMarker = L.marker([lat, lng], { icon: pulseIcon }).addTo(map);
                userMarker.bindPopup("<b>📍 Lokasi Presensi Anda</b>").openPopup();

                accuracyCircle = L.circle([lat, lng], {
                    radius: accuracy || 25,
                    color: '#10b981',
                    fillColor: '#10b981',
                    fillOpacity: 0.15,
                    weight: 1
                }).addTo(map);
            } else {
                map.setView([lat, lng], 16);
                if (userMarker) userMarker.setLatLng([lat, lng]);
                if (accuracyCircle) {
                    accuracyCircle.setLatLng([lat, lng]);
                    accuracyCircle.setRadius(accuracy || 25);
                }
            }

            setTimeout(() => {
                if (map) map.invalidateSize();
            }, 200);
        }

        async function updateUIRealtimeState(isVerified, coords = null, addressData = null, errorMsg = null) {
            const card = document.getElementById('location-card');
            const iconBox = document.getElementById('location-icon-box');
            const badge = document.getElementById('location-badge');
            const badgeText = document.getElementById('badge-text');
            const untrackedMsg = document.getElementById('untracked-msg-container');
            const addressDetails = document.getElementById('address-details');
            const addressText = document.getElementById('realtime-address-text');
            const regionText = document.getElementById('region-text');
            const updateTime = document.getElementById('update-time');
            const btn = document.getElementById('btn-track-location');
            const btnText = document.getElementById('track-btn-text');
            const btnIcon = document.getElementById('track-btn-icon');
            const methodsStatus = document.getElementById('methods-status-tag');
            const btnScan = document.getElementById('btn-scan-wajah');
            const btnLogin = document.getElementById('btn-login-manual');
            const lockIndicators = document.querySelectorAll('.lock-indicator');

            if (!card || !btn) return;

            if (isVerified && coords) {
                // Card UI
                card.className = "rounded-3xl border border-emerald-300 dark:border-emerald-700/60 bg-emerald-50/40 dark:bg-emerald-950/20 p-4 sm:p-5 space-y-4 transition-all duration-300 shadow-xs";
                iconBox.className = "w-11 h-11 rounded-2xl bg-emerald-100 dark:bg-emerald-900/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 transition-colors shadow-2xs";
                badge.className = "inline-flex items-center gap-1.5 text-[10px] font-extrabold px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700 shrink-0";
                badge.innerHTML = '<span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span><span>Live Terlacak</span>';
                
                if (untrackedMsg) untrackedMsg.classList.add('hidden');
                if (addressDetails) addressDetails.classList.remove('hidden');

                if (addressData) {
                    if (addressText) addressText.textContent = addressData.full;
                    if (regionText) regionText.textContent = `📍 ${addressData.region}`;
                }

                const now = new Date();
                const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
                if (updateTime) updateTime.textContent = timeString;

                if (btn.parentElement) btn.parentElement.classList.add('hidden');

                // Render or update Interactive Map
                initOrUpdateMap(coords.latitude, coords.longitude, coords.accuracy);

                // Methods unlock
                methodsStatus.className = "text-[10px] font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1";
                methodsStatus.innerHTML = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg><span>Terbuka</span>';

                // Button Scan Wajah
                btnScan.className = "method-option border-2 border-ijo-tua dark:border-emerald-500 bg-ijo-sangatmuda/50 dark:bg-[#0f1c19] rounded-2xl p-5 text-center flex items-center space-x-4 cursor-pointer hover:shadow-md hover:scale-[1.01] transition-all duration-300 relative group";
                const scanIcon = btnScan.querySelector('.method-icon-bg');
                if (scanIcon) scanIcon.className = "w-14 h-14 rounded-full bg-ijo-tua dark:bg-[#107050] text-white flex items-center justify-center text-2xl shrink-0 shadow-xs border border-transparent dark:border-[#10b981]/30";

                // Button Login Manual
                btnLogin.className = "method-option border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] hover:border-ijo-tua dark:hover:border-emerald-500 rounded-2xl p-5 text-center flex items-center space-x-4 cursor-pointer hover:shadow-md hover:scale-[1.01] transition-all duration-300 group";
                const loginIcon = btnLogin.querySelector('.method-icon-bg');
                if (loginIcon) loginIcon.className = "w-14 h-14 rounded-full bg-gray-100 dark:bg-[#152420] text-gray-500 dark:text-gray-400 group-hover:bg-ijo-tua dark:group-hover:bg-[#107050] group-hover:text-white transition-colors flex items-center justify-center text-xl shrink-0";

                // Lock Badges
                lockIndicators.forEach(el => {
                    el.className = "lock-indicator text-[10px] font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-100 dark:bg-emerald-950/80 border border-emerald-200 dark:border-emerald-800 px-2 py-0.5 rounded-md flex items-center gap-1";
                    el.innerHTML = '<svg class="w-2.5 h-2.5 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg><span>Siap</span>';
                });
            } else {
                if (errorMsg) {
                    card.className = "rounded-3xl border border-red-300 dark:border-red-800/80 bg-red-50/50 dark:bg-red-950/20 p-4 sm:p-5 space-y-4 transition-all duration-300";
                    iconBox.className = "w-11 h-11 rounded-2xl bg-red-100 dark:bg-red-900/60 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0 transition-colors";
                    badge.className = "inline-flex items-center gap-1.5 text-[10px] font-extrabold px-3 py-1 rounded-full bg-red-100 dark:bg-red-950/80 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800 shrink-0";
                    badge.innerHTML = '<span class="w-2 h-2 rounded-full bg-red-500"></span><span>Gagal</span>';
                    
                    if (untrackedMsg) {
                        untrackedMsg.classList.remove('hidden');
                        untrackedMsg.innerHTML = `<span class="text-red-600 dark:text-red-400 font-semibold">⚠️ ${errorMsg}</span>`;
                    }

                    btn.className = "w-full h-11 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-xs flex items-center justify-center space-x-2 cursor-pointer";
                    btnText.textContent = "🔄 Coba Lacak Ulang Lokasi";
                }
            }
        }

        async function processPosition(position) {
            const coords = {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                accuracy: position.coords.accuracy
            };

            const addressData = await fetchReadableAddress(coords.latitude, coords.longitude);

            sessionStorage.setItem(sessionKey, JSON.stringify({
                verified: true,
                coords: coords,
                addressData: addressData,
                time: Date.now()
            }));

            // Simpan teks alamat GPS nyata untuk dikirim saat presensi
            sessionStorage.setItem('presensi_address_' + agendaId, addressData.full);
            sessionStorage.setItem('presensi_address_global', addressData.full);
            localStorage.setItem('presensi_address_latest', addressData.full);

            updateUIRealtimeState(true, coords, addressData);
        }

        function startRealtimeTracking() {
            const btn = document.getElementById('btn-track-location');
            const btnText = document.getElementById('track-btn-text');
            const untrackedMsg = document.getElementById('untracked-msg-container');

            if (!navigator.geolocation) {
                updateUIRealtimeState(false, null, null, "Browser Anda tidak mendukung fitur pelacakan lokasi Geolocation.");
                return;
            }

            btn.disabled = true;
            btnText.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg> Melacak lokasi real-time...';
            if (untrackedMsg) untrackedMsg.textContent = "Sedang mengambil data lokasi GPS & alamat Anda saat ini...";

            navigator.geolocation.getCurrentPosition(
                async function (position) {
                    btn.disabled = false;
                    await processPosition(position);

                    // Also start watching position for live tracking if moved
                    if (!watchId && navigator.geolocation.watchPosition) {
                        watchId = navigator.geolocation.watchPosition(
                            function(pos) { processPosition(pos); },
                            function(err) { console.warn("Watch position error:", err); },
                            { enableHighAccuracy: true, maximumAge: 5000 }
                        );
                    }
                },
                function (error) {
                    btn.disabled = false;
                    let message = "Gagal mendapatkan lokasi.";
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            message = "Izin akses lokasi ditolak. Silakan izinkan akses lokasi (GPS) pada pengaturan browser Anda.";
                            break;
                        case error.POSITION_UNAVAILABLE:
                            message = "Informasi lokasi tidak tersedia pada perangkat Anda saat ini.";
                            break;
                        case error.TIMEOUT:
                            message = "Waktu permintaan lokasi habis. Pastikan sinyal GPS perangkat aktif.";
                            break;
                    }
                    updateUIRealtimeState(false, null, null, message);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 12000,
                    maximumAge: 0
                }
            );
        }

        document.addEventListener('DOMContentLoaded', function () {
            const saved = sessionStorage.getItem(sessionKey);
            if (saved) {
                try {
                    const data = JSON.parse(saved);
                    // Validasi tersimpan selama 1 jam
                    if (data && data.verified && (Date.now() - data.time < 3600000)) {
                        updateUIRealtimeState(true, data.coords, data.addressData);
                    }
                } catch (e) {
                    sessionStorage.removeItem(sessionKey);
                }
            }
        });
    </script>
</body>
</html>
