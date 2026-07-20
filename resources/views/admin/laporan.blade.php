<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="flex min-h-screen bg-gray-100 font-sans antialiased">
    <x-admin.sidebar active="laporan" />

    <main class="flex-1 p-8">
        <x-admin.navbar title="Laporan" subtitle="Kelola dan cetak laporan absensi rapat." />

        <div class="rounded-lg bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-[#3b6f6c]">Laporan</p>
            <h1 class="mt-2 text-2xl font-extrabold text-gray-900">Halaman Laporan</h1>
            <p class="mt-2 text-sm text-gray-600">Total logbook saat ini: {{ $totalLogbook }}</p>

            <a href="{{ url('/admin/laporan/cetak') }}" class="mt-6 inline-flex rounded-lg bg-[#3b6f6c] px-4 py-2 text-sm font-bold text-white transition hover:bg-[#315d5a]">
                Cetak Laporan
            </a>
        </div>
    </main>
</body>
</html>
