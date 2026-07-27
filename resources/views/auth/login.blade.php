<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Agenda - Login</title>
    
    <!-- Font & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            teal: '#3E7B78',
                            darkTeal: '#2A5C59',
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
<body class="font-sans antialiased bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="flex flex-col md:flex-row w-full h-screen bg-white overflow-hidden">
        
        <!-- BAGIAN KIRI: Branding & Informasi -->
        <div class="relative w-full md:w-5/12 bg-brand-teal text-white flex flex-col justify-between p-8 md:p-12 overflow-hidden">
            
            <!-- Ornamen Lingkaran Top-Left -->
            <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-white/10 pointer-events-none"></div>

            <!-- Konten Tengah (Logo & Judul) -->
            <div class="my-auto flex flex-col items-center text-center z-10">
                <div class="mb-6">
                    <img src="{{ asset('foto/logo-bappenda.png') }}" 
                         alt="Logo Kab. Bogor" 
                         class="h-36 w-auto drop-shadow-md">
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight mb-2">e-Agenda</h1>
                <p class="text-sm md:text-base font-medium opacity-90 max-w-xs">
                    Sistem Agenda Kegiatan Dinas Kab. Bogor
                </p>
            </div>

            <!-- Footer Kiri -->
            <div class="text-center text-xs opacity-80 z-10 space-y-1">
                <p class="font-medium">Versi 1.0</p>
                <p>&copy; 2026 Bappenda Kabupaten Bogor</p>
            </div>
        </div>

        <!-- BAGIAN KANAN: Form Login -->
        <div class="w-full md:w-7/12 flex items-center justify-center p-8 md:p-16 bg-white">
            <div class="w-full max-w-md space-y-8">
                
                <!-- Header Form -->
                <div class="text-center space-y-2">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Selamat Datang</h2>
                    <p class="text-sm text-gray-500 font-medium">Silakan login menggunakan akun resmi Anda.</p>
                </div>

                <!-- Alert Error Validation -->
                @if ($errors->any())
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Login -->
                <!-- PASTIKAN action mengarah ke route proses POST login (misal: login.proses) -->
                <form action="{{ route('login.proses') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Input Username (Sudah diubah dari Email ke Username) -->
                    <div>
                        <label for="username" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Username</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <!-- Icon diubah menjadi user -->
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                            <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus
                                class="block w-full pl-10 pr-3 py-2.5 text-sm bg-gray-50/50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-teal focus:border-transparent placeholder-gray-400 text-gray-900 transition duration-150"
                                placeholder="Masukkan username admin">
                        </div>
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Kata sandi</label>
                        <div class="relative rounded-md shadow-sm" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i data-lucide="lock" class="w-5 h-5"></i>
                            </div>
                            
                            <input :type="show ? 'text' : 'password'" name="password" id="password" required
                                class="block w-full pl-10 pr-10 py-2.5 text-sm bg-gray-50/50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-teal focus:border-transparent placeholder-gray-400 text-gray-900 transition duration-150"
                                placeholder="Masukkan kata sandi">

                            <!-- Toggle Password Hide/Show -->
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i data-lucide="eye-off" x-show="!show" class="w-5 h-5"></i>
                                <i data-lucide="eye" x-show="show" class="w-5 h-5" style="display: none;"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-2">
                        <button type="submit" 
                            class="w-full py-3 px-4 text-sm font-semibold text-white bg-brand-gold hover:bg-brand-goldHover rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-gold transition duration-150 ease-in-out">
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