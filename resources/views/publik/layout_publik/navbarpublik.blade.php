@php
    $appName = config('sirapi.name', 'SIRAPI');
    $organizationName = config('sirapi.organization', 'Dinas Komunikasi & Informatika');
    $regionName = config('sirapi.region', 'Pemerintah Kabupaten Bogor');
@endphp

<header class="bg-[#35635b] dark:bg-[#0f1c19] text-white sticky top-0 z-50 shadow-md border-b border-transparent dark:border-[#233a34] transition-colors duration-200">
    <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 flex items-center justify-between h-20">
        
        <!-- Logo & Branding -->
        <a href="{{ route('publik.beranda') }}" class="flex items-center space-x-3.5 group">
            <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo" class="w-11 h-11 object-contain shrink-0 group-hover:scale-105 transition-transform">
            <div class="flex flex-col justify-center">
                <p class="text-[9px] font-bold tracking-wider text-ijo-sangatmuda dark:text-emerald-400 uppercase leading-tight">{{ $regionName }}</p>
                <h1 class="font-black text-lg leading-tight tracking-wide text-white">{{ $appName }}</h1>
                <p class="text-[11px] font-medium text-white/80 dark:text-gray-300 leading-tight">{{ $organizationName }}</p>
            </div>
        </a>

        <!-- Desktop Navigation Menu & Theme Switcher -->
        <div class="flex items-center space-x-2 lg:space-x-3">
            <nav class="flex items-center space-x-1 lg:space-x-2 text-xs font-semibold">
                <a href="{{ route('publik.beranda') }}" 
                   class="px-3.5 py-2 rounded-xl transition-all {{ request()->routeIs('publik.beranda') ? 'bg-white/15 dark:bg-[#1a332d] dark:text-emerald-400 dark:border dark:border-[#284c43] text-white font-bold' : 'text-gray-200 dark:text-gray-300 hover:bg-white/10 dark:hover:bg-[#152420] hover:text-white' }}">
                    Beranda
                </a>

                <a href="{{ route('publik.masukan') }}" 
                   class="px-4 py-2 bg-oren-utama hover:bg-oren-tua dark:bg-[#d97706] dark:hover:bg-[#b45309] text-white font-bold rounded-xl shadow-xs transition-colors">
                    Aduan
                </a>
            </nav>

            <!-- Dark / Light Mode Switcher Button -->
            <button type="button" onclick="toggleSirapiTheme()" title="Ubah Mode Gelap / Terang" class="p-2 rounded-xl bg-white/10 dark:bg-[#152420] dark:border dark:border-[#284c43] text-white dark:text-amber-400 hover:bg-white/20 dark:hover:bg-[#1b3832] transition-all focus:outline-none shadow-2xs cursor-pointer">
                <svg data-theme-icon-light class="w-5 h-5 text-amber-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <svg data-theme-icon-dark class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
            </button>
        </div>

    </div>
</header>
