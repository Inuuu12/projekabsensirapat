<!-- Mobile Overlay Backdrop -->
<div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity"></div>

<!-- Sidebar Container -->
<aside id="sidebar-menu" class="fixed md:static inset-y-0 left-0 z-50 w-64 h-screen bg-[#35635b] text-white flex flex-col justify-between font-sans shadow-lg select-none transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
    
    <div>
        <!-- Logo & Header -->
        <div class="p-5 flex items-center space-x-3 border-b border-[#2a504a]">
            <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo" class="w-10 h-auto object-contain">
            <div>
                <h1 class="font-black text-lg leading-tight tracking-wide">Diskominfo</h1>
                <p class="text-[10px] tracking-wider opacity-80 uppercase">Pemerintah Kabupaten Bogor</p>
            </div>
            <!-- Mobile Close Button -->
            <button onclick="toggleSidebar()" class="md:hidden ml-auto text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-6 px-3 space-y-1 text-sm font-medium">
            
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#2b4f49] font-bold text-white shadow-sm' : 'hover:bg-[#2b4f49]/60 text-white/90' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Dashboard</span>
            </a>

            <!-- Agenda Submenu -->
            @php $isAgendaActive = request()->routeIs('admin.agenda.*') || request()->routeIs('admin.ruang.*'); @endphp
            <div class="space-y-1">
                <button onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-colors {{ $isAgendaActive ? 'bg-[#2b4f49] font-bold' : 'hover:bg-[#2b4f49]/60 text-white/90' }} focus:outline-none">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Agenda</span>
                    </div>
                    <svg class="w-4 h-4 opacity-80 arrow-icon transition-transform {{ $isAgendaActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div class="{{ $isAgendaActive ? 'flex' : 'hidden' }} flex-col pl-12 pr-4 py-1 space-y-2">
                    <a href="{{ route('admin.agenda.lihat') }}" class="block text-xs font-semibold py-1.5 px-3 rounded-lg hover:bg-[#2b4f49]/50 transition {{ request()->routeIs('admin.agenda.lihat') ? 'bg-[#2b4f49] font-bold text-white' : 'text-white/80' }}">Daftar Agenda</a>
                    <a href="{{ route('admin.ruang.lihat') }}" class="block text-xs font-semibold py-1.5 px-3 rounded-lg hover:bg-[#2b4f49]/50 transition {{ request()->routeIs('admin.ruang.lihat') ? 'bg-[#2b4f49] font-bold text-white' : 'text-white/80' }}">Daftar Ruang</a>
                </div>
            </div>

            <!-- Data Pengguna Submenu -->
            @php $isUserActive = request()->routeIs('admin.pegawai.*') || request()->routeIs('admin.tamu.*'); @endphp
            <div class="space-y-1">
                <button onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-colors {{ $isUserActive ? 'bg-[#2b4f49] font-bold' : 'hover:bg-[#2b4f49]/60 text-white/90' }} focus:outline-none">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>Data Pengguna</span>
                    </div>
                    <svg class="w-4 h-4 opacity-80 arrow-icon transition-transform {{ $isUserActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div class="{{ $isUserActive ? 'flex' : 'hidden' }} flex-col pl-12 pr-4 py-1 space-y-2">
                    <a href="{{ route('admin.pegawai.lihat') }}" class="block text-xs font-semibold py-1.5 px-3 rounded-lg hover:bg-[#2b4f49]/50 transition {{ request()->routeIs('admin.pegawai.lihat') ? 'bg-[#2b4f49] font-bold text-white' : 'text-white/80' }}">Data Pegawai</a>
                    <a href="{{ route('admin.tamu.lihat') }}" class="block text-xs font-semibold py-1.5 px-3 rounded-lg hover:bg-[#2b4f49]/50 transition {{ request()->routeIs('admin.tamu.lihat') ? 'bg-[#2b4f49] font-bold text-white' : 'text-white/80' }}">Data Tamu</a>
                </div>
            </div>

            <!-- Kunjungan -->
            <a href="{{ route('admin.kunjungan.lihat') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.kunjungan.lihat') ? 'bg-[#2b4f49] font-bold text-white shadow-sm' : 'hover:bg-[#2b4f49]/60 text-white/90' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span>Kunjungan</span>
            </a>

            <!-- Masukkan / Aduan -->
            <a href="{{ route('admin.masukkan.lihat') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.masukkan.lihat') ? 'bg-[#2b4f49] font-bold text-white shadow-sm' : 'hover:bg-[#2b4f49]/60 text-white/90' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <span>Masukkan</span>
            </a>

        </nav>
    </div>

    <!-- Bottom Logout Button -->
    <div class="p-4 border-t border-[#2a504a]">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center justify-center p-2.5 hover:bg-[#2b4f49] rounded-xl transition-colors text-white/90 hover:text-white" title="Logout">
                <svg class="w-6 h-6 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </button>
        </form>
    </div>

</aside>
