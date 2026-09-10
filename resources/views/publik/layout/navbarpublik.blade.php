@php
    $appName = config('sirapi.name', 'RAPID');
    $organizationName = config('sirapi.organization', 'Dinas Komunikasi & Informatika');
    $regionName = config('sirapi.region', 'Pemerintah Kabupaten Bogor');
@endphp

<header class="bg-[#35635b] dark:bg-[#0f1c19] text-white sticky top-0 z-[1001] shadow-md border-b border-transparent dark:border-[#233a34] transition-colors duration-200">
    <div class="w-full max-w-[1680px] mx-auto px-3.5 sm:px-6 lg:px-8 2xl:px-10 flex items-center justify-between h-16 sm:h-20">
        
        <!-- Logo & Branding -->
        <a href="{{ route('publik.beranda') }}" class="flex items-center gap-2 sm:gap-3 group min-w-0 pr-2">
            <img src="{{ asset('assets/foto/logo-bappenda.png') }}" alt="Logo Kabupaten Bogor" class="w-8 h-8 sm:w-10 sm:h-10 md:w-11 md:h-11 object-contain group-hover:scale-105 transition-transform drop-shadow-sm shrink-0">
            <div class="flex flex-col justify-center min-w-0">
                <span class="font-black text-sm sm:text-lg md:text-xl tracking-wide text-white leading-tight truncate">{{ $appName }}</span>
                <p class="text-[9px] sm:text-[11px] font-medium text-white/80 dark:text-gray-300 leading-none truncate mt-0.5">{{ $organizationName }}</p>
            </div>
        </a>

        <!-- Desktop Navigation Menu & Theme Switcher -->
        <div class="hidden md:flex items-center gap-2.5 shrink-0">
            <nav class="flex items-center gap-1.5 text-xs font-semibold">
                <a href="{{ route('publik.beranda') }}" 
                   class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('publik.beranda') ? 'bg-white/15 dark:bg-[#1a332d] dark:text-emerald-400 dark:border dark:border-[#284c43] text-white' : 'text-gray-200 dark:text-gray-300 hover:bg-white/10 dark:hover:bg-[#152420] hover:text-white' }}">
                    Beranda
                </a>

                <a href="{{ route('publik.masukan') }}" 
                   class="px-4 py-2 bg-oren-utama hover:bg-oren-tua dark:bg-[#d97706] dark:hover:bg-[#b45309] text-white font-bold rounded-xl shadow-xs text-xs transition-colors">
                    Aduan
                </a>

                <a href="{{ route('pegawai.login') }}" 
                   class="px-3.5 py-2 bg-white/15 hover:bg-white/25 dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold rounded-xl shadow-xs text-xs transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Portal Pegawai</span>
                </a>
            </nav>

            <!-- Dark / Light Mode Switcher Button (Desktop) -->
            <button type="button" onclick="toggleSirapiTheme()" title="Ubah Mode Gelap / Terang" class="p-2 rounded-xl bg-white/10 dark:bg-[#152420] dark:border dark:border-[#284c43] text-white dark:text-amber-400 hover:bg-white/20 dark:hover:bg-[#1b3832] transition-all focus:outline-none shadow-2xs cursor-pointer flex items-center justify-center">
                <svg data-theme-icon-light class="w-5 h-5 text-amber-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <svg data-theme-icon-dark class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>
        </div>

        <!-- Mobile Controls (Theme Switcher + Mobile Hamburger Button) -->
        <div class="flex md:hidden items-center gap-2 shrink-0">
            <!-- Dark / Light Mode Switcher Button (Mobile) -->
            <button type="button" onclick="toggleSirapiTheme()" title="Ubah Mode Gelap / Terang" class="p-2 rounded-xl bg-white/10 dark:bg-[#152420] dark:border dark:border-[#284c43] text-white dark:text-amber-400 hover:bg-white/20 focus:outline-none cursor-pointer flex items-center justify-center">
                <svg data-theme-icon-light class="w-4 h-4 text-amber-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <svg data-theme-icon-dark class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>

            <!-- Hamburger Button -->
            <button type="button" onclick="togglePublikMobileMenu()" id="publik-menu-btn" aria-label="Toggle Navigation" class="p-2 rounded-xl bg-white/10 hover:bg-white/20 text-white focus:outline-none transition cursor-pointer">
                <svg id="icon-menu-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg id="icon-menu-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

    </div>

    <!-- Mobile Navigation Drawer / Dropdown -->
    <div id="mobile-publik-menu" class="hidden md:hidden border-t border-white/10 dark:border-[#233a34] bg-[#2b4f49] dark:bg-[#0f1c19] px-4 py-3 space-y-2 shadow-inner transition-all">
        <a href="{{ route('publik.beranda') }}" 
           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('publik.beranda') ? 'bg-white/20 dark:bg-[#1a332d] text-white dark:text-emerald-400' : 'text-gray-200 dark:text-gray-300 hover:bg-white/10' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span>Beranda</span>
        </a>

        <a href="{{ route('publik.masukan') }}" 
           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-xs font-bold bg-oren-utama text-white hover:bg-oren-tua transition-all shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"></path></svg>
            <span>Sampaikan Aduan</span>
        </a>

        <a href="{{ route('pegawai.login') }}" 
           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-xs font-bold bg-white/15 dark:bg-[#107050] text-white hover:bg-white/25 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span>Portal Pegawai</span>
        </a>
    </div>
</header>

<script>
    function togglePublikMobileMenu() {
        const menu = document.getElementById('mobile-publik-menu');
        const openIcon = document.getElementById('icon-menu-open');
        const closeIcon = document.getElementById('icon-menu-close');
        if (!menu) return;
        
        const isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            menu.classList.remove('hidden');
            openIcon?.classList.add('hidden');
            closeIcon?.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
            openIcon?.classList.remove('hidden');
            closeIcon?.classList.add('hidden');
        }
    }
</script>

