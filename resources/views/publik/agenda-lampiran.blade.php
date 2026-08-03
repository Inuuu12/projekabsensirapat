<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lampiran Agenda - SIRAPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ijo-tua': '#14524E',
                        'ijo-semitua': '#1F7A6F',
                        'ijo-sangatmuda': '#DCF1E6',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-black font-sans antialiased text-white">
    <main class="flex min-h-screen flex-col">
        <section class="flex flex-1 items-center justify-center overflow-auto bg-black">
            @if ($isImage)
                <img src="{{ $fileUrl }}" alt="Lampiran {{ $agenda->nama_agenda }}" class="max-h-none w-full max-w-full object-contain sm:h-auto sm:w-auto sm:max-h-[calc(100vh-84px)]">
            @elseif ($isPdf)
                <iframe src="{{ $fileUrl }}" title="Lampiran {{ $agenda->nama_agenda }}" class="h-[calc(100vh-84px)] w-full border-0 bg-white"></iframe>
            @else
                <div class="flex min-h-[calc(100vh-84px)] flex-col items-center justify-center gap-4 p-6 text-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/10 text-xs font-black uppercase text-white">
                        {{ $extension ?: 'file' }}
                    </div>
                    <p class="max-w-sm text-sm text-white/70">Preview file tidak tersedia di browser.</p>
                    <a href="{{ $fileUrl }}" target="_blank" rel="noopener" class="inline-flex h-10 items-center justify-center rounded-lg bg-white px-4 text-xs font-bold text-gray-900 transition hover:bg-gray-200">
                        Buka File
                    </a>
                </div>
            @endif
        </section>

        <div class="flex min-h-[84px] items-center justify-center border-t border-white/10 bg-black px-4 py-5">
            <a href="{{ route('publik.agenda.detail', $agenda->id_agenda, false) }}" class="inline-flex h-11 items-center justify-center rounded-lg bg-ijo-tua px-5 text-sm font-bold text-white transition hover:bg-ijo-semitua">
                Kembali
            </a>
        </div>
    </main>
</body>
</html>
