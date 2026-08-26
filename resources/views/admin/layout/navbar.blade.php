@php
    $appName = config('sirapi.name', 'SIRAPI');
    $regionName = config('sirapi.region', 'Pemerintah Kabupaten Bogor');
@endphp

<header class="h-16 bg-white dark:bg-[#152420] border-b border-gray-100 dark:border-[#233a34] flex items-center justify-between px-4 sm:px-8 shadow-xs z-30 transition-colors duration-200">
    <!-- Left Side: Hamburger Menu & Title -->
    <div class="flex items-center space-x-3">
        <button onclick="toggleSidebar()" class="md:hidden p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 focus:outline-none cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        <span class="text-sm font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider hidden sm:inline-block">Portal Admin</span>
    </div>

    <!-- Right Side: Theme Toggle, Date & User Profile Pill -->
    <div class="flex items-center space-x-3 sm:space-x-5">
        <!-- Dark / Light Mode Switcher Button -->
        <button type="button" onclick="toggleSirapiTheme()" title="Ubah Mode Gelap / Terang" class="p-2 rounded-xl bg-gray-100 dark:bg-[#0f1c19] dark:border dark:border-[#284c43] text-gray-600 dark:text-amber-400 hover:bg-gray-200 dark:hover:bg-[#1b3832] transition-all focus:outline-none shadow-2xs cursor-pointer">
            <!-- Ikon Matahari (Muncul saat Dark Mode) -->
            <svg data-theme-icon-light class="w-5 h-5 text-amber-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <!-- Ikon Bulan (Muncul saat Light Mode) -->
            <svg data-theme-icon-dark class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
        </button>

        <!-- Date / Time Info -->
        <div class="hidden lg:flex flex-col text-right">
            <span class="text-xs font-semibold text-gray-700 dark:text-slate-200">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
        </div>

        <!-- User Profile Pill -->
        <div class="bg-[#35635b] dark:bg-[#0f1c19] dark:border dark:border-[#284c43] text-white py-1.5 px-3.5 sm:px-4 rounded-full flex items-center space-x-3 shadow-xs hover:opacity-95 dark:hover:border-emerald-500/50 transition cursor-pointer">
            <div class="w-8 h-8 rounded-full bg-white/20 dark:bg-[#1b3832] flex items-center justify-center text-white dark:text-emerald-400 font-bold text-sm overflow-hidden border border-white/30 dark:border-emerald-500/30">
                @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->foto)
                    <img src="{{ asset('storage/' . Auth::guard('admin')->user()->foto) }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-5 h-5 text-white dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                @endif
            </div>
            <div class="flex flex-col text-left">
                <span class="text-xs font-bold leading-tight text-white">{{ Auth::guard('admin')->user()->nama ?? 'Admin' }}</span>
                <span class="text-[10px] text-white/80 dark:text-emerald-400 font-semibold leading-tight">Super Admin</span>
            </div>
        </div>
    </div>
</header>
