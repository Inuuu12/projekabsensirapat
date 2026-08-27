@php
    $appName = config('sirapi.name', 'SIRAPI');
    $organizationName = config('sirapi.organization', 'Dinas Komunikasi & Informatika');
    $regionName = config('sirapi.region', 'Pemerintah Kabupaten Bogor');
@endphp

<footer class="bg-ijo-tua dark:bg-[#0f1c19] text-white mt-auto border-t border-white/10 dark:border-[#233a34] transition-colors duration-200">
    <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 pt-12 pb-8 space-y-10">
        
        <!-- MAIN FOOTER CONTENT (GRID 4 KOLOM) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Kolom 1: Logo, Deskripsi & Sosmed (4 Cols) -->
            <div class="lg:col-span-4 space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/foto/logo-bappenda.png') }}" alt="Logo Kabupaten Bogor" class="w-10 h-10 md:w-11 md:h-11 object-contain shrink-0 drop-shadow-sm">
                    <div class="flex flex-col justify-center min-w-0">
                        <p class="text-[8.5px] sm:text-[9px] font-bold tracking-widest text-ijo-sangatmuda uppercase leading-none">{{ $regionName }}</p>
                        <span class="font-black text-lg md:text-xl tracking-wide text-white leading-tight mt-0.5">{{ $appName }}</span>
                        <p class="text-[10px] sm:text-[11px] font-medium text-white/80 leading-none mt-0.5">{{ $organizationName }}</p>
                    </div>
                </div>

                <p class="text-xs text-gray-300 leading-relaxed pr-2">
                    Melayani administrasi kependudukan, informasi publik, dan pengaduan masyarakat Kabupaten Bogor secara cepat, transparan, dan terintegrasi.
                </p>

                <!-- Social Media Buttons -->
                <div class="flex items-center space-x-2 pt-2">
                    <a href="https://www.instagram.com/diskominfokabbogor?igsh=MXNkbDF1dDIyN3FrZg==" 
                       target="_blank" rel="noopener noreferrer" title="Instagram Diskominfo Kab. Bogor"
                       class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-bold flex items-center justify-center transition-colors">
                        IG
                    </a>
                    
                    <a href="https://www.facebook.com/share/1RYDNtxEpS/" 
                       target="_blank" rel="noopener noreferrer" title="Facebook Diskominfo Kab. Bogor"
                       class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-bold flex items-center justify-center transition-colors">
                        FB
                    </a>

                    <a href="https://youtube.com/@kabupatenbogor?si=PAPn9ARUMrvRwMYy" 
                       target="_blank" rel="noopener noreferrer" title="YouTube Kabupaten Bogor"
                       class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 text-xs font-bold flex items-center justify-center transition-colors">
                        YT
                    </a>
                </div>
            </div>

            <!-- Kolom 2: Layanan (2.5 Cols) -->
            <div class="lg:col-span-2 space-y-3">
                <div class="relative">
                    <h4 class="text-sm font-bold text-white">Layanan</h4>
                    <div class="w-8 h-0.5 bg-oren-utama mt-1"></div>
                </div>
                <ul class="space-y-2.5 text-xs text-gray-300">
                    <li><a href="{{ route('publik.masukan') }}" class="hover:text-white transition-colors">Formulir Pengaduan</a></li>
                    <li><a href="{{ route('publik.ulangtahun') }}" class="hover:text-white transition-colors">Info Ulang Tahun</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Tautan Navigasi (2.5 Cols) -->
            <div class="lg:col-span-2 space-y-3">
                <div class="relative">
                    <h4 class="text-sm font-bold text-white">Tautan</h4>
                    <div class="w-8 h-0.5 bg-oren-utama mt-1"></div>
                </div>
                <ul class="space-y-2.5 text-xs text-gray-300">
                    <li><a href="{{ route('publik.beranda') }}" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="{{ route('publik.berita') }}" class="hover:text-white transition-colors">Berita Terkini</a></li>
                    <li><a href="{{ route('publik.agenda') }}" class="hover:text-white transition-colors">Agenda Kegiatan</a></li>
                    <li><a href="{{ route('publik.galeri') }}" class="hover:text-white transition-colors">Galeri Foto</a></li>
                    <li><a href="{{ route('publik.video') }}" class="hover:text-white transition-colors">Dokumentasi Video</a></li>
                </ul>
            </div>

            <!-- Kolom 4: Kontak Kami (3 Cols) -->
            <div class="lg:col-span-4 space-y-3">
                <div class="relative">
                    <h4 class="text-sm font-bold text-white">Kontak Kami</h4>
                    <div class="w-8 h-0.5 bg-oren-utama mt-1"></div>
                </div>
                
                <div class="space-y-3 text-xs text-gray-300 pt-1">
                    <div class="flex items-start space-x-3">
                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center shrink-0 text-xs">📍</div>
                        <p class="leading-relaxed">Jl. Tegar Beriman, Cibinong, Kabupaten Bogor, Jawa Barat</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center shrink-0 text-xs">☎️</div>
                        <p>(021) xxxx-xxxx</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center shrink-0 text-xs">✉️</div>
                        <p>diskominfo@bogorkab.go.id</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- BOTTOM FOOTER / COPYRIGHT BAR -->
        <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row items-center justify-between text-[11px] text-gray-400 gap-4">
            <p>&copy; {{ date('Y') }} {{ $appName }} - {{ $regionName }}. Hak cipta dilindungi.</p>
            
            <div class="bg-white/10 border border-white/10 px-3 py-1 rounded-full text-oren-muda font-semibold flex items-center space-x-1.5 text-[10px]">
                <span class="w-2 h-2 rounded-full bg-oren-utama animate-pulse"></span>
                <span>Layanan Aktif</span>
            </div>

            <!-- Links Legal (DI SINI PERUBAHANNYA) -->
            <div class="flex items-center space-x-4">
                <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                <a href="{{ route('peta.situs') }}" class="hover:text-white transition-colors">Peta Situs</a>
            </div>
        </div>

    </div>
</footer>
