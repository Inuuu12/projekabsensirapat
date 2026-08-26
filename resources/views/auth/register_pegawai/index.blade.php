<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai - SIRAPI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    @include('publik.layout_publik.theme_script')
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
</head>
<body class="min-h-screen bg-white dark:bg-[#0d1614] font-sans text-sirapi-ink dark:text-slate-100 antialiased transition-colors duration-200">
    <header class="relative flex h-[220px] items-center justify-center overflow-hidden bg-sirapi-green dark:bg-[#0f1c19] dark:border-b dark:border-[#233a34] text-white">
        <div class="absolute -left-20 -top-24 h-72 w-72 rounded-full bg-white/10 dark:bg-white/5"></div>
        
        <!-- Theme Toggle Top-Right -->
        <button type="button" 
                onclick="toggleSirapiTheme()" 
                class="absolute top-5 right-5 w-10 h-10 rounded-full flex items-center justify-center text-white/90 hover:text-white dark:text-amber-400 dark:hover:text-amber-300 bg-white/10 hover:bg-white/20 dark:bg-[#152420] dark:border dark:border-[#284c43] transition-colors cursor-pointer z-20"
                title="Ganti Mode Gelap / Terang">
            <svg data-theme-icon-light class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg data-theme-icon-dark class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>

        <div class="relative flex flex-col items-center text-center">
            <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Kabupaten Bogor" class="h-24 w-auto drop-shadow">
            <h1 class="mt-4 text-2xl font-extrabold tracking-wide">SIRAPI</h1>
            <p class="mt-2 text-sm font-bold">Daftar Akun Pegawai</p>
        </div>
    </header>

    <main class="flex min-h-[calc(100vh-220px)] justify-center px-6 py-10">
        <section class="w-full max-w-2xl">
            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950/40 px-4 py-3 text-sm font-semibold text-red-700 dark:text-red-300">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-6 rounded-2xl border border-blue-200 dark:border-blue-800/60 bg-blue-50 dark:bg-blue-950/40 p-4 text-xs text-blue-800 dark:text-blue-200 flex items-center gap-3 shadow-xs">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="leading-snug">
                    <strong class="font-bold text-sm text-blue-900 dark:text-blue-100">Informasi:</strong>
                    Akun baru memerlukan verifikasi Administrator sebelum dapat digunakan untuk login dan presensi.
                </div>
            </div>

            <form action="{{ route('pegawai.register.submit') }}" method="POST" class="grid gap-5 rounded-2xl border border-[#DDE3DF] dark:border-[#233a34] bg-white dark:bg-[#152420] p-6 shadow-xs sm:grid-cols-2 transition-colors">
                @csrf

                <label class="sm:col-span-2">
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">Nama Lengkap</span>
                    <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai') }}" required autofocus
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-semibold text-gray-800 dark:text-white outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="Nama pegawai">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">NIP</span>
                    <input type="text" name="nip" value="{{ old('nip') }}" required pattern="[0-9]+" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-semibold text-gray-800 dark:text-white outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="Nomor induk pegawai">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">Tanggal Lahir</span>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-semibold text-gray-800 dark:text-white outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">Jabatan</span>
                    <select name="jabatan" required
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-semibold text-gray-800 dark:text-white outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15">
                        <option value="">Pilih jabatan</option>
                        @foreach ($jabatanOptions as $jabatan)
                            <option value="{{ $jabatan }}" @selected(old('jabatan') === $jabatan)>{{ $jabatan }}</option>
                        @endforeach
                    </select>
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">Bidang</span>
                    <select name="bidang"
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-semibold text-gray-800 dark:text-white outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15">
                        <option value="">Pilih bidang</option>
                        @foreach ($bidangOptions as $bidang)
                            <option value="{{ $bidang }}" @selected(old('bidang') === $bidang)>{{ $bidang }}</option>
                        @endforeach
                    </select>
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">No. HP</span>
                    <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}" required pattern="[0-9]+" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-semibold text-gray-800 dark:text-white outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="08xxxxxxxxxx">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-semibold text-gray-800 dark:text-white outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="Masukkan email anda">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">Password</span>
                    <input type="password" name="password" required minlength="8"
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-semibold text-gray-800 dark:text-white outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="Minimal 8 karakter">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">Konfirmasi Password</span>
                    <input type="password" name="password_confirmation" required
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-semibold text-gray-800 dark:text-white outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="Ulangi password">
                </label>

                <div class="flex flex-col gap-3 pt-2 sm:col-span-2 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('pegawai.login') }}" class="text-sm font-bold text-[#27364A] dark:text-emerald-400 hover:underline">
                        Sudah punya akun?
                    </a>
                    <button type="submit" class="h-12 rounded-lg bg-sirapi-green hover:bg-sirapi-greenSoft dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 px-8 text-sm font-extrabold text-white shadow-xs transition focus:outline-none focus:ring-2 focus:ring-sirapi-green/25 cursor-pointer">
                        Daftar
                    </button>
                </div>
            </form>
        </section>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
