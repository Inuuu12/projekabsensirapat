<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Pegawai - Diskominfo Kab. Bogor</title>
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

    <main class="flex-grow container mx-auto px-4 py-12 flex items-center justify-center">
        @php
            $agendaAktif = $agenda ?? null;
            $qrAktif = $agendaAktif && ($agendaAktif->status_qr === 'aktif') && ($qrCode ?? null);
            $qrBisaScan = $qrAktif && ($qrSedangBerlangsung ?? false);
            $routeParams = $agendaAktif ? ['agenda_id' => $agendaAktif->id_agenda] : [];
            $qrPayload = $qrAktif ? $qrCode->qr_codepath : null;
            $qrImageUrl = $qrPayload ? 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=' . urlencode($qrPayload) : null;
        @endphp

        <div class="bg-white border border-gray-200/80 rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-lg relative space-y-6">
            <a href="{{ route('publik.agenda') }}" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 font-bold transition-colors">
                x
            </a>

            <a href="{{ route('publik.presensi.pilih', $routeParams) }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-ijo-semitua hover:underline">
                <span>&larr;</span>
                <span>Kembali</span>
            </a>

            <div class="space-y-1">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Presensi Pegawai</h1>
                <p class="text-xs text-gray-500 font-medium">{{ $agendaAktif?->nama_agenda ?? 'Belum ada agenda tersedia' }}</p>
                <p class="text-xs text-gray-400">
                    {{ substr((string) $agendaAktif?->waktu, 0, 5) ?: '-' }}{{ $agendaAktif?->waktu_selesai ? ' - ' . substr((string) $agendaAktif->waktu_selesai, 0, 5) : '' }} WIB &bull; {{ $agendaAktif?->lokasi ?? '-' }}
                </p>
            </div>

            <hr class="border-gray-100">

            @if ($agendaAktif)
                <div class="border-2 border-ijo-tua bg-ijo-sangatmuda/50 rounded-2xl p-4 flex items-center justify-between shadow-sm relative">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-ijo-tua text-white flex items-center justify-center text-sm font-bold shrink-0">QR</div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900">Generate QR Code</h4>
                            <p class="text-[11px] text-gray-500">
                                @if ($qrBisaScan)
                                    QR sedang aktif dan siap discan.
                                @elseif ($qrAktif)
                                    QR sudah dibuat, tapi hanya aktif pada {{ $qrWindowLabel }}.
                                @else
                                    QR belum dibuat atau belum diaktifkan admin.
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="w-6 h-6 rounded-full {{ $qrBisaScan ? 'bg-ijo-tua text-white' : 'bg-gray-200 text-gray-500' }} flex items-center justify-center text-xs font-bold shrink-0">{{ $qrBisaScan ? 'OK' : '!' }}</div>
                </div>

                @if ($qrBisaScan)
                    <div class="rounded-3xl border border-gray-100 bg-white p-5 text-center shadow-sm space-y-4">
                        <img src="{{ $qrImageUrl }}" alt="QR Presensi {{ $agendaAktif->nama_agenda }}" class="mx-auto h-64 w-64 rounded-2xl border border-gray-100 bg-white p-3">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Scan QR untuk Hadir</h3>
                            <p class="text-[11px] text-gray-500 mt-1">QR ini dibuat dari admin. Saat discan, kehadiran agenda akan langsung dicatat.</p>
                        </div>
                        <a href="{{ $qrPayload }}" target="_blank" rel="noopener" class="inline-flex w-full items-center justify-center rounded-2xl bg-ijo-tua py-3.5 text-xs font-bold text-white hover:bg-ijo-semitua">
                            Test Buka Link QR
                        </a>
                    </div>
                @elseif ($qrAktif)
                    <div class="rounded-2xl bg-oren-muda p-5 text-center">
                        <h3 class="text-sm font-bold text-oren-tua">QR otomatis tertutup</h3>
                        <p class="text-xs text-oren-tua/80 mt-2">QR hanya bisa discan saat agenda sedang berlangsung: {{ $qrWindowLabel }}.</p>
                    </div>
                @else
                    <div class="rounded-2xl bg-gray-50 p-5 text-center">
                        <h3 class="text-sm font-bold text-gray-900">QR belum tersedia</h3>
                        <p class="text-xs text-gray-500 mt-2">Admin harus klik tombol Generate QR di daftar agenda dan memastikan Status QR aktif.</p>
                    </div>
                @endif
            @else
                <div class="rounded-2xl bg-gray-50 p-5 text-center">
                    <h3 class="text-sm font-bold text-gray-900">Agenda belum tersedia</h3>
                    <p class="text-xs text-gray-500 mt-2">Tambahkan agenda di admin terlebih dahulu sebelum membuat QR presensi.</p>
                </div>
            @endif
        </div>
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
