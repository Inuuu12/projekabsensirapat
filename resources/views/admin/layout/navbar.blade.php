<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 shadow-sm">
    <!-- Page Title / Search -->
    <div class="flex items-center space-x-4">
        <h2 class="text-lg font-bold text-gray-800">Admin Panel</h2>
    </div>

    <!-- Right Side: User Profile & Quick Actions -->
    <div class="flex items-center space-x-6">
        <!-- Date / Time Info -->
        <div class="hidden md:flex flex-col text-right">
            <span class="text-xs text-gray-500 font-semibold">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            <span class="text-xs text-gray-400">Selamat datang kembali</span>
        </div>

        <!-- User Dropdown / Profile info -->
        <div class="flex items-center space-x-3 border-l pl-6 border-gray-200">
            <div class="w-9 h-9 rounded-full bg-[#387673] flex items-center justify-center text-white font-bold shadow-inner">
                {{ strtoupper(substr(Auth::guard('admin')->user()->nama ?? 'A', 0, 1)) }}
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-bold text-gray-800 leading-none">{{ Auth::guard('admin')->user()->nama ?? 'Admin' }}</span>
                <span class="text-xs text-gray-500 mt-0.5">{{ Auth::guard('admin')->user()->username ?? 'admin' }}</span>
            </div>
        </div>
    </div>
</header>
