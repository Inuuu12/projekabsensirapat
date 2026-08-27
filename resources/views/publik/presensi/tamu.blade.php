<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tamu Rapat - SIRAPI</title>
    @include('publik.layout.theme_script')
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
    @include('publik.layout.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-12 flex items-center justify-center">
        @php
            $agendaAktif = $agenda ?? null;
            $routeParams = $agendaAktif ? ['agenda_id' => $agendaAktif->id_agenda] : [];
        @endphp

        <div class="bg-white dark:bg-[#152420] border border-gray-200/80 dark:border-[#233a34] rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-lg relative space-y-6 transition-colors">
            <div class="flex items-center justify-between">
                <a href="{{ $agendaAktif ? route('publik.agenda.detail', $agendaAktif->id_agenda) : route('publik.agenda') }}" class="inline-flex items-center space-x-1.5 text-xs font-bold text-ijo-semitua dark:text-emerald-400 hover:underline">
                    <span>&larr;</span>
                    <span>Kembali</span>
                </a>

                <span class="bg-gray-100 dark:bg-[#0f1c19] text-gray-600 dark:text-gray-300 text-[11px] font-bold px-3 py-1 rounded-full border border-transparent dark:border-[#284c43]">Tamu Rapat</span>
            </div>

            <div class="space-y-1">
                <h1 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white">Form Tamu Rapat</h1>
                <p class="text-xs text-gray-500 dark:text-gray-300 font-medium">{{ $agendaAktif?->nama_agenda ?? 'Belum ada agenda tersedia' }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-400">{{ substr((string) $agendaAktif?->waktu, 0, 5) ?: '-' }} WIB &bull; {{ $agendaAktif?->lokasi_display ?? '-' }}</p>
            </div>

            <hr class="border-gray-100 dark:border-[#233a34]">

            @if (session('success'))
                <div class="rounded-2xl bg-ijo-sangatmuda dark:bg-[#0f1c19] text-ijo-tua dark:text-emerald-400 border border-transparent dark:border-[#284c43] px-4 py-3 text-xs font-bold shadow-xs">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-2xl bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800 px-4 py-3 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($agendaAktif && $agendaAktif->status_label === 'Selesai')
                <div class="rounded-2xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/40 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/60 text-amber-600 dark:text-amber-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 11 0 0118 0" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-amber-900 dark:text-amber-200">Agenda Rapat Telah Selesai</h3>
                    <p class="text-xs font-medium text-amber-700 dark:text-amber-300 leading-relaxed">Presensi untuk agenda rapat ini telah ditutup karena waktu pelaksanaan rapat telah berakhir.</p>
                </div>
            @elseif ($agendaAktif && $agendaAktif->status_label === 'Mendatang')
                <div class="rounded-2xl border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-950/40 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/60 text-blue-600 dark:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-blue-900 dark:text-blue-200">Presensi Belum Dibuka (Terkunci)</h3>
                    <p class="text-xs font-medium text-blue-700 dark:text-blue-300 leading-relaxed">
                        Presensi tamu untuk agenda ini masih terkunci dan baru dapat diisi saat rapat dimulai pada pukul <strong>{{ substr((string) $agendaAktif->waktu, 0, 5) }} WIB</strong> ({{ $agendaAktif->tanggal?->translatedFormat('d F Y') }}).
                    </p>
                </div>
            @elseif ($agendaAktif && strtolower((string) ($agendaAktif->kategori_surat ?? '')) === 'masuk')
                <div class="rounded-2xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/40 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/60 text-amber-600 dark:text-amber-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-amber-900 dark:text-amber-200">Agenda Surat Masuk</h3>
                    <p class="text-xs font-medium text-amber-700 dark:text-amber-300 leading-relaxed">Agenda ini diadakan oleh pihak eksternal dan hanya diperuntukkan bagi kehadiran pegawai internal yang ditugaskan.</p>
                </div>
            @elseif ($agendaAktif && $agendaAktif->isKuotaPenuh())
                <div class="rounded-2xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950/40 p-6 text-center space-y-3">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/60 text-red-600 dark:text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-red-900 dark:text-red-200">Kuota Presensi Penuh</h3>
                    <p class="text-xs font-medium text-red-700 dark:text-red-300 leading-relaxed">Pendaftaran kehadiran tamu telah ditutup karena kuota maksimal peserta agenda ini telah terpenuhi.</p>
                </div>
            @elseif ($agendaAktif)
                <form action="{{ route('publik.tamu.hadir') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="id_agenda" value="{{ $agendaAktif->id_agenda }}">

                    <!-- 1. Foto / Swafoto -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800 dark:text-gray-200">Foto Presensi / Swafoto *</label>
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-[#284c43] rounded-2xl cursor-pointer bg-[#EAE8E1]/40 dark:bg-[#0f1c19] hover:bg-[#EAE8E1]/80 dark:hover:bg-[#152420] transition-all relative overflow-hidden group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4" id="upload-placeholder">
                                    <svg class="w-6 h-6 mb-1 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-[11px] text-gray-600 dark:text-gray-300 font-semibold">Klik untuk ambil/unggah foto</p>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-400">PNG, JPG atau JPEG (Maks. 5MB)</p>
                                </div>
                                <img id="foto-preview" class="hidden absolute inset-0 w-full h-full object-cover rounded-2xl" />
                                <input type="file" name="foto" id="foto-input" accept="image/*" capture="user" class="hidden" required onchange="previewImage(event)" />
                            </label>
                        </div>
                    </div>

                    <!-- 2. Nama Lengkap -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800 dark:text-gray-200">Nama Lengkap *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap" class="w-full bg-[#EAE8E1]/60 dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] focus:border-ijo-semitua dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#152420] text-xs rounded-2xl px-4 py-3.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                    </div>

                    <!-- 3. NIK (Nomer Induk Karyawan) -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800 dark:text-gray-200">NIK (Nomor Induk Karyawan/Pegawai) *</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" required pattern="[0-9]+" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Masukkan NIK/NIP karyawan" class="w-full bg-[#EAE8E1]/60 dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] focus:border-ijo-semitua dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#152420] text-xs rounded-2xl px-4 py-3.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                    </div>

                    <!-- 4. Jabatan -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800 dark:text-gray-200">Jabatan *</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" required placeholder="Contoh: Staf IT / Kepala Bidang" class="w-full bg-[#EAE8E1]/60 dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] focus:border-ijo-semitua dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#152420] text-xs rounded-2xl px-4 py-3.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                    </div>

                    <!-- 5. No. HP / WhatsApp -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800 dark:text-gray-200">No. HP / WhatsApp *</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required pattern="[0-9]+" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="08xx-xxxx-xxxx" class="w-full bg-[#EAE8E1]/60 dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] focus:border-ijo-semitua dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#152420] text-xs rounded-2xl px-4 py-3.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                    </div>

                    <!-- 6. Asal Instansi -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800 dark:text-gray-200">Instansi / Asal *</label>
                        <input type="text" name="asal_instansi" value="{{ old('asal_instansi') }}" required placeholder="Contoh: Dinas Pendidikan Kab. Bogor" class="w-full bg-[#EAE8E1]/60 dark:bg-[#0f1c19] border border-transparent dark:border-[#284c43] focus:border-ijo-semitua dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#152420] text-xs rounded-2xl px-4 py-3.5 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none transition-all">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-ijo-tua hover:bg-ijo-semitua dark:bg-[#107050] dark:hover:bg-[#0c5940] dark:border dark:border-[#10b981]/30 text-white font-bold text-xs py-3.5 rounded-2xl transition-colors flex items-center justify-center space-x-2 shadow-xs cursor-pointer">
                            <span>Daftar Hadir</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </form>
            @else
                <div class="rounded-2xl bg-gray-50 dark:bg-[#0f1c19] border border-gray-100 dark:border-[#233a34] p-5 text-center">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Agenda belum tersedia</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Tambahkan agenda di admin terlebih dahulu sebelum mengisi daftar hadir tamu.</p>
                </div>
            @endif
        </div>
    </main>
    @include('publik.layout.footer')

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
