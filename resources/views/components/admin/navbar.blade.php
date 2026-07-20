@props([
    'title' => 'Admin Panel',
    'subtitle' => 'Selamat datang kembali.',
])

@php
    $adminUser = auth('admin')->user();
    $displayName = $adminUser->nama ?? $adminUser->username ?? 'Admin';
    $initial = strtoupper(substr($displayName, 0, 1));
@endphp

<header class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-3xl font-extrabold tracking-tight text-gray-800">{{ $title }}</h2>
        <p class="mt-1 text-xs text-gray-400">{{ $subtitle }}</p>
    </div>

    <div class="flex max-w-xs items-center gap-3 rounded-full border border-[#3b6f6c]/20 bg-[#3b6f6c]/10 px-4 py-2 shadow-sm">
        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#3b6f6c] text-sm font-extrabold text-white">
            {{ $initial }}
        </div>
        <div class="text-xs">
            <p class="font-extrabold text-gray-800">{{ $displayName }}</p>
            <p class="text-[10px] font-medium text-gray-400">Super Admin</p>
        </div>
    </div>
</header>
