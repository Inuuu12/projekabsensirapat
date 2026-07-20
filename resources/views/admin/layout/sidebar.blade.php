<div class="w-64 h-screen bg-[#387673] text-white flex flex-col justify-between font-sans shadow-lg select-none">
    
    <div>
        <div class="p-5 flex items-center space-x-3 border-b border-[#2d5f5c]">
            <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo" class="w-11 h-auto object-contain">
            <div>
                <h1 class="font-black text-xl leading-none tracking-wide">BAPPENDA</h1>
                <p class="text-xs tracking-wider opacity-90 mt-0.5">KABUPATEN BOGOR</p>
            </div>
        </div>

        <nav class="mt-6 px-3 space-y-1 text-sm font-semibold">
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-[#438a87] rounded-lg transition-colors group">
                <img src="{{ asset('foto/Dashboardlogo.png') }}" alt="Agenda" class="w-5 h-5 mr-3">
                <span>Dashboard</span>
            </a>

            <div class="space-y-1">
                <button class="w-full flex items-center justify-between px-4 py-3 hover:bg-[#438a87] rounded-lg transition-colors">
                    <div class="flex items-center">
                        <img src="{{ asset('foto/Agendalogo.png') }}" alt="Agenda" class="w-5 h-5 mr-3">
                        <span>Agenda</span>
                    </div>
                    <span class="text-xs">▲</span>
                </button>
                
                <div class="pl-11 space-y-1">
                    <a href="{{ route('admin.agenda.lihat') }}" class="block px-4 py-2.5 rounded-lg opacity-80 hover:opacity-100 transition-opacity">
                        Daftar Agenda
                    </a>
                    <a href="{{ route('admin.ruang.lihat') }}" class="block px-4 py-2.5 rounded-lg opacity-80 hover:opacity-100 transition-opacity">
                        Daftar Ruang
                    </a>
                </div>
            </div>

            <!-- Submenu Data Pegawai Aktif (Biarkan seperti ini) -->
<a href="/admin/datapegawai" class="block py-2 px-3 font-bold bg-white/20 rounded-lg text-white">Data Pegawai</a>
<a href="/admin/datatamu" class="block py-2 opacity-80 hover:opacity-100">Data Tamu</a>
                <img src="{{ asset('foto/Pegawailogo.png') }}" alt="Agenda" class="w-5 h-5 mr-3">
                <span>Data Pengguna</span>
            </a>

            <a href="{{ route('admin.kunjungan.lihat') }}" class="flex items-center px-4 py-3 hover:bg-[#438a87] rounded-lg transition-colors opacity-80 hover:opacity-100">
                <img src="{{ asset('foto/Kunjunganlogo.png') }}" alt="Agenda" class="w-5 h-5 mr-3">
                <span>Kunjungan</span>
            </a>

            <a href="{{ route('admin.laporan.lihat') }}" class="flex items-center px-4 py-3 hover:bg-[#438a87] rounded-lg transition-colors opacity-80 hover:opacity-100">
                <img src="{{ asset('foto/Laporanlogo.png') }}" alt="Agenda" class="w-5 h-5 mr-3">
                <span>Laporan</span>
            </a>

        </nav>
    </div>

    <div class="p-5 border-t border-[#2d5f5c]">
        <!-- Logout Form / Button -->
        <form action="{{ route('admin.logout') }}" method="POST" class="inline" id="logout-form">
            @csrf
            <button type="submit" class="inline-flex items-center justify-center p-2 hover:bg-[#438a87] rounded-lg transition-colors group" title="Logout">
                <svg class="w-6 h-6 transform rotate-180 opacity-80 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </button>
        </form>
    </div>

</div>
