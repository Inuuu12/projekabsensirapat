<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Pegawai - Diskominfo Kab. Bogor</title>
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
        
        <!-- CARD CONTAINER -->
        <div class="bg-white border border-gray-200/80 rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-lg relative space-y-6">
            
            <!-- Tombol Close (X) -->
            <a href="{{ route('publik.agenda') }}" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 font-bold transition-colors">
                ✕
            </a>

            <!-- Kembali Link -->
            <a href="{{ route('publik.presensi.pilih') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-ijo-semitua hover:underline">
                <span>&larr;</span>
                <span>Kembali</span>
            </a>

            <!-- Header Info Rapat -->
            <div class="space-y-1">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Presensi Pegawai</h1>
                <p class="text-xs text-gray-500 font-medium">Sosialisasi Dampak Perubahan Iklim</p>
                <p class="text-xs text-gray-400">07.30 – 09.00 · Aula Diskominfo</p>
            </div>

            <hr class="border-gray-100">

            <!-- Subtitle -->
            <h3 class="text-xs font-bold text-gray-800">Pilih metode presensi</h3>

            <!-- METODE PRESENSI -->
            <div class="space-y-3">
                
                <!-- Opsi 1: Generate QR Code (Active State) -->
                <div class="border-2 border-ijo-tua bg-ijo-sangatmuda/50 rounded-2xl p-4 flex items-center justify-between cursor-pointer shadow-sm relative">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-ijo-tua text-white flex items-center justify-center text-xl shrink-0">
                            🏁
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900">Generate QR Code</h4>
                            <p class="text-[11px] text-gray-500">Scan melalui aplikasi....</p>
                        </div>
                    </div>
                    <!-- Checkmark Badge -->
                    <div class="w-6 h-6 rounded-full bg-ijo-tua text-white flex items-center justify-center text-xs font-bold shrink-0">
                        ✓
                    </div>
                </div>

                <!-- Opsi 2: Absen Manual -->
                <div class="border border-gray-200 bg-white hover:border-ijo-tua rounded-2xl p-4 flex items-center space-x-4 cursor-pointer transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-gray-100 text-gray-500 flex items-center justify-center text-xl shrink-0">
                        👤
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900">Absen Manual</h4>
                        <p class="text-[11px] text-gray-400">Jika terkendala dengan QR CODE bisa melalui Isi manual</p>
                    </div>
                </div>

            </div>

            <!-- Action Button -->
            <button type="button" class="w-full bg-ijo-tua hover:bg-ijo-semitua text-white font-bold text-xs py-3.5 rounded-2xl transition-colors flex items-center justify-center space-x-2 shadow-md">
                <span>Lanjutkan dengan QR Code</span>
                <span>&rarr;</span>
            </button>

        </div>

    </main>

    <!-- Memanggil Footer Publik -->
    @include('publik.layout_publik.footer')

</body>
</html>