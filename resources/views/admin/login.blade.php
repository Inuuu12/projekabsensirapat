<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- CONTAINER UTAMA: Membagi layar jadi 2 kolom saat ukuran md (laptop/desktop) -->
    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2">
        
        <!-- ==================== SISI KIRI: BRANDING & LOGO (HIJAU) ==================== -->
        <div class="bg-[#3b6f6c] text-white flex flex-col justify-between items-center p-8 relative overflow-hidden">
            <!-- Ornamen lingkaran di pojok kiri atas -->
            <div class="absolute -top-16 -left-16 w-48 h-48 bg-[#4a7f7c] rounded-full opacity-60"></div>

            <!-- Spacer atas biar konten tengah benar-benar pas di posisi tengah vertikal -->
            <div></div>

            <!-- Konten Tengah -->
            <div class="flex flex-col items-center text-center z-10">
                <h2 class="text-2xl font-bold mb-6">Login Admin</h2>
            
                <!-- Logo Bappenda -->
                <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Bappenda" class="w-36 h-auto mb-6">
            
                <h1 class="text-3xl font-extrabold tracking-wide">e-Agenda</h1>
                <p class="text-sm mt-2 opacity-90 max-w-xs">Sistem Agenda Kegiatan Dinas Kab. Bogor</p>
            </div>

            <!-- Konten Bawah -->
            <div class="text-center text-xs opacity-75 z-10">
                <p class="mb-1">Versi 1.0</p>
                <p>&copy; 2026 Bappenda Kabupaten Bogor</p>
            </div>
        </div>

        <!-- ==================== SISI KANAN: FORM LOGIN (PUTIH) ==================== -->
        <div class="bg-white flex flex-col justify-center items-center p-8">
            <div class="w-full max-w-sm">
                
                <!-- Judul Selamat Datang -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-[#1f2937] tracking-tight">Selamat Datang</h2>
                    <p class="text-sm text-gray-500 mt-2">Silakan login menggunakan email resmi Anda.</p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <ul class="text-red-600 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Input Email -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <!-- Icon Email -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input name="email" type="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#3b6f6c] transition-all {{ $errors->has('email') ? 'border-red-500 bg-red-50' : '' }}">
                        </div>
                        @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Kata sandi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <!-- Icon Gembok -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <input name="password" type="password" placeholder="Masukkan kata sandi Anda" required
                                class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#3b6f6c] transition-all {{ $errors->has('password') ? 'border-red-500 bg-red-50' : '' }}">
                            
                            <!-- Icon Mata Dicoret (Eye-off) -->
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 cursor-pointer toggle-password">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1M3 3l18 18" />
                                </svg>
                            </span>
                        </div>
                        @error('password')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Log Masuk -->
                    <button type="submit" 
                        class="w-full bg-[#d49e19] hover:bg-[#b88510] text-white font-bold py-2.5 px-4 rounded-lg text-sm transition duration-200 mt-6 shadow-md active:scale-[0.98]">
                        Log Masuk
                    </button>
                </form>

            </div>
        </div>

    </div>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input[type="password"], input[type="text"]');
                if (input) {
                    if (input.type === 'password') {
                        input.type = 'text';
                    } else {
                        input.type = 'password';
                    }
                }
            });
        });
    </script>

</body>
</html>