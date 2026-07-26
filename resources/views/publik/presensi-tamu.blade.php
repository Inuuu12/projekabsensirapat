<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tamu Rapat - Diskominfo Kab. Bogor</title>
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

            <!-- Top Row: Kembali & Badge Tamu Rapat -->
            <div class="flex items-center justify-between">
                <a href="{{ route('publik.presensi.pilih') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-ijo-semitua hover:underline">
                    <span>&larr;</span>
                    <span>Kembali</span>
                </a>

                <span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-3 py-1 rounded-full">
                    Tamu Rapat
                </span>
            </div>

            <!-- Header Title -->
            <div class="space-y-1">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Form Tamu Rapat</h1>
                <p class="text-xs text-gray-500 font-medium">Sosialisasi Dampak Perubahan Iklim · 07.30 – 09.00</p>
            </div>

            <hr class="border-gray-100">

            <!-- FORM TAMU -->
            <form action="#" method="POST" class="space-y-4">
                @csrf

                <!-- Nama Lengkap -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-800">Nama Lengkap *</label>
                    <input type="text" required placeholder="Masukkan nama lengkap" 
                           class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3.5 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                </div>

                <!-- Instansi / Asal -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-800">Instansi / Asal *</label>
                    <input type="text" required placeholder="Contoh: Dinas Pendidikan Kab. Bogor" 
                           class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3.5 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                </div>

                <!-- No HP / WhatsApp -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-800">No. HP / WhatsApp *</label>
                    <input type="text" required placeholder="08xx-xxxx-xxxx" 
                           class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3.5 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                </div>

                <!-- Email -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-800">Email *</label>
                    <input type="email" required placeholder="Masukkan alamat email anda" 
                           class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3.5 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-ijo-tua hover:bg-ijo-semitua text-white font-bold text-xs py-3.5 rounded-2xl transition-colors flex items-center justify-center space-x-2 shadow-md">
                        <span>Daftar Hadir</span>
                        <span>&rarr;</span>
                    </button>
                </div>

            </form>

        </div>

    </main>

    <!-- Memanggil Footer Publik -->
    @include('publik.layout_publik.footer')

</body>
</html>