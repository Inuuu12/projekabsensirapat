<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Berita - Diskominfo Kabupaten Bogor</title>
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
                <span class="text-gray-800 font-semibold">Berita</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Semua Berita</h1>
                    <p class="text-xs text-gray-500 mt-1">Kabar terbaru seputar Diskominfo Kabupaten Bogor</p>
                </div>

                <!-- Dropdown / Filter Kategori & Urutan -->
                <div class="flex items-center space-x-3">
                    <button class="bg-ijo-tua text-white text-xs font-semibold px-4 py-2 rounded-full flex items-center space-x-2 shadow-sm">
                        <span>Semua Kategori</span>
                    </button>
                    <button class="bg-white border border-gray-200 text-gray-700 text-xs font-semibold px-4 py-2 rounded-full flex items-center space-x-2 shadow-sm hover:bg-gray-50">
                        <span>Terbaru</span>
                        <span class="text-[10px]">↓</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- GRID BERITA (3 Kolom) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Card Berita 1 -->
            <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div>
                    <!-- Banner Placeholder dengan Badge Kategori -->
                    <div class="h-48 bg-[#6A9C95] relative p-4">
                        <span class="bg-white text-gray-800 text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">
                            Kegiatan
                        </span>
                    </div>
                    <!-- Konten Berita -->
                    <div class="p-6 space-y-2">
                        <p class="text-xs text-gray-400 font-mono">12 Juli 2026</p>
                        <h3 class="font-bold text-base text-gray-900 leading-snug hover:text-ijo-semitua transition-colors">
                            <a href="/publik/berita/detail">Kepala Diskominfo Dampingi Kampanye Iklim di Car Free Day</a>
                        </h3>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">
                            Mengedukasi warga tentang dampak perubahan cuaca ekstrem di Bogor...
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="/publik/berita/detail" class="text-xs font-bold text-ijo-tua hover:text-ijo-semitua inline-flex items-center space-x-1">
                        <span>Baca Selengkapnya</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Card Berita 2 -->
            <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div>
                    <div class="h-48 bg-[#3B7A75] relative p-4">
                        <span class="bg-white text-gray-800 text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">
                            Layanan Publik
                        </span>
                    </div>
                    <div class="p-6 space-y-2">
                        <p class="text-xs text-gray-400 font-mono">10 Juli 2026</p>
                        <h3 class="font-bold text-base text-gray-900 leading-snug hover:text-ijo-semitua transition-colors">
                            <a href="/publik/berita/detail">Diskominfo Luncurkan Layanan Pengaduan Online Terintegrasi</a>
                        </h3>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">
                            Warga bisa melapor keluhan tanpa perlu datang langsung ke kantor...
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="/publik/berita/detail" class="text-xs font-bold text-ijo-tua hover:text-ijo-semitua inline-flex items-center space-x-1">
                        <span>Baca Selengkapnya</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Card Berita 3 -->
            <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div>
                    <div class="h-48 bg-[#1A3A37] relative p-4">
                        <span class="bg-white text-gray-800 text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">
                            Sumber Daya
                        </span>
                    </div>
                    <div class="p-6 space-y-2">
                        <p class="text-xs text-gray-400 font-mono">8 Juli 2026</p>
                        <h3 class="font-bold text-base text-gray-900 leading-snug hover:text-ijo-semitua transition-colors">
                            <a href="/publik/berita/detail">Pelatihan Jurnalistik Digital Dibuka untuk 60 ASN Bogor</a>
                        </h3>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">
                            Membekali aparatur dengan skill komunikasi publik di era digital...
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="/publik/berita/detail" class="text-xs font-bold text-ijo-tua hover:text-ijo-semitua inline-flex items-center space-x-1">
                        <span>Baca Selengkapnya</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Card Berita 4 -->
            <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div>
                    <div class="h-48 bg-[#D29D47] relative p-4">
                        <span class="bg-white text-gray-800 text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">
                            Teknologi
                        </span>
                    </div>
                    <div class="p-6 space-y-2">
                        <p class="text-xs text-gray-400 font-mono">6 Juli 2026</p>
                        <h3 class="font-bold text-base text-gray-900 leading-snug hover:text-ijo-semitua transition-colors">
                            <a href="/publik/berita/detail">Aplikasi SIAP Bogor Resmi Diluncurkan untuk Warga</a>
                        </h3>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">
                            Satu aplikasi untuk akses seluruh layanan administrasi Kabupaten Bogor...
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="/publik/berita/detail" class="text-xs font-bold text-ijo-tua hover:text-ijo-semitua inline-flex items-center space-x-1">
                        <span>Baca Selengkapnya</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Card Berita 5 -->
            <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div>
                    <div class="h-48 bg-[#6A9C95] relative p-4">
                        <span class="bg-white text-gray-800 text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">
                            Pemerintahan
                        </span>
                    </div>
                    <div class="p-6 space-y-2">
                        <p class="text-xs text-gray-400 font-mono">4 Juli 2026</p>
                        <h3 class="font-bold text-base text-gray-900 leading-snug hover:text-ijo-semitua transition-colors">
                            <a href="/publik/berita/detail">Rakor Smart City Bahas Integrasi Data Antar Dinas</a>
                        </h3>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">
                            Delapan OPD sepakat menyatukan basis data layanan publik tahun ini...
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="/publik/berita/detail" class="text-xs font-bold text-ijo-tua hover:text-ijo-semitua inline-flex items-center space-x-1">
                        <span>Baca Selengkapnya</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Card Berita 6 -->
            <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div>
                    <div class="h-48 bg-[#3B7A75] relative p-4">
                        <span class="bg-white text-gray-800 text-[11px] font-bold px-3 py-1 rounded-full shadow-sm">
                            Sumber Daya
                        </span>
                    </div>
                    <div class="p-6 space-y-2">
                        <p class="text-xs text-gray-400 font-mono">2 Juli 2026</p>
                        <h3 class="font-bold text-base text-gray-900 leading-snug hover:text-ijo-semitua transition-colors">
                            <a href="/publik/berita/detail">Bimtek Medsos untuk 75 Perangkat Desa se-Bogor</a>
                        </h3>
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">
                            Mendorong desa lebih aktif mempublikasikan program kerjanya...
                        </p>
                    </div>
                </div>
                <div class="px-6 pb-6 pt-2">
                    <a href="/publik/berita/detail" class="text-xs font-bold text-ijo-tua hover:text-ijo-semitua inline-flex items-center space-x-1">
                        <span>Baca Selengkapnya</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- PAGINATION SECTION -->
        <div class="flex items-center justify-center space-x-2 pt-6">
            <button class="w-8 h-8 rounded-full bg-ijo-tua text-white font-bold text-xs flex items-center justify-center shadow-sm">
                1
            </button>
            <button class="w-8 h-8 rounded-full bg-gray-200/80 hover:bg-gray-300 text-gray-700 text-xs flex items-center justify-center transition-colors">
                2
            </button>
            <button class="w-8 h-8 rounded-full bg-gray-200/80 hover:bg-gray-300 text-gray-700 text-xs flex items-center justify-center transition-colors">
                3
            </button>
        </div>

    </main>

    <!-- Memanggil Footer Publik -->
    @include('publik.layout_publik.footer') 

</body>
</html>