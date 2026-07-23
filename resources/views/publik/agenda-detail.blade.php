<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Agenda - Diskominfo Kabupaten Bogor</title>
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

        <!-- Breadcrumb & Tombol Kembali -->
        <div class="space-y-3">
            <nav class="text-xs text-gray-500 flex items-center space-x-2">
                <a href="/publik" class="hover:underline">Beranda</a>
                <span>/</span>
                <a href="/publik/agenda" class="hover:underline">Agenda</a>
                <span>/</span>
                <span class="text-gray-800 font-semibold truncate">Sosialisasi Dampak Perubahan Iklim</span>
            </nav>

            <a href="/publik/agenda" class="inline-flex items-center space-x-1 text-xs font-bold text-ijo-tua hover:underline">
                <span>&larr;</span>
                <span>Kembali ke Semua Agenda</span>
            </a>
        </div>

        <!-- Header Detail Agenda -->
        <div class="space-y-3 border-b border-gray-200/60 pb-6">
            <div>
                <span class="bg-ijo-sangatmuda text-ijo-tua text-[10px] font-bold px-3 py-1 rounded-full uppercase inline-block mb-2">
                    ● Berlangsung
                </span>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight">
                    Sosialisasi Dampak Perubahan Iklim<br class="hidden md:inline"> di Kabupaten Bogor
                </h1>
            </div>

            <!-- Meta Info (Waktu, Tanggal, Lokasi) -->
            <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600 font-medium pt-1">
                <div class="flex items-center space-x-1.5">
                    <span>🕒</span>
                    <span>07.30 – 09.00 WIB</span>
                </div>
                <div class="flex items-center space-x-1.5">
                    <span>📅</span>
                    <span>Minggu, 13 Juli 2026</span>
                </div>
                <div class="flex items-center space-x-1.5">
                    <span>📍</span>
                    <span>Aula Diskominfo, Cibinong</span>
                </div>
            </div>
        </div>

        <!-- Grid Utama Konten (Kiri: Detail, Kanan: Sidebar Widget) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- KONTEN KIRI (Deskripsi, Susunan Acara, Lampiran) -->
            <div class="lg:col-span-7 space-y-8">

                <!-- 1. Deskripsi Kegiatan -->
                <div class="space-y-2">
                    <h3 class="text-sm font-bold text-gray-900">Deskripsi Kegiatan</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Kegiatan ini bertujuan untuk meningkatkan kesadaran masyarakat Kabupaten Bogor terhadap dampak perubahan iklim yang semakin nyata dirasakan, mulai dari cuaca ekstrem hingga potensi bencana hidrometeorologi. Diskominfo bekerja sama dengan Dinas Lingkungan Hidup menghadirkan narasumber ahli untuk memberikan edukasi dan langkah mitigasi yang dapat diterapkan warga sehari-hari.
                    </p>
                </div>

                <!-- 2. Susunan Acara (Timeline Vertical) -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-gray-900">Susunan Acara</h3>
                    
                    <div class="relative pl-6 border-l-2 border-ijo-muda/40 space-y-6">
                        
                        <!-- Item Timeline 1 -->
                        <div class="relative">
                            <span class="absolute -left-[31px] top-1 w-2.5 h-2.5 rounded-full bg-ijo-tua ring-4 ring-[#F8F7F4]"></span>
                            <p class="text-xs font-bold text-ijo-tua">07.30 – 08.00</p>
                            <p class="text-xs font-semibold text-gray-800 mt-0.5">Registrasi Peserta</p>
                        </div>

                        <!-- Item Timeline 2 -->
                        <div class="relative">
                            <span class="absolute -left-[31px] top-1 w-2.5 h-2.5 rounded-full bg-ijo-tua ring-4 ring-[#F8F7F4]"></span>
                            <p class="text-xs font-bold text-ijo-tua">08.00 – 08.15</p>
                            <p class="text-xs font-semibold text-gray-800 mt-0.5">Sambutan Kepala Diskominfo Kabupaten Bogor</p>
                        </div>

                        <!-- Item Timeline 3 -->
                        <div class="relative">
                            <span class="absolute -left-[31px] top-1 w-2.5 h-2.5 rounded-full bg-ijo-tua ring-4 ring-[#F8F7F4]"></span>
                            <p class="text-xs font-bold text-ijo-tua">08.15 – 08.45</p>
                            <p class="text-xs font-semibold text-gray-800 mt-0.5">Pemaparan Materi: Dampak Perubahan Iklim di Wilayah Bogor</p>
                        </div>

                        <!-- Item Timeline 4 -->
                        <div class="relative">
                            <span class="absolute -left-[31px] top-1 w-2.5 h-2.5 rounded-full bg-ijo-tua ring-4 ring-[#F8F7F4]"></span>
                            <p class="text-xs font-bold text-ijo-tua">08.45 – 09.00</p>
                            <p class="text-xs font-semibold text-gray-800 mt-0.5">Sesi Tanya Jawab & Penutupan</p>
                        </div>

                    </div>
                </div>

                <!-- 3. Lampiran File -->
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-gray-900">Lampiran</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <!-- File 1 (PDF) -->
                        <a href="#" class="bg-white rounded-2xl p-3 border border-gray-100 shadow-sm flex items-center space-x-3 hover:border-gray-300 transition-colors">
                            <div class="w-10 h-10 rounded-xl bg-oren-muda text-oren-tua font-bold text-[10px] flex items-center justify-center shrink-0 uppercase">
                                PDF
                            </div>
                            <div class="overflow-hidden">
                                <h5 class="text-xs font-bold text-gray-900 truncate">Materi-Sosialisasi.pdf</h5>
                                <p class="text-[10px] text-gray-400">2.4 MB</p>
                            </div>
                        </a>

                        <!-- File 2 (XLS) -->
                        <a href="#" class="bg-white rounded-2xl p-3 border border-gray-100 shadow-sm flex items-center space-x-3 hover:border-gray-300 transition-colors">
                            <div class="w-10 h-10 rounded-xl bg-ijo-sangatmuda text-ijo-tua font-bold text-[10px] flex items-center justify-center shrink-0 uppercase">
                                XLS
                            </div>
                            <div class="overflow-hidden">
                                <h5 class="text-xs font-bold text-gray-900 truncate">Daftar-Hadir.xlsx</h5>
                                <p class="text-[10px] text-gray-400">128 KB</p>
                            </div>
                        </a>

                    </div>
                </div>

            </div>


            <!-- SIDEBAR KANAN (Informasi Ringkas, QR Presensi, Peserta, Map) -->
            <div class="lg:col-span-5 space-y-5">

                <!-- 1. Ringkasan Informasi -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                    <h4 class="font-bold text-sm text-gray-900">Informasi Kegiatan</h4>
                    <div class="space-y-3 text-xs divide-y divide-gray-100">
                        <div class="pt-1">
                            <p class="text-[10px] uppercase font-semibold text-gray-400">Waktu</p>
                            <p class="font-bold text-gray-800 mt-0.5">07.30 – 09.00 WIB</p>
                        </div>
                        <div class="pt-3">
                            <p class="text-[10px] uppercase font-semibold text-gray-400">Tanggal</p>
                            <p class="font-bold text-gray-800 mt-0.5">Minggu, 13 Juli 2026</p>
                        </div>
                        <div class="pt-3">
                            <p class="text-[10px] uppercase font-semibold text-gray-400">Lokasi</p>
                            <p class="font-bold text-gray-800 mt-0.5">Aula Diskominfo, Cibinong</p>
                        </div>
                        <div class="pt-3">
                            <p class="text-[10px] uppercase font-semibold text-gray-400">Penyelenggara</p>
                            <p class="font-bold text-gray-800 mt-0.5">Bidang Informasi Publik</p>
                        </div>
                    </div>
                </div>

                <!-- 2. Tombol Generate QR Presensi -->
                <div class="bg-ijo-tua text-white rounded-3xl p-5 shadow-md flex items-center space-x-4 cursor-pointer hover:bg-ijo-semitua transition-colors">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-xl shrink-0">
                        📱
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">Generate QR Presensi</h4>
                        <p class="text-[10px] text-gray-200 mt-0.5">Pilih Pegawai atau Tamu &rarr;</p>
                    </div>
                </div>

                <!-- 3. Progress Peserta Hadir -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                    <div class="flex items-center justify-between text-xs">
                        <h4 class="font-bold text-gray-900">Peserta Hadir</h4>
                        <span class="font-bold text-ijo-tua">45 / 60</span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-ijo-tua h-full rounded-full" style="width: 75%;"></div>
                    </div>

                    <!-- Avatar List Singkat -->
                    <div class="flex items-center space-x-1.5 pt-1">
                        <div class="w-8 h-8 rounded-full bg-ijo-semitua text-white text-[10px] font-bold flex items-center justify-center border-2 border-white">AF</div>
                        <div class="w-8 h-8 rounded-full bg-ijo-muda text-white text-[10px] font-bold flex items-center justify-center border-2 border-white">RW</div>
                        <div class="w-8 h-8 rounded-full bg-oren-utama text-white text-[10px] font-bold flex items-center justify-center border-2 border-white">BS</div>
                        <div class="w-8 h-8 rounded-full bg-gray-800 text-white text-[10px] font-bold flex items-center justify-center border-2 border-white">SA</div>
                        <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 text-[9px] font-bold flex items-center justify-center border-2 border-white">+41</div>
                    </div>
                </div>

                <!-- 4. Peta Lokasi (Placeholder Map) -->
                <div class="bg-ijo-sangatmuda/60 rounded-3xl p-6 border border-ijo-sangatmuda text-center space-y-2 flex flex-col items-center justify-center min-h-[140px]">
                    <div class="w-8 h-8 rounded-full bg-ijo-tua text-white flex items-center justify-center text-xs">
                        📍
                    </div>
                    <div>
                        <h5 class="font-bold text-xs text-gray-900">Aula Diskominfo Kabupaten Bogor</h5>
                        <p class="text-[10px] text-gray-500">Jl. Tegar Beriman, Cibinong</p>
                    </div>
                </div>

            </div>

        </div>

    </main>

    

</body>
@include('publik.layout_publik.footer')
</html>