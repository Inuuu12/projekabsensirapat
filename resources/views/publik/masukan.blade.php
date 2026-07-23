<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sampaikan Masukan Anda - Diskominfo Kabupaten Bogor</title>
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

        <!-- Breadcrumb & Header Section -->
        <div class="space-y-2">
            <nav class="text-xs text-gray-500 flex items-center space-x-2">
                <a href="/publik" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 font-semibold">Feedback</span>
            </nav>

            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Sampaikan Masukan Anda</h1>
                <p class="text-xs text-gray-500 mt-1">Laporkan kendala pelaksanaan rapat atau masalah teknis aplikasi di lingkungan Diskominfo</p>
            </div>
        </div>

        <!-- MAIN LAYOUT (Form Left 8 Cols, Sidebar Right 4 Cols) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- LEFT FORM COLUMN (8 Cols) -->
            <div class="lg:col-span-8 bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm space-y-6">
                
                <div class="border-b border-gray-100 pb-4">
                    <h2 class="text-base font-bold text-gray-900">Ajukan Masukan Baru</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Semua kolom wajib diisi</p>
                </div>

                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <!-- Email Input -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">Email *</label>
                        <input type="email" required placeholder="nama@email.com" 
                               class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                        <p class="text-[10px] text-gray-400 flex items-center space-x-1 pt-0.5">
                            <span>🔒</span>
                            <span>Email akan disamarkan otomatis saat ditampilkan ke publik</span>
                        </p>
                    </div>

                    <!-- No HP Input -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">No. HP *</label>
                        <input type="text" required placeholder="08xx-xxxx-xxxx" 
                               class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                    </div>

                    <!-- Kategori Masalah Dropdown -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">Kategori Masalah *</label>
                        <div class="relative">
                            <select required class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3 text-gray-600 appearance-none focus:outline-none transition-all cursor-pointer">
                                <option value="" disabled selected>Pilih kategori masalah</option>
                                <option value="rapat">Kendala Pelaksanaan Rapat</option>
                                <option value="aplikasi">Masalah Teknis Aplikasi</option>
                                <option value="infrastruktur">Jaringan / WiFi / Jaringan TI</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500 text-xs">
                                ▼
                            </div>
                        </div>
                    </div>

                    <!-- Isi Masukan Textarea -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">Isi Masukan *</label>
                        <textarea rows="4" required placeholder="Jelaskan detail masalah yang Anda alami, contoh: ruang rapat bentrok jadwal, atau aplikasi SIAP Bogor gagal login sejak pagi ini..." 
                                  class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl p-4 text-gray-800 placeholder-gray-400 focus:outline-none transition-all resize-none"></textarea>
                    </div>

                    <!-- Lampiran File Upload -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">Lampiran</label>
                        <label class="flex items-center space-x-3 bg-[#EAE8E1]/60 hover:bg-[#EAE8E1] border-2 border-dashed border-sky-400 rounded-2xl px-4 py-3 cursor-pointer transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-white/80 flex items-center justify-center shrink-0 text-xs shadow-sm">
                                🖼️
                            </div>
                            <div class="text-xs">
                                <p class="font-bold text-gray-800">Klik untuk unggah gambar</p>
                                <p class="text-[10px] text-gray-400">PNG, JPG, atau WEBP - maks 5MB per gambar</p>
                            </div>
                            <input type="file" accept="image/*" class="hidden">
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-ijo-tua hover:bg-ijo-semitua text-white font-bold text-xs py-3.5 rounded-2xl transition-colors flex items-center justify-center space-x-2 shadow-md">
                            <span>Kirim Feedback</span>
                            <span>&rarr;</span>
                        </button>
                    </div>

                </form>
            </div>

            <!-- RIGHT SIDEBAR COLUMN (4 Cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- CARD 1: Tips Mengisi Feedback -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-bold text-sm text-gray-900">Tips Mengisi Feedback yang Baik</h3>
                    
                    <ul class="space-y-3 text-xs text-gray-600">
                        <li class="flex items-start space-x-2.5">
                            <span class="w-5 h-5 rounded-full bg-ijo-sangatmuda text-ijo-tua flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">✓</span>
                            <span>Jelaskan kronologi kejadian secara singkat & jelas</span>
                        </li>
                        <li class="flex items-start space-x-2.5">
                            <span class="w-5 h-5 rounded-full bg-ijo-sangatmuda text-ijo-tua flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">✓</span>
                            <span>Sertakan waktu & lokasi kejadian jika relevan</span>
                        </li>
                        <li class="flex items-start space-x-2.5">
                            <span class="w-5 h-5 rounded-full bg-ijo-sangatmuda text-ijo-tua flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">✓</span>
                            <span>Gunakan bahasa yang sopan dan mudah dipahami</span>
                        </li>
                        <li class="flex items-start space-x-2.5">
                            <span class="w-5 h-5 rounded-full bg-ijo-sangatmuda text-ijo-tua flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">✓</span>
                            <span>Satu formulir untuk satu masalah agar mudah ditelusuri</span>
                        </li>
                    </ul>
                </div>

                <!-- CARD 2: Butuh Bantuan Cepat? -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-5">
                    <h3 class="font-bold text-sm text-gray-900">Butuh Bantuan Cepat?</h3>

                    <div class="space-y-4 text-xs">
                        <!-- Call Center -->
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-2xl bg-gray-100 flex items-center justify-center shrink-0 text-sm">
                                📞
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">Call Center</p>
                                <p class="text-gray-500 font-mono text-[11px]">(0251) 8750-000</p>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-2xl bg-gray-100 flex items-center justify-center shrink-0 text-sm">
                                💬
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">WhatsApp</p>
                                <p class="text-gray-500 font-mono text-[11px]">0812-9876-5432</p>
                            </div>
                        </div>

                        <!-- Email Resmi -->
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-2xl bg-gray-100 flex items-center justify-center shrink-0 text-sm">
                                ✉️
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">Email Resmi</p>
                                <p class="text-gray-500 font-mono text-[11px]">feedback@bogorkab.go.id</p>
                            </div>
                        </div>
                    </div>

                    <!-- Badge Estimasi Penanganan -->
                    <div class="pt-1">
                        <span class="bg-ijo-tua text-white text-[11px] font-bold px-4 py-2 rounded-full inline-block">
                            Rata-rata 1×24 Jam
                        </span>
                    </div>
                </div>

            </div>

        </div>

    </main>

    <!-- Memanggil Footer Publik -->
    @include('publik.layout_publik.footer') 

</body>
</html>