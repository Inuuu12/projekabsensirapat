<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kepala Diskominfo Dampingi Kampanye Iklim di Car Free Day - Diskominfo Kabupaten Bogor</title>
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

    <main class="flex-grow container mx-auto px-6 lg:px-12 py-8 space-y-6 max-w-7xl">

        <!-- Breadcrumb Navigation -->
        <nav class="text-xs text-gray-500 flex items-center space-x-2 flex-wrap">
            <a href="/publik" class="hover:underline">Beranda</a>
            <span>/</span>
            <a href="/publik/berita" class="hover:underline">Berita</a>
            <span>/</span>
            <span class="text-gray-800 font-semibold truncate max-w-xs md:max-w-md">Kepala Diskominfo Dampingi Kampanye Iklim di CFD</span>
        </nav>

        <!-- Back Button -->
        <div>
            <a href="/publik/berita" class="inline-flex items-center space-x-2 text-xs font-bold text-ijo-tua hover:text-ijo-semitua transition-colors">
                <span>&larr;</span>
                <span>Kembali ke Berita</span>
            </a>
        </div>

        <!-- MAIN LAYOUT (Content Left 8 Cols, Sidebar Right 4 Cols) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- LEFT CONTENT COLUMN (8 Cols) -->
            <article class="lg:col-span-8 space-y-6">

                <!-- Featured Image Box -->
                <div class="w-full h-72 md:h-[400px] bg-[#6A9C95] rounded-3xl relative p-6 shadow-sm overflow-hidden flex items-start">
                    <span class="bg-white text-gray-800 text-xs font-bold px-4 py-1.5 rounded-full shadow-md">
                        Kegiatan
                    </span>
                </div>

                <!-- Meta Info Date & Source -->
                <div class="flex items-center space-x-2 text-xs text-gray-500 font-mono">
                    <span>12 Juli 2026</span>
                    <span>&bull;</span>
                    <span>Sumber: Bidang Informasi Publik Diskominfo</span>
                </div>

                <!-- Main News Title -->
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight">
                    Kepala Diskominfo Dampingi Kampanye Iklim di Car Free Day
                </h1>

                <hr class="border-gray-200 my-4">

                <!-- Article Body Paragraphs -->
                <div class="space-y-4 text-xs md:text-sm text-gray-700 leading-relaxed">
                    <p>
                        Dalam rangka memperingati momentum global climate action, Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Bogor turut ambil bagian dalam kegiatan Car Free Day (CFD) yang digelar di kawasan Tegar Beriman, Cibinong, Minggu (12/7). Kepala Diskominfo Kabupaten Bogor turun langsung mendampingi warga dalam kampanye kesadaran perubahan iklim.
                    </p>

                    <p>
                        Kegiatan ini menghadirkan booth edukasi interaktif, pembagian bibit pohon, serta konsultasi gratis seputar mitigasi bencana hidrometeorologi. Menurut Kepala Diskominfo, pemilihan CFD sebagai lokasi kampanye bukan tanpa alasan &mdash; momen ini dinilai efektif menjangkau warga dari berbagai kalangan usia yang berolahraga setiap akhir pekan.
                    </p>

                    <!-- Blockquote Section -->
                    <blockquote class="border-l-4 border-oren-utama pl-4 py-2 my-6 bg-oren-muda/30 rounded-r-xl italic text-gray-800 font-medium">
                        &ldquo;Kami ingin memastikan informasi mengenai dampak perubahan cuaca ekstrem sampai ke masyarakat secara langsung, bukan hanya lewat media sosial,&rdquo; <br>
                        <span class="not-italic text-xs text-gray-500 mt-1 block">&mdash; ujar Kepala Diskominfo di sela kegiatan. Edukasi semacam ini akan terus dilakukan berkala di berbagai titik strategis Kabupaten Bogor.</span>
                    </blockquote>

                    <p>
                        Selain unsur edukasi, kegiatan ini juga menjadi ajang sosialisasi layanan digital milik Diskominfo, termasuk aplikasi pelaporan cuaca ekstrem yang terintegrasi dengan BMKG. Warga yang hadir tampak antusias mencoba fitur baru yang ditampilkan melalui layar interaktif di lokasi.
                    </p>
                </div>

                <hr class="border-gray-200 my-6">

                <!-- Share Section -->
                <div class="flex items-center space-x-3 text-xs">
                    <span class="font-bold text-gray-700">Bagikan:</span>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 flex items-center justify-center transition-colors">
                        f
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 flex items-center justify-center transition-colors">
                        💬
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 flex items-center justify-center transition-colors">
                        🔗
                    </a>
                </div>

            </article>

            <!-- RIGHT SIDEBAR COLUMN (4 Cols) -->
            <aside class="lg:col-span-4 space-y-6">

                <!-- CARD 1: Informasi Artikel -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-bold text-sm text-gray-900 border-b border-gray-100 pb-3">Informasi Artikel</h3>
                    
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 uppercase font-semibold text-[10px] tracking-wider">TANGGAL</span>
                            <span class="font-bold text-gray-800">12 Juli 2026</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 uppercase font-semibold text-[10px] tracking-wider">SUMBER</span>
                            <span class="font-bold text-gray-800 text-right">Bidang Informasi Publik</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 uppercase font-semibold text-[10px] tracking-wider">KATEGORI</span>
                            <div class="flex space-x-1">
                                <span class="bg-ijo-sangatmuda text-ijo-tua font-bold px-2.5 py-0.5 rounded-full text-[10px]">Kegiatan</span>
                                <span class="bg-ijo-sangatmuda text-ijo-tua font-bold px-2.5 py-0.5 rounded-full text-[10px]">Kegiatan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Berita Terkait -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-bold text-sm text-gray-900 border-b border-gray-100 pb-3">Berita Terkait</h3>

                    <div class="space-y-4">
                        <!-- Item 1 -->
                        <div class="flex space-x-3 items-center group">
                            <div class="w-16 h-16 bg-[#3B7A75] rounded-2xl shrink-0"></div>
                            <div class="space-y-1">
                                <p class="text-[10px] text-gray-400 font-mono">10 Juli 2026</p>
                                <h4 class="text-xs font-bold text-gray-900 group-hover:text-ijo-semitua transition-colors line-clamp-2">
                                    <a href="/publik/berita/detail">Diskominfo Luncurkan Layanan Pengaduan Online</a>
                                </h4>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="flex space-x-3 items-center group">
                            <div class="w-16 h-16 bg-[#1A3A37] rounded-2xl shrink-0"></div>
                            <div class="space-y-1">
                                <p class="text-[10px] text-gray-400 font-mono">8 Juli 2026</p>
                                <h4 class="text-xs font-bold text-gray-900 group-hover:text-ijo-semitua transition-colors line-clamp-2">
                                    <a href="/publik/berita/detail">Pelatihan Jurnalistik Digital untuk 60 ASN</a>
                                </h4>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="flex space-x-3 items-center group">
                            <div class="w-16 h-16 bg-[#D29D47] rounded-2xl shrink-0"></div>
                            <div class="space-y-1">
                                <p class="text-[10px] text-gray-400 font-mono">6 Juli 2026</p>
                                <h4 class="text-xs font-bold text-gray-900 group-hover:text-ijo-semitua transition-colors line-clamp-2">
                                    <a href="/publik/berita/detail">Aplikasi SIAP Bogor Resmi Diluncurkan</a>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 text-center">
                        <a href="/publik/berita" class="text-xs font-bold text-ijo-tua hover:text-ijo-semitua inline-flex items-center space-x-1">
                            <span>Lihat Semua Berita</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>

            </aside>

        </div>

    </main>

    <!-- Memanggil Footer Publik -->
    @include('publik.layout_publik.footer') 

</body>
</html>