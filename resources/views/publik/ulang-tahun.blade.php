<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulang Tahun Pegawai - Diskominfo Kabupaten Bogor</title>
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

    <main class="flex-grow container mx-auto px-6 lg:px-12 py-8 space-y-8 max-w-7xl">

        <!-- Breadcrumb & Header Section -->
        <div class="space-y-4">
            <nav class="text-xs text-gray-500 flex items-center space-x-2">
                <a href="/publik" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 font-semibold">Pegawai</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Ulang Tahun Pegawai</h1>
                    <p class="text-xs text-gray-500 mt-1">Rayakan momen spesial rekan kerja di Diskominfo Kabupaten Bogor</p>
                </div>

                <!-- Filter Buttons -->
                <div class="flex items-center space-x-2">
                    <button class="bg-ijo-tua text-white text-xs font-semibold px-4 py-2 rounded-full shadow-sm">
                        Semua
                    </button>
                    <button class="bg-white border border-gray-200 text-gray-600 hover:text-gray-900 text-xs font-semibold px-4 py-2 rounded-full shadow-sm hover:bg-gray-50 transition-colors">
                        Bulan Ini
                    </button>
                    <button class="bg-white border border-gray-200 text-gray-600 hover:text-gray-900 text-xs font-semibold px-4 py-2 rounded-full shadow-sm hover:bg-gray-50 transition-colors">
                        Bulan Depan
                    </button>
                </div>
            </div>
        </div>

        <!-- HERO BANNER: ULANG TAHUN HARI INI -->
        <div class="bg-ijo-tua rounded-3xl p-6 md:p-8 text-white relative overflow-hidden shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            
            <!-- Badge Ribbon Kiri Atas -->
            <div class="absolute top-0 left-0 bg-oren-utama text-white text-[10px] font-bold uppercase tracking-wider px-4 py-1.5 rounded-br-2xl flex items-center space-x-1.5 shadow-sm">
                <span>🎉</span>
                <span>ULANG TAHUN HARI INI</span>
            </div>

            <!-- Profile Info -->
            <div class="flex items-center space-x-5 pt-4 md:pt-0">
                <!-- Avatar Initial -->
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-ijo-muda/40 border-2 border-white/20 flex items-center justify-center text-xl md:text-2xl font-bold text-white shrink-0 shadow-inner">
                    DK
                </div>
                <!-- Details -->
                <div class="space-y-1">
                    <h2 class="text-xl md:text-2xl font-extrabold text-white">Dedi Kurniawan</h2>
                    <p class="text-xs text-gray-200/90 font-medium">Staff IT & Jaringan &bull; Bidang Infrastruktur TI</p>
                    <div class="flex items-center space-x-2 text-xs text-oren-muda font-mono pt-1">
                        <span>🎂 14 Juli 2026</span>
                        <span>&bull;</span>
                        <span>Genap 34 tahun</span>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="w-full md:w-auto">
                <a href="#" class="w-full md:w-auto bg-oren-utama hover:bg-oren-tua text-white font-bold text-xs px-6 py-3 rounded-full flex items-center justify-center space-x-2 shadow-md transition-colors">
                    <span>Kirim Ucapan</span>
                    <span>🎉</span>
                </a>
            </div>
        </div>

        <!-- SECTION: AKAN DATANG -->
        <div class="space-y-4 pt-2">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Akan Datang</h3>
                <p class="text-xs text-gray-500">8 pegawai berulang tahun dalam waktu dekat</p>
            </div>

            <!-- GRID 8 PEGAWAI (4 Kolom Layout) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                <!-- Card Pegawai 1 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-3 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-full bg-[#3B7A75] flex items-center justify-center text-white font-bold text-base shadow-sm">
                        RW
                    </div>
                    <div class="space-y-0.5 w-full">
                        <h4 class="font-bold text-sm text-gray-900 truncate">Rina Wulandari</h4>
                        <p class="text-[11px] text-gray-400">Analis Data</p>
                    </div>
                    <div class="w-full pt-2 border-t border-gray-50">
                        <span class="bg-ijo-sangatmuda text-ijo-tua text-xs font-bold px-4 py-1.5 rounded-full inline-block">
                            🎂 18 Juli
                        </span>
                    </div>
                </div>

                <!-- Card Pegawai 2 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-3 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-full bg-oren-utama flex items-center justify-center text-white font-bold text-base shadow-sm">
                        BS
                    </div>
                    <div class="space-y-0.5 w-full">
                        <h4 class="font-bold text-sm text-gray-900 truncate">Bayu Segara</h4>
                        <p class="text-[11px] text-gray-400">Humas & Publikasi</p>
                    </div>
                    <div class="w-full pt-2 border-t border-gray-50">
                        <span class="bg-ijo-sangatmuda text-ijo-tua text-xs font-bold px-4 py-1.5 rounded-full inline-block">
                            🎂 22 Juli
                        </span>
                    </div>
                </div>

                <!-- Card Pegawai 3 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-3 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-full bg-[#6A9C95] flex items-center justify-center text-white font-bold text-base shadow-sm">
                        SA
                    </div>
                    <div class="space-y-0.5 w-full">
                        <h4 class="font-bold text-sm text-gray-900 truncate">Siti Aminah</h4>
                        <p class="text-[11px] text-gray-400">Staff Keuangan</p>
                    </div>
                    <div class="w-full pt-2 border-t border-gray-50">
                        <span class="bg-ijo-sangatmuda text-ijo-tua text-xs font-bold px-4 py-1.5 rounded-full inline-block">
                            🎂 25 Juli
                        </span>
                    </div>
                </div>

                <!-- Card Pegawai 4 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-3 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-full bg-[#1A3A37] flex items-center justify-center text-white font-bold text-base shadow-sm">
                        FN
                    </div>
                    <div class="space-y-0.5 w-full">
                        <h4 class="font-bold text-sm text-gray-900 truncate">Fajar Nugroho</h4>
                        <p class="text-[11px] text-gray-400">Programmer</p>
                    </div>
                    <div class="w-full pt-2 border-t border-gray-50">
                        <span class="bg-ijo-sangatmuda text-ijo-tua text-xs font-bold px-4 py-1.5 rounded-full inline-block">
                            🎂 28 Juli
                        </span>
                    </div>
                </div>

                <!-- Card Pegawai 5 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-3 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-full bg-[#3B7A75] flex items-center justify-center text-white font-bold text-base shadow-sm">
                        MK
                    </div>
                    <div class="space-y-0.5 w-full">
                        <h4 class="font-bold text-sm text-gray-900 truncate">Maya Kartika</h4>
                        <p class="text-[11px] text-gray-400">Staff Umum</p>
                    </div>
                    <div class="w-full pt-2 border-t border-gray-50">
                        <span class="bg-gray-100 text-gray-700 text-xs font-bold px-4 py-1.5 rounded-full inline-block">
                            🎂 2 Agustus
                        </span>
                    </div>
                </div>

                <!-- Card Pegawai 6 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-3 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-full bg-oren-utama flex items-center justify-center text-white font-bold text-base shadow-sm">
                        YH
                    </div>
                    <div class="space-y-0.5 w-full">
                        <h4 class="font-bold text-sm text-gray-900 truncate">Yusuf Hidayat</h4>
                        <p class="text-[11px] text-gray-400">Kepala Bidang</p>
                    </div>
                    <div class="w-full pt-2 border-t border-gray-50">
                        <span class="bg-gray-100 text-gray-700 text-xs font-bold px-4 py-1.5 rounded-full inline-block">
                            🎂 5 Agustus
                        </span>
                    </div>
                </div>

                <!-- Card Pegawai 7 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-3 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-full bg-[#6A9C95] flex items-center justify-center text-white font-bold text-base shadow-sm">
                        NP
                    </div>
                    <div class="space-y-0.5 w-full">
                        <h4 class="font-bold text-sm text-gray-900 truncate">Nadia Permata</h4>
                        <p class="text-[11px] text-gray-400">Desainer Grafis</p>
                    </div>
                    <div class="w-full pt-2 border-t border-gray-50">
                        <span class="bg-gray-100 text-gray-700 text-xs font-bold px-4 py-1.5 rounded-full inline-block">
                            🎂 9 Agustus
                        </span>
                    </div>
                </div>

                <!-- Card Pegawai 8 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex flex-col items-center text-center space-y-3 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-full bg-[#1A3A37] flex items-center justify-center text-white font-bold text-base shadow-sm">
                        AR
                    </div>
                    <div class="space-y-0.5 w-full">
                        <h4 class="font-bold text-sm text-gray-900 truncate">Arief Rahman</h4>
                        <p class="text-[11px] text-gray-400">Teknisi Jaringan</p>
                    </div>
                    <div class="w-full pt-2 border-t border-gray-50">
                        <span class="bg-gray-100 text-gray-700 text-xs font-bold px-4 py-1.5 rounded-full inline-block">
                            🎂 14 Agustus
                        </span>
                    </div>
                </div>

            </div>
        </div>

    </main>

    <!-- Memanggil Footer Publik -->
    @include('publik.layout_publik.footer') 

</body>
</html>