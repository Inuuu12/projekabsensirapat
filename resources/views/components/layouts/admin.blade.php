@props(['title' => 'Admin e-Agenda', 'heading' => null])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin e-Agenda' }}</title>
    @include('partials.frontend-assets')
</head>
<body>
    @php
        $activeResource = request()->route('resource');
        $nav = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'dashboard'],
            [
                'label' => 'Agenda',
                'icon' => 'agenda',
                'active' => $activeResource && in_array($activeResource, ['agenda', 'status-agenda', 'ruang-rapat', 'qrcode', 'dokumen-notulen']),
                'children' => [
                    ['label' => 'Agenda', 'resource' => 'agenda'],
                    ['label' => 'Status Agenda', 'resource' => 'status-agenda'],
                    ['label' => 'Ruang Rapat', 'resource' => 'ruang-rapat'],
                    ['label' => 'QRCode', 'resource' => 'qrcode'],
                    ['label' => 'Dokumen Notulen', 'resource' => 'dokumen-notulen'],
                ],
            ],
            ['label' => 'Kehadiran', 'route' => 'admin.crud.index', 'resource' => 'kehadiran', 'icon' => 'rekap'],
            [
                'label' => 'Data Pengguna',
                'icon' => 'users',
                'active' => $activeResource && in_array($activeResource, ['admins', 'pegawai', 'peserta', 'face-recog', 'kunjungan']),
                'children' => [
                    ['label' => 'Admin', 'resource' => 'admins'],
                    ['label' => 'Pegawai', 'resource' => 'pegawai'],
                    ['label' => 'Peserta', 'resource' => 'peserta'],
                    ['label' => 'FaceRecog', 'resource' => 'face-recog'],
                    ['label' => 'Kunjungan', 'resource' => 'kunjungan'],
                ],
            ],
            [
                'label' => 'Masukan',
                'icon' => 'masukan',
                'active' => $activeResource && in_array($activeResource, ['masukan', 'data-masukan', 'status-masukan']),
                'children' => [
                    ['label' => 'Masukan', 'resource' => 'masukan'],
                    ['label' => 'Data Masukan', 'resource' => 'data-masukan'],
                    ['label' => 'Status Masukan', 'resource' => 'status-masukan'],
                ],
            ],
            [
                'label' => 'Beranda',
                'icon' => 'dashboard',
                'active' => $activeResource && in_array($activeResource, ['berita', 'galeri', 'ulang-tahun', 'cuaca']),
                'children' => [
                    ['label' => 'Berita', 'resource' => 'berita'],
                    ['label' => 'Galeri', 'resource' => 'galeri'],
                    ['label' => 'Ulang Tahun', 'resource' => 'ulang-tahun'],
                    ['label' => 'Cuaca', 'resource' => 'cuaca'],
                ],
            ],
            ['label' => 'Logbook', 'route' => 'admin.crud.index', 'resource' => 'logbook', 'icon' => 'rekap'],
        ];
    @endphp

    <div class="admin-shell">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('assets/bappenda-logo.png') }}" alt="Bappenda Kabupaten Bogor">
                <div>
                    <div class="sidebar-title">BAPPENDA</div>
                    <div class="sidebar-subtitle">KABUPATEN BOGOR</div>
                </div>
            </div>

            <nav class="sidebar-nav">
                @foreach ($nav as $item)
                    @php
                        $hasChildren = isset($item['children']);
                        $isActive = $item['active'] ?? (!$hasChildren && (
                            isset($item['resource'])
                                ? $activeResource === $item['resource']
                                : (isset($item['route']) && request()->routeIs($item['route']))
                        ));
                    @endphp

                    <div class="nav-group">
                        <a href="{{ isset($item['resource']) ? route($item['route'], $item['resource']) : (isset($item['route']) && Route::has($item['route']) ? route($item['route']) : '#') }}" class="nav-item {{ $isActive && !$hasChildren ? 'active' : '' }}">
                            @include('partials.icon', ['name' => $item['icon'], 'class' => 'h-5 w-5 shrink-0'])
                            <span class="nav-text">{{ $item['label'] }}</span>
                            @if ($hasChildren)
                                @include('partials.icon', ['name' => 'chevron-down', 'class' => 'h-4 w-4 shrink-0'])
                            @endif
                        </a>

                        @if ($hasChildren && $isActive)
                            <div class="nav-children">
                                @foreach ($item['children'] as $child)
                                    @php($childActive = $activeResource === $child['resource'])
                                    <a href="{{ route('admin.crud.index', $child['resource']) }}" class="nav-child {{ $childActive ? 'active' : '' }}">{{ $child['label'] }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </nav>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="logout-link" aria-label="Logout">
                    @include('partials.icon', ['name' => 'logout', 'class' => 'h-6 w-6'])
                </button>
            </form>
        </aside>

        <main class="admin-main">
            <div class="admin-content">
                <header class="page-header">
                    <div>
                        <h1 class="page-title">{{ $heading ?? $title ?? 'Dashboard' }}</h1>
                        <p class="page-kicker">Selamat datang kembali, Admin!</p>
                    </div>

                    <div class="profile-chip">
                        <div class="profile-avatar">AD</div>
                        <div>
                            <div class="profile-name">{{ session('admin_name', 'Admin') }}</div>
                            <div class="profile-role">Super Admin</div>
                        </div>
                    </div>
                </header>

                {{ $slot }}
            </div>
        </main>
    </div>
    @include('partials.frontend-scripts')
</body>
</html>
