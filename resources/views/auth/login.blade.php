<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - e-Agenda</title>
    @include('partials.frontend-assets')
</head>
<body>
    <main class="login-shell">
        <section class="login-brand">
            <div class="login-brand-inner">
                <h1>Login Admin</h1>
                <img src="{{ asset('assets/bappenda-logo.png') }}" alt="Bappenda Kabupaten Bogor" class="login-logo">
                <div class="brand-name">BAPPENDA</div>
                <div class="brand-region">KABUPATEN BOGOR</div>
                <div class="app-name">e-Agenda</div>
                <p class="app-subtitle">Sistem Agenda Kegiatan Dinas Kab. Bogor</p>
                <div class="login-version">
                    <div>Versi 1.0</div>
                    <div>&copy; 2026 Bappenda Kabupaten Bogor</div>
                </div>
            </div>
        </section>

        <section class="login-form-wrap">
            <form method="POST" action="{{ route('admin.login.submit') }}" class="login-form">
                @csrf
                <div class="login-title">
                    <h2>Selamat Datang</h2>
                    <p>Silakan login menggunakan email resmi Anda.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">{{ $errors->first() }}</div>
                @endif

                <label class="field-label" for="username">Email</label>
                <input id="username" name="username" type="text" value="{{ old('username') }}" class="field" style="margin-bottom: 16px;" autocomplete="username" required>

                <label class="field-label" for="password">Kata sandi</label>
                <div class="password-wrap">
                    <input id="password" name="password" type="password" class="field" autocomplete="current-password" required>
                    <button type="button" data-password-toggle="password" class="icon-inside" aria-label="Tampilkan kata sandi">
                        @include('partials.icon', ['name' => 'eye', 'class' => 'h-5 w-5'])
                    </button>
                </div>

                <button type="submit" class="btn-login">Log Masuk</button>
            </form>
        </section>
    </main>
    @include('partials.frontend-scripts')
</body>
</html>
