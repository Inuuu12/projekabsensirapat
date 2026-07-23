<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto Kegiatan - Diskominfo Kabupaten Bogor</title>
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
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div class="space-y-3">
                <nav class="text-xs text-gray-500 flex items-center space-x-2">
                    <a href="/publik" class="hover:underline">Beranda</a>
                    <span>/</span>
                    <span class="text-gray-800 font-semibold">Galeri</span>
                </nav>

                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Galeri Foto Kegiatan</h1>
                    <p class="text-xs text-gray-500 mt-1">Dokumentasi visual seluruh kegiatan Diskominfo Kabupaten Bogor</p>
                </div>
            </div>

            <!-- Badge Summary Total Foto -->
            <div class="bg-ijo-tua text-white text-xs font-bold px-4 py-2 rounded-full self-start md:self-auto shadow-sm">
                32 Foto &bull; 6 Album
            </div>
        </div>

        <!-- MASONRY / ASYMMETRIC GRID GALERI -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-start">

            <!-- KOLOM 1 -->
            <div class="space-y-4">
                <!-- Foto 1 (Ijo Muda - Tinggi) -->
                <div class="relative bg-ijo-muda rounded-3xl p-4 min-h-[260px] shadow-sm overflow-hidden group cursor-pointer transition-transform hover:scale-[1.01]">
                    <span class="bg-white/80 backdrop-blur-md text-gray-900 text-[10px] font-bold px-3 py-1 rounded-full inline-block">
                        Kegiatan
                    </span>
                </div>

                <!-- Foto 2 (Ijo Semitua - Pendek) -->
                <div class="relative bg-ijo-semitua rounded-3xl p-4 min-h-[160px] shadow-sm overflow-hidden group cursor-pointer transition-transform hover:scale-[1.01]">
                    <span class="bg-white/80 backdrop-blur-md text-gray-900 text-[10px] font-bold px-3 py-1 rounded-full inline-block">
                        Rapat
                    </span>
                </div>

                <!-- Foto 3 (Ijo Tua - Sedang) -->
                <div class="relative bg-ijo-tua rounded-3xl p-4 min-h-[200px] shadow-sm overflow-hidden group cursor-pointer transition-transform hover:scale-[1.01]">
                    <span class="bg-white/80 backdrop-blur-md text-gray-900 text-[10px] font-bold px-3 py-1 rounded-full inline-block">
                        Pelatihan
                    </span>
                </div>
            </div>

            <!-- KOLOM 2 -->
            <div class="space-y-4">
                <!-- Foto 4 (Oren Utama - Sedang) -->
                <div class="relative bg-oren-utama rounded-3xl p-4 min-h-[190px] shadow-sm overflow-hidden group cursor-pointer transition-transform hover:scale-[1.01]">
                    <span class="bg-white/80 backdrop-blur-md text-gray-900 text-[10px] font-bold px-3 py-1 rounded-full inline-block">
                        Kegiatan
                    </span>
                </div>

                <!-- Foto 5 (Ijo Muda - Tinggi) -->
                <div class="relative bg-ijo-muda rounded-3xl p-4 min-h-[250px] shadow-sm overflow-hidden group cursor-pointer transition-transform hover:scale-[1.01]">
                    <span class="bg-white/80 backdrop-blur-md text-gray-900 text-[10px] font-bold px-3 py-1 rounded-full inline-block">
                        Sosialisasi
                    </span>
                </div>

                <!-- Foto 6 (Ijo Semitua - Pendek) -->
                <div class="relative bg-ijo-semitua rounded-3xl p-4 min-h-[170px] shadow-sm overflow-hidden group cursor-pointer transition-transform hover:scale-[1.01]">
                    <span class="bg-white/80 backdrop-blur-md text-gray-900 text-[10px] font-bold px-3 py-1 rounded-full inline-block">
                        Rapat
                    </span>
                </div>
            </div>

            <!-- KOLOM 3 -->
            <div class="space-y-4">
                <!-- Foto 7 (Ijo Tua - Tinggi) -->
                <div class="relative bg-ijo-tua rounded-3xl p-4 min-h-[230px] shadow-sm overflow-hidden group cursor-pointer transition-transform hover:scale-[1.01]">
                    <span class="bg-white/80 backdrop-blur-md text-gray-900 text-[10px] font-bold px-3 py-1 rounded-full inline-block">
                        Pelatihan
                    </span>
                </div>

                <!-- Foto 8 (Oren Utama - Sedang) -->
                <div class="relative bg-oren-utama rounded-3xl p-4 min-h-[200px] shadow-sm overflow-hidden group cursor-pointer transition-transform hover:scale-[1.01]">
                    <span class="bg-white/80 backdrop-blur-md text-gray-900 text-[10px] font-bold px-3 py-1 rounded-full inline-block">
                        Kegiatan
                    </span>
                </div>

                <!-- Foto 9 (Ijo Muda - Tinggi) -->
                <div class="relative bg-ijo-muda rounded-3xl p-4 min-h-[240px] shadow-sm overflow-hidden group cursor-pointer transition-transform hover:scale-[1.01]">
                    <span class="bg-white/80 backdrop-blur-md text-gray-900 text-[10px] font-bold px-3 py-1 rounded-full inline-block">
                        Sosialisasi
                    </span>
                </div>
            </div>

            <!-- KOLOM 4 -->
            <div class="space-y-4">
                <!-- Foto 10 (Ijo Semitua - Tinggi) -->
                <div class="relative bg-ijo-semitua rounded-3xl p-4 min-h-[270px] shadow-sm overflow-hidden group cursor-pointer transition-transform hover:scale-[1.01]">
                    <span class="bg-white/80 backdrop-blur-md text-gray-900 text-[10px] font-bold px-3 py-1 rounded-full inline-block">
                        Rapat
                    </span>
                </div>

                <!-- Foto 11 (Ijo Tua - Sedang) -->
                <div class="relative bg-ijo-tua rounded-3xl p-4 min-h-[180px] shadow-sm overflow-hidden group cursor-pointer transition-transform hover:scale-[1.01]">
                    <span class="bg-white/80 backdrop-blur-md text-gray-900 text-[10px] font-bold px-3 py-1 rounded-full inline-block">
                        Pelatihan
                    </span>
                </div>

                <!-- Card Spesial "+20 Foto Lainnya" -->
                <div class="relative bg-[#0F3A37] text-white rounded-3xl p-6 min-h-[210px] shadow-md flex items-center justify-center text-center cursor-pointer transition-transform hover:scale-[1.01]">
                    <h3 class="text-lg md:text-xl font-extrabold tracking-wide">
                        +20 Foto Lainnya
                    </h3>
                </div>
            </div>

        </div>

    </main>

  
@include('publik.layout_publik.footer')
</body>
</html>