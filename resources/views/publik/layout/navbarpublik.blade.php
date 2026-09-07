@php
    $appName = config('sirapi.name', 'RAPID');
    $organizationName = config('sirapi.organization', 'Dinas Komunikasi & Informatika');
    $regionName = config('sirapi.region', 'Pemerintah Kabupaten Bogor');
@endphp

<header class="bg-[#35635b] dark:bg-[#0f1c19] text-white sticky top-0 z-50 shadow-md border-b border-transparent dark:border-[#233a34] transition-colors duration-200">
    <div class="w-full max-w-[1680px] mx-auto px-3.5 sm:px-6 lg:px-8 2xl:px-10 flex items-center justify-between h-16 sm:h-20">
        
        <!-- Logo & Branding -->
        <a href="{{ route('publik.beranda') }}" class="flex items-center gap-2.5 sm:gap-3 group min-w-0 pr-2">
            <img src="{{ asset('assets/foto/logo-bappenda.png') }}" alt="Logo Kabupaten Bogor" class="w-9 h-9 sm:w-10 sm:h-10 md:w-11 md:h-11 object-contain group-hover:scale-105 transition-transform drop-shadow-sm shrink-0">
            <div class="flex flex-col justify-center min-w-0">
                <span class="font-black text-base sm:text-lg md:text-xl tracking-wide text-white leading-tight">{{ $appName }}</span>
                <p class="text-[9.5px] sm:text-[11px] font-medium text-white/80 dark:text-gray-300 leading-none truncate mt-0.5">{{ $organizationName }}</p>
            </div>
        </a>

        <!-- Desktop Navigation Menu & Theme Switcher -->
        <div class="flex items-center gap-1.5 sm:gap-2.5 shrink-0">
            <nav class="flex items-center gap-1 sm:gap-1.5 text-xs font-semibold">
                <a href="{{ route('publik.beranda') }}" 
                   class="px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('publik.beranda') ? 'bg-white/15 dark:bg-[#1a332d] dark:text-emerald-400 dark:border dark:border-[#284c43] text-white' : 'text-gray-200 dark:text-gray-300 hover:bg-white/10 dark:hover:bg-[#152420] hover:text-white' }}">
                    Beranda
                </a>

                <a href="{{ route('publik.masukan') }}" 
                   class="px-3 sm:px-4 py-1.5 sm:py-2 bg-oren-utama hover:bg-oren-tua dark:bg-[#d97706] dark:hover:bg-[#b45309] text-white font-bold rounded-xl shadow-xs text-xs transition-colors">
                    Aduan
                </a>

                <a href="{{ route('pegawai.login') }}" 
                   class="px-3 sm:px-3.5 py-1.5 sm:py-2 bg-white/15 hover:bg-white/25 dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold rounded-xl shadow-xs text-xs transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Portal Pegawai</span>
                </a>
            </nav>

            <!-- Dark / Light Mode Switcher Button -->
            <button type="button" onclick="toggleSirapiTheme()" title="Ubah Mode Gelap / Terang" class="p-1.5 sm:p-2 rounded-xl bg-white/10 dark:bg-[#152420] dark:border dark:border-[#284c43] text-white dark:text-amber-400 hover:bg-white/20 dark:hover:bg-[#1b3832] transition-all focus:outline-none shadow-2xs cursor-pointer flex items-center justify-center">
                <svg data-theme-icon-light class="w-4 h-4 sm:w-5 sm:h-5 text-amber-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <svg data-theme-icon-dark class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>
        </div>

    </div>
</header>
