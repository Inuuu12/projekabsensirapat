<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SIRAPI</title>
    
    <!-- Font & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    @include('publik.layout_publik.theme_script')
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            teal: '#35635b',
                            darkTeal: '#2b4f49',
                            gold: '#D8A01A',
                            goldHover: '#C28E13',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-[#0d1614] min-h-screen flex items-center justify-center transition-colors duration-200">

    @php
        $organizationName = config('sirapi.organization', 'Dinas Komunikasi & Informatika');
        $regionName = config('sirapi.region', 'Pemerintah Kabupaten Bogor');
    @endphp

    <div class="flex flex-col md:flex-row w-full h-screen bg-white dark:bg-[#152420] overflow-hidden transition-colors">
        
        <!-- BAGIAN KIRI: Branding & Informasi -->
        <div class="relative w-full md:w-5/12 bg-brand-teal dark:bg-[#0f1c19] dark:border-r dark:border-[#233a34] text-white flex flex-col justify-between p-8 md:p-12 overflow-hidden">
            
            <!-- Ornamen Lingkaran Top-Left -->
            <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-white/10 dark:bg-white/5 pointer-events-none"></div>

            <!-- Konten Tengah (Logo & Judul) -->
            <div class="my-auto flex flex-col items-center text-center z-10">
                <div class="mb-6">
                    <img src="{{ asset('foto/logo-bappenda.png') }}" 
                         alt="Logo Kab. Bogor" 
                         class="h-36 w-auto drop-shadow-md">
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight mb-2">{{ config('sirapi.name', 'SIRAPI') }}</h1>
                <p class="text-sm md:text-base font-medium opacity-90 max-w-xs mb-2">
                    Sistem Informasi Rapat dan Presensi
                </p>
                <p class="text-xs opacity-80 max-w-xs">
                    {{ $regionName }}
                </p>
            </div>

            <!-- Footer Kiri -->
            <div class="text-center text-xs opacity-80 z-10 space-y-1">
                <p class="font-medium">Versi 1.0</p>
                <p>&copy; {{ date('Y') }} {{ $regionName }}</p>
            </div>
        </div>

        <!-- BAGIAN KANAN: Form Login -->
        <div class="w-full md:w-7/12 flex items-center justify-center p-8 md:p-16 bg-white dark:bg-[#152420] relative transition-colors">
            <!-- Theme Toggle Top-Right -->
            <button type="button" 
                    onclick="toggleSirapiTheme()" 
                    class="absolute top-6 right-6 w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:text-gray-900 dark:text-amber-400 dark:hover:text-amber-300 bg-gray-100 hover:bg-gray-200 dark:bg-[#0f1c19] dark:border dark:border-[#284c43] dark:hover:bg-white/10 transition-colors cursor-pointer"
                    title="Ganti Mode Gelap / Terang">
                <svg data-theme-icon-light class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg data-theme-icon-dark class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>

            <div class="w-full max-w-md space-y-8">
                
                <!-- Header Form -->
                <div class="text-center space-y-2">
                    <h2 class="text-2xl md:text-4xl font-bold text-[#27364A] dark:text-white tracking-tight">Selamat Datang</h2>
                    <p class="text-sm font-semibold text-[#27364A] dark:text-gray-300">Silakan login menggunakan username Admin Anda.</p>
                </div>

                <!-- Alert Error Validation -->
                @if ($errors->any())
                    <div class="p-4 mb-4 text-sm text-red-800 dark:text-red-300 rounded-lg bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Input Username -->
                    <div>
                        <label for="username" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Username</label>
                        <div class="relative rounded-md shadow-xs">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                            <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus
                                class="block w-full pl-10 pr-3 py-2.5 text-sm bg-gray-50/50 dark:bg-[#0f1c19] border border-gray-200 dark:border-[#284c43] rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-teal focus:border-transparent placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white transition duration-150"
                                placeholder="Masukkan username Admin">
                        </div>
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-2">Kata sandi</label>
                        <div class="relative rounded-md shadow-xs" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="lock" class="w-5 h-5"></i>
                            </div>
                            
                            <input :type="show ? 'text' : 'password'" name="password" id="password" required
                                class="block w-full pl-10 pr-10 py-2.5 text-sm bg-gray-50/50 dark:bg-[#0f1c19] border border-gray-200 dark:border-[#284c43] rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-teal focus:border-transparent placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white transition duration-150"
                                placeholder="Masukkan kata sandi">

                            <!-- Toggle Password Hide/Show -->
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none">
                                <i data-lucide="eye-off" x-show="!show" class="w-5 h-5"></i>
                                <i data-lucide="eye" x-show="show" class="w-5 h-5" style="display: none;"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-2">
                        <button type="submit" 
                            class="w-full py-3 px-4 text-sm font-semibold text-white bg-brand-gold hover:bg-brand-goldHover dark:bg-[#107050] dark:hover:bg-[#0c5940] rounded-lg shadow-xs focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-gold transition duration-150 ease-in-out cursor-pointer">
                            Log Masuk
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <!-- Script Lucide Icons & AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
