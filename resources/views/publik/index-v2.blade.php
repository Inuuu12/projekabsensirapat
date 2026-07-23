<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Publik v2 - Diskominfo Kabupaten Bogor</title>
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

    <!-- Memanggil Navbar Publik -->
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

        <!-- 2. Header Grid (Widget Cuaca & Ulang Tahun Pegawai) -->
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

        <!-- 3. Banner Kunjungan Pejabat (Fitur Tambahan V2) -->
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-ijo-sangatmuda rounded-2xl flex items-center justify-center text-ijo-tua text-xl shrink-0">
                    🏛️
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">Ingin Bertemu Pejabat Kami?</h3>
                    <p class="text-xs text-gray-500">Daftarkan kunjungan Anda secara online &mdash; cepat, tanpa antre di lokasi</p>
                </div>
            </div>
            <a href="/publik/kunjungan-pejabat" class="bg-ijo-tua hover:bg-ijo-semitua text-white text-xs font-bold px-5 py-3 rounded-xl transition-colors shrink-0 flex items-center space-x-2">
                <span>Isi Form Kunjungan Pejabat</span>
                <span>&rarr;</span>
            </a>
        </div>

        <!-- 4. Section Agenda Hari Ini -->
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

        <!-- 5. Section Media (Video Terbaru & Galeri) -->
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

        <!-- 6. Section Berita Terkini & Ulang Tahun Pegawai List -->
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

        <!-- 7. Section Riwayat Feedback (Update Spesifik V2) -->
        <section class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Riwayat Feedback</h3>
                    <p class="text-xs text-gray-500">Status diperbarui otomatis oleh admin Diskominfo &bull; identitas pengirim disamarkan</p>
                </div>
                <a href="/publik/feedback" class="text-xs font-semibold text-gray-700 bg-gray-200 hover:bg-gray-300 px-4 py-1.5 rounded-full transition-colors">
                    Selengkapnya
                </a>
            </div>

            <!-- Tab Filter Feedback -->
            <div class="flex space-x-2 text-xs font-medium">
                <button class="bg-oren-muda text-oren-tua px-4 py-1 rounded-full font-bold">Menunggu</button>
                <button class="bg-biru-muda text-biru-tua px-4 py-1 rounded-full">Proses</button>
                <button class="bg-ijo-sangatmuda text-ijo-tua px-4 py-1 rounded-full">Selesai</button>
            </div>

            <!-- Tabel Riwayat Feedback Publik (Email Disensor) -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-gray-100 text-gray-500 uppercase text-[10px] tracking-wider">
                            <th class="p-3 rounded-l-xl">EMAIL PENGIRIM</th>
                            <th class="p-3">FEEDBACK</th>
                            <th class="p-3">WAKTU</th>
                            <th class="p-3">TANGGAL</th>
                            <th class="p-3 text-center rounded-r-xl">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                        <tr>
                            <td class="p-3 font-mono font-bold text-gray-800">sit***@gmail.com</td>
                            <td class="p-3 text-gray-500">Ruang rapat bentrok jadwal...</td>
                            <td class="p-3 text-gray-400">09:30</td>
                            <td class="p-3 text-gray-400">12 Jul</td>
                            <td class="p-3 text-center">
                                <span class="bg-biru-muda text-biru-tua font-bold px-3 py-1 rounded-full text-[10px]">Proses</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-3 font-mono font-bold text-gray-800">riz***@gmail.com</td>
                            <td class="p-3 text-gray-500">Fitur presensi QR tidak muncul...</td>
                            <td class="p-3 text-gray-400">10:30</td>
                            <td class="p-3 text-gray-400">10 Jul</td>
                            <td class="p-3 text-center">
                                <span class="bg-biru-muda text-biru-tua font-bold px-3 py-1 rounded-full text-[10px]">Proses</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-3 font-mono font-bold text-gray-800">dew***@gmail.com</td>
                            <td class="p-3 text-gray-500">Undangan rapat tidak terkirim...</td>
                            <td class="p-3 text-gray-400">12:00</td>
                            <td class="p-3 text-gray-400">8 Jul</td>
                            <td class="p-3 text-center">
                                <span class="bg-biru-muda text-biru-tua font-bold px-3 py-1 rounded-full text-[10px]">Proses</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="p-3 font-mono font-bold text-gray-800">bag***@gmail.com</td>
                            <td class="p-3 text-gray-500">Aplikasi absensi error saat submit...</td>
                            <td class="p-3 text-gray-400">14:00</td>
                            <td class="p-3 text-gray-400">4 Jul</td>
                            <td class="p-3 text-center">
                                <span class="bg-biru-muda text-biru-tua font-bold px-3 py-1 rounded-full text-[10px]">Proses</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between pt-2">
                <p class="text-[10px] text-gray-400">Feedback baru akan tampil di sini setelah mulai ditindaklanjuti admin</p>
                <a href="/publik/feedback" class="text-xs font-bold text-ijo-tua hover:underline">Buat Feedback Baru &rarr;</a>
            </div>
        </section>

    </main>

   
@include('publik.layout_publik.footer')
</body>
</html>