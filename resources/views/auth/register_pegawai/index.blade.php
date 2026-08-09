<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pegawai - SIRAPI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sirapi: {
                            green: '#155B53',
                            greenSoft: '#246F66',
                            ink: '#14211F',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-white font-sans text-sirapi-ink antialiased">
    <header class="relative flex h-[220px] items-center justify-center overflow-hidden bg-sirapi-green text-white">
        <div class="absolute -left-20 -top-24 h-72 w-72 rounded-full bg-white/10"></div>
        <div class="relative flex flex-col items-center text-center">
            <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Kabupaten Bogor" class="h-24 w-auto drop-shadow">
            <h1 class="mt-4 text-2xl font-extrabold tracking-wide">SIRAPI</h1>
            <p class="mt-2 text-sm font-bold">Daftar Akun Pegawai</p>
        </div>
    </header>

    <main class="flex min-h-[calc(100vh-220px)] justify-center px-6 py-10">
        <section class="w-full max-w-2xl">
            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pegawai.register.submit') }}" method="POST" class="grid gap-5 rounded-2xl border border-[#DDE3DF] bg-white p-6 shadow-sm sm:grid-cols-2">
                @csrf

                <label class="sm:col-span-2">
                    <span class="text-xs font-extrabold uppercase text-gray-500">Nama Lengkap</span>
                    <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai') }}" required autofocus
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] px-4 text-sm font-semibold outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="Nama pegawai">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">NIP</span>
                    <input type="text" name="nip" value="{{ old('nip') }}" required pattern="[0-9]+" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] px-4 text-sm font-semibold outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="Nomor induk pegawai">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Tanggal Lahir</span>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] px-4 text-sm font-semibold outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Jabatan</span>
                    <select name="jabatan" required
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] bg-white px-4 text-sm font-semibold outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15">
                        <option value="">Pilih jabatan</option>
                        @foreach ($jabatanOptions as $jabatan)
                            <option value="{{ $jabatan }}" @selected(old('jabatan') === $jabatan)>{{ $jabatan }}</option>
                        @endforeach
                    </select>
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Bidang</span>
                    <select name="bidang"
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] bg-white px-4 text-sm font-semibold outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15">
                        <option value="">Pilih bidang</option>
                        @foreach ($bidangOptions as $bidang)
                            <option value="{{ $bidang }}" @selected(old('bidang') === $bidang)>{{ $bidang }}</option>
                        @endforeach
                    </select>
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">No. HP</span>
                    <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}" required pattern="[0-9]+" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] px-4 text-sm font-semibold outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="08xxxxxxxxxx">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] px-4 text-sm font-semibold outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="Masukkan email anda">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Password</span>
                    <input type="password" name="password" required minlength="8"
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] px-4 text-sm font-semibold outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="Minimal 8 karakter">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Konfirmasi Password</span>
                    <input type="password" name="password_confirmation" required
                        class="mt-2 h-12 w-full rounded-lg border border-[#DDE3DF] px-4 text-sm font-semibold outline-none transition focus:border-sirapi-green focus:ring-2 focus:ring-sirapi-green/15"
                        placeholder="Ulangi password">
                </label>

                <div class="flex flex-col gap-3 pt-2 sm:col-span-2 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('pegawai.login') }}" class="text-sm font-bold text-[#27364A] hover:text-sirapi-green">
                        Sudah punya akun?
                    </a>
                    <button type="submit" class="h-12 rounded-lg bg-sirapi-green px-8 text-sm font-extrabold text-white shadow-sm transition hover:bg-sirapi-greenSoft focus:outline-none focus:ring-2 focus:ring-sirapi-green/25">
                        Daftar
                    </button>
                </div>
            </form>
        </section>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
