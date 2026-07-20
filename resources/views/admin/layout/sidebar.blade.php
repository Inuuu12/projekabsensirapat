@php
    $active = match (true) {
        request()->routeIs('admin.agenda*') => 'agenda',
        request()->routeIs('admin.ruang*') => 'ruang',
        request()->routeIs('admin.datapegawai*'), request()->routeIs('admin.pengguna*') => 'pegawai',
        request()->routeIs('admin.datatamu*') => 'tamu',
        request()->routeIs('admin.kunjungan*'), request()->routeIs('admin.daftarkunjungan*') => 'kunjungan',
        request()->routeIs('admin.umpanbalik*') => 'umpanbalik',
        request()->routeIs('admin.laporan*') => 'laporan',
        default => 'dashboard',
    };
@endphp

<x-admin.sidebar :active="$active" />
