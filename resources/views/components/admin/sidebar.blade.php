@props(['active' => 'dashboard'])

@php
    $linkBase = 'flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-semibold transition hover:bg-white/10';
    $linkActive = 'bg-white/20 text-white';
    $linkInactive = 'text-white/80 hover:text-white';
    $subBase = 'block rounded-lg px-3 py-2 text-xs font-bold transition hover:bg-white/10';
@endphp

<aside class="flex min-h-screen w-64 shrink-0 flex-col justify-between bg-[#3b6f6c] p-5 text-white shadow-lg">
    <div>
        <div class="mb-6 flex items-center gap-3 border-b border-white/20 pb-6">
            <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Bappenda" class="h-12 w-auto">
            <div>
                <h1 class="text-sm font-extrabold uppercase tracking-wide">Bappenda</h1>
                <p class="text-[10px] tracking-wider text-gray-200">KABUPATEN BOGOR</p>
            </div>
        </div>

        <nav class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ $linkBase }} {{ $active === 'dashboard' ? $linkActive : $linkInactive }}">
                <span class="w-5 text-center">D</span>
                <span>Dashboard</span>
            </a>

            <div class="space-y-1">
                <div class="{{ $linkBase }} {{ in_array($active, ['agenda', 'ruang'], true) ? 'bg-white/10 text-white' : $linkInactive }}">
                    <span class="w-5 text-center">A</span>
                    <span class="flex-1">Agenda</span>
                    <span class="text-xs">{{ in_array($active, ['agenda', 'ruang'], true) ? '^' : 'v' }}</span>
                </div>
                <div class="ml-8 space-y-1">
                    <a href="{{ route('admin.agenda.lihat') }}" class="{{ $subBase }} {{ $active === 'agenda' ? $linkActive : $linkInactive }}">
                        Daftar Agenda
                    </a>
                    <a href="{{ route('admin.ruang.lihat') }}" class="{{ $subBase }} {{ $active === 'ruang' ? $linkActive : $linkInactive }}">
                        Daftar Ruang
                    </a>
                </div>
            </div>

            <div class="space-y-1">
                <div class="{{ $linkBase }} {{ in_array($active, ['pegawai', 'tamu'], true) ? 'bg-white/10 text-white' : $linkInactive }}">
                    <span class="w-5 text-center">P</span>
                    <span class="flex-1">Data Pengguna</span>
                    <span class="text-xs">{{ in_array($active, ['pegawai', 'tamu'], true) ? '^' : 'v' }}</span>
                </div>
                <div class="ml-8 space-y-1">
                    <a href="{{ route('admin.datapegawai') }}" class="{{ $subBase }} {{ $active === 'pegawai' ? $linkActive : $linkInactive }}">
                        Data Pegawai
                    </a>
                    <a href="{{ route('admin.datatamu') }}" class="{{ $subBase }} {{ $active === 'tamu' ? $linkActive : $linkInactive }}">
                        Data Tamu
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.kunjungan.lihat') }}" class="{{ $linkBase }} {{ $active === 'kunjungan' ? $linkActive : $linkInactive }}">
                <span class="w-5 text-center">K</span>
                <span>Kunjungan</span>
            </a>

            <a href="{{ route('admin.umpanbalik') }}" class="{{ $linkBase }} {{ $active === 'umpanbalik' ? $linkActive : $linkInactive }}">
                <span class="w-5 text-center">U</span>
                <span>Umpan Balik</span>
            </a>

            <a href="{{ route('admin.laporan.lihat') }}" class="{{ $linkBase }} {{ $active === 'laporan' ? $linkActive : $linkInactive }}">
                <span class="w-5 text-center">L</span>
                <span>Laporan</span>
            </a>
        </nav>
    </div>

    <form method="POST" action="{{ route('admin.logout') }}" class="border-t border-white/10 pt-4">
        @csrf
        <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-4 py-2.5 text-left text-sm font-semibold text-white/80 transition hover:bg-black/10 hover:text-white">
            <span class="w-5 text-center">X</span>
            <span>Keluar</span>
        </button>
    </form>
</aside>
