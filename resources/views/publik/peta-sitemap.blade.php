<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Situs (Sitemap) - SIRAPI</title>
    @include('publik.layout_publik.theme_script')
    <!-- Tailwind CSS CDN -->
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

    <!-- Navbar Publik -->
    @include('publik.layout_publik.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-10 space-y-8">
        
        <!-- Header Page -->
        <div class="bg-white dark:bg-[#152420] border border-gray-200/80 dark:border-[#233a34] rounded-3xl p-6 md:p-8 shadow-xs transition-colors">
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">Peta Situs (Sitemap)</h1>
            <p class="text-xs md:text-sm text-gray-500 dark:text-gray-300 mt-1">Daftar struktur halaman dan layanan yang tersedia di website resmi SIRAPI.</p>
        </div>

        <!-- Grid Sitemap / Daftar Isi Website -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Kelompok 1: Navigasi Utama -->
            <div class="bg-white dark:bg-[#152420] border border-gray-200/80 dark:border-[#233a34] rounded-2xl p-6 space-y-4 shadow-xs transition-colors">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-ijo-sangatmuda dark:bg-[#0f1c19] text-ijo-tua dark:text-emerald-400 font-bold flex items-center justify-center text-sm border border-transparent dark:border-[#284c43]">🌐</div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-sm">Halaman Utama</h3>
                </div>
                <hr class="border-gray-100 dark:border-[#233a34]">
                <ul class="space-y-2 text-xs font-medium text-gray-600 dark:text-gray-300">
                    <li><a href="{{ route('publik.beranda') }}" class="hover:text-ijo-semitua dark:hover:text-emerald-400 transition-colors flex items-center space-x-1.5"><span>•</span> <span>Beranda</span></a></li>
                    <li><a href="{{ route('publik.berita') }}" class="hover:text-ijo-semitua dark:hover:text-emerald-400 transition-colors flex items-center space-x-1.5"><span>•</span> <span>Berita Terkini</span></a></li>
                    <li><a href="{{ route('publik.agenda') }}" class="hover:text-ijo-semitua dark:hover:text-emerald-400 transition-colors flex items-center space-x-1.5"><span>•</span> <span>Agenda Kegiatan</span></a></li>
                    <li><a href="{{ route('publik.galeri') }}" class="hover:text-ijo-semitua dark:hover:text-emerald-400 transition-colors flex items-center space-x-1.5"><span>•</span> <span>Galeri Foto</span></a></li>
                    <li><a href="{{ route('publik.video') }}" class="hover:text-ijo-semitua dark:hover:text-emerald-400 transition-colors flex items-center space-x-1.5"><span>•</span> <span>Dokumentasi Video</span></a></li>
                </ul>
            </div>

            <!-- Kelompok 2: Layanan Publik & Partisipasi -->
            <div class="bg-white dark:bg-[#152420] border border-gray-200/80 dark:border-[#233a34] rounded-2xl p-6 space-y-4 shadow-xs transition-colors">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-oren-muda dark:bg-amber-950/60 text-oren-tua dark:text-amber-300 font-bold flex items-center justify-center text-sm border border-transparent dark:border-amber-700/40">📝</div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-sm">Layanan & Partisipasi</h3>
                </div>
                <hr class="border-gray-100 dark:border-[#233a34]">
                <ul class="space-y-2 text-xs font-medium text-gray-600 dark:text-gray-300">
                    <li><a href="{{ route('publik.masukan') }}" class="hover:text-ijo-semitua dark:hover:text-emerald-400 transition-colors flex items-center space-x-1.5"><span>•</span> <span>Formulir Pengaduan</span></a></li>
                    <li><a href="{{ route('publik.ulangtahun') }}" class="hover:text-ijo-semitua dark:hover:text-emerald-400 transition-colors flex items-center space-x-1.5"><span>•</span> <span>Informasi Ulang Tahun</span></a></li>
                    <li><a href="{{ route('publik.agenda') }}" class="hover:text-ijo-semitua dark:hover:text-emerald-400 transition-colors flex items-center space-x-1.5"><span>•</span> <span>Agenda & Presensi Rapat</span></a></li>
                </ul>
            </div>

            <!-- Kelompok 3: Alur Presensi -->
            <div class="bg-white dark:bg-[#152420] border border-gray-200/80 dark:border-[#233a34] rounded-2xl p-6 space-y-4 shadow-xs transition-colors">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-ijo-sangatmuda dark:bg-[#0f1c19] text-ijo-tua dark:text-emerald-400 font-bold flex items-center justify-center text-sm border border-transparent dark:border-[#284c43]">📌</div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-sm">Menu Presensi</h3>
                </div>
                <hr class="border-gray-100 dark:border-[#233a34]">
                <ul class="space-y-2 text-xs font-medium text-gray-600 dark:text-gray-300">
                    <li><a href="{{ route('publik.agenda') }}" class="hover:text-ijo-semitua dark:hover:text-emerald-400 transition-colors flex items-center space-x-1.5"><span>•</span> <span>Daftar Agenda & Detail Presensi</span></a></li>
                    <li><a href="{{ route('publik.presensi.pegawai') }}" class="hover:text-ijo-semitua dark:hover:text-emerald-400 transition-colors flex items-center space-x-1.5"><span>•</span> <span>Metode Presensi Pegawai</span></a></li>
                    <li><a href="{{ route('publik.presensi.tamu') }}" class="hover:text-ijo-semitua dark:hover:text-emerald-400 transition-colors flex items-center space-x-1.5"><span>•</span> <span>Form Presensi Tamu Rapat</span></a></li>
                </ul>
            </div>

        </div>

    </main>

    <!-- Footer Publik -->
    @include('publik.layout_publik.footer')

</body>
</html>
