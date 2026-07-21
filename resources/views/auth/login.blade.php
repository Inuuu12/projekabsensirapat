<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - e-Agenda</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-gray-100 font-sans antialiased">
    <main class="grid min-h-screen grid-cols-1 lg:grid-cols-2">
        <section class="flex items-center justify-center bg-[#3b6f6c] p-8 text-white">
            <div class="max-w-sm text-center">
                <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Bappenda" class="mx-auto mb-6 h-24 w-auto">
                <!-- <h1 class="text-3xl font-extrabold">BAPPENDA</h1>
                <p class="mt-1 text-sm font-semibold tracking-wider text-white/80">KABUPATEN BOGOR</p> -->
                <p class="mt-8 text-5xl font-bold">e-Agenda</p>
                <p class="mt-2 text-sm text-white/80">Sistem Agenda Kegiatan Dinas Kab. Bogor</p>
            </div>
        </section>

        <section class="flex items-center justify-center p-8">
            <form method="POST" action="{{ route('admin.login.submit') }}" class="w-full max-w-md rounded-lg bg-white p-8 shadow-sm">
                @csrf

                <h2 class="text-2xl font-extrabold text-gray-900">Login Admin</h2>
                <p class="mt-2 text-sm text-gray-500">Masuk menggunakan username admin Anda.</p>

                @if (session('status'))
                    <div class="mt-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="mt-6">
                    <label for="username" class="text-sm font-bold text-gray-700">Username</label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}" autocomplete="username" required class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#3b6f6c] focus:ring-2 focus:ring-[#3b6f6c]/20">
                </div>

                <div class="mt-4">
                    <label for="password" class="text-sm font-bold text-gray-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-[#3b6f6c] focus:ring-2 focus:ring-[#3b6f6c]/20">
                </div>

                <button type="submit" class="mt-6 w-full rounded-lg bg-[#3b6f6c] px-4 py-3 text-sm font-extrabold text-white transition hover:bg-[#315d5a]">
                    Login
                </button>
            </form>
        </section>
    </main>
</body>
</html>
