<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sampaikan Masukan Anda - SIRAPI</title>
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

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-8 space-y-8">

        <!-- Breadcrumb & Header Section -->
        <div class="space-y-2">
            <nav class="text-xs text-gray-500 flex items-center space-x-2">
                <a href="/publik" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 font-semibold">Aduan & Feedback</span>
            </nav>

            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Sampaikan Masukan / Aduan Anda</h1>
                <p class="text-xs text-gray-500 mt-1">Laporkan kendala pelaksanaan rapat atau masalah teknis aplikasi di lingkungan Diskominfo</p>
            </div>
        </div>

        <!-- MAIN LAYOUT (Form Left 8 Cols, Sidebar Right 4 Cols) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- LEFT FORM COLUMN (8 Cols) -->
            <div class="lg:col-span-8 bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm space-y-6">
                
                <div class="border-b border-gray-100 pb-4">
                    <h2 class="text-base font-bold text-gray-900">Ajukan Aduan Baru</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Semua kolom wajib diisi</p>
                </div>

                @if (session('success'))
                    <div class="rounded-2xl bg-ijo-sangatmuda px-4 py-3 text-xs font-bold text-ijo-tua">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rounded-2xl bg-red-50 px-4 py-3 text-xs font-bold text-red-600">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('publik.aduan.kirim') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <!-- Nama Input -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">Nama *</label>
                        <input type="text" name="nama_pengadu" value="{{ old('nama_pengadu') }}" required placeholder="Nama lengkap"
                               class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                    </div>

                    <!-- Email Input -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">Email *</label>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <input id="aduan-email" type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                                   class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                            <button id="send-otp-button" type="button" class="shrink-0 rounded-2xl bg-ijo-tua px-5 py-3 text-xs font-bold text-white transition-colors hover:bg-ijo-semitua">
                                Kirim OTP
                            </button>
                        </div>
                        <p class="text-[10px] text-gray-400 flex items-center space-x-1 pt-0.5">
                            <span>Email akan disamarkan otomatis saat ditampilkan ke publik</span>
                        </p>
                    </div>

                    <p id="otp-status" class="hidden text-[10px] font-bold"></p>

                    <!-- OTP Input -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">Masukkan OTP *</label>
                        <input id="aduan-otp" type="text" name="otp" value="{{ old('otp') }}" required inputmode="numeric" pattern="[0-9]{6}" maxlength="6" placeholder="6 digit kode OTP"
                               class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                        <p class="text-[10px] text-gray-400 pt-0.5">Kode OTP dikirim ke email dan berlaku 10 menit.</p>
                    </div>

                    <!-- No HP Input -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">No. HP *</label>
                        <input type="tel" name="nomor_pengadu" id="aduan-nomor-pengadu" value="{{ old('nomor_pengadu') }}" required inputmode="numeric" pattern="[0-9]+" maxlength="13" placeholder="Contoh: 081234567890" 
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)"
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                               class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                        <p class="text-[10px] text-gray-400 pt-0.5">Maksimal 13 digit angka (hanya angka tanpa spasi/huruf/simbol).</p>
                    </div>

                    <!-- Kategori Masalah Dropdown -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">Kategori Masalah *</label>
                        <div class="relative">
                            <select name="kategori" required class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3 text-gray-600 appearance-none focus:outline-none transition-all cursor-pointer">
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
                        <label class="block text-xs font-bold text-gray-700">Isi Masukan / Aduan *</label>
                        <textarea rows="4" name="isi_aduan" required placeholder="Jelaskan detail masalah yang Anda alami, contoh: ruang rapat bentrok jadwal, atau aplikasi SIAP Bogor gagal login sejak pagi ini..." 
                                  class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl p-4 text-gray-800 placeholder-gray-400 focus:outline-none transition-all resize-none">{{ old('isi_aduan') }}</textarea>
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
                            <input type="file" name="foto" accept="image/*" class="hidden">
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-ijo-tua hover:bg-ijo-semitua text-white font-bold text-xs py-3.5 rounded-2xl transition-colors flex items-center justify-center space-x-2 shadow-md">
                            <span>Kirim</span>
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

        <!-- ========================================================= -->
        <!-- SEKSI BARU: DAFTAR ADUAN & REPLIES / TANGGAPAN ADMIN      -->
        <!-- ========================================================= -->
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center justify-between gap-2">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Daftar Masukan & Aduan Publik</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Daftar riwayat aduan publik beserta status tanggapan dari tim admin</p>
                </div>
            </div>

            <div class="space-y-4">
                @if(isset($aduans) && count($aduans) > 0)
                    @foreach($aduans as $aduan)
                        <div class="border border-gray-100 rounded-2xl p-5 bg-[#FBFBFA] space-y-3 transition-all hover:border-ijo-muda/40">
                            
                            <!-- Header Aduan: Nama, Email Samaran, Tanggal, & Badge Status -->
                            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-200/60 pb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-full bg-ijo-sangatmuda text-ijo-tua font-bold flex items-center justify-center text-xs">
                                        {{ strtoupper(substr($aduan->nama_pengadu ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900">{{ $aduan->nama_pengadu ?? 'Anonim' }}</p>
                                        <p class="text-[10px] text-gray-400 font-mono">
                                            {{ isset($aduan->email) ? Str::mask($aduan->email, '*', 2, 5) : '***@email.com' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <span class="text-[10px] text-gray-400">
                                        {{ isset($aduan->created_at) ? $aduan->created_at->format('d M Y, H:i') : 'Baru saja' }}
                                    </span>
                                    
                                    <!-- Badge Status Balasan -->
                                    @php
                                        $st = strtolower(trim((string) ($aduan->status ?? 'menunggu')));
                                        $hasReply = !empty($aduan->balasan_admin);
                                    @endphp
                                    @if($st === 'selesai' || ($hasReply && $st !== 'diproses'))
                                        <span class="bg-ijo-sangatmuda text-ijo-tua text-[10px] font-bold px-2.5 py-1 rounded-full border border-ijo-muda/30">
                                            ✓ Selesai
                                        </span>
                                    @elseif($st === 'diproses' || $st === 'proses' || $st === 'di baca')
                                        <span class="bg-blue-50 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-blue-200">
                                            🔄 Diproses
                                        </span>
                                    @else
                                        <span class="bg-oren-muda text-oren-tua text-[10px] font-bold px-2.5 py-1 rounded-full border border-oren-utama/30">
                                            ⏳ Menunggu
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Isi Aduan -->
                            <div>
                                <p class="text-xs text-gray-700 leading-relaxed">
                                    {{ $aduan->isi_aduan ?? 'Tidak ada pesan' }}
                                </p>
                                @php
                                    $hasPhoto = !empty($aduan->foto)
                                        && $aduan->foto !== 'aduan/default.jpg'
                                        && file_exists(public_path('storage/' . $aduan->foto));
                                @endphp
                                @if($hasPhoto)
                                    <div class="mt-2.5">
                                        <button type="button" 
                                                onclick="openPhotoModal('{{ asset('storage/' . $aduan->foto) }}', '{{ e($aduan->nama_pengadu ?? 'Aduan Publik') }}')"
                                                class="inline-flex items-center space-x-1.5 text-[11px] text-ijo-semitua hover:text-ijo-tua font-semibold bg-ijo-sangatmuda/60 hover:bg-ijo-sangatmuda px-3 py-1.5 rounded-xl border border-ijo-muda/30 transition-all shadow-xs cursor-pointer">
                                            <span>🖼️</span>
                                            <span>Lihat Lampiran Foto</span>
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <!-- BOX TANGGAPAN / REPLY ADMIN -->
                            @if(!empty($aduan->balasan_admin))
                                <div class="mt-3 pt-3 border-t border-dashed border-gray-200">
                                    <div class="bg-ijo-sangatmuda/40 border border-ijo-muda/30 rounded-xl p-4 space-y-2">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-xs">🛡️</span>
                                                <span class="text-xs font-bold text-ijo-tua">Tanggapan Admin / Tim Diskominfo</span>
                                            </div>
                                            <span class="text-[10px] text-gray-400">
                                                {{ isset($aduan->updated_at) ? \Carbon\Carbon::parse($aduan->updated_at)->format('d M Y, H:i') : '' }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-800 leading-relaxed">
                                            {{ $aduan->balasan_admin }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endforeach
                @else
                    <div class="border border-dashed border-gray-200 rounded-2xl p-8 text-center bg-[#FBFBFA]">
                        <p class="text-xs font-semibold text-gray-500">Belum ada aduan atau masukan publik yang dikirimkan.</p>
                    </div>
                @endif
            </div>
        </div>

    </main>

    <!-- Modal Preview Foto Lampiran Pop-Up (Larger size, Zoom Controls, Sleek Rounded Corners) -->
    <div id="photo-preview-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm p-3 sm:p-6 transition-all duration-300">
        <div class="relative w-full max-w-5xl rounded-xl bg-white shadow-2xl overflow-hidden flex flex-col max-h-[94vh] animate-in fade-in zoom-in-95 duration-200">
            <!-- Header Modal -->
            <div class="bg-ijo-tua text-white px-5 py-3.5 flex flex-wrap items-center justify-between gap-3 shrink-0 border-b border-white/10">
                <div class="flex items-center space-x-2.5">
                    <span class="text-base">🖼️</span>
                    <div>
                        <h3 class="text-xs sm:text-sm font-bold text-white leading-tight">Lampiran Foto Aduan</h3>
                        <p id="modal-photo-author" class="text-[10px] text-white/70">Pengadu: -</p>
                    </div>
                </div>

                <!-- Zoom Controls & Close Button -->
                <div class="flex items-center space-x-2">
                    <div class="flex items-center bg-white/10 rounded-lg p-1 space-x-1 border border-white/10">
                        <button type="button" onclick="zoomOut()" class="w-7 h-7 rounded-md bg-transparent hover:bg-white/20 text-white flex items-center justify-center text-xs font-bold transition cursor-pointer" title="Perkecil (Zoom Out)">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
                        </button>
                        <span id="zoom-level-badge" class="px-2 text-[11px] font-mono font-bold text-white min-w-[44px] text-center">100%</span>
                        <button type="button" onclick="zoomIn()" class="w-7 h-7 rounded-md bg-transparent hover:bg-white/20 text-white flex items-center justify-center text-xs font-bold transition cursor-pointer" title="Perbesar (Zoom In)">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </button>
                        <button type="button" onclick="resetZoom()" class="px-2 h-7 rounded-md bg-transparent hover:bg-white/20 text-white flex items-center justify-center text-[10px] font-bold transition cursor-pointer" title="Reset Zoom">
                            Reset
                        </button>
                    </div>

                    <button type="button" onclick="closePhotoModal()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-sm font-bold transition cursor-pointer ml-1" title="Tutup">
                        ✕
                    </button>
                </div>
            </div>

            <!-- Konten Gambar (Lebar & Bersih dengan Drag/Pan Bebas ke Segala Arah) -->
            <div id="photo-container" class="relative p-4 sm:p-6 bg-[#161d1b] flex-1 flex items-center justify-center overflow-hidden min-h-[55vh] max-h-[76vh] select-none">
                <div class="transition-transform duration-100 ease-out origin-center flex items-center justify-center will-change-transform" id="zoom-wrapper">
                    <img id="modal-photo-img" 
                         src="" 
                         alt="Lampiran Foto Aduan" 
                         ondblclick="toggleZoom()"
                         class="max-h-[72vh] w-auto max-w-full object-contain rounded-lg shadow-lg border border-white/10 bg-[#0e1412] cursor-grab transition-all">
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="px-5 py-3 bg-white border-t border-gray-100 flex flex-wrap items-center justify-between gap-3 shrink-0">
                <p class="text-[11px] text-gray-500 flex items-center space-x-1.5">
                    <span>💡</span>
                    <span>Gunakan tombol <span class="font-bold text-gray-700">Zoom</span> / Scroll mouse, lalu <span class="font-bold text-gray-700">drag (geser mouse)</span> bebas ke kiri, kanan, atas, bawah.</span>
                </p>
                <div class="flex items-center space-x-2.5">
                    <a id="modal-photo-download" href="#" target="_blank" download class="text-xs text-ijo-semitua hover:text-ijo-tua font-bold px-3.5 py-2 rounded-lg hover:bg-ijo-sangatmuda/50 border border-ijo-muda/30 transition-colors flex items-center space-x-1.5">
                        <span>⬇️</span>
                        <span>Buka Gambar Asli</span>
                    </a>
                    <button type="button" onclick="closePhotoModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2 rounded-lg transition-colors cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Memanggil Footer Publik -->
    @include('publik.layout_publik.footer') 

    <script>
        // Pop-up Lightbox Foto & Zoom / Pan Controls
        const photoModal = document.getElementById('photo-preview-modal');
        const photoContainer = document.getElementById('photo-container');
        const modalPhotoImg = document.getElementById('modal-photo-img');
        const zoomWrapper = document.getElementById('zoom-wrapper');
        const zoomLevelBadge = document.getElementById('zoom-level-badge');
        const modalPhotoAuthor = document.getElementById('modal-photo-author');
        const modalPhotoDownload = document.getElementById('modal-photo-download');

        let currentZoom = 1;
        let translateX = 0;
        let translateY = 0;
        let isDragging = false;
        let startX = 0;
        let startY = 0;

        const minZoom = 1.0;
        const maxZoom = 3.5;
        const zoomStep = 0.25;

        function applyTransform() {
            if (!zoomWrapper) return;
            zoomWrapper.style.transform = `translate(${translateX}px, ${translateY}px) scale(${currentZoom})`;
            if (zoomLevelBadge) {
                zoomLevelBadge.textContent = `${Math.round(currentZoom * 100)}%`;
            }
            if (photoContainer) {
                if (currentZoom > 1) {
                    photoContainer.classList.add('cursor-grab');
                    if (isDragging) {
                        photoContainer.classList.add('cursor-grabbing');
                    } else {
                        photoContainer.classList.remove('cursor-grabbing');
                    }
                } else {
                    photoContainer.classList.remove('cursor-grab', 'cursor-grabbing');
                }
            }
        }

        function zoomIn() {
            if (currentZoom < maxZoom) {
                currentZoom = Math.min(maxZoom, Math.round((currentZoom + zoomStep) * 100) / 100);
                applyTransform();
            }
        }

        function zoomOut() {
            if (currentZoom > minZoom) {
                currentZoom = Math.max(minZoom, Math.round((currentZoom - zoomStep) * 100) / 100);
                if (currentZoom <= 1) {
                    translateX = 0;
                    translateY = 0;
                }
                applyTransform();
            }
        }

        function resetZoom() {
            currentZoom = 1;
            translateX = 0;
            translateY = 0;
            applyTransform();
        }

        function toggleZoom() {
            if (currentZoom === 1) {
                currentZoom = 2;
            } else {
                currentZoom = 1;
                translateX = 0;
                translateY = 0;
            }
            applyTransform();
        }

        // Drag / Pan Logic (Mouse)
        photoContainer?.addEventListener('mousedown', (e) => {
            if (e.button !== 0) return;
            if (currentZoom > 1) {
                isDragging = true;
                startX = e.clientX - translateX;
                startY = e.clientY - translateY;
                photoContainer.classList.add('cursor-grabbing');
                e.preventDefault();
            }
        });

        window.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            translateX = e.clientX - startX;
            translateY = e.clientY - startY;
            applyTransform();
        });

        window.addEventListener('mouseup', () => {
            if (isDragging) {
                isDragging = false;
                if (photoContainer) photoContainer.classList.remove('cursor-grabbing');
            }
        });

        // Touch Drag / Pan Logic (Mobile)
        photoContainer?.addEventListener('touchstart', (e) => {
            if (e.touches.length === 1 && currentZoom > 1) {
                isDragging = true;
                startX = e.touches[0].clientX - translateX;
                startY = e.touches[0].clientY - translateY;
            }
        }, { passive: true });

        window.addEventListener('touchmove', (e) => {
            if (!isDragging || e.touches.length !== 1) return;
            translateX = e.touches[0].clientX - startX;
            translateY = e.touches[0].clientY - startY;
            applyTransform();
        }, { passive: true });

        window.addEventListener('touchend', () => {
            isDragging = false;
        });

        // Mouse Wheel Zoom
        photoContainer?.addEventListener('wheel', (e) => {
            e.preventDefault();
            if (e.deltaY < 0) {
                zoomIn();
            } else {
                zoomOut();
            }
        }, { passive: false });

        function openPhotoModal(imgSrc, authorName) {
            if (!photoModal || !modalPhotoImg) return;
            resetZoom();
            modalPhotoImg.src = imgSrc;
            if (modalPhotoAuthor) {
                modalPhotoAuthor.textContent = `Pengadu: ${authorName || 'Anonim'}`;
            }
            if (modalPhotoDownload) {
                modalPhotoDownload.href = imgSrc;
            }
            photoModal.classList.remove('hidden');
            photoModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closePhotoModal() {
            if (!photoModal) return;
            photoModal.classList.add('hidden');
            photoModal.classList.remove('flex');
            if (modalPhotoImg) modalPhotoImg.src = '';
            resetZoom();
            document.body.classList.remove('overflow-hidden');
        }

        // Tutup jika klik backdrop / latar belakang hitam
        photoModal?.addEventListener('click', (e) => {
            if (e.target === photoModal) {
                closePhotoModal();
            }
        });

        // Tutup jika tombol ESC ditekan
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !photoModal?.classList.contains('hidden')) {
                closePhotoModal();
            }
        });

        const otpButton = document.getElementById('send-otp-button');
        const otpEmail = document.getElementById('aduan-email');
        const otpStatus = document.getElementById('otp-status');
        const csrfToken = document.querySelector('input[name="_token"]')?.value;

        function showOtpStatus(message, isSuccess = false) {
            if (!otpStatus) return;
            otpStatus.textContent = message;
            otpStatus.classList.remove('hidden', 'text-red-600', 'text-ijo-tua');
            otpStatus.classList.add(isSuccess ? 'text-ijo-tua' : 'text-red-600');
        }

        otpButton?.addEventListener('click', async () => {
            const email = otpEmail?.value.trim();

            if (!email) {
                showOtpStatus('Isi email terlebih dahulu.');
                otpEmail?.focus();
                return;
            }

            otpButton.disabled = true;
            otpButton.textContent = 'Mengirim...';
            showOtpStatus('Mengirim kode OTP...', true);

            try {
                const response = await fetch('{{ route('publik.aduan.otp') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ email }),
                });
                const payload = await response.json();

                showOtpStatus(payload.message || 'Gagal mengirim OTP.', response.ok && payload.success);
            } catch (error) {
                showOtpStatus('Gagal mengirim OTP. Periksa koneksi atau konfigurasi email.');
            } finally {
                otpButton.disabled = false;
                otpButton.textContent = 'Kirim OTP';
            }
        });
    </script>

</body>
</html>