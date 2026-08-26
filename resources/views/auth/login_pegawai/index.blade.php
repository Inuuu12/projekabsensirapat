<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pegawai - SIRAPI</title>
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
    <header class="relative flex h-[240px] items-center justify-center overflow-hidden bg-sirapi-green dark:bg-[#0f1c19] dark:border-b dark:border-[#233a34] text-white">
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
            <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Kabupaten Bogor" class="h-28 w-auto drop-shadow">
            <h1 class="mt-5 text-2xl font-extrabold tracking-wide">SIRAPI</h1>
            <p class="mt-2 text-sm font-bold">Sistem Informasi Rapat dan Presensi</p>
        </div>
    </header>

    <main class="flex min-h-[calc(100vh-240px)] items-start justify-center px-6 pt-16 pb-12">
        <section class="w-full max-w-[356px]">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-[#2A3547] dark:text-white tracking-tight">Selamat Datang</h2>
                <p class="mt-2 text-[15px] font-bold text-[#2A3547] dark:text-gray-300">Silakan login menggunakan email resmi Anda.</p>
            </div>

            @if (session('status'))
                <div class="mb-5 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/40 px-4 py-3 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950/40 px-4 py-3 text-sm font-semibold text-red-700 dark:text-red-300">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('pegawai.login.submit') }}" method="POST" class="space-y-7">
                @csrf
                @if (request('agenda_id'))
                    <input type="hidden" name="agenda_id" value="{{ request('agenda_id') }}">
                @endif

                <div>
                    <label for="email" class="block text-left text-sm font-bold text-[#2A3547] dark:text-gray-200 mb-1.5">Email</label>
                    <div class="relative block">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#8B9490]">
                            <i data-lucide="mail" class="h-5 w-5"></i>
                        </span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                            class="h-12 w-full rounded-lg border border-[#DDE3DF] dark:border-[#284c43] bg-white dark:bg-[#0f1c19] pl-12 pr-4 text-sm font-medium text-gray-800 dark:text-white shadow-xs outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                            placeholder="Masukkan email anda">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-left text-sm font-bold text-[#2A3547] dark:text-gray-200 mb-1.5">Kata sandi</label>
                    <div class="relative block">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#8B9490]">
                            <i data-lucide="lock-keyhole" class="h-5 w-5"></i>
                        </span>
                        <input id="password" name="password" type="password" required
                            class="h-12 w-full rounded-lg border border-[#DDE3DF] dark:border-[#284c43] bg-white dark:bg-[#0f1c19] pl-12 pr-12 text-sm font-medium text-gray-800 dark:text-white shadow-xs outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                            placeholder="Minimal 8 karakter">
                        <button type="button" data-password-toggle class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-[#8B9490] hover:text-sirapi-green dark:hover:text-emerald-400 transition" aria-label="Tampilkan kata sandi">
                            <i data-lucide="eye-off" class="h-5 w-5"></i>
                        </button>
                    </div>
                    <div class="mt-3 text-right">
                        <button type="button" data-open-forgot class="text-sm font-bold text-[#2A3547] dark:text-gray-300 hover:text-sirapi-green dark:hover:text-emerald-400">Lupa kata sandi?</button>
                    </div>
                </div>

                <button type="submit" class="h-12 w-full rounded-lg bg-[#D8A01A] hover:bg-[#C28E13] dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 text-sm font-extrabold text-white shadow-xs transition focus:outline-none focus:ring-2 focus:ring-[#D8A01A]/25 cursor-pointer">
                    Masuk
                </button>

                <p class="text-center text-sm font-semibold text-gray-500 dark:text-gray-400">
                    Belum punya akun?
                    <a href="{{ route('pegawai.register') }}" class="font-extrabold text-[#27364A] dark:text-emerald-400 hover:underline">Daftar Sekarang!</a>
                </p>
            </form>
        </section>
    </main>

    <div data-forgot-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-black/45 backdrop-blur-xs px-5">
        <section class="w-full max-w-md rounded-2xl bg-white dark:bg-[#152420] text-sirapi-ink dark:text-slate-100 p-6 shadow-xl border border-transparent dark:border-[#233a34]">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-extrabold text-sirapi-ink dark:text-white">Reset Kata Sandi</h2>
                    <p class="mt-1 text-sm font-medium text-gray-500 dark:text-gray-400">Kirim OTP ke email pegawai, lalu masukkan password baru.</p>
                </div>
                <button type="button" data-close-forgot class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 dark:hover:bg-white/10 hover:text-gray-700 dark:hover:text-gray-200" aria-label="Tutup">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <form action="{{ route('pegawai.password.otp') }}" method="POST" class="mt-6 space-y-3">
                @csrf
                <label class="block">
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">Email Pegawai</span>
                    <input name="reset_email" type="email" value="{{ old('reset_email') }}" required data-reset-email-input class="mt-2 h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-gray-800 dark:text-white px-3 text-sm font-bold outline-none focus:border-sirapi-green" placeholder="Masukkan email anda">
                </label>
                <button type="submit" class="h-11 w-full rounded-xl border border-sirapi-green dark:border-emerald-500/40 px-4 text-sm font-extrabold text-sirapi-green dark:text-emerald-400 transition hover:bg-sirapi-green dark:hover:bg-[#107050] hover:text-white cursor-pointer">Kirim OTP</button>
            </form>

            <form action="{{ route('pegawai.password.reset') }}" method="POST" class="mt-5 grid grid-cols-1 gap-3">
                @csrf
                <input name="reset_email" type="hidden" value="{{ old('reset_email') }}" data-reset-email-hidden>
                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">Kode OTP</span>
                    <input name="otp" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required class="mt-2 h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-gray-800 dark:text-white px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                </label>
                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">Password Baru</span>
                    <input name="password" type="password" required minlength="8" class="mt-2 h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-gray-800 dark:text-white px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                </label>
                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400">Konfirmasi Password</span>
                    <input name="password_confirmation" type="password" required minlength="8" class="mt-2 h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-gray-800 dark:text-white px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                </label>
                <button type="submit" class="mt-1 h-11 rounded-xl bg-sirapi-green hover:bg-sirapi-greenSoft dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 px-4 text-sm font-extrabold text-white transition cursor-pointer">Simpan Password Baru</button>
            </form>
        </section>
    </div>

    <script>
        lucide.createIcons();

        const toggle = document.querySelector('[data-password-toggle]');
        const password = document.getElementById('password');
        const forgotModal = document.querySelector('[data-forgot-modal]');
        const openForgotButton = document.querySelector('[data-open-forgot]');
        const closeForgotButton = document.querySelector('[data-close-forgot]');
        const resetEmailInput = document.querySelector('[data-reset-email-input]');
        const resetEmailHidden = document.querySelector('[data-reset-email-hidden]');

        function openForgotModal() {
            forgotModal?.classList.remove('hidden');
            forgotModal?.classList.add('flex');
        }

        function closeForgotModal() {
            forgotModal?.classList.add('hidden');
            forgotModal?.classList.remove('flex');
        }

        openForgotButton?.addEventListener('click', openForgotModal);
        closeForgotButton?.addEventListener('click', closeForgotModal);
        resetEmailInput?.addEventListener('input', () => {
            if (resetEmailHidden) {
                resetEmailHidden.value = resetEmailInput.value;
            }
        });
        forgotModal?.addEventListener('click', (event) => {
            if (event.target === forgotModal) {
                closeForgotModal();
            }
        });

        toggle?.addEventListener('click', () => {
            const hidden = password.type === 'password';
            password.type = hidden ? 'text' : 'password';
            toggle.innerHTML = hidden
                ? '<i data-lucide="eye" class="h-5 w-5"></i>'
                : '<i data-lucide="eye-off" class="h-5 w-5"></i>';
            lucide.createIcons();
        });

        @if (session('forgot_open') || old('reset_email'))
            openForgotModal();
        @endif
    </script>
</body>
</html>
