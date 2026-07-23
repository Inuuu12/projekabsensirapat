<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Publik - Diskominfo Kabupaten Bogor</title>
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
                        'biru-muda': '#DCEEF5',
                        'biru-tua': '#1E6E8C',
                        'oren-muda': '#FBEBD1',
                        'oren-tua': '#B87A1E',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8F7F4] font-sans antialiased text-gray-800 flex flex-col min-h-screen">

    <!-- Memanggil Navbar Publik (Sesuai Path Komponen Terbaru) -->
    @include('publik.layout_publik.navbarpublik') 

    <main class="flex-grow container mx-auto px-4 md:px-12 py-6 space-y-8 max-w-7xl">

        <!-- 1. Running Text Info Terkini -->
        <div class="bg-white rounded-2xl shadow-sm p-3 flex items-center space-x-3 border border-gray-100">
            <span class="bg-ijo-tua text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shrink-0">
                INFO TERKINI
            </span>
            <marquee class="text-xs font-medium text-gray-700">
                Pelayanan administrasi kependudukan tutup lebih awal Jumat, 18 Juli 2026 pukul 14.00 WIB &bull; Pendaftaran Pelatihan Jurnalistik Digital ASN dibuka hingga 20 Juli
            </marquee>
        </div>

        <!-- 2. Header Grid (Widget Cuaca & Banner Ulang Tahun Pegawai Hari Ini) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Widget Cuaca -->
            <div class="lg:col-span-6 bg-ijo-tua text-white rounded-3xl p-6 flex items-center justify-between shadow-md">
                <div>
                    <p class="text-xs text-gray-200">Cibinong, Kab. Bogor</p>
                    <h2 class="text-4xl font-extrabold mt-1">27°C</h2>
                    <p class="text-xs text-gray-200 mt-1">Berawan &bull; Terasa 29°C</p>
                    <p class="text-[10px] text-gray-300 mt-2">💧 78% &nbsp; 💨 12 km/h</p>
                </div>
                <div class="text-5xl">⛅</div>
            </div>

            <!-- Widget Ulang Tahun Hari Ini -->
            <div class="lg:col-span-6 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-2xl bg-ijo-semitua text-white font-extrabold text-lg flex items-center justify-center shrink-0">
                        DK
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-base">🎂</span>
                            <h3 class="font-bold text-gray-900 text-sm">Dedi Kurniawan berulang tahun hari ini!</h3>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Staff IT & Jaringan &bull; Bidang Infrastruktur TI</p>
                    </div>
                </div>
                <div class="flex flex-col items-end space-y-2 shrink-0">
                    <span class="bg-oren-muda text-oren-tua text-[10px] font-bold px-3 py-1 rounded-full">🎉 Hari Ini!</span>
                    <a href="/publik/ulang-tahun" class="text-xs font-bold text-ijo-tua hover:underline">Selengkapnya &rarr;</a>
                </div>
            </div>
        </div>

        <!-- 3. Section Agenda Hari Ini -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Agenda Hari Ini</h3>
                    <p class="text-xs text-gray-500">Minggu, 13 Juli 2026 &bull; 3 kegiatan terjadwal</p>
                </div>
                <a href="/publik/agenda" class="text-xs font-semibold text-gray-700 bg-gray-200 hover:bg-gray-300 px-4 py-1.5 rounded-full transition-colors">
                    Selengkapnya
                </a>
            </div>

            <!-- Cards Agenda -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 (Berlangsung) -->
                <div class="bg-ijo-tua text-white rounded-2xl p-5 flex flex-col justify-between space-y-4 shadow-md">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs text-gray-300">
                            <span>07.30 - 09.00</span>
                            <span class="bg-oren-utama text-white text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">● Berlangsung</span>
                        </div>
                        <h4 class="font-bold text-sm leading-snug">Sosialisasi Dampak Perubahan Iklim di Kabupaten Bogor</h4>
                        <p class="text-xs text-gray-300">📍 Aula Diskominfo, Cibinong</p>
                    </div>
                    <div class="flex items-center justify-between border-t border-white/10 pt-3 text-xs">
                        <span class="bg-oren-muda text-oren-tua font-bold px-3 py-1 rounded-full text-[10px]">45 Peserta</span>
                        <button class="bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded-lg text-[10px] font-semibold transition-colors flex items-center space-x-1">
                            <span>📱</span> <span>Generate QR</span>
                        </button>
                    </div>
                </div>

                <!-- Card 2 (Akan Datang) -->
                <div class="bg-ijo-tua text-white rounded-2xl p-5 flex flex-col justify-between space-y-4 shadow-md">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs text-gray-300">
                            <span>09.30 - 11.00</span>
                            <span class="bg-white/20 text-white text-[10px] font-medium px-2 py-0.5 rounded-full">Akan Datang</span>
                        </div>
                        <h4 class="font-bold text-sm leading-snug">Rapat Koordinasi Program Smart City Kabupaten Bogor</h4>
                        <p class="text-xs text-gray-300">📍 Ruang Rapat Bupati, Setda</p>
                    </div>
                    <div class="flex items-center justify-between border-t border-white/10 pt-3 text-xs">
                        <span class="bg-oren-muda text-oren-tua font-bold px-3 py-1 rounded-full text-[10px]">28 Peserta</span>
                        <button class="bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded-lg text-[10px] font-semibold transition-colors flex items-center space-x-1">
                            <span>📱</span> <span>Generate QR</span>
                        </button>
                    </div>
                </div>

                <!-- Card 3 (Akan Datang) -->
                <div class="bg-ijo-tua text-white rounded-2xl p-5 flex flex-col justify-between space-y-4 shadow-md">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs text-gray-300">
                            <span>13.00 - 15.00</span>
                            <span class="bg-white/20 text-white text-[10px] font-medium px-2 py-0.5 rounded-full">Akan Datang</span>
                        </div>
                        <h4 class="font-bold text-sm leading-snug">Pelatihan Jurnalistik Digital bagi ASN Kabupaten Bogor</h4>
                        <p class="text-xs text-gray-300">📍 Gedung Serbaguna, Cibinong</p>
                    </div>
                    <div class="flex items-center justify-between border-t border-white/10 pt-3 text-xs">
                        <span class="bg-oren-muda text-oren-tua font-bold px-3 py-1 rounded-full text-[10px]">60 Peserta</span>
                        <button class="bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded-lg text-[10px] font-semibold transition-colors flex items-center space-x-1">
                            <span>📱</span> <span>Generate QR</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. Section Media (Video Terbaru & Galeri) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Video Terbaru -->
            <div class="lg:col-span-7 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Video Terbaru</h3>
                        <p class="text-xs text-gray-500">Otomatis dari dokumentasi kegiatan agenda</p>
                    </div>
                    <a href="/publik/video" class="text-xs font-bold text-ijo-tua hover:underline">Lihat Semua &rarr;</a>
                </div>
                <div class="relative bg-ijo-tua rounded-3xl overflow-hidden shadow-md aspect-video flex flex-col justify-between p-6 text-white">
                    <div class="self-end bg-black/40 text-[10px] px-2 py-0.5 rounded-md font-mono">04:12</div>
                    
                    <!-- Play Button Central Icon -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <button class="w-14 h-14 bg-white text-ijo-tua rounded-full flex items-center justify-center shadow-lg hover:scale-105 transition-transform pl-1">
                            ▶
                        </button>
                    </div>

                    <div class="relative z-10 bg-black/30 -mx-6 -mb-6 p-4 backdrop-blur-sm">
                        <h4 class="font-bold text-sm">Dokumentasi Car Free Day: Edukasi Perubahan Iklim untuk Warga</h4>
                        <p class="text-[10px] text-gray-300 mt-1">Diunggah 12 Jul 2026 &bull; 3.240 ditonton</p>
                    </div>
                </div>
            </div>

            <!-- Galeri Foto -->
            <div class="lg:col-span-5 space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-900">Galeri</h3>
                    <a href="/publik/galeri" class="text-xs font-bold text-ijo-tua hover:underline">Lihat Semua &rarr;</a>
                </div>
                <div class="grid grid-cols-2 gap-3 h-[240px]">
                    <div class="bg-ijo-muda rounded-2xl h-full shadow-sm"></div>
                    <div class="space-y-3 h-full flex flex-col">
                        <div class="bg-ijo-semitua rounded-2xl flex-1 shadow-sm"></div>
                        <div class="bg-ijo-tua rounded-2xl flex-1 shadow-sm flex items-center justify-center text-white font-bold text-sm">
                            +18 Foto
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Section Berita Terkini & Widget Ulang Tahun Pegawai List -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Berita Terkini -->
            <div class="lg:col-span-8 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Berita Terkini</h3>
                        <p class="text-xs text-gray-500">Kabar terbaru seputar Diskominfo Kabupaten Bogor</p>
                    </div>
                    <a href="/publik/berita" class="text-xs font-semibold text-gray-700 bg-gray-200 hover:bg-gray-300 px-4 py-1.5 rounded-full transition-colors">
                        Selengkapnya
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Card Berita 1 -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 flex flex-col justify-between">
                        <div>
                            <div class="h-40 bg-ijo-muda relative p-4">
                                <span class="bg-white text-ijo-tua font-bold text-[10px] px-3 py-1 rounded-full">Kegiatan</span>
                            </div>
                            <div class="p-5 space-y-2">
                                <p class="text-[10px] text-gray-400 font-semibold">12 Juli 2026</p>
                                <h4 class="font-bold text-gray-900 text-sm leading-snug">Kepala Diskominfo Dampingi Kampanye Iklim di CFD</h4>
                                <p class="text-xs text-gray-500 line-clamp-2">Mengedukasi warga tentang dampak perubahan cuaca ekstrem di Bogor...</p>
                            </div>
                        </div>
                        <div class="p-5 pt-0">
                            <a href="/publik/berita/detail" class="text-xs font-bold text-ijo-tua hover:underline">Baca Selengkapnya &rarr;</a>
                        </div>
                    </div>

                    <!-- Card Berita 2 -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 flex flex-col justify-between">
                        <div>
                            <div class="h-40 bg-ijo-semitua relative p-4">
                                <span class="bg-white text-ijo-tua font-bold text-[10px] px-3 py-1 rounded-full">Layanan</span>
                            </div>
                            <div class="p-5 space-y-2">
                                <p class="text-[10px] text-gray-400 font-semibold">10 Juli 2026</p>
                                <h4 class="font-bold text-gray-900 text-sm leading-snug">Layanan Pengaduan Online Kini Terintegrasi</h4>
                                <p class="text-xs text-gray-500 line-clamp-2">Warga bisa melapor keluhan tanpa perlu datang langsung ke kantor...</p>
                            </div>
                        </div>
                        <div class="p-5 pt-0">
                            <a href="/publik/berita/detail" class="text-xs font-bold text-ijo-tua hover:underline">Baca Selengkapnya &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List Ulang Tahun Pegawai -->
            <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4 flex flex-col justify-between">
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="text-base">🎂</span>
                        <h3 class="font-bold text-gray-900 text-sm">Ulang Tahun Pegawai</h3>
                    </div>
                    <p class="text-xs text-gray-500">Jangan lupa ucapkan selamat ke rekan kerja</p>

                    <div class="mt-4 space-y-3">
                        <!-- Item 1 (Hari Ini) -->
                        <div class="bg-oren-muda rounded-2xl p-3 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-ijo-tua text-white font-bold text-xs flex items-center justify-center">
                                    DK
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold text-gray-900">Dedi Kurniawan</h5>
                                    <p class="text-[10px] text-gray-500">Staff IT & Jaringan</p>
                                    <span class="bg-oren-tua text-white text-[9px] font-bold px-2 py-0.5 rounded-full mt-0.5 inline-block">🎉 Hari Ini!</span>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-oren-tua">14 Jul</span>
                        </div>

                        <!-- Item 2 -->
                        <div class="flex items-center justify-between p-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-ijo-muda text-white font-bold text-xs flex items-center justify-center">
                                    RW
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold text-gray-900">Rina Wulandari</h5>
                                    <p class="text-[10px] text-gray-500">Analis Data</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-medium text-gray-400">18 Jul</span>
                        </div>

                        <!-- Item 3 -->
                        <div class="flex items-center justify-between p-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-oren-utama text-white font-bold text-xs flex items-center justify-center">
                                    BS
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold text-gray-900">Bayu Segara</h5>
                                    <p class="text-[10px] text-gray-500">Humas & Publikasi</p>
                                </div>
                            </div>
                            <span class="text-[10px] font-medium text-gray-400">22 Jul</span>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-3 text-center">
                    <a href="/publik/ulang-tahun" class="text-xs font-bold text-ijo-tua hover:underline">Lihat Semua Pegawai &rarr;</a>
                </div>
            </div>
        </div>

        <!-- 6. Section Riwayat Aduan Saya -->
        <section class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Riwayat Aduan Saya</h3>
                    <p class="text-xs text-gray-500">Status diperbarui otomatis oleh admin Diskominfo</p>
                </div>
                <a href="/publik/feedback" class="text-xs font-semibold text-gray-700 bg-gray-200 hover:bg-gray-300 px-4 py-1.5 rounded-full transition-colors">
                    Selengkapnya
                </a>
            </div>

            <!-- Tabel Riwayat Aduan -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-gray-100 text-gray-500 uppercase text-[10px] tracking-wider">
                            <th class="p-3 rounded-l-xl">NAMA PENGADU</th>
                            <th class="p-3">ISI ADUAN</th>
                            <th class="p-3 text-center">STATUS</th>
                            <th class="p-3 text-right rounded-r-xl">TANGGAL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                        <!-- Row 1: Pending -->
                        <tr>
                            <td class="p-3 font-bold text-gray-900">Ahmad Fauzan</td>
                            <td class="p-3 text-gray-500">Aplikasi SIAP Bogor gagal login...</td>
                            <td class="p-3 text-center">
                                <span class="bg-oren-muda text-oren-tua font-bold px-3 py-1 rounded-full text-[10px]">Pending</span>
                            </td>
                            <td class="p-3 text-right text-gray-400">13 Jul</td>
                        </tr>

                        <!-- Row 2: Diproses -->
                        <tr>
                            <td class="p-3 font-bold text-gray-900">Siti Nurhaliza</td>
                            <td class="p-3 text-gray-500">Ruang rapat bentrok jadwal...</td>
                            <td class="p-3 text-center">
                                <span class="bg-biru-muda text-biru-tua font-bold px-3 py-1 rounded-full text-[10px]">Diproses</span>
                            </td>
                            <td class="p-3 text-right text-gray-400">12 Jul</td>
                        </tr>

                        <!-- Row 3: Selesai -->
                        <tr>
                            <td class="p-3 font-bold text-gray-900">Rizky Pratama</td>
                            <td class="p-3 text-gray-500">Fitur presensi QR tidak muncul...</td>
                            <td class="p-3 text-center">
                                <span class="bg-ijo-sangatmuda text-ijo-tua font-bold px-3 py-1 rounded-full text-[10px]">Selesai</span>
                            </td>
                            <td class="p-3 text-right text-gray-400">10 Jul</td>
                        </tr>

                        <!-- Row 4: Selesai -->
                        <tr>
                            <td class="p-3 font-bold text-gray-900">Dewi Anggraini</td>
                            <td class="p-3 text-gray-500">Undangan rapat tidak terkirim...</td>
                            <td class="p-3 text-center">
                                <span class="bg-ijo-sangatmuda text-ijo-tua font-bold px-3 py-1 rounded-full text-[10px]">Selesai</span>
                            </td>
                            <td class="p-3 text-right text-gray-400">8 Jul</td>
                        </tr>

                        <!-- Row 5: Diproses -->
                        <tr>
                            <td class="p-3 font-bold text-gray-900">Bagus Wicaksono</td>
                            <td class="p-3 text-gray-500">Aplikasi absensi error saat submit...</td>
                            <td class="p-3 text-center">
                                <span class="bg-biru-muda text-biru-tua font-bold px-3 py-1 rounded-full text-[10px]">Diproses</span>
                            </td>
                            <td class="p-3 text-right text-gray-400">4 Jul</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end pt-2">
                <a href="/publik/feedback" class="text-xs font-bold text-ijo-tua hover:underline">Buat Aduan Baru &rarr;</a>
            </div>
        </section>

    </main>

  
@include('publik.layout_publik.footer')
</body>
</html>