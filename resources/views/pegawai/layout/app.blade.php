<!DOCTYPE html>
<html lang="id" class="h-full bg-[#FAFAFA] dark:bg-[#121d1a]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Pegawai') - RAPID</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Script Anti-FOUC Tema Gelap/Terang -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('sirapi_theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();

        function toggleSirapiTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            const newTheme = isDark ? 'dark' : 'light';
            localStorage.setItem('sirapi_theme', newTheme);
            updateThemeIcons();
        }

        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('[data-theme-icon-light]').forEach(el => {
                el.classList.toggle('hidden', !isDark);
            });
            document.querySelectorAll('[data-theme-icon-dark]').forEach(el => {
                el.classList.toggle('hidden', isDark);
            });
        }
        document.addEventListener('DOMContentLoaded', updateThemeIcons);
    </script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'pegawai-bg-dark': '#0d1614',
                        'pegawai-card-dark': '#152420',
                        'pegawai-border-dark': '#233a34',
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }
        * { font-family: 'Poppins', sans-serif !important; }

        /* Custom Scrollbars */
        ::-webkit-scrollbar { height: 6px; width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        .dark ::-webkit-scrollbar-track { background: #0d1614; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .dark ::-webkit-scrollbar-thumb { background: #284c43; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #35635b; }

        .overflow-y-auto, .overflow-auto { -webkit-overflow-scrolling: touch; }

        @media (max-width: 640px) {
            input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]):not([type="hidden"]),
            select, textarea { font-size: 16px !important; }
        }

        /* Dark Mode Overrides */
        .dark { color-scheme: dark; }
        .dark, .dark body, .dark main { background-color: #0d1614 !important; color: #f1f5f9 !important; }
        .dark .bg-white { background-color: #152420 !important; color: #f1f5f9 !important; border-color: #233a34 !important; }

        main .shadow-xs, main .shadow-sm, main .shadow-md, main .shadow {
            box-shadow: 0 4px 18px -2px rgba(0,0,0,0.08), 0 2px 6px -1px rgba(0,0,0,0.04) !important;
        }
        .dark main .shadow-xs, .dark main .shadow-sm, .dark main .shadow-md, .dark main .shadow {
            box-shadow: 0 6px 24px -2px rgba(0,0,0,0.45) !important;
        }

        .dark .bg-gray-50, .dark .bg-slate-50, .dark .bg-gray-50\/50, .dark .bg-gray-50\/80 {
            background-color: #1a2d29 !important; color: #f1f5f9 !important;
        }
        .dark .border-gray-100, .dark .border-gray-200, .dark .border-slate-100, .dark .border-slate-200, .dark .border-slate-300 {
            border-color: #233a34 !important;
        }
        .dark h1, .dark h2, .dark h3, .dark h4, .dark h5, .dark h6 { color: #ffffff !important; }
        .dark .text-gray-500, .dark .text-gray-600, .dark .text-gray-700, .dark .text-gray-800,
        .dark .text-slate-500, .dark .text-slate-600, .dark .text-slate-700, .dark .text-slate-800 { color: #cbd5e1 !important; }
        .dark .text-gray-400, .dark .text-slate-400 { color: #94a3b8 !important; }

        .dark label { color: #e2e8f0; }

        .dark input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]):not([type="hidden"]),
        .dark select, .dark textarea {
            background-color: #0f1c19 !important; border-color: #284c43 !important; color: #ffffff !important;
        }
        .dark input::placeholder, .dark textarea::placeholder { color: #64748b !important; }
        .dark input:focus, .dark select:focus, .dark textarea:focus {
            border-color: #10b981 !important; box-shadow: 0 0 0 2px rgba(16,185,129,0.25) !important;
        }

        .dark thead tr { background-color: #1b3832 !important; color: #ffffff !important; }
        .dark thead th { color: #ffffff !important; border-bottom: 1px solid #233a34 !important; }
        .dark tbody tr { border-bottom-color: #233a34 !important; }
        .dark tbody tr:hover { background-color: #1b332d !important; }
        .dark tbody td { color: #e2e8f0 !important; }

        .dark .bg-emerald-50, .dark .bg-emerald-100 { background-color: rgba(6,78,59,0.5) !important; color: #6ee7b7 !important; border: 1px solid rgba(16,185,129,0.4) !important; }
        .dark .bg-amber-50, .dark .bg-amber-100, .dark .bg-yellow-50 { background-color: rgba(120,53,15,0.5) !important; color: #fcd34d !important; border: 1px solid rgba(245,158,11,0.4) !important; }
        .dark .bg-red-50, .dark .bg-red-100 { background-color: rgba(127,29,29,0.5) !important; color: #fca5a5 !important; border: 1px solid rgba(239,68,68,0.4) !important; }
        .dark .bg-blue-50, .dark .bg-blue-100 { background-color: rgba(30,58,138,0.5) !important; color: #93c5fd !important; border: 1px solid rgba(59,130,246,0.4) !important; }
        .dark .bg-gray-100, .dark .bg-gray-200, .dark .bg-slate-100, .dark .bg-slate-200 {
            background-color: #1a2e29 !important; color: #e2e8f0 !important; border: 1px solid #35584f !important;
        }

        /* Autofill */
        input:-webkit-autofill, input:-webkit-autofill:hover, input:-webkit-autofill:focus, input:-webkit-autofill:active,
        textarea:-webkit-autofill, textarea:-webkit-autofill:hover, textarea:-webkit-autofill:focus,
        select:-webkit-autofill, select:-webkit-autofill:hover, select:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
            -webkit-text-fill-color: #1f2937 !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        .dark input:-webkit-autofill, .dark input:-webkit-autofill:hover, .dark input:-webkit-autofill:focus, .dark input:-webkit-autofill:active,
        .dark textarea:-webkit-autofill, .dark textarea:-webkit-autofill:hover, .dark textarea:-webkit-autofill:focus,
        .dark select:-webkit-autofill, .dark select:-webkit-autofill:hover, .dark select:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #0f1c19 inset !important;
            -webkit-text-fill-color: #ffffff !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* Modal enforce viewport */
        div[id^="modal-"], div[id*="-modal"] {
            position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; bottom: 0 !important;
            width: 100vw !important; height: 100vh !important; max-width: 100vw !important; max-height: 100dvh !important;
            margin: 0 !important; z-index: 9999 !important; box-sizing: border-box !important;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-gray-800 dark:text-slate-100 flex overflow-hidden bg-[#FAFAFA] dark:bg-[#0d1614] transition-colors duration-200">

    @php
        $pegawaiUser = Auth::guard('pegawai')->user();
        $currentRoute = request()->route() ? request()->route()->getName() : '';
    @endphp

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity"></div>

    <!-- Sidebar -->
    <aside id="sidebar-menu" class="fixed md:static inset-y-0 left-0 z-50 w-72 md:w-[270px] h-screen bg-white dark:bg-[#0f1c19] border-r border-gray-200/80 dark:border-[#233a34] text-gray-800 dark:text-white flex flex-col justify-between font-sans shadow-xl md:shadow-[6px_0_30px_rgba(0,0,0,0.06)] select-none transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out">
        <div>
            <!-- Logo & Header -->
            <div class="px-5 py-4 flex items-center gap-3 border-b border-gray-100 dark:border-[#233a34]">
                <div class="w-8 h-9 flex items-center justify-center shrink-0">
                    <img src="{{ asset('assets/foto/logo-bappenda.png') }}" alt="Logo Kab. Bogor" class="w-full h-full object-contain drop-shadow-xs">
                </div>
                <div class="min-w-0 flex-1">
                    <h1 class="font-black text-xl leading-none tracking-wide text-[#35635b] dark:text-white">RAPID</h1>
                    <p class="text-[8px] font-bold text-gray-400 dark:text-gray-400 tracking-wider uppercase mt-1 leading-none whitespace-nowrap">PORTAL PEGAWAI</p>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden ml-auto w-8 h-8 rounded-lg bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 flex items-center justify-center text-[#35635b] dark:text-white focus:outline-none shrink-0 transition-colors cursor-pointer" title="Tutup Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="mt-4 px-3 space-y-1.5 text-sm font-medium">
                <!-- Dashboard -->
                <a href="{{ route('pegawai.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ $currentRoute === 'pegawai.dashboard' ? 'bg-[#35635b] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-md dark:border dark:border-[#284c43]' : 'hover:bg-[#35635b]/10 dark:hover:bg-[#152420] text-[#35635b] dark:text-gray-300 dark:hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 {{ $currentRoute === 'pegawai.dashboard' ? 'text-white dark:text-emerald-400' : 'text-[#35635b] dark:text-emerald-400/80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Dashboard</span>
                </a>

                <!-- Pengajuan Agenda -->
                <a href="{{ route('pegawai.pengajuan.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ str_contains($currentRoute, 'pegawai.pengajuan') ? 'bg-[#35635b] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-md dark:border dark:border-[#284c43]' : 'hover:bg-[#35635b]/10 dark:hover:bg-[#152420] text-[#35635b] dark:text-gray-300 dark:hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 {{ str_contains($currentRoute, 'pegawai.pengajuan') ? 'text-white dark:text-emerald-400' : 'text-[#35635b] dark:text-emerald-400/80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Pengajuan Agenda</span>
                </a>

                <!-- Kalender Booking -->
                <a href="{{ route('pegawai.booking.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ str_contains($currentRoute, 'pegawai.booking') ? 'bg-[#35635b] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-md dark:border dark:border-[#284c43]' : 'hover:bg-[#35635b]/10 dark:hover:bg-[#152420] text-[#35635b] dark:text-gray-300 dark:hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 {{ str_contains($currentRoute, 'pegawai.booking') ? 'text-white dark:text-emerald-400' : 'text-[#35635b] dark:text-emerald-400/80' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="3" y="4" width="18" height="17" rx="3.5" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-width="2.5" d="M8 2v4M16 2v4M3 9h18"/>
                        <path stroke-linecap="round" stroke-width="2.5" d="M7 13h2M11 13h2M15 13h2M7 17h2M11 17h2"/>
                    </svg>
                    <span>Kalender Booking</span>
                </a>

                <!-- History Rapat -->
                <a href="{{ route('pegawai.history.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ str_contains($currentRoute, 'pegawai.history') ? 'bg-[#35635b] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-md dark:border dark:border-[#284c43]' : 'hover:bg-[#35635b]/10 dark:hover:bg-[#152420] text-[#35635b] dark:text-gray-300 dark:hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 {{ str_contains($currentRoute, 'pegawai.history') ? 'text-white dark:text-emerald-400' : 'text-[#35635b] dark:text-emerald-400/80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>History Rapat</span>
                </a>

                <!-- Data Diri -->
                <a href="{{ route('pegawai.profil.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all {{ str_contains($currentRoute, 'pegawai.profil') ? 'bg-[#35635b] dark:bg-[#1a332d] text-white dark:text-emerald-400 font-bold shadow-md dark:border dark:border-[#284c43]' : 'hover:bg-[#35635b]/10 dark:hover:bg-[#152420] text-[#35635b] dark:text-gray-300 dark:hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 {{ str_contains($currentRoute, 'pegawai.profil') ? 'text-white dark:text-emerald-400' : 'text-[#35635b] dark:text-emerald-400/80' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Data Diri</span>
                </a>
            </nav>
        </div>

        <!-- Bottom: Logout -->
        <div class="px-3 py-4 border-t border-gray-100 dark:border-[#233a34]">
            <form method="POST" action="{{ route('pegawai.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 rounded-xl text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all text-sm font-semibold cursor-pointer">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Navbar -->
        @php
            $navTitle = match(true) {
                str_contains($currentRoute, 'dashboard') => 'Dashboard',
                str_contains($currentRoute, 'pengajuan') => 'Pengajuan Agenda',
                str_contains($currentRoute, 'booking') => 'Kalender Booking',
                str_contains($currentRoute, 'history') => 'History Rapat',
                str_contains($currentRoute, 'profil') => 'Data Diri',
                default => 'Portal Pegawai',
            };
            $navSubtitle = match(true) {
                str_contains($currentRoute, 'dashboard') => 'Ringkasan aktivitas dan agenda rapat Anda.',
                str_contains($currentRoute, 'pengajuan') => 'Ajukan pengajuan agenda rapat baru ke admin.',
                str_contains($currentRoute, 'booking') => 'Lihat ketersediaan ruang rapat dan jadwal.',
                str_contains($currentRoute, 'history') => 'Riwayat kehadiran rapat yang telah Anda ikuti.',
                str_contains($currentRoute, 'profil') => 'Kelola informasi data diri dan akun Anda.',
                default => 'Selamat datang di Portal Pegawai RAPID.',
            };
        @endphp

        <header class="bg-white dark:bg-[#152420] px-3 sm:px-8 py-3 flex items-center justify-between shadow-xs z-30 transition-colors duration-200 min-h-[64px] sm:min-h-[72px]">
            <div class="flex items-center space-x-2 sm:space-x-3.5 min-w-0 pr-2">
                <button onclick="toggleSidebar()" class="md:hidden p-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 focus:outline-none shrink-0 transition-colors cursor-pointer" title="Menu Navigasi">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="flex flex-col min-w-0 justify-center">
                    <h1 class="text-base sm:text-2xl font-black text-[#1F2937] dark:text-white tracking-tight leading-tight truncate">
                        @yield('header_title', $navTitle)
                    </h1>
                    <p class="hidden xs:block text-[11px] sm:text-xs text-gray-500 dark:text-gray-300 font-medium leading-snug truncate mt-0.5">
                        @yield('header_subtitle', $navSubtitle)
                    </p>
                </div>
            </div>

            <!-- Right: Theme Toggle + Profile -->
            <div class="flex items-center space-x-2 sm:space-x-3 shrink-0">
                <!-- Theme Toggle -->
                <button onclick="toggleSirapiTheme()" class="p-2 rounded-xl text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 transition-colors cursor-pointer" title="Ubah Tema">
                    <svg data-theme-icon-dark class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg data-theme-icon-light class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                <!-- Profile Badge -->
                <div class="flex items-center gap-2 sm:gap-3 bg-gray-50 dark:bg-[#1a2d29] rounded-xl px-3 py-2 border border-gray-100 dark:border-[#233a34]">
                    @php
                        $fotoUrl = null;
                        if ($pegawaiUser && $pegawaiUser->foto) {
                            $fotoUrl = route('storage.media', $pegawaiUser->foto);
                        }
                    @endphp
                    <div class="w-8 h-8 rounded-full bg-[#35635b] flex items-center justify-center text-white font-bold text-xs overflow-hidden shrink-0">
                        @if($fotoUrl)
                            <img src="{{ $fotoUrl }}" alt="Foto" class="w-full h-full object-cover">
                        @else
                            {{ $pegawaiUser ? strtoupper(substr($pegawaiUser->nama_pegawai, 0, 1)) : 'P' }}
                        @endif
                    </div>
                    <div class="hidden sm:block min-w-0">
                        <p class="text-xs font-bold text-gray-800 dark:text-white truncate max-w-[120px]">{{ $pegawaiUser->nama_pegawai ?? 'Pegawai' }}</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-400 truncate max-w-[120px]">{{ $pegawaiUser->jabatan ?? 'Staf' }}</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-[#FAFAFA] dark:bg-[#121d1a]">
            @if (session('success'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-5 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-700">
                    {{ session('warning') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                if (modal.parentElement && modal.parentElement !== document.body) document.body.appendChild(modal);
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }
        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) { modal.classList.remove('flex'); modal.classList.add('hidden'); }
        }
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-menu');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar && overlay) { sidebar.classList.toggle('-translate-x-full'); overlay.classList.toggle('hidden'); }
        }
        function teleportModalsToBody() {
            document.querySelectorAll('div[id^="modal-"], div[id*="-modal"]').forEach(modal => {
                if (modal.parentElement && modal.parentElement !== document.body) document.body.appendChild(modal);
            });
        }
        document.addEventListener('DOMContentLoaded', teleportModalsToBody);
        window.addEventListener('load', teleportModalsToBody);
    </script>
    @stack('scripts')
</body>
</html>
