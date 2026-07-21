<header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 sm:px-8 shadow-xs z-30">
    <!-- Left Side: Hamburger Menu & Title -->
    <div class="flex items-center space-x-3">
        <button onclick="toggleSidebar()" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        <span class="text-sm font-bold text-gray-500 uppercase tracking-wider hidden sm:inline-block">Dinas Komunikasi & Informatika</span>
    </div>

    <!-- Right Side: Date & User Profile Pill -->
    <div class="flex items-center space-x-4 sm:space-x-6">
        <!-- Date / Time Info -->
        <div class="hidden lg:flex flex-col text-right">
            <span class="text-xs font-semibold text-gray-700">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
        </div>

        <!-- User Profile Pill (matching dummy design) -->
        <div class="bg-[#35635b] text-white py-1.5 px-3.5 sm:px-4 rounded-full flex items-center space-x-3 shadow-sm hover:opacity-95 transition cursor-pointer">
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-sm overflow-hidden border border-white/30">
                @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->foto)
                    <img src="{{ asset('storage/' . Auth::guard('admin')->user()->foto) }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                @endif
            </div>
            <div class="flex flex-col text-left">
                <span class="text-xs font-bold leading-tight">{{ Auth::guard('admin')->user()->nama ?? 'Admin' }}</span>
                <span class="text-[10px] text-white/80 leading-tight">Super Admin</span>
            </div>
        </div>
    </div>
</header>

