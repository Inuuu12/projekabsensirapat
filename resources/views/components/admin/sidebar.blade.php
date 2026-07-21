@props(['active' => 'dashboard'])

@php
    $linkBase = 'flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm font-medium transition hover:bg-white/10 cursor-pointer';
    $linkActive = 'bg-[#558b88] text-white font-bold rounded-xl shadow-inner';
    $linkInactive = 'text-white/80 hover:text-white';
    $subBase = 'block rounded-lg px-4 py-2 text-xs font-semibold transition hover:bg-white/10';
@endphp

<aside class="flex min-h-screen w-64 shrink-0 flex-col justify-between bg-[#387672] p-4 text-white shadow-xl">
    <div>
        {{-- Header / Logo --}}
        <div class="mb-6 flex items-center gap-3 border-b border-white/20 pb-5 pt-2">
            <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Bappenda" class="h-10 w-auto">
            <div>
                <h1 class="text-[10px] font-medium uppercase tracking-wider text-white/90">PEMERINTAH KABUPATEN BOGOR</h1>
                <p class="text-xs font-bold leading-tight text-white">Dinas Komunikasi & Informatika</p>
            </div>
        </div>

        {{-- Navigasi Utama --}}
        <nav class="space-y-2">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="{{ $linkBase }} {{ $active === 'dashboard' ? $linkActive : $linkInactive }}">
                <img src="{{ asset('foto/Dashboardlogo.png') }}" alt="Dashboard" class="h-5 w-5 object-contain">
                <span>Dashboard</span>
            </a>

            {{-- Dropdown Agenda --}}
            <div x-data="{ open: {{ in_array($active, ['agenda', 'ruang'], true) ? 'true' : 'false' }} }">
                <button @click="open = !open" type="button" class="w-full {{ $linkBase }} {{ in_array($active, ['agenda', 'ruang'], true) ? 'text-white' : $linkInactive }}">
                    <img src="{{ asset('foto/Agendalogo.png') }}" alt="Agenda" class="h-5 w-5 object-contain">
                    <span class="flex-1 text-left">Agenda</span>
                    <svg class="h-3.5 w-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 pl-4">
                    <a href="{{ route('admin.agenda.lihat') }}" class="{{ $subBase }} {{ $active === 'agenda' ? $linkActive : $linkInactive }}">
                        Daftar Agenda
                    </a>
                    <a href="{{ route('admin.ruang.lihat') }}" class="{{ $subBase }} {{ $active === 'ruang' ? $linkActive : $linkInactive }}">
                        Daftar Ruang
                    </a>
                </div>
            </div>

            {{-- Dropdown Data Pengguna --}}
            <div x-data="{ open: {{ in_array($active, ['pegawai', 'tamu'], true) ? 'true' : 'false' }} }">
                <button @click="open = !open" type="button" class="w-full {{ $linkBase }} {{ in_array($active, ['pegawai', 'tamu'], true) ? 'text-white' : $linkInactive }}">
                    <img src="{{ asset('foto/Pegawailogo.png') }}" alt="Data Pengguna" class="h-5 w-5 object-contain">
                    <span class="flex-1 text-left">Data Pengguna</span>
                    <svg class="h-3.5 w-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open" x-collapse x-cloak class="mt-1 space-y-1 pl-4">
                    <a href="{{ route('admin.datapegawai') }}" class="{{ $subBase }} {{ $active === 'pegawai' ? $linkActive : $linkInactive }}">
                        Data Pegawai
                    </a>
                    <a href="{{ route('admin.datatamu') }}" class="{{ $subBase }} {{ $active === 'tamu' ? $linkActive : $linkInactive }}">
                        Data Tamu
                    </a>
                </div>
            </div>

            {{-- Kunjungan --}}
            <a href="{{ route('admin.kunjungan.lihat') }}" class="{{ $linkBase }} {{ $active === 'kunjungan' ? $linkActive : $linkInactive }}">
                <img src="{{ asset('foto/Kunjunganlogo.png') }}" alt="Kunjungan" class="h-5 w-5 object-contain">
                <span>Kunjungan</span>
            </a>

            {{-- Masukkan / Umpan Balik --}}
            <a href="{{ route('admin.umpanbalik') }}" class="{{ $linkBase }} {{ $active === 'umpanbalik' ? $linkActive : $linkInactive }}">
                <img src="{{ asset('foto/Laporanlogo.png') }}" alt="Masukkan" class="h-5 w-5 object-contain">
                <span>Masukkan</span>
            </a>
        </nav>
    </div>

    {{-- Logout --}}
    <form method="POST" action="{{ route('admin.logout') }}" class="border-t border-white/10 pt-4">
        @csrf
        <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-2 py-2 text-left text-sm font-semibold text-white/80 transition hover:bg-black/10 hover:text-white">
            <svg class="h-6 w-6 transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
        </button>
    </form>
</aside>