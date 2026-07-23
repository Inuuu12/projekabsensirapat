<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Video - Diskominfo Kabupaten Bogor</title>
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
        <div class="space-y-3">
            <nav class="text-xs text-gray-500 flex items-center space-x-2">
                <a href="/publik" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 font-semibold">Video</span>
            </nav>

            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Semua Video</h1>
                <p class="text-xs text-gray-500 mt-1">Dokumentasi kegiatan & publikasi resmi Diskominfo Kab. Bogor</p>
            </div>
        </div>

        <!-- GRID VIDEO CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Card Video 1 (Ijo Tua) -->
            <div class="space-y-3 group cursor-pointer">
                <div class="relative bg-ijo-tua rounded-3xl overflow-hidden shadow-sm aspect-[16/10] flex items-center justify-center p-4 transition-transform group-hover:scale-[1.01]">
                    <!-- Badge Durasi -->
                    <span class="absolute top-4 right-4 bg-black/40 text-white font-mono text-[10px] font-semibold px-2.5 py-1 rounded-md backdrop-blur-sm">
                        04:12
                    </span>
                    <!-- Play Button -->
                    <div class="w-12 h-12 rounded-full bg-white text-ijo-tua flex items-center justify-center shadow-lg transition-transform group-hover:scale-110 pl-1">
                        ▶
                    </div>
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-sm text-gray-900 group-hover:text-ijo-tua transition-colors">
                        Dokumentasi CFD: Edukasi Perubahan Iklim
                    </h3>
                    <p class="text-xs text-gray-400 font-medium">12 Jul 2026 &bull; 3.240 ditonton</p>
                </div>
            </div>

            <!-- Card Video 2 (Ijo Semitua) -->
            <div class="space-y-3 group cursor-pointer">
                <div class="relative bg-ijo-semitua rounded-3xl overflow-hidden shadow-sm aspect-[16/10] flex items-center justify-center p-4 transition-transform group-hover:scale-[1.01]">
                    <!-- Badge Durasi -->
                    <span class="absolute top-4 right-4 bg-black/40 text-white font-mono text-[10px] font-semibold px-2.5 py-1 rounded-md backdrop-blur-sm">
                        02:48
                    </span>
                    <!-- Play Button -->
                    <div class="w-12 h-12 rounded-full bg-white text-ijo-semitua flex items-center justify-center shadow-lg transition-transform group-hover:scale-110 pl-1">
                        ▶
                    </div>
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-sm text-gray-900 group-hover:text-ijo-tua transition-colors">
                        Peresmian Aplikasi SIAP Bogor
                    </h3>
                    <p class="text-xs text-gray-400 font-medium">9 Jul 2026 &bull; 1.870 ditonton</p>
                </div>
            </div>

            <!-- Card Video 3 (Ijo Muda) -->
            <div class="space-y-3 group cursor-pointer">
                <div class="relative bg-ijo-muda rounded-3xl overflow-hidden shadow-sm aspect-[16/10] flex items-center justify-center p-4 transition-transform group-hover:scale-[1.01]">
                    <!-- Badge Durasi -->
                    <span class="absolute top-4 right-4 bg-black/40 text-white font-mono text-[10px] font-semibold px-2.5 py-1 rounded-md backdrop-blur-sm">
                        06:35
                    </span>
                    <!-- Play Button -->
                    <div class="w-12 h-12 rounded-full bg-white text-ijo-muda flex items-center justify-center shadow-lg transition-transform group-hover:scale-110 pl-1">
                        ▶
                    </div>
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-sm text-gray-900 group-hover:text-ijo-tua transition-colors">
                        Profil Layanan Diskominfo 2026
                    </h3>
                    <p class="text-xs text-gray-400 font-medium">5 Jul 2026 &bull; 5.102 ditonton</p>
                </div>
            </div>

            <!-- Card Video 4 (Oren Utama) -->
            <div class="space-y-3 group cursor-pointer">
                <div class="relative bg-oren-utama rounded-3xl overflow-hidden shadow-sm aspect-[16/10] flex items-center justify-center p-4 transition-transform group-hover:scale-[1.01]">
                    <!-- Badge Durasi -->
                    <span class="absolute top-4 right-4 bg-black/40 text-white font-mono text-[10px] font-semibold px-2.5 py-1 rounded-md backdrop-blur-sm">
                        03:20
                    </span>
                    <!-- Play Button -->
                    <div class="w-12 h-12 rounded-full bg-white text-oren-utama flex items-center justify-center shadow-lg transition-transform group-hover:scale-110 pl-1">
                        ▶
                    </div>
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-sm text-gray-900 group-hover:text-ijo-tua transition-colors">
                        Bimtek Media Sosial Perangkat Desa
                    </h3>
                    <p class="text-xs text-gray-400 font-medium">2 Jul 2026 &bull; 940 ditonton</p>
                </div>
            </div>

            <!-- Card Video 5 (Ijo Tua) -->
            <div class="space-y-3 group cursor-pointer">
                <div class="relative bg-ijo-tua rounded-3xl overflow-hidden shadow-sm aspect-[16/10] flex items-center justify-center p-4 transition-transform group-hover:scale-[1.01]">
                    <!-- Badge Durasi -->
                    <span class="absolute top-4 right-4 bg-black/40 text-white font-mono text-[10px] font-semibold px-2.5 py-1 rounded-md backdrop-blur-sm">
                        05:04
                    </span>
                    <!-- Play Button -->
                    <div class="w-12 h-12 rounded-full bg-white text-ijo-tua flex items-center justify-center shadow-lg transition-transform group-hover:scale-110 pl-1">
                        ▶
                    </div>
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-sm text-gray-900 group-hover:text-ijo-tua transition-colors">
                        Rapat Koordinasi Smart City Bogor
                    </h3>
                    <p class="text-xs text-gray-400 font-medium">29 Jun 2026 &bull; 1.215 ditonton</p>
                </div>
            </div>

            <!-- Card Video 6 (Ijo Semitua) -->
            <div class="space-y-3 group cursor-pointer">
                <div class="relative bg-ijo-semitua rounded-3xl overflow-hidden shadow-sm aspect-[16/10] flex items-center justify-center p-4 transition-transform group-hover:scale-[1.01]">
                    <!-- Badge Durasi -->
                    <span class="absolute top-4 right-4 bg-black/40 text-white font-mono text-[10px] font-semibold px-2.5 py-1 rounded-md backdrop-blur-sm">
                        07:52
                    </span>
                    <!-- Play Button -->
                    <div class="w-12 h-12 rounded-full bg-white text-ijo-semitua flex items-center justify-center shadow-lg transition-transform group-hover:scale-110 pl-1">
                        ▶
                    </div>
                </div>
                <div class="space-y-1">
                    <h3 class="font-bold text-sm text-gray-900 group-hover:text-ijo-tua transition-colors">
                        Wawancara Kepala Diskominfo Bogor
                    </h3>
                    <p class="text-xs text-gray-400 font-medium">25 Jun 2026 &bull; 2.630 ditonton</p>
                </div>
            </div>

        </div>

    </main>

    <!-- Memanggil Footer Publik -->
    @include('publik.layout_publik.footer')

</body>
</html>