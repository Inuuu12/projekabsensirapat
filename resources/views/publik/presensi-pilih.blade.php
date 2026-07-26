<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jenis Peserta Presensi - Diskominfo Kab. Bogor</title>
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

    <main class="flex-grow container mx-auto px-4 py-12 flex items-center justify-center">
        
        <!-- CARD CONTAINER / POPUP CONTAINER -->
        <div class="bg-white border border-gray-200/80 rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-lg relative space-y-6">
            
            <!-- Tombol Close (X) -->
            <a href="{{ route('publik.agenda') }}" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 font-bold transition-colors">
                ✕
            </a>

            <!-- Header Info Rapat -->
            <div class="space-y-1">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Generate QR Presensi</h1>
                <p class="text-xs text-gray-500 font-medium">Sosialisasi Dampak Perubahan Iklim</p>
                <p class="text-xs text-gray-400">07.30 – 09.00 · Aula Diskominfo</p>
            </div>

            <hr class="border-gray-100">

            <!-- Subtitle -->
            <h3 class="text-xs font-bold text-gray-800">Pilih jenis peserta</h3>

            <!-- OPSI PILIHAN ROLE (PEGAWAI / TAMU) -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Opsi Pegawai (Selected State) -->
                <a href="{{ route('publik.presensi.pegawai') }}" class="border-2 border-ijo-tua bg-ijo-sangatmuda/50 rounded-2xl p-5 text-center flex flex-col items-center justify-center space-y-3 cursor-pointer hover:shadow-md transition-all">
                    <div class="w-16 h-16 rounded-full bg-ijo-tua text-white flex items-center justify-center text-2xl">
                        👤
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900">Pegawai</h4>
                        <p class="text-[10px] text-gray-500 mt-1 leading-tight">Presensi otomatis terhubung data NIP</p>
                    </div>
                </a>

                <!-- Opsi Tamu -->
                <a href="{{ route('publik.presensi.tamu') }}" class="border border-gray-200 bg-white hover:border-ijo-tua rounded-2xl p-5 text-center flex flex-col items-center justify-center space-y-3 cursor-pointer hover:shadow-md transition-all">
                    <div class="w-16 h-16 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-2xl">
                        👤
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900">Tamu</h4>
                        <p class="text-[10px] text-gray-500 mt-1 leading-tight">Isi data kunjungan secara manual</p>
                    </div>
                </a>
            </div>

            <!-- Action Button -->
            <a href="{{ route('publik.presensi.pegawai') }}" class="w-full bg-ijo-tua hover:bg-ijo-semitua text-white font-bold text-xs py-3.5 rounded-2xl transition-colors flex items-center justify-center space-x-2 shadow-md">
                <span>Lanjutkan sebagai Pegawai</span>
                <span>&rarr;</span>
            </a>

            <!-- Batal Link -->
            <div class="text-center">
                <a href="{{ route('publik.agenda') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">Batal</a>
            </div>

        </div>

    </main>

    <!-- Memanggil Footer Publik -->
    @include('publik.layout_publik.footer')

</body>
</html>