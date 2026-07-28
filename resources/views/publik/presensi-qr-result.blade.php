<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Presensi QR - SIRAPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ijo-tua': '#14524E',
                        'ijo-semitua': '#1F7A6F',
                        'ijo-sangatmuda': '#DCF1E6',
                        'oren-muda': '#FBEBD1',
                        'oren-tua': '#B87A1E',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8F7F4] font-sans antialiased text-gray-800 flex flex-col min-h-screen">
    @include('publik.layout_publik.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-12 flex items-center justify-center">
        <div class="bg-white border border-gray-200/80 rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-lg text-center space-y-5">
            <div class="mx-auto w-16 h-16 rounded-full {{ $success ? 'bg-ijo-tua text-white' : 'bg-oren-muda text-oren-tua' }} flex items-center justify-center text-xl font-black">
                {{ $success ? 'OK' : '!' }}
            </div>

            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">{{ $success ? 'Presensi Berhasil' : 'Presensi Gagal' }}</h1>
                <p class="text-xs text-gray-500 mt-2">{{ $message }}</p>
            </div>

            <div class="rounded-2xl bg-gray-50 p-4 text-left text-xs space-y-2">
                <p><span class="font-bold text-gray-900">Agenda:</span> {{ $agenda->nama_agenda }}</p>
                <p><span class="font-bold text-gray-900">Tanggal:</span> {{ $agenda->tanggal?->translatedFormat('d F Y') ?? '-' }}</p>
                <p><span class="font-bold text-gray-900">Waktu:</span> {{ substr((string) $agenda->waktu, 0, 5) ?: '-' }} WIB</p>
                <p><span class="font-bold text-gray-900">Lokasi:</span> {{ $agenda->lokasi ?? '-' }}</p>
            </div>

            <a href="{{ route('publik.beranda') }}" class="inline-flex w-full items-center justify-center rounded-2xl bg-ijo-tua py-3.5 text-xs font-bold text-white hover:bg-ijo-semitua">
                Kembali ke Beranda
            </a>
        </div>
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
