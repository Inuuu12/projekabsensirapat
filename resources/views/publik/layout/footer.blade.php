@php
    $appName = config('sirapi.name', 'RAPID');
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
                        <span class="font-black text-lg md:text-xl tracking-wide text-white leading-tight">{{ $appName }}</span>
                        <p class="text-[10px] sm:text-[11px] font-medium text-white/80 leading-none mt-0.5">{{ $organizationName }}</p>
                    </div>
                </div>

                <p class="text-xs text-gray-300 leading-relaxed pr-2">
                    Memfasilitasi pengelolaan agenda rapat kedinasan, presensi digital pegawai, dan dokumentasi koordinasi internal secara tertib, efisien, dan terintegrasi.
                </p>

                <!-- Social Media Buttons -->
                <div class="flex items-center space-x-2 pt-2">
                    <a href="https://www.instagram.com/diskominfokabbogor?igsh=MXNkbDF1dDIyN3FrZg==" 
                       target="_blank" rel="noopener noreferrer" title="Instagram Diskominfo Kab. Bogor"
                       class="w-7 h-7 rounded-lg bg-white/10 hover:bg-gradient-to-tr hover:from-amber-500 hover:via-rose-500 hover:to-purple-600 text-white flex items-center justify-center transition-all duration-300 shadow-xs hover:scale-105"
                       aria-label="Instagram">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    
                    <a href="https://www.facebook.com/share/1RYDNtxEpS/" 
                       target="_blank" rel="noopener noreferrer" title="Facebook Diskominfo Kab. Bogor"
                       class="w-7 h-7 rounded-lg bg-white/10 hover:bg-[#1877F2] text-white flex items-center justify-center transition-all duration-300 shadow-xs hover:scale-105"
                       aria-label="Facebook">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>

                    <a href="{{ \App\Services\AppSetting::get('sirapi_youtube_channel_url', config('sirapi.youtube_channel_url', 'https://youtube.com/@kabupatenbogor?si=PAPn9ARUMrvRwMYy')) }}" 
                       target="_blank" rel="noopener noreferrer" title="YouTube Channel"
                       class="w-7 h-7 rounded-lg bg-white/10 hover:bg-[#FF0000] text-white flex items-center justify-center transition-all duration-300 shadow-xs hover:scale-105"
                       aria-label="YouTube">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
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
                    <li><a href="{{ route('pegawai.login') }}" class="hover:text-white transition-colors">Portal / Login Pegawai</a></li>
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
                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center shrink-0 text-oren-utama">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="leading-normal">Jl. Tegar Beriman, Cibinong, Kabupaten Bogor, Jawa Barat</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center shrink-0 text-oren-utama">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <p class="leading-normal">(021) xxxx-xxxx</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center shrink-0 text-oren-utama">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="leading-normal">diskominfo@bogorkab.go.id</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- BOTTOM FOOTER / COPYRIGHT BAR -->
        <div class="border-t border-white/10 pt-6 flex flex-col items-center justify-center text-center text-[11px] text-gray-400 gap-3">
            <p>&copy; {{ date('Y') }} {{ $appName }} - {{ $regionName }}. Hak cipta dilindungi.</p>

            <!-- Button Akses Admin -->
            <div>
                @if (Auth::guard('admin')->check())
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-emerald-600/20 hover:bg-emerald-600 text-emerald-400 hover:text-white border border-emerald-500/30 text-xs font-bold transition-all shadow-xs hover:shadow-md">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span>Dashboard Admin</span>
                    </a>
                @else
                    <a href="{{ route('admin.login') }}" 
                       class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white/10 hover:bg-oren-utama text-gray-300 hover:text-white border border-white/15 text-xs font-bold transition-all shadow-xs hover:shadow-md group">
                        <svg class="w-3.5 h-3.5 text-oren-utama group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>Login Admin</span>
                    </a>
                @endif
            </div>
        </div>

    </div>
</footer>
