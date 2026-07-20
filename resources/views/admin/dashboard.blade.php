<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - e-Agenda</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex min-h-screen bg-gray-100 font-sans antialiased">
    <x-admin.sidebar active="dashboard" />

    <main class="flex-1 p-8">
        <x-admin.navbar title="Dashboard Admin" subtitle="Selamat datang kembali." />

        <div class="rounded-lg bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-[#3b6f6c]">Dashboard Admin</p>
            <h1 class="mt-2 text-2xl font-extrabold text-gray-900">Selamat datang, {{ $admin->nama ?? 'Admin' }}</h1>
            <p class="mt-2 text-sm text-gray-600">Login berhasil. Anda sudah masuk sebagai admin e-Agenda.</p>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('admin.agenda.lihat') }}" class="rounded-lg bg-[#3b6f6c] px-4 py-2 text-sm font-bold text-white transition hover:bg-[#315d5a]">
                    Daftar Agenda
                </a>
                <a href="{{ route('admin.ruang.lihat') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-bold text-gray-700 transition hover:bg-gray-50">
                    Daftar Ruang
                </a>
            </div>
        </div>
    </main>
</body>
</html>
