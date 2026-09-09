@php
    $appName = config('sirapi.name', 'RAPID');
    $organizationName = config('sirapi.organization', 'Dinas Komunikasi & Informatika');
    $regionName = config('sirapi.region', 'Pemerintah Kabupaten Bogor');
@endphp

<!-- Mobile Overlay Backdrop -->
<div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity"></div>

<!-- Sidebar Container -->
<aside id="sidebar-menu" class="fixed md:static inset-y-0 left-0 z-50 w-72 md:w-64 h-screen bg-[#35635b] dark:bg-[#0f1c19] dark:border-r dark:border-[#233a34] text-white flex flex-col justify-between font-sans shadow-2xl md:shadow-[6px_0_30px_rgba(0,0,0,0.22)] select-none transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out">
    
    <div>
        <!-- Logo & Header -->
        <div class="p-4 flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-white/10 dark:bg-white/5 border border-white/20 dark:border-white/10 p-1 flex items-center justify-center shrink-0 shadow-md backdrop-blur-xs group">
                <img src="{{ asset('assets/foto/logo-bappenda.png') }}" alt="Logo Kab. Bogor" class="w-full h-full object-contain drop-shadow group-hover:scale-105 transition-transform duration-300">
            </div>
            <div class="min-w-0 flex-1">
                <h1 class="font-black text-lg leading-tight tracking-wide text-white">{{ $appName }}</h1>
                <p class="text-[11px] font-medium text-white/80 dark:text-gray-300 leading-tight">{{ $organizationName }}</p>
            </div>
            <!-- Mobile Close Button -->
            <button onclick="toggleSidebar()" class="md:hidden ml-auto w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-white focus:outline-none shrink-0 transition-colors cursor-pointer" title="Tutup Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-6 px-3 space-y-1 text-sm font-medium">
            
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#2b4f49] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-md dark:border dark:border-[#284c43]' : 'hover:bg-[#2b4f49]/60 dark:hover:bg-[#152420] text-white/90 dark:text-gray-300 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-white dark:text-emerald-400' : 'opacity-80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Dashboard</span>
            </a>

            <!-- Agenda Submenu -->
            @php $isAgendaActive = request()->routeIs('admin.agenda.*') || request()->routeIs('admin.ruang.*'); @endphp
            <div class="space-y-1">
                <button onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ $isAgendaActive ? 'bg-[#2b4f49] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-md dark:border dark:border-[#284c43]' : 'hover:bg-[#2b4f49]/60 dark:hover:bg-[#152420] text-white/90 dark:text-gray-300 dark:hover:text-white' }} focus:outline-none cursor-pointer">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 {{ $isAgendaActive ? 'text-white dark:text-emerald-400' : 'opacity-80' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="4" width="18" height="17" rx="3.5" stroke-width="2"/>
                            <path stroke-linecap="round" stroke-width="2.5" d="M8 2v4M16 2v4M3 9h18"/>
                            <path stroke-linecap="round" stroke-width="2.5" d="M7 13h2M11 13h2M15 13h2M7 17h2M11 17h2M15 17h2"/>
                        </svg>
                        <span>Agenda</span>
                    </div>
                    <svg class="w-4 h-4 opacity-80 arrow-icon transition-transform {{ $isAgendaActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div class="{{ $isAgendaActive ? 'flex' : 'hidden' }} flex-col pl-12 pr-4 py-1 space-y-2">
                    <a href="{{ route('admin.agenda.lihat') }}" class="block text-xs font-semibold py-1.5 px-3 rounded-lg transition {{ request()->routeIs('admin.agenda.lihat') ? 'bg-[#2b4f49] dark:bg-[#23423b] font-bold text-white dark:text-emerald-300' : 'text-white/80 dark:text-gray-400 hover:bg-[#2b4f49]/50 dark:hover:bg-[#152420] dark:hover:text-white' }}">Daftar Agenda</a>
                    <a href="{{ route('admin.agenda.riwayat') }}" class="block text-xs font-semibold py-1.5 px-3 rounded-lg transition {{ request()->routeIs('admin.agenda.riwayat') ? 'bg-[#2b4f49] dark:bg-[#23423b] font-bold text-white dark:text-emerald-300' : 'text-white/80 dark:text-gray-400 hover:bg-[#2b4f49]/50 dark:hover:bg-[#152420] dark:hover:text-white' }}">Riwayat Agenda</a>
                    <a href="{{ route('admin.ruang.lihat') }}" class="block text-xs font-semibold py-1.5 px-3 rounded-lg transition {{ request()->routeIs('admin.ruang.lihat') ? 'bg-[#2b4f49] dark:bg-[#23423b] font-bold text-white dark:text-emerald-300' : 'text-white/80 dark:text-gray-400 hover:bg-[#2b4f49]/50 dark:hover:bg-[#152420] dark:hover:text-white' }}">Daftar Ruangan</a>
                </div>
            </div>

            <!-- Data Pengguna Submenu -->
            @php $isUserActive = request()->routeIs('admin.pegawai.*') || request()->routeIs('admin.tamu.*'); @endphp
            <div class="space-y-1">
                <button onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.arrow-icon').classList.toggle('rotate-180')" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ $isUserActive ? 'bg-[#2b4f49] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-md dark:border dark:border-[#284c43]' : 'hover:bg-[#2b4f49]/60 dark:hover:bg-[#152420] text-white/90 dark:text-gray-300 dark:hover:text-white' }} focus:outline-none cursor-pointer">
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
                            <span class="inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-extrabold leading-none text-white bg-amber-500 rounded-full shadow-xs">{{ $pendingPegawaiCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.tamu.lihat') }}" class="block text-xs font-semibold py-1.5 px-3 rounded-lg transition {{ request()->routeIs('admin.tamu.lihat') ? 'bg-[#2b4f49] dark:bg-[#23423b] font-bold text-white dark:text-emerald-300' : 'text-white/80 dark:text-gray-400 hover:bg-[#2b4f49]/50 dark:hover:bg-[#152420] dark:hover:text-white' }}">Data Tamu</a>
                </div>
            </div>

            <!-- Kunjungan -->
            <a href="{{ route('admin.kunjungan.lihat') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.kunjungan.lihat') ? 'bg-[#2b4f49] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-md dark:border dark:border-[#284c43]' : 'hover:bg-[#2b4f49]/60 dark:hover:bg-[#152420] text-white/90 dark:text-gray-300 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.kunjungan.lihat') ? 'text-white dark:text-emerald-400' : 'opacity-80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span>Kunjungan</span>
            </a>

            <!-- Masukkan / Aduan -->
            <a href="{{ route('admin.masukkan.lihat') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.masukkan.lihat') ? 'bg-[#2b4f49] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-md dark:border dark:border-[#284c43]' : 'hover:bg-[#2b4f49]/60 dark:hover:bg-[#152420] text-white/90 dark:text-gray-300 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.masukkan.lihat') ? 'text-white dark:text-emerald-400' : 'opacity-80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                </svg>
                <span>Pengaduan</span>
            </a>

            <!-- Konten Publik -->
            <a href="{{ route('admin.publik.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.publik.*') ? 'bg-[#2b4f49] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-md dark:border dark:border-[#284c43]' : 'hover:bg-[#2b4f49]/60 dark:hover:bg-[#152420] text-white/90 dark:text-gray-300 dark:hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.publik.*') ? 'text-white dark:text-emerald-400' : 'opacity-80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <rect x="5" y="5" width="16" height="15" rx="2.5" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8v10a2 2 0 002 2h12M15 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm-7 9l3.5-3.5a1.5 1.5 0 012.12 0L18 19"/>
                </svg>
                <span>Konten Publik</span>
            </a>

        </nav>
    </div>

    <!-- Bottom Logout Button -->
    <div class="p-4 border-t border-[#2a504a] dark:border-[#233a34]">
        <button type="button" onclick="openAdminLogoutModal()" class="w-full flex items-center justify-center gap-2.5 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-red-600/90 text-white border border-white/15 hover:border-red-500/50 text-xs font-bold transition-all shadow-md cursor-pointer group" title="Logout">
            <svg class="w-4 h-4 transform rotate-180 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Keluar / Logout</span>
        </button>
    </div>

</aside>

<!-- Modal Konfirmasi Logout (Styling Tajam & Bayangan Kunker) -->
<div id="logoutModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-xs items-center justify-center p-4 transition-all duration-200" onclick="if(event.target === this) closeAdminLogoutModal()">
    <div class="relative w-full max-w-sm rounded-xl bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] text-center shadow-2xl p-6 sm:p-8 transform scale-95 transition-all">
        <!-- Ikon Peringatan -->
        <div class="mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-950/60 text-red-600 dark:text-red-400 mb-4 shadow-sm">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
        </div>
        
        <!-- Teks Konfirmasi -->
        <div class="space-y-1.5 mb-6">
            <h3 class="text-lg font-bold leading-6 text-gray-900 dark:text-white">Konfirmasi Keluar</h3>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-300 font-medium">Apakah Anda yakin ingin keluar dari sistem?</p>
        </div>
        
        <!-- Bagian Tombol Aksi (Batal / Keluar) -->
        <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-100 dark:border-[#233a34]">
            <button type="button" onclick="closeAdminLogoutModal()" class="inline-flex w-full h-10 items-center justify-center rounded-xl bg-white dark:bg-[#0f1c19] px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 shadow-sm border border-gray-300 dark:border-[#284c43] hover:bg-gray-50 dark:hover:bg-white/5 transition cursor-pointer">
                Batal
            </button>

            <!-- Form Laravel untuk eksekusi POST /logout -->
            <form action="{{ route('admin.logout') }}" method="POST" class="m-0 w-full">
                @csrf 
                <button type="submit" class="inline-flex w-full h-10 items-center justify-center rounded-xl bg-red-600 hover:bg-red-700 px-4 text-xs sm:text-sm font-bold text-white shadow-md transition cursor-pointer">
                    Ya, Keluar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openAdminLogoutModal() {
        const modal = document.getElementById('logoutModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }
    function closeAdminLogoutModal() {
        const modal = document.getElementById('logoutModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
</script>
