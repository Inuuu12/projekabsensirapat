<header class="bg-ijo-tua text-white sticky top-0 z-50 shadow-md">
    <div class="container mx-auto px-4 md:px-12 max-w-7xl flex items-center justify-between h-20">
        
        <!-- Logo Bappenda / Diskominfo -->
        <a href="{{ route('publik.beranda') }}" class="flex items-center space-x-3 group">
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center p-1 border border-white/20 group-hover:scale-105 transition-transform overflow-hidden">
                <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Bappenda" class="w-full h-full object-contain">
            </div>
            <div>
                <p class="text-[10px] tracking-widest text-ijo-sangatmuda font-semibold uppercase">Pemerintah Kabupaten Bogor</p>
                <p class="text-sm font-extrabold tracking-tight">Dinas Komunikasi & Informatika</p>
            </div>
        </a>

        <!-- Desktop Navigation Menu -->
        <nav class="hidden md:flex items-center space-x-1 lg:space-x-2 text-xs font-semibold">
            <a href="{{ route('publik.beranda') }}" 
               class="px-3 py-2 rounded-xl transition-all {{ request()->routeIs('publik.beranda') ? 'bg-white/15 text-white font-bold' : 'text-gray-200 hover:bg-white/10 hover:text-white' }}">
                Beranda
            </a>

            <a href="{{ route('publik.berita') }}" 
               class="px-3 py-2 rounded-xl transition-all {{ request()->routeIs('publik.berita*') ? 'bg-white/15 text-white font-bold' : 'text-gray-200 hover:bg-white/10 hover:text-white' }}">
                Berita
            </a>

            <a href="{{ route('publik.agenda') }}" 
               class="px-3 py-2 rounded-xl transition-all {{ request()->routeIs('publik.agenda*') ? 'bg-white/15 text-white font-bold' : 'text-gray-200 hover:bg-white/10 hover:text-white' }}">
                Agenda
            </a>

            <a href="{{ route('publik.masukan') }}" 
               class="ml-2 px-4 py-2 bg-oren-utama hover:bg-oren-tua text-white font-bold rounded-xl shadow-sm transition-colors">
                Masukan
            </a>
        </nav>

    </div>
</header>
