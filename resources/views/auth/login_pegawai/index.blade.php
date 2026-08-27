<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Pegawai - SIRAPI</title>
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
    </style>
</head>
<body class="min-h-screen bg-white dark:bg-[#0d1614] font-sans text-sirapi-ink dark:text-slate-100 antialiased transition-colors duration-200 flex flex-col">
    <header class="relative flex h-[200px] sm:h-[240px] items-center justify-center overflow-hidden bg-sirapi-green dark:bg-[#0f1c19] dark:border-b dark:border-[#233a34] text-white shrink-0">
        <div class="absolute -left-20 -top-24 h-72 w-72 rounded-full bg-white/10 dark:bg-white/5"></div>
        
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

        <div class="relative flex flex-col items-center text-center px-4">
            <img src="{{ asset('assets/foto/logo-bappenda.png') }}" alt="Logo Kabupaten Bogor" class="h-20 sm:h-28 w-auto drop-shadow">
            <h1 class="mt-3 sm:mt-5 text-xl sm:text-2xl font-extrabold tracking-wide">SIRAPI</h1>
            <p class="mt-1 sm:mt-2 text-xs sm:text-sm font-bold">Sistem Informasi Rapat dan Presensi</p>
        </div>
    </header>

    <main class="flex flex-1 items-start justify-center px-4 sm:px-6 pt-8 sm:pt-14 pb-12">
        <section class="w-full max-w-[356px]">
            <div class="text-center mb-6 sm:mb-8">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#2A3547] dark:text-white tracking-tight">Selamat Datang</h2>
                <p class="mt-1 sm:mt-2 text-xs sm:text-[15px] font-bold text-[#2A3547] dark:text-gray-300">Silakan login menggunakan email resmi Anda.</p>
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
            <div class="flex items-start justify-between gap-4 border-b border-gray-100 dark:border-[#233a34] pb-4">
                <div>
                    <h2 class="text-lg font-extrabold text-sirapi-ink dark:text-white">Reset Kata Sandi</h2>
                    <p class="mt-0.5 text-xs font-medium text-gray-500 dark:text-gray-400">Kirim kode OTP ke email pegawai, lalu buat kata sandi baru.</p>
                </div>
                <button type="button" data-close-forgot class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 dark:hover:bg-white/10 hover:text-gray-700 dark:hover:text-gray-200 cursor-pointer" aria-label="Tutup">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <form id="form-reset-password" action="{{ route('pegawai.password.reset') }}" method="POST" class="mt-5 space-y-4">
                @csrf
                <!-- Email Pegawai + Tombol Kirim OTP -->
                <div>
                    <label class="block text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400 mb-1">Email Pegawai <span class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <input id="reset_email" name="reset_email" type="email" value="{{ old('reset_email') }}" required placeholder="Masukkan email terdaftar" class="h-11 min-w-0 flex-1 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-gray-800 dark:text-white px-3 text-xs sm:text-sm font-bold outline-none focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/20">
                        <button type="button" id="btn-send-reset-otp" class="h-11 shrink-0 rounded-xl bg-[#04733f] hover:bg-[#035f35] dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 px-4 text-xs font-extrabold text-white transition shadow-xs cursor-pointer inline-flex items-center gap-1.5">
                            <i data-lucide="send" class="h-3.5 w-3.5"></i>
                            <span>Kirim OTP</span>
                        </button>
                    </div>
                    <p id="reset-otp-status" class="mt-1.5 hidden text-xs font-bold"></p>
                    <p class="mt-1 text-[11px] text-gray-400 dark:text-gray-400">Klik <strong>Kirim OTP</strong> untuk menerima kode verifikasi 6 digit di email Anda.</p>
                </div>

                <!-- Kode OTP -->
                <div>
                    <label class="block text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400 mb-1">Kode OTP <span class="text-red-500">*</span></label>
                    <input name="otp" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required placeholder="Masukkan 6 digit kode OTP" class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-gray-800 dark:text-white px-3 text-xs sm:text-sm font-bold outline-none focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/20">
                </div>

                <!-- Password Baru -->
                <div>
                    <label class="block text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400 mb-1">Password Baru <span class="text-red-500">*</span></label>
                    <input name="password" type="password" required minlength="8" placeholder="Minimal 8 karakter" class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-gray-800 dark:text-white px-3 text-xs sm:text-sm font-bold outline-none focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/20">
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label class="block text-xs font-extrabold uppercase text-gray-500 dark:text-gray-400 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input name="password_confirmation" type="password" required minlength="8" placeholder="Ulangi password baru" class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-gray-800 dark:text-white px-3 text-xs sm:text-sm font-bold outline-none focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/20">
                </div>

                <div class="pt-1">
                    <button type="submit" class="h-11 w-full rounded-xl bg-[#04733f] hover:bg-[#035f35] dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 px-4 text-sm font-extrabold text-white transition shadow-xs cursor-pointer">Simpan Password Baru</button>
                </div>
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
        const resetEmailInput = document.getElementById('reset_email');
        const sendResetOtpButton = document.getElementById('btn-send-reset-otp');
        const resetOtpStatus = document.getElementById('reset-otp-status');

        function showResetOtpStatus(message, isSuccess) {
            if (!resetOtpStatus) return;
            resetOtpStatus.textContent = message;
            resetOtpStatus.classList.remove('hidden', 'text-red-600', 'text-emerald-600');
            resetOtpStatus.classList.add(isSuccess ? 'text-emerald-600' : 'text-red-600');
        }

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

        forgotModal?.addEventListener('click', (event) => {
            if (event.target === forgotModal) {
                closeForgotModal();
            }
        });

        sendResetOtpButton?.addEventListener('click', async () => {
            const email = resetEmailInput?.value.trim();
            if (!email) {
                showResetOtpStatus('Isi email pegawai terlebih dahulu.', false);
                resetEmailInput?.focus();
                return;
            }

            sendResetOtpButton.disabled = true;
            sendResetOtpButton.innerHTML = '<i data-lucide="loader-2" class="h-3.5 w-3.5 animate-spin"></i><span>Mengirim...</span>';
            lucide.createIcons();
            showResetOtpStatus('Mengirim kode OTP ke email...', true);

            try {
                const response = await fetch('{{ route('pegawai.password.otp') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ reset_email: email }),
                });
                const data = await response.json();

                showResetOtpStatus(data.message || 'Kode OTP sudah dikirim ke email.', response.ok && data.success);
            } catch (error) {
                showResetOtpStatus('OTP gagal dikirim. Periksa koneksi atau konfigurasi email.', false);
            } finally {
                sendResetOtpButton.disabled = false;
                sendResetOtpButton.innerHTML = '<i data-lucide="send" class="h-3.5 w-3.5"></i><span>Kirim OTP</span>';
                lucide.createIcons();
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
