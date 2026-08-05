<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Presensi Pegawai - SIRAPI</title>
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
                            green2: '#1F7D73',
                            ink: '#14211F',
                            line: '#E7E2DA',
                            paper: '#FBFAF8',
                            gold: '#F2B84B',
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
    @php
        $agendaAktif = $agenda ?? null;
        $sudahHadir = (bool) ($kehadiran ?? false);
        $hadirPada = $sudahHadir
            ? \Carbon\Carbon::parse($kehadiran->created_at)->timezone('Asia/Jakarta')->format('H:i')
            : null;
        $tanggalAgenda = $agendaAktif?->tanggal
            ? $agendaAktif->tanggal->translatedFormat('l, d F Y')
            : '-';
        $waktuMulai = substr((string) $agendaAktif?->waktu, 0, 5) ?: '-';
        $waktuSelesai = substr((string) $agendaAktif?->waktu_selesai, 0, 5);
        $waktuAgenda = $waktuMulai . ($waktuSelesai ? ' - ' . $waktuSelesai : '') . ' WIB';
        $namaDepan = trim(explode(' ', $pegawai->nama_pegawai)[0] ?? $pegawai->nama_pegawai);
        $initials = collect(explode(' ', $pegawai->nama_pegawai))->filter()->take(2)->map(fn ($part) => strtoupper(substr($part, 0, 1)))->implode('');
        $fotoPegawai = $pegawai->foto
            ? (str_starts_with($pegawai->foto, 'foto/') ? asset($pegawai->foto) : asset('storage/' . $pegawai->foto))
            : null;
        $routeParams = $agendaAktif ? ['agenda_id' => $agendaAktif->id_agenda] : [];
        $lampiranAgenda = $agendaAktif?->lampiran ? basename($agendaAktif->lampiran) : null;
    @endphp

    <header class="h-[72px] bg-sirapi-green text-white">
        <div class="mx-auto flex h-full w-full max-w-[700px] items-center justify-between px-4 sm:px-6">
            <a href="{{ route('publik.beranda') }}" class="flex min-w-0 items-center gap-3">
                <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Kabupaten Bogor" class="h-11 w-11 shrink-0 object-contain">
                <span class="min-w-0">
                    <span class="block text-[11px] font-medium leading-tight text-white/90">Dinas Komunikasi & Informatika</span>
                    <span class="block text-lg font-extrabold leading-tight tracking-wide">SIRAPI</span>
                </span>
            </a>

            <div class="relative" data-profile-menu>
                <button type="button" data-toggle-profile-menu class="flex items-center gap-2 rounded-full py-1 pl-1 pr-2 transition hover:bg-white/10" title="Menu profil">
                    <span class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-white/15 text-sm font-extrabold ring-2 ring-white/20">
                        @if ($fotoPegawai)
                            <img src="{{ $fotoPegawai }}" alt="{{ $pegawai->nama_pegawai }}" class="h-full w-full object-cover">
                        @else
                            {{ $initials ?: 'P' }}
                        @endif
                    </span>
                    <span class="hidden text-left sm:block">
                        <span class="block max-w-24 truncate text-sm font-extrabold">{{ $namaDepan }}</span>
                        <span class="block text-[11px] font-medium leading-tight text-white/90">{{ $pegawai->jabatan ?: 'Pegawai' }}</span>
                    </span>
                    <i data-lucide="chevron-down" class="h-4 w-4 text-white/80"></i>
                </button>

                <div data-profile-dropdown class="absolute right-0 top-12 z-40 hidden w-48 overflow-hidden rounded-xl border border-gray-100 bg-white py-2 text-sirapi-ink shadow-xl">
                    <button type="button" data-open-profile class="flex w-full items-center gap-2 px-4 py-2.5 text-left text-sm font-bold transition hover:bg-gray-50">
                        <i data-lucide="user-pen" class="h-4 w-4 text-sirapi-green"></i>
                        <span>Edit Profil</span>
                    </button>
                    <form action="{{ route('pegawai.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-left text-sm font-bold text-red-600 transition hover:bg-red-50">
                            <i data-lucide="power" class="h-4 w-4"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="mx-auto w-full max-w-[700px] px-4 pb-16 pt-16 sm:px-6">
        @if ($errors->has('presensi'))
            <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-bold text-red-700">
                {{ $errors->first('presensi') }}
            </div>
        @endif

        @if (session('profile_success'))
            <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-700">
                {{ session('profile_success') }}
            </div>
        @endif

        <section class="rounded-[22px] border border-sirapi-line bg-white px-8 py-5 shadow-[3px_4px_4px_rgba(0,0,0,0.22)] sm:px-9">
            <h1 class="text-base font-extrabold">Informasi Kegiatan</h1>

            <div class="mt-5 divide-y divide-sirapi-line">
                <div class="pb-3">
                    <p class="text-[11px] font-medium uppercase text-[#AAB2AE]">Waktu</p>
                    <p class="mt-1 text-sm font-extrabold">{{ $agendaAktif ? $waktuAgenda : '-' }}</p>
                </div>
                <div class="py-3">
                    <p class="text-[11px] font-medium uppercase text-[#AAB2AE]">Tanggal</p>
                    <p class="mt-1 text-sm font-extrabold">{{ $tanggalAgenda }}</p>
                </div>
                <div class="py-3">
                    <p class="text-[11px] font-medium uppercase text-[#AAB2AE]">Lokasi</p>
                    <p class="mt-1 text-sm font-extrabold">{{ $agendaAktif?->lokasi ?? '-' }}</p>
                </div>
                <div class="pt-3">
                    <p class="text-[11px] font-medium uppercase text-[#AAB2AE]">Penyelenggara</p>
                    <p class="mt-1 text-sm font-extrabold">{{ $agendaAktif?->asal_surat ?: $agendaAktif?->ditugaskan ?: 'Bidang Informasi Publik' }}</p>
                </div>
            </div>
        </section>

        <section class="mt-14 flex justify-center">
            @if (! $agendaAktif)
                <div class="w-full max-w-[450px] rounded-2xl border border-amber-200 bg-amber-50 px-8 py-5 text-center">
                    <p class="text-sm font-extrabold text-amber-800">Agenda belum tersedia</p>
                    <p class="mt-1 text-xs font-medium text-amber-700">Silakan pilih agenda publik atau hubungi admin.</p>
                </div>
            @elseif ($sudahHadir)
                <div class="flex min-h-[64px] w-full max-w-[450px] items-center gap-7 rounded-2xl border-[3px] border-[#23D93D] px-9 py-4 text-[#16D934]">
                    <i data-lucide="circle-check" class="h-7 w-7 shrink-0 stroke-[2.4]"></i>
                    <div>
                        <p class="text-sm font-extrabold leading-tight">Presensi telah berhasil</p>
                        <p class="text-[11px] font-medium leading-tight">Tercatat pada jam {{ $hadirPada }} WIB</p>
                    </div>
                </div>
            @else
                <form action="{{ route('pegawai.presensi.submit', $routeParams) }}" method="POST" class="w-full max-w-[445px]">
                    @csrf
                    <button type="submit" class="flex min-h-[96px] w-full items-center gap-5 rounded-2xl bg-gradient-to-r from-sirapi-green to-sirapi-green2 px-6 text-left text-white shadow-sm transition hover:brightness-105 focus:outline-none focus:ring-4 focus:ring-sirapi-green/20">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/15">
                            <i data-lucide="scan-line" class="h-7 w-7"></i>
                        </span>
                        <span>
                            <span class="block text-base font-extrabold">Presensi</span>
                            <span class="mt-1 block text-xs font-medium text-white/80">Tekan untuk mencatat kehadiran</span>
                        </span>
                    </button>
                </form>
            @endif
        </section>

        <section class="mt-16 px-8 sm:px-9">
            <h2 class="text-lg font-extrabold">Lampiran</h2>
            <div class="mt-3 grid gap-4 sm:grid-cols-2">
                @forelse ($dokumen as $item)
                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" rel="noopener" class="flex min-h-[53px] items-center gap-3 rounded-xl border border-sirapi-line bg-white px-4 transition hover:border-sirapi-green">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#FFE6BB] text-[10px] font-extrabold text-[#D58A18]">PDF</span>
                        <span class="min-w-0">
                            <span class="block truncate text-xs font-extrabold">{{ $item->nama_file ?: basename($item->file_path) }}</span>
                            <span class="block text-[11px] font-medium text-[#9CA5A0]">{{ strtoupper(pathinfo($item->file_path, PATHINFO_EXTENSION) ?: 'FILE') }}</span>
                        </span>
                    </a>
                @empty
                    @if ($lampiranAgenda)
                        <a href="{{ route('publik.agenda.lampiran.file', $agendaAktif->id_agenda) }}" target="_blank" rel="noopener" class="flex min-h-[53px] items-center gap-3 rounded-xl border border-sirapi-line bg-white px-4 transition hover:border-sirapi-green">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#FFE6BB] text-[10px] font-extrabold text-[#D58A18]">PDF</span>
                            <span class="min-w-0">
                                <span class="block truncate text-xs font-extrabold">{{ $lampiranAgenda }}</span>
                                <span class="block text-[11px] font-medium text-[#9CA5A0]">{{ strtoupper(pathinfo($lampiranAgenda, PATHINFO_EXTENSION) ?: 'FILE') }}</span>
                            </span>
                        </a>
                    @else
                        <p class="text-sm font-medium text-[#9CA5A0]">Tidak ada lampiran.</p>
                    @endif
                @endforelse
            </div>
        </section>
    </main>

    <div data-profile-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-black/45 px-4 py-6">
        <section class="max-h-full w-full max-w-xl overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-extrabold">Edit Profil</h2>
                    <p class="mt-1 text-xs font-medium text-gray-500">{{ $pegawai->email }}</p>
                </div>
                <button type="button" data-close-profile class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 transition hover:bg-gray-200" title="Tutup">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            @if ($errors->any() && ! $errors->has('presensi'))
                <div class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('pegawai.profil.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 grid gap-4 sm:grid-cols-2">
                @csrf
                @method('PUT')

                <label class="sm:col-span-2">
                    <span class="text-xs font-extrabold uppercase text-gray-500">Foto</span>
                    <input type="file" name="foto" accept="image/*" class="mt-2 block w-full rounded-xl border border-gray-200 px-3 py-2 text-sm font-medium">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Nama</span>
                    <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}" required class="mt-2 h-11 w-full rounded-xl border border-gray-200 px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">NIP</span>
                    <input type="text" name="nip" value="{{ old('nip', $pegawai->nip) }}" required pattern="[0-9]+" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="mt-2 h-11 w-full rounded-xl border border-gray-200 px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Jabatan</span>
                    <select name="jabatan" required class="mt-2 h-11 w-full rounded-xl border border-gray-200 bg-white px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                        <option value="">Pilih jabatan</option>
                        @foreach ($jabatanOptions->merge([$pegawai->jabatan])->filter()->unique() as $jabatan)
                            <option value="{{ $jabatan }}" @selected(old('jabatan', $pegawai->jabatan) === $jabatan)>{{ $jabatan }}</option>
                        @endforeach
                    </select>
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Bidang</span>
                    <select name="bidang" class="mt-2 h-11 w-full rounded-xl border border-gray-200 bg-white px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                        <option value="">Pilih bidang</option>
                        @foreach ($bidangOptions->merge([$pegawai->bidang])->filter()->unique() as $bidang)
                            <option value="{{ $bidang }}" @selected(old('bidang', $pegawai->bidang) === $bidang)>{{ $bidang }}</option>
                        @endforeach
                    </select>
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">No. HP</span>
                    <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $pegawai->nomor_hp) }}" pattern="[0-9]+" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="mt-2 h-11 w-full rounded-xl border border-gray-200 px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Email</span>
                    <input type="email" name="email" value="{{ old('email', $pegawai->email) }}" required class="mt-2 h-11 w-full rounded-xl border border-gray-200 px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Password Baru</span>
                    <input type="password" name="password" class="mt-2 h-11 w-full rounded-xl border border-gray-200 px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                </label>

                <label>
                    <span class="text-xs font-extrabold uppercase text-gray-500">Konfirmasi Password</span>
                    <input type="password" name="password_confirmation" class="mt-2 h-11 w-full rounded-xl border border-gray-200 px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                </label>

                <div>
                    <span class="text-xs font-extrabold uppercase text-gray-500">OTP Password</span>
                    <div class="mt-2 flex gap-2">
                        <input type="text" name="password_otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" class="h-11 min-w-0 flex-1 rounded-xl border border-gray-200 px-3 text-sm font-bold outline-none focus:border-sirapi-green">
                        <button type="button" data-send-password-otp class="h-11 shrink-0 rounded-xl bg-sirapi-green px-4 text-xs font-extrabold text-white transition hover:bg-sirapi-green2">Kirim OTP</button>
                    </div>
                    <p data-password-otp-status class="mt-2 hidden text-xs font-bold"></p>
                </div>

                <div class="flex justify-end gap-3 sm:col-span-2">
                    <button type="button" data-close-profile class="rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-extrabold text-gray-600 transition hover:bg-gray-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-sirapi-green px-5 py-2.5 text-sm font-extrabold text-white transition hover:bg-sirapi-green2">Simpan</button>
                </div>
            </form>
        </section>
    </div>

    <script>
        lucide.createIcons();

        const profileModal = document.querySelector('[data-profile-modal]');
        const profileMenu = document.querySelector('[data-profile-menu]');
        const profileDropdown = document.querySelector('[data-profile-dropdown]');
        const toggleProfileMenuButton = document.querySelector('[data-toggle-profile-menu]');
        const openProfileButtons = document.querySelectorAll('[data-open-profile]');
        const closeProfileButtons = document.querySelectorAll('[data-close-profile]');
        const sendPasswordOtpButton = document.querySelector('[data-send-password-otp]');
        const passwordOtpStatus = document.querySelector('[data-password-otp-status]');

        function showPasswordOtpStatus(message, isSuccess) {
            if (!passwordOtpStatus) return;

            passwordOtpStatus.textContent = message;
            passwordOtpStatus.classList.remove('hidden', 'text-red-600', 'text-sirapi-green');
            passwordOtpStatus.classList.add(isSuccess ? 'text-sirapi-green' : 'text-red-600');
        }

        function closeProfileDropdown() {
            profileDropdown?.classList.add('hidden');
        }

        function openProfileModal() {
            closeProfileDropdown();
            profileModal.classList.remove('hidden');
            profileModal.classList.add('flex');
        }

        function closeProfileModal() {
            profileModal.classList.add('hidden');
            profileModal.classList.remove('flex');
        }

        openProfileButtons.forEach((button) => button.addEventListener('click', openProfileModal));
        closeProfileButtons.forEach((button) => button.addEventListener('click', closeProfileModal));
        toggleProfileMenuButton?.addEventListener('click', (event) => {
            event.stopPropagation();
            profileDropdown.classList.toggle('hidden');
        });
        document.addEventListener('click', (event) => {
            if (profileMenu && !profileMenu.contains(event.target)) {
                closeProfileDropdown();
            }
        });
        profileModal.addEventListener('click', (event) => {
            if (event.target === profileModal) {
                closeProfileModal();
            }
        });

        sendPasswordOtpButton?.addEventListener('click', async () => {
            sendPasswordOtpButton.disabled = true;
            sendPasswordOtpButton.textContent = 'Mengirim...';
            showPasswordOtpStatus('Mengirim kode OTP...', true);

            try {
                const response = await fetch('{{ route('pegawai.profil.password-otp') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({}),
                });
                const data = await response.json();

                showPasswordOtpStatus(data.message || 'Kode OTP sudah dikirim.', response.ok && data.success);
            } catch (error) {
                showPasswordOtpStatus('OTP gagal dikirim. Coba lagi nanti.', false);
            } finally {
                sendPasswordOtpButton.disabled = false;
                sendPasswordOtpButton.textContent = 'Kirim OTP';
            }
        });

        @if ($errors->any() && ! $errors->has('presensi'))
            openProfileModal();
        @endif
    </script>
</body>
</html>
