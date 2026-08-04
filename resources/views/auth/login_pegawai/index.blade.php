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

    <main class="flex min-h-[calc(100vh-240px)] items-start justify-center px-6 pt-44">
        <section class="w-full max-w-[356px]">
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

                <label for="email" class="relative block">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#8B9490]">
                        <i data-lucide="mail" class="h-5 w-5"></i>
                    </span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        class="h-12 w-full rounded-lg border border-[#DDE3DF] bg-white pl-12 pr-4 text-sm font-medium text-gray-800 shadow-sm outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="nama@bogorkab.go.id">
                </label>

                <div>
                    <label for="password" class="relative block">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-[#8B9490]">
                            <i data-lucide="lock-keyhole" class="h-5 w-5"></i>
                        </span>
                        <input id="password" name="password" type="password" required
                            class="h-12 w-full rounded-lg border border-[#DDE3DF] bg-white pl-12 pr-12 text-sm font-medium text-gray-800 shadow-sm outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                            placeholder="Minimal 8 karakter">
                        <button type="button" data-password-toggle class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-[#8B9490] transition hover:text-sirapi-green" aria-label="Tampilkan kata sandi">
                            <i data-lucide="eye-off" class="h-5 w-5"></i>
                        </button>
                    </label>
                    <div class="mt-3 text-right">
                        <a href="#" class="text-sm font-bold text-[#27364A] hover:text-sirapi-green">Lupa kata sandi?</a>
                    </div>
                </div>

                <button type="submit" class="h-12 w-full rounded-lg bg-sirapi-green text-sm font-extrabold text-white shadow-sm transition hover:bg-sirapi-greenSoft focus:outline-none focus:ring-2 focus:ring-sirapi-green/25">
                    Login Pegawai
                </button>

                <p class="text-center text-sm font-semibold text-gray-500">
                    Belum punya akun?
                    <a href="{{ route('pegawai.register') }}" class="font-extrabold text-[#27364A] hover:text-sirapi-green">Daftar pegawai</a>
                </p>
            </form>
        </section>
    </main>

    <script>
        lucide.createIcons();

        const toggle = document.querySelector('[data-password-toggle]');
        const password = document.getElementById('password');

        toggle?.addEventListener('click', () => {
            const hidden = password.type === 'password';
            password.type = hidden ? 'text' : 'password';
            toggle.innerHTML = hidden
                ? '<i data-lucide="eye" class="h-5 w-5"></i>'
                : '<i data-lucide="eye-off" class="h-5 w-5"></i>';
            lucide.createIcons();
        });
    </script>
</body>
</html>
