<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - e-Agenda</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @stack('styles')
</head>
<body class="flex min-h-screen bg-gray-100 font-sans antialiased">
    @include('admin.layout.sidebar')

    <main class="flex-1 p-8">
        @include('admin.layout.navbar')
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
