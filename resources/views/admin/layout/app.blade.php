<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - e-Agenda</title>
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-gray-900 flex overflow-hidden">

    <!-- Sidebar Layout -->
    @include('admin.layout.sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Navbar Layout -->
        @include('admin.layout.navbar')

        <!-- Scrollable Content Page -->
        <main class="flex-1 overflow-y-auto p-8 bg-gray-50">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
