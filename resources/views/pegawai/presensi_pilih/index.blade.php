<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Metode Presensi Pegawai - SIRAPI</title>
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
            <a href="{{ $agendaAktif ? route('publik.agenda.detail', $agendaAktif->id_agenda) : route('publik.agenda') }}" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 font-bold transition-colors" title="Kembali">
                &larr;
            </a>

            <div class="space-y-1">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Metode Presensi</h1>
                <p class="text-xs text-gray-500 font-medium">Pegawai &bull; {{ $agendaAktif?->nama_agenda ?? 'Belum ada agenda tersedia' }}</p>
                <p class="text-xs text-gray-400">{{ substr((string) $agendaAktif?->waktu, 0, 5) ?: '-' }} WIB &bull; {{ $agendaAktif?->lokasi ?? '-' }}</p>
            </div>

            <hr class="border-gray-100">

            @if ($agendaAktif && $agendaAktif->status_label === 'Selesai')
                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 11 0 0118 0" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-amber-900">Agenda Rapat Telah Selesai</h3>
                    <p class="text-xs font-medium text-amber-700 leading-relaxed">Presensi untuk agenda rapat ini telah ditutup karena waktu pelaksanaan rapat telah berakhir.</p>
                </div>
            @elseif ($agendaAktif)
                <h3 class="text-xs font-bold text-gray-800">Pilih metode kehadiran</h3>

                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('publik.presensi.pegawai.wajah', $routeParams) }}" class="border-2 border-ijo-tua bg-ijo-sangatmuda/50 rounded-2xl p-5 text-center flex items-center space-x-4 cursor-pointer hover:shadow-md transition-all">
                        <div class="w-14 h-14 rounded-full bg-ijo-tua text-white flex items-center justify-center text-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold text-sm text-gray-900">Scan Wajah (Otomatis)</h4>
                            <p class="text-[10px] text-gray-600 mt-1 leading-tight">Gunakan kamera untuk absen cepat</p>
                        </div>
                    </a>

                    <a href="{{ route('pegawai.login', $routeParams) }}" class="border border-gray-200 bg-white hover:border-ijo-tua rounded-2xl p-5 text-center flex items-center space-x-4 cursor-pointer hover:shadow-md transition-all group">
                        <div class="w-14 h-14 rounded-full bg-gray-100 text-gray-500 group-hover:bg-ijo-tua group-hover:text-white transition-colors flex items-center justify-center text-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold text-sm text-gray-900 group-hover:text-ijo-tua transition-colors">Login Manual</h4>
                            <p class="text-[10px] text-gray-500 mt-1 leading-tight">Masuk dengan email dan password</p>
                        </div>
                    </a>
                </div>
            @endif

            <div class="text-center mt-6">
                <a href="{{ $agendaAktif ? route('publik.agenda.detail', $agendaAktif->id_agenda) : route('publik.agenda') }}" class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors">Kembali ke Detail Agenda</a>
            </div>
        </div>
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
