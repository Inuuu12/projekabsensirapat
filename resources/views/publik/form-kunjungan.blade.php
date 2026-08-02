<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kunjungan - SIRAPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ijo-tua': '#14524E',
                        'ijo-semitua': '#1F7A6F',
                        'ijo-muda': '#5FA79C',
                        'ijo-sangatmuda': '#DCF1E6',
                        'oren-utama': '#D89B3C',
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

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 flex items-center justify-center">
        @php
            $initial = fn ($name) => collect(explode(' ', trim((string) $name)))->filter()->take(2)->map(fn ($word) => strtoupper(substr($word, 0, 1)))->join('') ?: 'P';
            $colors = ['bg-ijo-tua text-white', 'bg-ijo-muda text-white', 'bg-oren-utama text-white', 'bg-ijo-semitua text-white'];

            $allPejabat = collect($pegawaiList ?? [])->map(function($p, $idx) use ($colors) {
                return [
                    'nama' => $p->nama_pegawai,
                    'jabatan' => $p->jabatan ?? $p->bidang ?? 'Pegawai Diskominfo',
                    'color' => $colors[$idx % count($colors)],
                ];
            })->values();

            $featuredPejabat = $allPejabat->take(3);
            $extraPejabat = $allPejabat->slice(3);
        @endphp

        <div class="w-full max-w-xl bg-white border border-gray-200/80 rounded-3xl md:rounded-[36px] p-6 md:p-10 shadow-xl space-y-6 my-4">
            
            <!-- Success Alert -->
            @if (session('success'))
                <div class="rounded-2xl bg-ijo-sangatmuda text-ijo-tua p-4 flex items-start space-x-3 text-xs md:text-sm font-bold shadow-sm">
                    <span class="text-base">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Validation Errors Alert -->
            @if ($errors->any())
                <div class="rounded-2xl bg-red-50 text-red-700 p-4 text-xs md:text-sm space-y-1">
                    <p class="font-bold">Mohon periksa kembali isian form Anda:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Header Bar -->
            <div class="flex items-center justify-between">
                <a href="{{ route('publik.beranda') }}" class="inline-flex items-center space-x-1.5 text-xs md:text-sm font-bold text-ijo-semitua hover:underline">
                    <span>&larr;</span>
                    <span>Kembali</span>
                </a>

                <span class="bg-oren-muda text-oren-tua font-bold text-xs px-3.5 py-1 rounded-full">
                    Kunjungan
                </span>
            </div>

            <!-- Title & Subtitle -->
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Form Kunjungan</h1>
                <p class="text-xs md:text-sm font-medium text-gray-500 mt-1">Diskominfo Kabupaten Bogor</p>
                <hr class="border-gray-100 mt-4">
            </div>

            <!-- Form -->
            <form action="{{ route('publik.form-kunjungan.simpan') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Pihak yang Dituju -->
                <div>
                    <label class="block text-xs md:text-sm font-bold text-gray-900 mb-3">Pihak yang Dituju *</label>
                    <input type="hidden" name="nama_pegawai" id="input_nama_pegawai" value="{{ old('nama_pegawai', old('nama_pejabat', $featuredPejabat->first()['nama'] ?? '')) }}" required>
                    <input type="hidden" name="nama_pejabat" id="input_nama_pejabat" value="{{ old('nama_pegawai', old('nama_pejabat', $featuredPejabat->first()['nama'] ?? '')) }}">

                    <div class="space-y-3" id="pejabat-featured-list">
                        @forelse ($featuredPejabat as $index => $pejabat)
                            @php
                                $isSelected = old('nama_pegawai', old('nama_pejabat', $featuredPejabat->first()['nama'] ?? '')) === $pejabat['nama'];
                            @endphp
                            <div type="button" 
                                 class="pejabat-card cursor-pointer rounded-2xl border p-4 flex items-center justify-between transition-all {{ $isSelected ? 'border-2 border-ijo-tua bg-[#E8F4F0] shadow-sm' : 'border-gray-200 bg-white hover:bg-gray-50' }}"
                                 data-nama="{{ $pejabat['nama'] }}">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-11 h-11 rounded-full {{ $pejabat['color'] }} font-extrabold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                        {{ $initial($pejabat['nama']) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-xs md:text-sm leading-snug">{{ $pejabat['nama'] }}</h4>
                                        <p class="text-[11px] md:text-xs text-gray-500 mt-0.5">{{ $pejabat['jabatan'] }}</p>
                                    </div>
                                </div>
                                <div class="check-icon shrink-0 ml-2 {{ $isSelected ? '' : 'hidden' }}">
                                    <div class="w-6 h-6 rounded-full bg-ijo-tua text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                        ✓
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-gray-200 p-4 text-xs font-medium text-gray-500 text-center">
                                Belum ada data pegawai di database.
                            </div>
                        @endforelse
                    </div>

                    <!-- Extra Pejabat (Hidden by default, expandable) -->
                    @if ($extraPejabat->isNotEmpty())
                        <div class="space-y-3 mt-3 hidden" id="pejabat-extra-list">
                            @foreach ($extraPejabat as $pejabat)
                                @php
                                    $isSelected = old('nama_pejabat') === $pejabat['nama'];
                                @endphp
                                <div type="button" 
                                     class="pejabat-card cursor-pointer rounded-2xl border p-4 flex items-center justify-between transition-all {{ $isSelected ? 'border-2 border-ijo-tua bg-[#E8F4F0] shadow-sm' : 'border-gray-200 bg-white hover:bg-gray-50' }}"
                                     data-nama="{{ $pejabat['nama'] }}">
                                    <div class="flex items-center space-x-3.5">
                                        <div class="w-11 h-11 rounded-full {{ $pejabat['color'] }} font-extrabold text-xs flex items-center justify-center shrink-0 shadow-sm">
                                            {{ $initial($pejabat['nama']) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-xs md:text-sm leading-snug">{{ $pejabat['nama'] }}</h4>
                                            <p class="text-[11px] md:text-xs text-gray-500 mt-0.5">{{ $pejabat['jabatan'] }}</p>
                                        </div>
                                    </div>
                                    <div class="check-icon shrink-0 ml-2 {{ $isSelected ? '' : 'hidden' }}">
                                        <div class="w-6 h-6 rounded-full bg-ijo-tua text-white flex items-center justify-center text-xs font-bold shadow-sm">
                                            ✓
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" id="btn-toggle-pegawai" class="w-full text-center text-xs md:text-sm font-bold text-ijo-semitua hover:underline mt-3 flex items-center justify-center space-x-1 py-1">
                            <span id="toggle-text">Lihat semua pegawai</span>
                            <span>&rarr;</span>
                        </button>
                    @endif
                </div>

                <!-- Nama Lengkap Tamu -->
                <div>
                    <label class="block text-xs md:text-sm font-bold text-gray-900 mb-1.5">Nama Lengkap Tamu *</label>
                    <input type="text" name="nama_pengunjung" value="{{ old('nama_pengunjung') }}" placeholder="Masukkan nama lengkap" required
                           class="w-full bg-[#F3F2ED] border-0 rounded-2xl p-4 text-xs md:text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-ijo-tua focus:bg-white transition-all">
                </div>

                <!-- Instansi / Asal -->
                <div>
                    <label class="block text-xs md:text-sm font-bold text-gray-900 mb-1.5">Instansi / Asal *</label>
                    <input type="text" name="asal_instansi" value="{{ old('asal_instansi') }}" placeholder="Contoh: PT Teknologi Nusantara" required
                           class="w-full bg-[#F3F2ED] border-0 rounded-2xl p-4 text-xs md:text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-ijo-tua focus:bg-white transition-all">
                </div>

                <!-- No. HP / WhatsApp -->
                <div>
                    <label class="block text-xs md:text-sm font-bold text-gray-900 mb-1.5">No. HP / WhatsApp *</label>
                    <input type="text" name="nomorhp_pengunjung" value="{{ old('nomorhp_pengunjung') }}" placeholder="08xx-xxxx-xxxx" required
                           class="w-full bg-[#F3F2ED] border-0 rounded-2xl p-4 text-xs md:text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-ijo-tua focus:bg-white transition-all">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs md:text-sm font-bold text-gray-900 mb-1.5">Email *</label>
                    <input type="email" name="email_pengunjung" value="{{ old('email_pengunjung') }}" placeholder="Masukkan alamat email anda" required
                           class="w-full bg-[#F3F2ED] border-0 rounded-2xl p-4 text-xs md:text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-ijo-tua focus:bg-white transition-all">
                </div>

                <!-- Keperluan Kunjungan -->
                <div>
                    <label class="block text-xs md:text-sm font-bold text-gray-900 mb-1.5">Keperluan Kunjungan *</label>
                    <textarea name="keperluan" rows="3" placeholder="Contoh: Audiensi kerja sama pengembangan aplikasi layanan publik..." required
                              class="w-full bg-[#F3F2ED] border-0 rounded-2xl p-4 text-xs md:text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-ijo-tua focus:bg-white transition-all">{{ old('keperluan') }}</textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-ijo-tua hover:bg-ijo-semitua text-white font-bold text-base py-4 rounded-full transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 mt-4">
                    Kirim
                </button>
            </form>

        </div>
    </main>

    @include('publik.layout_publik.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputPegawai = document.getElementById('input_nama_pegawai');
            const inputPejabat = document.getElementById('input_nama_pejabat');
            const allCards = document.querySelectorAll('.pejabat-card');
            const btnToggle = document.getElementById('btn-toggle-pegawai');
            const extraList = document.getElementById('pejabat-extra-list');
            const toggleText = document.getElementById('toggle-text');

            allCards.forEach(card => {
                card.addEventListener('click', () => {
                    const nama = card.dataset.nama;
                    if (inputPegawai) inputPegawai.value = nama;
                    if (inputPejabat) inputPejabat.value = nama;

                    allCards.forEach(c => {
                        c.classList.remove('border-2', 'border-ijo-tua', 'bg-[#E8F4F0]', 'shadow-sm');
                        c.classList.add('border-gray-200', 'bg-white');
                        const check = c.querySelector('.check-icon');
                        if (check) check.classList.add('hidden');
                    });

                    card.classList.remove('border-gray-200', 'bg-white');
                    card.classList.add('border-2', 'border-ijo-tua', 'bg-[#E8F4F0]', 'shadow-sm');
                    const check = card.querySelector('.check-icon');
                    if (check) check.classList.remove('hidden');
                });
            });

            if (btnToggle && extraList) {
                btnToggle.addEventListener('click', () => {
                    const isHidden = extraList.classList.contains('hidden');
                    if (isHidden) {
                        extraList.classList.remove('hidden');
                        if (toggleText) toggleText.textContent = 'Sembunyikan pegawai lain';
                    } else {
                        extraList.classList.add('hidden');
                        if (toggleText) toggleText.textContent = 'Lihat semua pegawai';
                    }
                });
            }
        });
    </script>
</body>
</html>
