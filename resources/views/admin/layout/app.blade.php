<!DOCTYPE html>
<html lang="id" class="h-full bg-[#FAFAFA] dark:bg-[#121d1a]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SIRAPI</title>
    
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
            window.dispatchEvent(new CustomEvent('sirapi-theme-changed', { detail: { theme: newTheme } }));
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

    <!-- Tailwind CSS CDN dengan mode Dark Class -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'admin-bg-dark': '#0d1614',
                        'admin-card-dark': '#152420',
                        'admin-border-dark': '#233a34',
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom Scrollbars */
        ::-webkit-scrollbar { height: 6px; width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        .dark ::-webkit-scrollbar-track { background: #0d1614; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .dark ::-webkit-scrollbar-thumb { background: #284c43; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #35635b; }

        /* Mobile Form & Touch Scrolling Optimizations */
        .overflow-y-auto, .overflow-auto {
            -webkit-overflow-scrolling: touch;
        }
        @media (max-width: 640px) {
            input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]):not([type="hidden"]),
            select,
            textarea {
                font-size: 16px !important; /* Prevents unwanted auto-zoom on iOS Safari */
            }
        }

        /* =========================================================
           HIGH-CONTRAST DARK MODE RULES FOR ADMIN PANEL
           ========================================================= */
        .dark {
            color-scheme: dark;
        }
        .dark, .dark body, .dark main {
            background-color: #0d1614 !important;
            color: #f1f5f9 !important;
        }
        
        /* Cards & White Surfaces */
        .dark .bg-white {
            background-color: #152420 !important;
            color: #f1f5f9 !important;
            border-color: #233a34 !important;
        }
        .dark .bg-gray-50, 
        .dark .bg-slate-50, 
        .dark .bg-gray-50\/50, 
        .dark .bg-gray-50\/80 {
            background-color: #1a2d29 !important;
            color: #f1f5f9 !important;
        }

        /* Borders & Dividers */
        .dark .border-gray-100, 
        .dark .border-gray-200, 
        .dark .border-slate-100, 
        .dark .border-slate-200, 
        .dark .border-slate-300 {
            border-color: #233a34 !important;
        }
        .dark .divide-gray-100 > * + *, 
        .dark .divide-gray-200 > * + *,
        .dark .divide-slate-100 > * + * {
            border-color: #233a34 !important;
        }

        /* Headings & High Contrast Titles */
        .dark h1, 
        .dark h2, 
        .dark h3, 
        .dark h4, 
        .dark h5, 
        .dark h6 {
            color: #ffffff !important;
        }

        /* Secondary Text & Labels */
        .dark .text-gray-500, 
        .dark .text-gray-600, 
        .dark .text-gray-700, 
        .dark .text-gray-800, 
        .dark .text-slate-500, 
        .dark .text-slate-600, 
        .dark .text-slate-700, 
        .dark .text-slate-800 {
            color: #cbd5e1 !important;
        }
        .dark .text-gray-400, 
        .dark .text-slate-400 {
            color: #94a3b8 !important;
        }
        .dark .font-bold, 
        .dark .font-extrabold, 
        .dark .font-black {
            color: #ffffff;
        }

        /* Form Labels */
        .dark label {
            color: #e2e8f0;
        }

        /* Stat Numbers & Highlights */
        .dark .text-emerald-700, 
        .dark .text-green-700 {
            color: #34d399 !important;
        }

        /* Table Header & Rows */
        .dark thead tr {
            background-color: #1b3832 !important;
            color: #ffffff !important;
        }
        .dark thead th {
            color: #ffffff !important;
            border-bottom: 1px solid #233a34 !important;
        }
        .dark tbody tr {
            border-bottom-color: #233a34 !important;
        }
        .dark tbody tr:hover {
            background-color: #1b332d !important;
        }
        .dark tbody td {
            color: #e2e8f0 !important;
        }

        /* Badges / Status Pills */
        .dark .bg-emerald-50,
        .dark .bg-emerald-100 {
            background-color: rgba(6, 78, 59, 0.5) !important;
            color: #6ee7b7 !important;
            border: 1px solid rgba(16, 185, 129, 0.4) !important;
        }
        .dark .bg-amber-50,
        .dark .bg-amber-100,
        .dark .bg-yellow-50 {
            background-color: rgba(120, 53, 15, 0.5) !important;
            color: #fcd34d !important;
            border: 1px solid rgba(245, 158, 11, 0.4) !important;
        }
        .dark .bg-red-50,
        .dark .bg-red-100 {
            background-color: rgba(127, 29, 29, 0.5) !important;
            color: #fca5a5 !important;
            border: 1px solid rgba(239, 68, 68, 0.4) !important;
        }
        .dark .bg-blue-50,
        .dark .bg-blue-100 {
            background-color: rgba(30, 58, 138, 0.5) !important;
            color: #93c5fd !important;
            border: 1px solid rgba(59, 130, 246, 0.4) !important;
        }
        .dark .bg-green-50,
        .dark .bg-green-100 {
            background-color: #1a332d !important;
            color: #6ee7b7 !important;
            border: 1px solid #284c43 !important;
        }
        .dark .bg-gray-100,
        .dark .bg-gray-200,
        .dark .bg-slate-100,
        .dark .bg-slate-200 {
            background-color: #1a2e29 !important;
            color: #e2e8f0 !important;
            border: 1px solid #35584f !important;
        }

        /* Inputs, Selects & Textareas */
        .dark input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]):not([type="hidden"]),
        .dark select,
        .dark textarea {
            background-color: #0f1c19 !important;
            border-color: #284c43 !important;
            color: #ffffff !important;
        }
        .dark input::placeholder, 
        .dark textarea::placeholder {
            color: #64748b !important;
        }
        .dark select option,
        .dark select optgroup {
            background-color: #0f1c19 !important;
            color: #ffffff !important;
        }
        .dark select optgroup {
            font-weight: 800 !important;
            color: #34d399 !important;
        }

        /* Focus states in Dark Mode */
        .dark input:focus,
        .dark select:focus,
        .dark textarea:focus {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25) !important;
        }

        /* Remove duplicate native picker indicator on the right so only the single left icon appears */
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator,
        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            opacity: 0;
            cursor: pointer;
        }

        /* File Upload Buttons in Dark Mode */
        .dark input[type="file"]::file-selector-button {
            background-color: #107050 !important;
            color: #ffffff !important;
            border: 0 !important;
            border-radius: 0.5rem !important;
            padding: 0.375rem 0.875rem !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            transition: background-color 0.2s ease;
        }
        .dark input[type="file"]::file-selector-button:hover {
            background-color: #0c5940 !important;
        }

        /* Checkboxes & Radios in Dark Mode */
        .dark input[type="checkbox"],
        .dark input[type="radio"] {
            background-color: #0f1c19 !important;
            border-color: #284c43 !important;
        }
        .dark input[type="checkbox"]:checked,
        .dark input[type="radio"]:checked {
            background-color: #04733f !important;
            border-color: #10b981 !important;
        }
        /* Modal Dialog Headers & Footers in Dark Mode */
        .dark .bg-\[\#3f8078\],
        .dark .bg-\[\#0f513f\] {
            background-color: #163830 !important;
            border-bottom: 1px solid #284c43 !important;
        }

        /* Form Labels in Dark Mode */
        .dark form label,
        .dark .modal-label {
            color: #e2e8f0 !important;
        }

        /* Action & Submit Buttons inside Modals in Dark Mode */
        .dark button[type="submit"].bg-\[\#04733f\],
        .dark a.bg-\[\#04733f\],
        .dark button.bg-\[\#04733f\] {
            background-color: #107050 !important;
            border: 1px solid rgba(52, 211, 153, 0.2) !important;
        }
        .dark button[type="submit"].bg-\[\#04733f\]:hover,
        .dark a.bg-\[\#04733f\]:hover,
        .dark button.bg-\[\#04733f\]:hover {
            background-color: #0c5940 !important;
        }

        /* Cancel Buttons inside Modals in Dark Mode */
        .dark .modal-btn-cancel {
            background-color: #0f1c19 !important;
            border: 1px solid #284c43 !important;
            color: #cbd5e1 !important;
        }
        .dark .modal-btn-cancel:hover {
            background-color: #1b332d !important;
            color: #ffffff !important;
        }

        /* =========================================================
           DARK MODE ICON & LOGO ENHANCEMENTS
           ========================================================= */
        .dark img[src*="Suratlogo.png"],
        .dark img[src*="Agendahariini.png"],
        .dark img[src*="Ruanganlogo.png"],
        .dark img[src*="Pengunjunglogo.png"],
        .dark img[src*="Lampiranlogo.png"],
        .dark img[src*="Totalagendalogo.png"],
        .dark img[src*="Total Aduan.png"],
        .dark img[src*="Menunggu.png"],
        .dark img[src*="process.png"],
        .dark img[src*="Selesai.png"],
        .dark img[src*="Selesailogo.png"],
        .dark img[src*="ruangantersedia.png"],
        .dark img[src*="ruanganterpakai.png"],
        .dark img[src*="totalruangan.png"],
        .dark img[src*="Beritalogo.png"],
        .dark img[src*="Videologo.png"],
        .dark img[src*="Galerilogo.png"],
        .dark img[src*="Lihatlogo.png"],
        .dark img[src*="Detaillogo.png"],
        .dark img[src*="Reply.png"],
        .dark img[src*="Kunjunganlogo.png"],
        .dark img[src*="Pegawailogo.png"],
        .dark img[src*="Container.png"],
        .dark img[src*="Akandatanglogo.png"],
        .dark img[src*="Agendalogo.png"] {
            filter: brightness(0) invert(1) !important;
            opacity: 0.95 !important;
        }

        /* Action Icon Highlights in Dark Mode */
        .dark img[src*="Editlogo.png"] {
            filter: brightness(1.2) drop-shadow(0 1px 2px rgba(251, 191, 36, 0.5)) !important;
        }
        .dark img[src*="Deletelogo.png"] {
            filter: brightness(1.2) drop-shadow(0 1px 2px rgba(248, 113, 113, 0.5)) !important;
        }

        /* Brand Seal Logo in Dark Mode */
        .dark img[src*="logo-bappenda.png"] {
            filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.6)) !important;
        }

        /* Enforce Exact Viewport Frame for all Modals */
        div[id^="modal-"],
        div[id*="-modal"] {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            width: 100dvw !important;
            height: 100vh !important;
            height: 100dvh !important;
            max-width: 100vw !important;
            max-height: 100dvh !important;
            margin: 0 !important;
            z-index: 9999 !important;
            box-sizing: border-box !important;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-gray-800 dark:text-slate-100 flex overflow-hidden bg-[#FAFAFA] dark:bg-[#0d1614] transition-colors duration-200">

    <!-- Sidebar Layout -->
    @include('admin.layout.sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Navbar Layout -->
        @include('admin.layout.navbar')

        <!-- Scrollable Content Page -->
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

    @include('admin.agenda.deletepopup')
    @include('admin.layout.document-preview-modal')

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar-menu');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        }

        // Teleport all modals to document.body to prevent flex/overflow offsets from <main>
        function teleportModalsToBody() {
            document.querySelectorAll('div[id^="modal-"], div[id*="-modal"]').forEach(modal => {
                if (modal.parentElement && modal.parentElement !== document.body) {
                    document.body.appendChild(modal);
                }
            });
        }
        document.addEventListener('DOMContentLoaded', teleportModalsToBody);
        window.addEventListener('load', teleportModalsToBody);
    </script>
    @stack('scripts')
</body>
</html>
