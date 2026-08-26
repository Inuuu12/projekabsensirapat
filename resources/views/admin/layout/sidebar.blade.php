@php
    $appName = config('sirapi.name', 'SIRAPI');
    $organizationName = config('sirapi.organization', 'Dinas Komunikasi & Informatika');
    $regionName = config('sirapi.region', 'Pemerintah Kabupaten Bogor');
@endphp

<!-- Mobile Overlay Backdrop -->
<div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity"></div>

<!-- Sidebar Container -->
<aside id="sidebar-menu" class="fixed md:static inset-y-0 left-0 z-50 w-64 h-screen bg-[#35635b] dark:bg-[#0f1c19] dark:border-r dark:border-[#233a34] text-white flex flex-col justify-between font-sans shadow-lg select-none transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out">
    
    <div>
        <!-- Logo & Header -->
        <div class="p-4 flex items-center space-x-3 border-b border-[#2a504a] dark:border-[#233a34]">
            <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo" class="w-10 h-10 object-contain shrink-0">
            <div class="min-w-0 flex-1">
                <p class="text-[9px] font-bold tracking-wider text-[#a8d5ba] dark:text-emerald-400 uppercase truncate leading-tight">{{ $regionName }}</p>
                <h1 class="font-black text-lg leading-tight tracking-wide text-white">{{ $appName }}</h1>
                <p class="text-[11px] font-medium text-white/80 dark:text-gray-300 truncate leading-tight">{{ $organizationName }}</p>
            </div>
            <!-- Mobile Close Button -->
            <button onclick="toggleSidebar()" class="md:hidden ml-auto text-white focus:outline-none shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-6 px-3 space-y-1 text-sm font-medium">
            
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#2b4f49] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-sm dark:border dark:border-[#284c43]' : 'hover:bg-[#2b4f49]/60 dark:hover:bg-[#152420] text-white/90 dark:text-gray-300 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-white dark:text-emerald-400' : 'opacity-80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Dashboard</span>
            </a>

            <!-- Agenda Submenu -->
            @php $isAgendaActive = request()->routeIs('admin.agenda.*') || request()->routeIs('admin.ruang.*'); @endphp
            <div class="space-y-1">
                <button onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-colors {{ $isAgendaActive ? 'bg-[#2b4f49] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold dark:border dark:border-[#284c43]' : 'hover:bg-[#2b4f49]/60 dark:hover:bg-[#152420] text-white/90 dark:text-gray-300 dark:hover:text-white' }} focus:outline-none cursor-pointer">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 {{ $isAgendaActive ? 'text-white dark:text-emerald-400' : 'opacity-80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Agenda</span>
                    </div>
                    <svg class="w-4 h-4 opacity-80 arrow-icon transition-transform {{ $isAgendaActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div class="{{ $isAgendaActive ? 'flex' : 'hidden' }} flex-col pl-12 pr-4 py-1 space-y-2">
                    <a href="{{ route('admin.agenda.lihat') }}" class="block text-xs font-semibold py-1.5 px-3 rounded-lg transition {{ request()->routeIs('admin.agenda.lihat') ? 'bg-[#2b4f49] dark:bg-[#23423b] font-bold text-white dark:text-emerald-300' : 'text-white/80 dark:text-gray-400 hover:bg-[#2b4f49]/50 dark:hover:bg-[#152420] dark:hover:text-white' }}">Daftar Agenda</a>
                    <a href="{{ route('admin.ruang.lihat') }}" class="block text-xs font-semibold py-1.5 px-3 rounded-lg transition {{ request()->routeIs('admin.ruang.lihat') ? 'bg-[#2b4f49] dark:bg-[#23423b] font-bold text-white dark:text-emerald-300' : 'text-white/80 dark:text-gray-400 hover:bg-[#2b4f49]/50 dark:hover:bg-[#152420] dark:hover:text-white' }}">Daftar Ruangan</a>
                </div>
            </div>

            <!-- Data Pengguna Submenu -->
            @php $isUserActive = request()->routeIs('admin.pegawai.*') || request()->routeIs('admin.tamu.*'); @endphp
            <div class="space-y-1">
                <button onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-colors {{ $isUserActive ? 'bg-[#2b4f49] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold dark:border dark:border-[#284c43]' : 'hover:bg-[#2b4f49]/60 dark:hover:bg-[#152420] text-white/90 dark:text-gray-300 dark:hover:text-white' }} focus:outline-none cursor-pointer">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 {{ $isUserActive ? 'text-white dark:text-emerald-400' : 'opacity-80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span>Data Pengguna</span>
                    </div>
                    <svg class="w-4 h-4 opacity-80 arrow-icon transition-transform {{ $isUserActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div class="{{ $isUserActive ? 'flex' : 'hidden' }} flex-col pl-12 pr-4 py-1 space-y-2">
                    <a href="{{ route('admin.pegawai.lihat') }}" class="flex items-center justify-between text-xs font-semibold py-1.5 px-3 rounded-lg transition {{ request()->routeIs('admin.pegawai.lihat') ? 'bg-[#2b4f49] dark:bg-[#23423b] font-bold text-white dark:text-emerald-300' : 'text-white/80 dark:text-gray-400 hover:bg-[#2b4f49]/50 dark:hover:bg-[#152420] dark:hover:text-white' }}">
                        <span>Data Pegawai</span>
                        @php
                            $pendingPegawaiCount = \App\Models\Pegawai::where('status_verifikasi', 'pending')->count();
                        @endphp
                        @if ($pendingPegawaiCount > 0)
                            <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-extrabold leading-none text-white bg-amber-500 rounded-full">{{ $pendingPegawaiCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.tamu.lihat') }}" class="block text-xs font-semibold py-1.5 px-3 rounded-lg transition {{ request()->routeIs('admin.tamu.lihat') ? 'bg-[#2b4f49] dark:bg-[#23423b] font-bold text-white dark:text-emerald-300' : 'text-white/80 dark:text-gray-400 hover:bg-[#2b4f49]/50 dark:hover:bg-[#152420] dark:hover:text-white' }}">Data Tamu</a>
                </div>
            </div>

            <!-- Kunjungan -->
            <a href="{{ route('admin.kunjungan.lihat') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.kunjungan.lihat') ? 'bg-[#2b4f49] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-sm dark:border dark:border-[#284c43]' : 'hover:bg-[#2b4f49]/60 dark:hover:bg-[#152420] text-white/90 dark:text-gray-300 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.kunjungan.lihat') ? 'text-white dark:text-emerald-400' : 'opacity-80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span>Kunjungan</span>
            </a>

            <!-- Masukkan / Aduan -->
            <a href="{{ route('admin.masukkan.lihat') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.masukkan.lihat') ? 'bg-[#2b4f49] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-sm dark:border dark:border-[#284c43]' : 'hover:bg-[#2b4f49]/60 dark:hover:bg-[#152420] text-white/90 dark:text-gray-300 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.masukkan.lihat') ? 'text-white dark:text-emerald-400' : 'opacity-80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <span>Pengaduan</span>
            </a>

            <!-- Konten Publik -->
            <a href="{{ route('admin.publik.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.publik.*') ? 'bg-[#2b4f49] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-sm dark:border dark:border-[#284c43]' : 'hover:bg-[#2b4f49]/60 dark:hover:bg-[#152420] text-white/90 dark:text-gray-300 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.publik.*') ? 'text-white dark:text-emerald-400' : 'opacity-80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z"></path></svg>
                <span>Konten Publik</span>
            </a>

        </nav>
    </div>

    <!-- Bottom Logout Button -->
    <div class="p-4 border-t border-[#2a504a] dark:border-[#233a34]">
        <button type="button" onclick="document.getElementById('logoutModal').classList.remove('hidden')" class="w-full flex items-center justify-center p-2.5 hover:bg-[#2b4f49] dark:hover:bg-[#152420] rounded-xl transition-colors text-white/90 dark:text-gray-300 hover:text-white cursor-pointer" title="Logout">
            <svg class="w-6 h-6 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
        </button>
    </div>

