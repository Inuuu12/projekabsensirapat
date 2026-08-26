<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Metode Presensi Pegawai - SIRAPI</title>
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
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8F7F4] dark:bg-[#0d1614] font-sans antialiased text-gray-800 dark:text-slate-100 flex flex-col min-h-screen transition-colors duration-200">
    @include('publik.layout_publik.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-12 flex items-center justify-center">
        @php
            $agendaAktif = $agenda ?? null;
            $routeParams = $agendaAktif ? ['agenda_id' => $agendaAktif->id_agenda] : [];
        @endphp

        <div class="bg-white dark:bg-[#152420] border border-gray-200/80 dark:border-[#233a34] rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-lg relative space-y-6 transition-colors">
            <a href="{{ $agendaAktif ? route('publik.agenda.detail', $agendaAktif->id_agenda) : route('publik.agenda') }}" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-gray-100 dark:bg-[#0f1c19] hover:bg-gray-200 dark:hover:bg-white/10 flex items-center justify-center text-gray-500 dark:text-gray-300 font-bold transition-colors cursor-pointer" title="Kembali">
                &larr;
            </a>

            <div class="space-y-1">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">Metode Presensi</h1>
                <p class="text-xs text-gray-500 dark:text-gray-300 font-medium">Pegawai &bull; {{ $agendaAktif?->nama_agenda ?? 'Belum ada agenda tersedia' }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-400">{{ substr((string) $agendaAktif?->waktu, 0, 5) ?: '-' }} WIB &bull; {{ $agendaAktif?->lokasi ?? '-' }}</p>
                @if (strtolower((string) ($agendaAktif?->kategori_surat ?? '')) === 'masuk' && !empty($agendaAktif?->ditugaskan))
                    <div class="mt-2 inline-flex items-center gap-1.5 rounded-lg bg-ijo-sangatmuda dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] px-3 py-1 text-xs font-bold text-ijo-tua dark:text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <span>Ditugaskan: {{ $agendaAktif->ditugaskan }}</span>
                    </div>
                @endif
            </div>

            <hr class="border-gray-100 dark:border-[#233a34]">

            @if ($agendaAktif && $agendaAktif->status_label === 'Selesai')
                <div class="rounded-2xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/40 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/60 text-amber-600 dark:text-amber-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 11 0 0118 0" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-amber-900 dark:text-amber-200">Agenda Rapat Telah Selesai</h3>
                    <p class="text-xs font-medium text-amber-700 dark:text-amber-300 leading-relaxed">Presensi untuk agenda rapat ini telah ditutup karena waktu pelaksanaan rapat telah berakhir.</p>
                </div>
            @elseif ($agendaAktif && $agendaAktif->isKuotaPenuh())
                <div class="rounded-2xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950/40 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/60 text-red-600 dark:text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-red-900 dark:text-red-200">Kuota Presensi Penuh</h3>
                    <p class="text-xs font-medium text-red-700 dark:text-red-300 leading-relaxed">Presensi untuk agenda ini telah ditutup karena kuota maksimal peserta telah terpenuhi.</p>
                </div>
            @elseif ($agendaAktif)
                <h3 class="text-xs font-bold text-gray-800 dark:text-gray-200">Pilih metode kehadiran</h3>

                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('publik.presensi.pegawai.wajah', $routeParams) }}" class="border-2 border-ijo-tua dark:border-emerald-500 bg-ijo-sangatmuda/50 dark:bg-[#0f1c19] rounded-2xl p-5 text-center flex items-center space-x-4 cursor-pointer hover:shadow-md transition-all">
                        <div class="w-14 h-14 rounded-full bg-ijo-tua dark:bg-[#107050] text-white flex items-center justify-center text-2xl shrink-0 shadow-xs border border-transparent dark:border-[#10b981]/30">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7V5a2 2 0 0 1 2-2h2"></path><path d="M17 3h2a2 2 0 0 1 2 2v2"></path><path d="M21 17v2a2 2 0 0 1-2 2h-2"></path><path d="M7 21H5a2 2 0 0 1-2-2v-2"></path><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">Scan Wajah (Otomatis)</h4>
                            <p class="text-[10px] text-gray-600 dark:text-gray-400 mt-1 leading-tight">Gunakan kamera untuk absen cepat</p>
                        </div>
                    </a>

                    <a href="{{ route('pegawai.login', $routeParams) }}" class="border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] hover:border-ijo-tua dark:hover:border-emerald-500 rounded-2xl p-5 text-center flex items-center space-x-4 cursor-pointer hover:shadow-md transition-all group">
                        <div class="w-14 h-14 rounded-full bg-gray-100 dark:bg-[#152420] text-gray-500 dark:text-gray-400 group-hover:bg-ijo-tua dark:group-hover:bg-[#107050] group-hover:text-white transition-colors flex items-center justify-center text-xl shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white group-hover:text-ijo-tua dark:group-hover:text-emerald-400 transition-colors">Login Manual</h4>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 leading-tight">Masuk dengan email dan password</p>
                        </div>
                    </a>
                </div>
            @endif

            <div class="text-center mt-6">
                <a href="{{ $agendaAktif ? route('publik.agenda.detail', $agendaAktif->id_agenda) : route('publik.agenda') }}" class="text-xs font-semibold text-gray-400 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">Kembali ke Detail Agenda</a>
            </div>
        </div>
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
