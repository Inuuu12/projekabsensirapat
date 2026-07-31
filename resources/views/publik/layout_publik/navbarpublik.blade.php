@php
    $appName = config('sirapi.name', 'SIRAPI');
    $organizationName = config('sirapi.organization', 'Dinas Komunikasi & Informatika');
    $regionName = config('sirapi.region', 'Pemerintah Kabupaten Bogor');
@endphp

<header class="bg-ijo-tua text-white sticky top-0 z-50 shadow-md">
    <div class="w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 flex items-center justify-between h-20">
        
        <!-- Logo Bappenda / Diskominfo -->
        <a href="{{ route('publik.beranda') }}" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center p-1 border border-white/20 group-hover:scale-105 transition-transform overflow-hidden">
                <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Bappenda" class="w-full h-full object-contain">
            </div>
            <div>
                <p class="text-[10px] tracking-widest text-ijo-sangatmuda font-semibold uppercase">{{ $regionName }}</p>
                <p class="text-sm font-extrabold tracking-tight">{{ $appName }}</p>
                <p class="text-[10px] font-semibold text-white/80">{{ $organizationName }}</p>
            </div>
        </a>

        <!-- Desktop Navigation Menu -->
        <nav class="hidden md:flex items-center space-x-1 lg:space-x-2 text-xs font-semibold">
            <a href="{{ route('publik.beranda') }}" 
               class="px-3 py-2 rounded-xl transition-all {{ request()->routeIs('publik.beranda') ? 'bg-white/15 text-white font-bold' : 'text-gray-200 hover:bg-white/10 hover:text-white' }}">
                Beranda
            </a>

            <a href="{{ route('publik.masukan') }}" 
               class="ml-2 px-4 py-2 bg-oren-utama hover:bg-oren-tua text-white font-bold rounded-xl shadow-sm transition-colors">
                Aduan
            </a>
        </nav>

    </div>
</header>
