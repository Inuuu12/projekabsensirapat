<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jenis Peserta Presensi - SIRAPI</title>
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
<body class="bg-[#F8F7F4] font-sans antialiased text-gray-800 flex flex-col min-h-screen">
    @include('publik.layout_publik.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-12 flex items-center justify-center">
        @php
            $agendaAktif = $agenda ?? null;
            $routeParams = $agendaAktif ? ['agenda_id' => $agendaAktif->id_agenda] : [];
        @endphp

        <div class="bg-white border border-gray-200/80 rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-lg relative space-y-6">
            <a href="{{ route('publik.agenda') }}" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 font-bold transition-colors">
                x
            </a>

            <div class="space-y-1">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Generate QR Presensi</h1>
                <p class="text-xs text-gray-500 font-medium">{{ $agendaAktif?->nama_agenda ?? 'Belum ada agenda tersedia' }}</p>
                <p class="text-xs text-gray-400">{{ substr((string) $agendaAktif?->waktu, 0, 5) ?: '-' }} WIB &bull; {{ $agendaAktif?->lokasi ?? '-' }}</p>
            </div>

            <hr class="border-gray-100">

            @if ($agendaAktif)
                <h3 class="text-xs font-bold text-gray-800">Pilih jenis peserta</h3>

                <div class="grid grid-cols-2 gap-4">
                    <button type="button" data-presensi-option="pegawai" data-url="{{ route('publik.presensi.pegawai', $routeParams) }}" class="presensi-option border-2 border-ijo-tua bg-ijo-sangatmuda/50 rounded-2xl p-5 text-center flex flex-col items-center justify-center space-y-3 cursor-pointer hover:shadow-md transition-all">
                        <div class="presensi-bubble w-16 h-16 rounded-full bg-ijo-tua text-white flex items-center justify-center text-xl transition-colors">P</div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900">Pegawai</h4>
                            <p class="text-[10px] text-gray-500 mt-1 leading-tight">Presensi pegawai untuk agenda ini</p>
                        </div>
                    </button>

                    <button type="button" data-presensi-option="tamu" data-url="{{ route('publik.presensi.tamu', $routeParams) }}" class="presensi-option border border-gray-200 bg-white hover:border-ijo-tua rounded-2xl p-5 text-center flex flex-col items-center justify-center space-y-3 cursor-pointer hover:shadow-md transition-all">
                        <div class="presensi-bubble w-16 h-16 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-xl transition-colors">T</div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900">Tamu</h4>
                            <p class="text-[10px] text-gray-500 mt-1 leading-tight">Isi data kehadiran tamu</p>
                        </div>
                    </button>
                </div>

                <a id="presensi-submit" href="{{ route('publik.presensi.pegawai', $routeParams) }}" class="w-full bg-ijo-tua hover:bg-ijo-semitua text-white font-bold text-xs py-3.5 rounded-2xl transition-colors flex items-center justify-center space-x-2 shadow-md">
                    <span id="presensi-submit-label">Lanjutkan sebagai Pegawai</span>
                    <span>&rarr;</span>
                </a>
            @else
                <div class="rounded-2xl bg-gray-50 p-5 text-center">
                    <h3 class="text-sm font-bold text-gray-900">Agenda belum tersedia</h3>
                    <p class="text-xs text-gray-500 mt-2">Tambahkan agenda di admin terlebih dahulu sebelum membuat presensi.</p>
                </div>
            @endif

            <div class="text-center">
                <a href="{{ route('publik.agenda') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">Batal</a>
            </div>
        </div>
    </main>

    @include('publik.layout_publik.footer')
    @if ($agendaAktif)
        <script>
            const presensiOptions = document.querySelectorAll('.presensi-option');
            const presensiSubmit = document.getElementById('presensi-submit');
            const presensiSubmitLabel = document.getElementById('presensi-submit-label');
            let selectedPresensi = 'pegawai';

            function setSelectedPresensi(option) {
                selectedPresensi = option.dataset.presensiOption;

                presensiOptions.forEach((item) => {
                    const bubble = item.querySelector('.presensi-bubble');
                    const isActive = item === option;

                    item.classList.toggle('border-2', isActive);
                    item.classList.toggle('border-ijo-tua', isActive);
                    item.classList.toggle('bg-ijo-sangatmuda/50', isActive);
                    item.classList.toggle('border', !isActive);
                    item.classList.toggle('border-gray-200', !isActive);
                    item.classList.toggle('bg-white', !isActive);

                    bubble.classList.toggle('bg-ijo-tua', isActive);
                    bubble.classList.toggle('text-white', isActive);
                    bubble.classList.toggle('bg-gray-100', !isActive);
                    bubble.classList.toggle('text-gray-500', !isActive);
                });

                presensiSubmit.href = option.dataset.url;
                presensiSubmitLabel.textContent = selectedPresensi === 'pegawai'
                    ? 'Lanjutkan sebagai Pegawai'
                    : 'Lanjutkan sebagai Tamu';
            }

            presensiOptions.forEach((option) => {
                option.addEventListener('click', () => {
                    if (selectedPresensi === option.dataset.presensiOption) {
                        window.location.href = option.dataset.url;
                        return;
                    }

                    setSelectedPresensi(option);
                });
            });
        </script>
    @endif
</body>
</html>
