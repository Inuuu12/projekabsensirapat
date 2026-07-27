<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Situs (Sitemap) - Diskominfo Kab. Bogor</title>
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

    <!-- Navbar Publik -->
    @include('publik.layout_publik.navbarpublik')

    <main class="flex-grow container mx-auto px-4 md:px-12 max-w-7xl py-10 space-y-8">
        
        <!-- Header Page -->
        <div class="bg-white border border-gray-200/80 rounded-3xl p-6 md:p-8 shadow-sm">
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Peta Situs (Sitemap)</h1>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Daftar struktur halaman dan layanan yang tersedia di website Resmi Diskominfo Kabupaten Bogor.</p>
        </div>

        <!-- Grid Sitemap / Daftar Isi Website -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Kelompok 1: Navigasi Utama -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-6 space-y-4 shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-ijo-sangatmuda text-ijo-tua font-bold flex items-center justify-center text-sm">🌐</div>
                    <h3 class="font-bold text-gray-900 text-sm">Halaman Utama</h3>
                </div>
                <hr class="border-gray-100">
                <ul class="space-y-2 text-xs font-medium text-gray-600">
                    <li><a href="{{ route('publik.beranda') }}" class="hover:text-ijo-semitua transition-colors flex items-center space-x-1.5"><span>•</span> <span>Beranda</span></a></li>
                    <li><a href="{{ route('publik.berita') }}" class="hover:text-ijo-semitua transition-colors flex items-center space-x-1.5"><span>•</span> <span>Berita Terkini</span></a></li>
                    <li><a href="{{ route('publik.agenda') }}" class="hover:text-ijo-semitua transition-colors flex items-center space-x-1.5"><span>•</span> <span>Agenda Kegiatan</span></a></li>
                    <li><a href="{{ route('publik.galeri') }}" class="hover:text-ijo-semitua transition-colors flex items-center space-x-1.5"><span>•</span> <span>Galeri Foto</span></a></li>
                    <li><a href="{{ route('publik.video') }}" class="hover:text-ijo-semitua transition-colors flex items-center space-x-1.5"><span>•</span> <span>Dokumentasi Video</span></a></li>
                </ul>
            </div>

            <!-- Kelompok 2: Layanan Publik & Partisipasi -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-6 space-y-4 shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-oren-muda text-oren-tua font-bold flex items-center justify-center text-sm">📝</div>
                    <h3 class="font-bold text-gray-900 text-sm">Layanan & Partisipasi</h3>
                </div>
                <hr class="border-gray-100">
                <ul class="space-y-2 text-xs font-medium text-gray-600">
                    <li><a href="{{ route('publik.masukan') }}" class="hover:text-ijo-semitua transition-colors flex items-center space-x-1.5"><span>•</span> <span>Formulir Masukan & Pengaduan</span></a></li>
                    <li><a href="{{ route('publik.ulangtahun') }}" class="hover:text-ijo-semitua transition-colors flex items-center space-x-1.5"><span>•</span> <span>Informasi Ulang Tahun</span></a></li>
                    <li><a href="{{ route('publik.presensi.pilih') }}" class="hover:text-ijo-semitua transition-colors flex items-center space-x-1.5"><span>•</span> <span>Presensi / Absensi Rapat</span></a></li>
                </ul>
            </div>

            <!-- Kelompok 3: Alur Presensi -->
            <div class="bg-white border border-gray-200/80 rounded-2xl p-6 space-y-4 shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-ijo-sangatmuda text-ijo-tua font-bold flex items-center justify-center text-sm">📌</div>
                    <h3 class="font-bold text-gray-900 text-sm">Menu Presensi</h3>
                </div>
                <hr class="border-gray-100">
                <ul class="space-y-2 text-xs font-medium text-gray-600">
                    <li><a href="{{ route('publik.presensi.pilih') }}" class="hover:text-ijo-semitua transition-colors flex items-center space-x-1.5"><span>•</span> <span>Pilih Role Peserta</span></a></li>
                    <li><a href="{{ route('publik.presensi.pegawai') }}" class="hover:text-ijo-semitua transition-colors flex items-center space-x-1.5"><span>•</span> <span>Metode Presensi Pegawai</span></a></li>
                    <li><a href="{{ route('publik.presensi.tamu') }}" class="hover:text-ijo-semitua transition-colors flex items-center space-x-1.5"><span>•</span> <span>Form Presensi Tamu Rapat</span></a></li>
                </ul>
            </div>

        </div>

    </main>

    <!-- Footer Publik -->
    @include('publik.layout_publik.footer')

</body>
</html>