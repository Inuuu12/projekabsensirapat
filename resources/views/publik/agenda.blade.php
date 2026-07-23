<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Agenda Kegiatan - Diskominfo Kabupaten Bogor</title>
    <!-- Tailwind CSS CDN -->
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

    <!-- Memanggil Navbar Publik -->
    @include('publik.layout_publik.navbarpublik') 

    <main class="flex-grow container mx-auto px-4 md:px-12 py-8 space-y-8 max-w-7xl">

        <!-- Breadcrumb & Header Section -->
        <div class="space-y-4">
            <nav class="text-xs text-gray-500 flex items-center space-x-2">
                <a href="/publik" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 font-semibold">Agenda</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Semua Agenda Kegiatan</h1>
                    <p class="text-xs text-gray-500 mt-1">Jadwal kegiatan Diskominfo Kabupaten Bogor minggu ini</p>
                </div>

                <!-- Input Search & Date Picker Picker -->
                <div class="flex items-center space-x-3">
                    <div class="relative w-full md:w-64">
                        <input type="text" placeholder="Pencarian" class="w-full bg-gray-200/70 border-none rounded-full py-2 pl-9 pr-4 text-xs focus:ring-2 focus:ring-ijo-tua focus:outline-none">
                        <span class="absolute left-3 top-2.5 text-gray-500 text-xs">🔍</span>
                    </div>
                    <button class="bg-white border border-gray-200 rounded-full px-4 py-2 text-xs text-gray-700 flex items-center space-x-2 shadow-sm shrink-0">
                        <span>📅</span>
                        <div class="text-left">
                            <span class="block text-[9px] text-gray-400 -mb-1">Lihat tanggal</span>
                            <span class="font-bold">13 Juli 2026</span>
                        </div>
                        <span class="text-[10px]">▼</span>
                    </button>
                </div>
            </div>

            <!-- Tab Filter Status -->
            <div class="flex flex-wrap gap-2 text-xs font-medium pt-2">
                <button class="bg-ijo-tua text-white px-5 py-1.5 rounded-full font-bold">Semua</button>
                <button class="bg-gray-200/80 text-gray-700 hover:bg-gray-300 px-5 py-1.5 rounded-full transition-colors">Berlangsung</button>
                <button class="bg-gray-200/80 text-gray-700 hover:bg-gray-300 px-5 py-1.5 rounded-full transition-colors">Akan Datang</button>
                <button class="bg-gray-200/80 text-gray-700 hover:bg-gray-300 px-5 py-1.5 rounded-full transition-colors">Selesai</button>
            </div>
        </div>

        <!-- LIST AGENDA GROUPED BY DATE -->
        <div class="space-y-8">

            <!-- GROUP 1: Selesai — Senin, 13 Juli 2026 -->
            <div class="space-y-3">
                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wide">Selesai &mdash; Senin, 13 Juli 2026</h3>

                <!-- Card 1 -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-gray-200 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-100 rounded-xl px-4 py-3 text-center shrink-0 w-24">
                            <p class="text-xs font-bold text-gray-800">06.00</p>
                            <p class="text-[10px] text-gray-400">- 07.00</p>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-gray-900">Apel Pagi & Briefing Harian</h4>
                            <p class="text-xs text-gray-500">📍 Halaman Kantor Diskominfo</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between md:justify-end space-x-4 shrink-0">
                        <div class="text-right">
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-3 py-1 rounded-full inline-block">✓ Selesai</span>
                            <p class="text-[10px] text-gray-400 mt-1">20 Peserta</p>
                        </div>
                        <a href="/publik/agenda/detail" class="border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-semibold px-4 py-1.5 rounded-full transition-colors">
                            Lihat Ringkasan &rsaquo;
                        </a>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-gray-200 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-100 rounded-xl px-4 py-3 text-center shrink-0 w-24">
                            <p class="text-xs font-bold text-gray-800">07.00</p>
                            <p class="text-[10px] text-gray-400">- 07.30</p>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-gray-900">Rapat Persiapan Sosialisasi Perubahan Iklim</h4>
                            <p class="text-xs text-gray-500">📍 Ruang Rapat Kecil, Diskominfo</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between md:justify-end space-x-4 shrink-0">
                        <div class="text-right">
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-3 py-1 rounded-full inline-block">✓ Selesai</span>
                            <p class="text-[10px] text-gray-400 mt-1">8 Peserta</p>
                        </div>
                        <a href="/publik/agenda/detail" class="border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-semibold px-4 py-1.5 rounded-full transition-colors">
                            Lihat Ringkasan &rsaquo;
                        </a>
                    </div>
                </div>
            </div>

            <!-- GROUP 2: Hari Ini — Senin, 13 Juli 2026 -->
            <div class="space-y-3">
                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wide">Hari Ini &mdash; Senin, 13 Juli 2026</h3>

                <!-- Card 1 (Berlangsung) -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-gray-200 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="bg-ijo-sangatmuda text-ijo-tua rounded-xl px-4 py-3 text-center shrink-0 w-24">
                            <p class="text-xs font-bold">07.30</p>
                            <p class="text-[10px] opacity-75">- 09.00</p>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-gray-900">Sosialisasi Dampak Perubahan Iklim di Kabupaten Bogor</h4>
                            <p class="text-xs text-gray-500">📍 Aula Diskominfo, Cibinong</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between md:justify-end space-x-4 shrink-0">
                        <div class="text-right">
                            <span class="bg-ijo-sangatmuda text-ijo-tua text-[10px] font-bold px-3 py-1 rounded-full inline-block">● Berlangsung</span>
                            <p class="text-[10px] text-gray-400 mt-1">45 Peserta</p>
                        </div>
                        <a href="/publik/agenda/detail" class="bg-ijo-tua hover:bg-ijo-semitua text-white text-xs font-bold px-4 py-2 rounded-xl transition-colors flex items-center space-x-2">
                            <span>📱</span> <span>Generate QR</span> &rsaquo;
                        </a>
                    </div>
                </div>

                <!-- Card 2 (Akan Datang) -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-gray-200 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="bg-ijo-sangatmuda text-ijo-tua rounded-xl px-4 py-3 text-center shrink-0 w-24">
                            <p class="text-xs font-bold">09.30</p>
                            <p class="text-[10px] opacity-75">- 11.00</p>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-gray-900">Rapat Koordinasi Program Smart City Kabupaten Bogor</h4>
                            <p class="text-xs text-gray-500">📍 Ruang Rapat Bupati, Setda</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between md:justify-end space-x-4 shrink-0">
                        <div class="text-right">
                            <span class="bg-oren-muda text-oren-tua text-[10px] font-bold px-3 py-1 rounded-full inline-block">Akan Datang</span>
                            <p class="text-[10px] text-gray-400 mt-1">28 Peserta</p>
                        </div>
                        <a href="/publik/agenda/detail" class="bg-ijo-tua hover:bg-ijo-semitua text-white text-xs font-bold px-4 py-2 rounded-xl transition-colors flex items-center space-x-2">
                            <span>📱</span> <span>Generate QR</span> &rsaquo;
                        </a>
                    </div>
                </div>

                <!-- Card 3 (Akan Datang) -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-gray-200 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="bg-ijo-sangatmuda text-ijo-tua rounded-xl px-4 py-3 text-center shrink-0 w-24">
                            <p class="text-xs font-bold">13.00</p>
                            <p class="text-[10px] opacity-75">- 15.00</p>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-gray-900">Pelatihan Jurnalistik Digital bagi ASN Kabupaten Bogor</h4>
                            <p class="text-xs text-gray-500">📍 Gedung Serbaguna, Cibinong</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between md:justify-end space-x-4 shrink-0">
                        <div class="text-right">
                            <span class="bg-oren-muda text-oren-tua text-[10px] font-bold px-3 py-1 rounded-full inline-block">Akan Datang</span>
                            <p class="text-[10px] text-gray-400 mt-1">60 Peserta</p>
                        </div>
                        <a href="/publik/agenda/detail" class="bg-ijo-tua hover:bg-ijo-semitua text-white text-xs font-bold px-4 py-2 rounded-xl transition-colors flex items-center space-x-2">
                            <span>📱</span> <span>Generate QR</span> &rsaquo;
                        </a>
                    </div>
                </div>
            </div>

            <!-- GROUP 3: Besok — Selasa, 14 Juli 2026 -->
            <div class="space-y-3">
                <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wide">Besok &mdash; Selasa, 14 Juli 2026</h3>

                <!-- Card 1 -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-gray-200 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-100 rounded-xl px-4 py-3 text-center shrink-0 w-24">
                            <p class="text-xs font-bold text-gray-800">08.00</p>
                            <p class="text-[10px] text-gray-400">- 10.00</p>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-gray-900">Bimtek Pengelolaan Media Sosial untuk Perangkat Desa</h4>
                            <p class="text-xs text-gray-500">📍 Aula Kecamatan Cibinong</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between md:justify-end space-x-4 shrink-0">
                        <div class="text-right">
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-3 py-1 rounded-full inline-block">Terjadwal</span>
                            <p class="text-[10px] text-gray-400 mt-1">32 Peserta</p>
                        </div>
                        <a href="/publik/agenda/detail" class="bg-gray-600 hover:bg-gray-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition-colors flex items-center space-x-2">
                            <span>📱</span> <span>Generate QR</span> &rsaquo;
                        </a>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-gray-200 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-100 rounded-xl px-4 py-3 text-center shrink-0 w-24">
                            <p class="text-xs font-bold text-gray-800">10.30</p>
                            <p class="text-[10px] text-gray-400">- 12.00</p>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-gray-900">Peluncuran Aplikasi SIAP Bogor untuk Layanan Terpadu</h4>
                            <p class="text-xs text-gray-500">📍 Pendopo Kabupaten Bogor</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between md:justify-end space-x-4 shrink-0">
                        <div class="text-right">
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-3 py-1 rounded-full inline-block">Terjadwal</span>
                            <p class="text-[10px] text-gray-400 mt-1">120 Peserta</p>
                        </div>
                        <a href="/publik/agenda/detail" class="bg-gray-600 hover:bg-gray-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition-colors flex items-center space-x-2">
                            <span>📱</span> <span>Generate QR</span> &rsaquo;
                        </a>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-gray-200 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-100 rounded-xl px-4 py-3 text-center shrink-0 w-24">
                            <p class="text-xs font-bold text-gray-800">14.00</p>
                            <p class="text-[10px] text-gray-400">- 16.00</p>
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-gray-900">Audiensi Forum Wartawan dengan Kepala Diskominfo</h4>
                            <p class="text-xs text-gray-500">📍 Ruang Tamu Diskominfo</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between md:justify-end space-x-4 shrink-0">
                        <div class="text-right">
                            <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-3 py-1 rounded-full inline-block">Terjadwal</span>
                            <p class="text-[10px] text-gray-400 mt-1">15 Peserta</p>
                        </div>
                        <a href="/publik/agenda/detail" class="bg-gray-600 hover:bg-gray-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition-colors flex items-center space-x-2">
                            <span>📱</span> <span>Generate QR</span> &rsaquo;
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </main>


@include('publik.layout_publik.footer')
</body>
</html>