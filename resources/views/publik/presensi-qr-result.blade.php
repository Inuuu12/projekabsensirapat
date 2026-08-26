<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Presensi QR - SIRAPI</title>
    @include('publik.layout_publik.theme_script')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'ijo-tua': '#35635b',
                        'ijo-semitua': '#2b4f49',
                        'ijo-sangatmuda': '#e3eeea',
                        'oren-muda': '#FBEBD1',
                        'oren-tua': '#B87A1E',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8F7F4] dark:bg-[#0d1614] font-sans antialiased text-gray-800 dark:text-slate-100 flex flex-col min-h-screen transition-colors duration-200">
    @include('publik.layout_publik.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-12 flex items-center justify-center">
        <div class="bg-white dark:bg-[#152420] border border-gray-200/80 dark:border-[#233a34] rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-lg text-center space-y-5 transition-colors">
            <div class="mx-auto w-16 h-16 rounded-full {{ $success ? 'bg-ijo-tua dark:bg-[#107050] text-white border border-transparent dark:border-[#10b981]/30' : 'bg-oren-muda dark:bg-amber-950/60 text-oren-tua dark:text-amber-300 border border-transparent dark:border-amber-700/40' }} flex items-center justify-center text-xl font-black">
                {{ $success ? 'OK' : '!' }}
            </div>

            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">{{ $success ? 'Presensi Berhasil' : 'Presensi Gagal' }}</h1>
                <p class="text-xs text-gray-500 dark:text-gray-300 mt-2">{{ $message }}</p>
            </div>

            <div class="rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] p-4 text-left text-xs space-y-2 text-gray-700 dark:text-gray-300">
                <p><span class="font-bold text-gray-900 dark:text-white">Agenda:</span> {{ $agenda->nama_agenda }}</p>
                <p><span class="font-bold text-gray-900 dark:text-white">Tanggal:</span> {{ $agenda->tanggal?->translatedFormat('d F Y') ?? '-' }}</p>
                <p><span class="font-bold text-gray-900 dark:text-white">Waktu:</span> {{ substr((string) $agenda->waktu, 0, 5) ?: '-' }} WIB</p>
                <p><span class="font-bold text-gray-900 dark:text-white">Lokasi:</span> {{ $agenda->lokasi ?? '-' }}</p>
            </div>

            <a href="{{ route('publik.beranda') }}" class="inline-flex w-full items-center justify-center rounded-2xl bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 py-3.5 text-xs font-bold text-white shadow-xs cursor-pointer">
                Kembali ke Beranda
            </a>
        </div>
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
