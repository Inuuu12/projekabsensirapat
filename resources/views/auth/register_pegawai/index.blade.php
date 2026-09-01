<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Daftar Pegawai - SIRAPI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    @include('publik.layout.theme_script')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        sirapi: {
                            green: '#35635b',
                            greenSoft: '#2b4f49',
                            ink: '#14211F',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Sembunyikan ikon mata bawaan browser Edge / IE */
        input::-ms-reveal,
        input::-ms-clear {
            display: none !important;
        }

        /* Autofill Styling (Mencegah background input berubah putih saat autofill di dark mode) */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active,
        select:-webkit-autofill,
        select:-webkit-autofill:hover,
        select:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
            -webkit-text-fill-color: #1f2937 !important;
            caret-color: #1f2937 !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        html.dark input:-webkit-autofill,
        html.dark input:-webkit-autofill:hover,
        html.dark input:-webkit-autofill:focus,
        html.dark input:-webkit-autofill:active,
        html.dark select:-webkit-autofill,
        html.dark select:-webkit-autofill:hover,
        html.dark select:-webkit-autofill:focus,
        .dark input:-webkit-autofill,
        .dark input:-webkit-autofill:hover,
        .dark input:-webkit-autofill:focus,
        .dark input:-webkit-autofill:active,
        .dark select:-webkit-autofill,
        .dark select:-webkit-autofill:hover,
        .dark select:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #0f1c19 inset !important;
            -webkit-text-fill-color: #ffffff !important;
            caret-color: #ffffff !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        html.dark {
            color-scheme: dark;
        }
        html:not(.dark) {
            color-scheme: light;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50/70 dark:bg-[#0d1614] font-sans text-sirapi-ink dark:text-slate-100 antialiased transition-colors duration-200 flex flex-col">
    <!-- Header -->
    <header class="relative flex min-h-[170px] sm:min-h-[220px] py-6 sm:py-8 items-center justify-center overflow-hidden bg-sirapi-green dark:bg-[#0f1c19] dark:border-b dark:border-[#233a34] text-white shrink-0">
        <div class="absolute -left-20 -top-24 h-72 w-72 rounded-full bg-white/10 dark:bg-white/5"></div>
        <div class="absolute -right-20 -bottom-24 h-72 w-72 rounded-full bg-white/5 dark:bg-white/5"></div>
        
        <!-- Back Button Top-Left -->
        <a href="{{ route('pegawai.login') }}" 
           class="absolute top-4 left-4 sm:top-5 sm:left-5 inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white/90 hover:text-white bg-white/10 hover:bg-white/20 dark:bg-[#152420] dark:border dark:border-[#284c43] transition cursor-pointer z-20"
           title="Kembali ke Login">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span class="hidden sm:inline">Kembali</span>
        </a>

        <!-- Theme Toggle Top-Right -->
        <button type="button" 
                onclick="toggleSirapiTheme()" 
                class="absolute top-4 right-4 sm:top-5 sm:right-5 w-10 h-10 rounded-full flex items-center justify-center text-white/90 hover:text-white dark:text-amber-400 dark:hover:text-amber-300 bg-white/10 hover:bg-white/20 dark:bg-[#152420] dark:border dark:border-[#284c43] transition-colors cursor-pointer z-20"
                title="Ganti Mode Gelap / Terang">
            <svg data-theme-icon-light class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg data-theme-icon-dark class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>

        <div class="relative flex flex-col items-center text-center px-4 z-10">
            <img src="{{ asset('assets/foto/logo-bappenda.png') }}" alt="Logo Kabupaten Bogor" class="h-16 sm:h-22 w-auto drop-shadow">
            <h1 class="mt-2.5 sm:mt-3 text-xl sm:text-2xl font-extrabold tracking-wide">SIRAPI</h1>
            <p class="mt-0.5 sm:mt-1 text-xs sm:text-sm font-semibold text-emerald-100 dark:text-gray-300">Pendaftaran Akun Pegawai</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex flex-1 justify-center px-3.5 sm:px-6 py-6 sm:py-10">
        <section class="w-full max-w-xl md:max-w-2xl lg:max-w-3xl">
            @if ($errors->any())
                <div class="mb-5 rounded-2xl border border-red-200 dark:border-red-800/80 bg-red-50 dark:bg-red-950/40 p-4 text-xs sm:text-sm font-medium text-red-700 dark:text-red-300 shadow-xs">
                    <div class="flex items-center gap-2 font-bold mb-1.5 text-red-800 dark:text-red-200">
                        <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                        <span>Mohon periksa kesalahan berikut:</span>
                    </div>
                    <ul class="list-inside list-disc space-y-0.5 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-5 sm:mb-6 rounded-2xl border border-blue-200 dark:border-blue-800/60 bg-blue-50/80 dark:bg-blue-950/40 p-4 text-xs sm:text-sm text-blue-800 dark:text-blue-200 flex items-start sm:items-center gap-3 shadow-xs">
                <i data-lucide="info" class="w-5 h-5 text-blue-600 dark:text-blue-400 shrink-0 mt-0.5 sm:mt-0"></i>
                <div class="leading-relaxed">
                    <strong class="font-bold text-blue-900 dark:text-blue-100">Informasi Pendaftaran:</strong>
                    Akun baru memerlukan verifikasi Administrator sebelum dapat digunakan untuk login dan presensi.
                </div>
            </div>

            <form action="{{ route('pegawai.register.submit') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 rounded-2xl sm:rounded-3xl border border-[#DDE3DF] dark:border-[#233a34] bg-white dark:bg-[#152420] p-4.5 sm:p-7 md:p-8 shadow-xs transition-colors">
                @csrf

                <!-- Nama Lengkap -->
                <div class="sm:col-span-2">
                    <label for="nama_pegawai" class="block text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-200 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 sm:pl-4 text-gray-400 dark:text-gray-500">
                            <i data-lucide="user" class="h-4 sm:h-5 w-4 sm:w-5"></i>
                        </span>
                        <input id="nama_pegawai" type="text" name="nama_pegawai" value="{{ old('nama_pegawai') }}" required autofocus
                            class="h-11 sm:h-12 w-full rounded-xl border border-[#DDE3DF] dark:border-[#284c43] bg-gray-50/50 dark:bg-[#0f1c19] pl-10 sm:pl-11 pr-4 text-xs sm:text-sm font-medium text-gray-800 dark:text-white shadow-xs outline-none transition focus:border-sirapi-green focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-sirapi-green/15"
                            placeholder="Masukkan nama lengkap beserta gelar jika ada">
                    </div>
                </div>

                <!-- NIP -->
                <div>
                    <label for="nip" class="block text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-200 mb-1.5">
                        NIP <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 sm:pl-4 text-gray-400 dark:text-gray-500">
                            <i data-lucide="badge-check" class="h-4 sm:h-5 w-4 sm:w-5"></i>
                        </span>
                        <input id="nip" type="text" inputmode="numeric" name="nip" value="{{ old('nip') }}" required pattern="[0-9]+" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="h-11 sm:h-12 w-full rounded-xl border border-[#DDE3DF] dark:border-[#284c43] bg-gray-50/50 dark:bg-[#0f1c19] pl-10 sm:pl-11 pr-4 text-xs sm:text-sm font-medium text-gray-800 dark:text-white shadow-xs outline-none transition focus:border-sirapi-green focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-sirapi-green/15"
                            placeholder="18 digit Nomor Induk Pegawai">
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-200 mb-1.5">
                        Tanggal Lahir
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 sm:pl-4 text-gray-400 dark:text-gray-500">
                            <i data-lucide="calendar" class="h-4 sm:h-5 w-4 sm:w-5"></i>
                        </span>
                        <input id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="h-11 sm:h-12 w-full rounded-xl border border-[#DDE3DF] dark:border-[#284c43] bg-gray-50/50 dark:bg-[#0f1c19] pl-10 sm:pl-11 pr-4 text-xs sm:text-sm font-medium text-gray-800 dark:text-white shadow-xs outline-none transition focus:border-sirapi-green focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-sirapi-green/15">
                    </div>
                </div>

                <!-- Jabatan -->
                <div>
                    <label for="jabatan" class="block text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-200 mb-1.5">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 sm:pl-4 text-gray-400 dark:text-gray-500">
                            <i data-lucide="briefcase" class="h-4 sm:h-5 w-4 sm:w-5"></i>
                        </span>
                        <select id="jabatan" name="jabatan" required
                            class="h-11 sm:h-12 w-full rounded-xl border border-[#DDE3DF] dark:border-[#284c43] bg-gray-50/50 dark:bg-[#0f1c19] pl-10 sm:pl-11 pr-8 text-xs sm:text-sm font-medium text-gray-800 dark:text-white shadow-xs outline-none transition focus:border-sirapi-green focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-sirapi-green/15 cursor-pointer appearance-none">
                            <option value="">Pilih jabatan</option>
                            @foreach ($jabatanOptions as $jabatan)
                                <option value="{{ $jabatan }}" @selected(old('jabatan') === $jabatan)>{{ $jabatan }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 dark:text-gray-500">
                            <i data-lucide="chevron-down" class="h-4 w-4"></i>
                        </span>
                    </div>
                </div>

                <!-- Bidang -->
                <div>
                    <label for="bidang" class="block text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-200 mb-1.5">
                        Bidang / Bagian
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 sm:pl-4 text-gray-400 dark:text-gray-500">
                            <i data-lucide="building" class="h-4 sm:h-5 w-4 sm:w-5"></i>
                        </span>
                        <select id="bidang" name="bidang"
                            class="h-11 sm:h-12 w-full rounded-xl border border-[#DDE3DF] dark:border-[#284c43] bg-gray-50/50 dark:bg-[#0f1c19] pl-10 sm:pl-11 pr-8 text-xs sm:text-sm font-medium text-gray-800 dark:text-white shadow-xs outline-none transition focus:border-sirapi-green focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-sirapi-green/15 cursor-pointer appearance-none">
                            <option value="">Pilih bidang (opsional)</option>
                            @foreach ($bidangOptions as $bidang)
                                <option value="{{ $bidang }}" @selected(old('bidang') === $bidang)>{{ $bidang }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 dark:text-gray-500">
                            <i data-lucide="chevron-down" class="h-4 w-4"></i>
                        </span>
                    </div>
                </div>

                <!-- No. HP -->
                <div>
                    <label for="nomor_hp" class="block text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-200 mb-1.5">
                        No. HP / WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 sm:pl-4 text-gray-400 dark:text-gray-500">
                            <i data-lucide="phone" class="h-4 sm:h-5 w-4 sm:w-5"></i>
                        </span>
                        <input id="nomor_hp" type="tel" inputmode="numeric" name="nomor_hp" value="{{ old('nomor_hp') }}" required pattern="[0-9]+" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="h-11 sm:h-12 w-full rounded-xl border border-[#DDE3DF] dark:border-[#284c43] bg-gray-50/50 dark:bg-[#0f1c19] pl-10 sm:pl-11 pr-4 text-xs sm:text-sm font-medium text-gray-800 dark:text-white shadow-xs outline-none transition focus:border-sirapi-green focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-sirapi-green/15"
                            placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-200 mb-1.5">
                        Email Resmi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 sm:pl-4 text-gray-400 dark:text-gray-500">
                            <i data-lucide="mail" class="h-4 sm:h-5 w-4 sm:w-5"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="h-11 sm:h-12 w-full rounded-xl border border-[#DDE3DF] dark:border-[#284c43] bg-gray-50/50 dark:bg-[#0f1c19] pl-10 sm:pl-11 pr-4 text-xs sm:text-sm font-medium text-gray-800 dark:text-white shadow-xs outline-none transition focus:border-sirapi-green focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-sirapi-green/15"
                            placeholder="nama@domain.go.id">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-200 mb-1.5">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 sm:pl-4 text-gray-400 dark:text-gray-500">
                            <i data-lucide="lock" class="h-4 sm:h-5 w-4 sm:w-5"></i>
                        </span>
                        <input id="password" type="password" name="password" required minlength="8"
                            class="h-11 sm:h-12 w-full rounded-xl border border-[#DDE3DF] dark:border-[#284c43] bg-gray-50/50 dark:bg-[#0f1c19] pl-10 sm:pl-11 pr-11 text-xs sm:text-sm font-medium text-gray-800 dark:text-white shadow-xs outline-none transition focus:border-sirapi-green focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-sirapi-green/15"
                            placeholder="Minimal 8 karakter">
                        <button type="button" onclick="togglePasswordVisibility('password', 'eye-icon-pass')" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition cursor-pointer" title="Lihat/Sembunyikan Sandi">
                            <i id="eye-icon-pass" data-lucide="eye" class="h-4 sm:h-5 w-4 sm:w-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-200 mb-1.5">
                        Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 sm:pl-4 text-gray-400 dark:text-gray-500">
                            <i data-lucide="lock-keyhole" class="h-4 sm:h-5 w-4 sm:w-5"></i>
                        </span>
                        <input id="password_confirmation" type="password" name="password_confirmation" required minlength="8"
                            class="h-11 sm:h-12 w-full rounded-xl border border-[#DDE3DF] dark:border-[#284c43] bg-gray-50/50 dark:bg-[#0f1c19] pl-10 sm:pl-11 pr-11 text-xs sm:text-sm font-medium text-gray-800 dark:text-white shadow-xs outline-none transition focus:border-sirapi-green focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-sirapi-green/15"
                            placeholder="Ulangi kata sandi">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eye-icon-confirm')" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition cursor-pointer" title="Lihat/Sembunyikan Sandi">
                            <i id="eye-icon-confirm" data-lucide="eye" class="h-4 sm:h-5 w-4 sm:w-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3.5 pt-4 sm:col-span-2 border-t border-gray-100 dark:border-[#233a34] mt-2">
                    <a href="{{ route('pegawai.login') }}" class="inline-flex items-center justify-center sm:justify-start gap-1.5 text-xs sm:text-sm font-bold text-gray-600 dark:text-emerald-400 hover:text-sirapi-green dark:hover:underline py-1.5 transition">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span>Sudah punya akun? Masuk di sini</span>
                    </a>
                    
                    <button type="submit" class="w-full sm:w-auto h-11 sm:h-12 rounded-xl bg-sirapi-green hover:bg-sirapi-greenSoft dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 px-7 sm:px-8 text-xs sm:text-sm font-extrabold text-white shadow-sm transition focus:outline-none focus:ring-2 focus:ring-sirapi-green/25 cursor-pointer flex items-center justify-center gap-2">
                        <span>Daftar Akun</span>
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </section>
    </main>

    <footer class="py-4 text-center text-xs text-gray-400 dark:text-gray-500 shrink-0">
        &copy; {{ date('Y') }} SIRAPI - Pemerintah Kabupaten Bogor.
    </footer>

    <script>
        lucide.createIcons();

        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>