</aside>

<!-- Modal Konfirmasi Logout -->
<div id="logoutModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <!-- Latar Belakang Gelap -->
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0 relative">
        <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-[#152420] dark:border dark:border-[#233a34] text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm">
            <div class="bg-white dark:bg-[#152420] px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start flex-col items-center">
                    <!-- Ikon Peringatan -->
                    <div class="mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-950/60 sm:mx-0 sm:h-12 sm:w-12 mb-4 sm:mb-0">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </div>
                    
                    <!-- Teks Konfirmasi -->
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-lg font-bold leading-6 text-gray-900 dark:text-white">Konfirmasi Keluar</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-300 font-medium">Apakah Anda yakin ingin keluar dari sistem?</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bagian Tombol Aksi (Ya atau Batal) -->
            <div class="bg-gray-50 dark:bg-[#0f1c19] px-4 py-3 grid grid-cols-2 sm:flex sm:flex-row-reverse sm:px-6 gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34]">
                <!-- Form Laravel untuk eksekusi POST /logout -->
                <form action="{{ route('admin.logout') }}" method="POST" class="inline-block m-0 w-full sm:w-auto">
                    @csrf 
                    <button type="submit" class="inline-flex w-full h-10 items-center justify-center rounded-xl bg-red-600 hover:bg-red-700 px-4 text-xs sm:text-sm font-bold text-white shadow-sm transition cursor-pointer">
                        Ya, Keluar
                    </button>
                </form>
                
                <!-- Tombol Batal untuk menutup modal -->
                <button type="button" onclick="document.getElementById('logoutModal').classList.add('hidden')" class="inline-flex w-full h-10 items-center justify-center rounded-xl bg-white dark:bg-[#152420] px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-[#284c43] hover:bg-gray-50 dark:hover:bg-white/5 transition cursor-pointer">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
