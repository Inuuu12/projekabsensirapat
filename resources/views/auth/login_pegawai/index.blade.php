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
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sirapi: {
                            green: '#155B53',
                            greenSoft: '#246F66',
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
<body class="min-h-screen bg-white font-sans text-sirapi-ink antialiased">
    <header class="relative flex h-[240px] items-center justify-center overflow-hidden bg-sirapi-green text-white">
        <div class="absolute -left-20 -top-24 h-72 w-72 rounded-full bg-white/10"></div>
        <div class="relative flex flex-col items-center text-center">
            <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Kabupaten Bogor" class="h-28 w-auto drop-shadow">
            <h1 class="mt-5 text-2xl font-extrabold tracking-wide">SIRAPI</h1>
            <p class="mt-2 text-sm font-bold">Sistem Informasi Rapat dan Presensi</p>
        </div>
    </header>

    <main class="flex min-h-[calc(100vh-240px)] items-start justify-center px-6 pt-16 pb-12">
        <section class="w-full max-w-[356px]">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-[#2A3547] tracking-tight">Selamat Datang</h2>
                <p class="mt-2 text-[15px] font-bold text-[#2A3547]">Silakan login menggunakan email resmi Anda.</p>
            </div>

            @if (session('status'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('pegawai.login.submit') }}" method="POST" class="space-y-7">
                @csrf
                @if(request('agenda_id'))
                    <input type="hidden" name="agenda_id" value="{{ request('agenda_id') }}">
                @endif

                <div>
                    <label for="email" class="block text-left text-sm font-bold text-[#2A3547] mb-1.5">Email</label>
                    <div class="relative block">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#8B9490]">
                            <i data-lucide="mail" class="h-5 w-5"></i>
                        </span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                            class="h-12 w-full rounded-lg border border-[#DDE3DF] bg-white pl-12 pr-4 text-sm font-medium text-gray-800 shadow-sm outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                            placeholder="Masukkan email anda">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-left text-sm font-bold text-[#2A3547] mb-1.5">Kata sandi</label>
                    <div class="relative block">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#8B9490]">
                            <i data-lucide="lock-keyhole" class="h-5 w-5"></i>
                        </span>
                        <input id="password" name="password" type="password" required
                            class="h-12 w-full rounded-lg border border-[#DDE3DF] bg-white pl-12 pr-12 text-sm font-medium text-gray-800 shadow-sm outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                            placeholder="Minimal 8 karakter">
                        <button type="button" data-password-toggle class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-[#8B9490] transition hover:text-sirapi-green" aria-label="Tampilkan kata sandi">
                            <i data-lucide="eye-off" class="h-5 w-5"></i>
                        </button>
                    </div>
                    <div class="mt-3 text-right">
                        <button type="button" data-open-forgot class="text-sm font-bold text-[#2A3547] hover:text-sirapi-green">Lupa kata sandi?</button>
                    </div>
                </div>

                <button type="submit" class="h-12 w-full rounded-lg bg-[#D8A01A] hover:bg-[#C28E13] text-sm font-extrabold text-white shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#D8A01A]/25">
                    Masuk
                </button>

                <p class="text-center text-sm font-semibold text-gray-500">
                    Belum punya akun?
                    <a href="{{ route('pegawai.register') }}" class="font-extrabold text-[#27364A] hover:text-sirapi-green">Daftar Sekarang!</a>
                </p>
            </form>
        </section>
    </main>

    <div data-forgot-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-black/45 px-5">
        <section class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-extrabold text-sirapi-ink">Reset Kata Sandi</h2>
                    <p class="mt-1 text-sm font-medium text-gray-500">Kirim OTP ke email pegawai, lalu masukkan password baru.</p>
                </div>
                <button type="button" data-close-forgot class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700" aria-label="Tutup">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <form action="{{ route('pegawai.password.otp') }}" method="POST" class="mt-6 space-y-3">
                @csrf
                <label class="block">
                    <span class="text-xs font-extrabold uppercase text-gray-500">Email Pegawai</span>
                    <input name="reset_email" type="email" value="{{ old('reset_email') }}" required data-reset-email-input class="mt-2 h-11 w-full rounded-xl border border-gray-200 px-3 text-sm font-bold outline-none focus:border-sirapi-green" placeholder="Masukkan email anda">
                </label>
                <button type="submit" class="h-11 w-full rounded-xl border border-sirapi-green px-4 text-sm font-extrabold text-sirapi-green transition hover:bg-sirapi-green hover:text-white">Kirim OTP</button>
            </form>

            <form action="{{ route('pegawai.password.reset') }}" method="POST" class="mt-5 grid grid-cols-1 gap-3">
                @csrf
                <input name="reset_email" type="hidden" value="{{ old('reset_email') }}" data-reset-email-hidden>
                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Kode OTP</span>
                    <input name="otp" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required class="mt-2 h-11 w-full rounded-xl border border-gray-200 px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                </label>
                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Password Baru</span>
                    <input name="password" type="password" required minlength="8" class="mt-2 h-11 w-full rounded-xl border border-gray-200 px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                </label>
                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Konfirmasi Password</span>
                    <input name="password_confirmation" type="password" required minlength="8" class="mt-2 h-11 w-full rounded-xl border border-gray-200 px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                </label>
                <button type="submit" class="mt-1 h-11 rounded-xl bg-sirapi-green px-4 text-sm font-extrabold text-white transition hover:bg-sirapi-greenSoft">Simpan Password Baru</button>
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
