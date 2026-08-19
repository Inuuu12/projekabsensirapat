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
                        <input type="text" name="nomor_pengadu" value="{{ old('nomor_pengadu') }}" required inputmode="numeric" pattern="[0-9]+" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)" placeholder="08xxxxxxxxxx" 
                               class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
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
                                @if(!empty($aduan->foto))
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $aduan->foto) }}" target="_blank" class="text-[11px] text-ijo-semitua hover:underline font-semibold flex items-center space-x-1">
                                            <span>🖼️ Lihat Lampiran Foto</span>
                                        </a>
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

    <!-- Memanggil Footer Publik -->
    @include('publik.layout_publik.footer') 

    <script>
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