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
                <form action="{{ route('publik.tamu.hadir') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="id_agenda" value="{{ $agendaAktif->id_agenda }}">

                    <!-- 1. Foto / Swafoto -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800">Foto Presensi / Swafoto *</label>
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-[#EAE8E1]/40 hover:bg-[#EAE8E1]/80 transition-all relative overflow-hidden group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4" id="upload-placeholder">
                                    <svg class="w-6 h-6 mb-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-[11px] text-gray-600 font-semibold">Klik untuk ambil/unggah foto</p>
                                    <p class="text-[10px] text-gray-400">PNG, JPG atau JPEG (Maks. 5MB)</p>
                                </div>
                                <img id="foto-preview" class="hidden absolute inset-0 w-full h-full object-cover rounded-2xl" />
                                <input type="file" name="foto" id="foto-input" accept="image/*" capture="user" class="hidden" required onchange="previewImage(event)" />
                            </label>
                        </div>
                    </div>

                    <!-- 2. Nama Lengkap -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800">Nama Lengkap *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap" class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3.5 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                    </div>

                    <!-- 3. NIK (Nomer Induk Karyawan) -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800">NIK (Nomor Induk Karyawan/Pegawai) *</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" required placeholder="Masukkan NIK/NIP karyawan" class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3.5 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                    </div>

                    <!-- 4. Jabatan -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800">Jabatan *</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" required placeholder="Contoh: Staf IT / Kepala Bidang" class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3.5 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                    </div>

                    <!-- 5. No. HP / WhatsApp -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800">No. HP / WhatsApp *</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xx-xxxx-xxxx" class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3.5 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
                    </div>

                    <!-- 6. Asal Instansi -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800">Instansi / Asal *</label>
                        <input type="text" name="asal_instansi" value="{{ old('asal_instansi') }}" required placeholder="Contoh: Dinas Pendidikan Kab. Bogor" class="w-full bg-[#EAE8E1]/60 border border-transparent focus:border-ijo-semitua focus:bg-white text-xs rounded-2xl px-4 py-3.5 text-gray-800 placeholder-gray-400 focus:outline-none transition-all">
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

    <!-- Script Preview Foto Real-time -->
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('foto-preview');
            const placeholder = document.getElementById('upload-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('opacity-0');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>