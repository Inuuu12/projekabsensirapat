@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { color: #0b302d; background: #f8faf9; }
        .scrollbar-soft::-webkit-scrollbar { width: 8px; height: 8px; }
        .scrollbar-soft::-webkit-scrollbar-thumb { background: #cbd8d6; border-radius: 999px; }
    </style>
@endif
<link rel="stylesheet" href="{{ asset('assets/admin-ui.css') }}">
