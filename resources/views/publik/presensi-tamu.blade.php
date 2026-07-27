<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tamu Rapat - Diskominfo Kab. Bogor</title>
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
            $routeParams = $agendaAktif ? ['agenda_id' => $agendaAktif->id_agenda] : [];
        @endphp

        <div class="bg-white border border-gray-200/80 rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-lg relative space-y-6">
            <div class="flex items-center justify-between">
                <a href="{{ route('publik.presensi.pilih', $routeParams) }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-ijo-semitua hover:underline">
                    <span>&larr;</span>
                    <span>Kembali</span>
                </a>

                <span class="bg-gray-100 text-gray-600 text-[11px] font-bold px-3 py-1 rounded-full">Tamu Rapat</span>
            </div>

            <div class="space-y-1">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Form Tamu Rapat</h1>
                <p class="text-xs text-gray-500 font-medium">{{ $agendaAktif?->nama_agenda ?? 'Belum ada agenda tersedia' }}</p>
                <p class="text-xs text-gray-400">{{ substr((string) $agendaAktif?->waktu, 0, 5) ?: '-' }} WIB &bull; {{ $agendaAktif?->lokasi ?? '-' }}</p>
            </div>

            <hr class="border-gray-100">

            @if (session('success'))
                <div class="rounded-2xl bg-ijo-sangatmuda text-ijo-tua px-4 py-3 text-xs font-bold">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-2xl bg-red-50 text-red-700 px-4 py-3 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($agendaAktif)
                <form action="{{ route('publik.tamu.hadir') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="id_agenda" value="{{ $agendaAktif->id_agenda }}">

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800">Nama Lengkap *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap" class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3.5 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800">Instansi / Asal *</label>
                        <input type="text" name="asal_instansi" value="{{ old('asal_instansi') }}" required placeholder="Contoh: Dinas Pendidikan Kab. Bogor" class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3.5 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800">No. HP / WhatsApp *</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xx-xxxx-xxxx" class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3.5 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-ijo-tua hover:bg-ijo-semitua text-white font-bold text-xs py-3.5 rounded-2xl transition-colors flex items-center justify-center space-x-2 shadow-md">
                            <span>Daftar Hadir</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </form>
            @else
                <div class="rounded-2xl bg-gray-50 p-5 text-center">
                    <h3 class="text-sm font-bold text-gray-900">Agenda belum tersedia</h3>
                    <p class="text-xs text-gray-500 mt-2">Tambahkan agenda di admin terlebih dahulu sebelum mengisi daftar hadir tamu.</p>
                </div>
            @endif
        </div>
    </main>

    @include('publik.layout_publik.footer')
</body>
</html>
