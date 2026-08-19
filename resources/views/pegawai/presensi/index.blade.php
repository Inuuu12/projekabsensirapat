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
            @elseif ($agendaAktif->status_label === 'Selesai')
                <div class="w-full max-w-[450px] rounded-2xl border border-amber-200 bg-amber-50 px-8 py-5 text-center">
                    <p class="text-sm font-extrabold text-amber-800">Agenda Rapat Telah Selesai</p>
                    <p class="mt-1 text-xs font-medium text-amber-700">Presensi untuk agenda rapat ini telah ditutup karena waktu rapat telah berakhir.</p>
                </div>
            @elseif (! $isDitugaskan)
                <div class="w-full max-w-[450px] rounded-2xl border border-red-200 bg-red-50 p-6 text-center space-y-2">
                    <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-full bg-red-100 text-red-600">
                        <i data-lucide="shield-alert" class="h-6 w-6"></i>
                    </div>
                    <p class="text-sm font-extrabold text-red-900">Akses Presensi Dibatasi</p>
                    <p class="text-xs font-medium text-red-700 leading-relaxed">
                        Agenda surat masuk ini hanya dikhususkan untuk pegawai yang ditugaskan:<br>
                        <span class="inline-block mt-1 font-bold text-red-900 bg-red-100/80 px-3 py-1 rounded-lg">{{ $agendaAktif->ditugaskan ?: '-' }}</span>
                    </p>
                </div>
            @else
                @if (empty($pegawai->face_descriptor))
                    <button type="button" data-open-face class="flex min-h-[96px] w-full max-w-[445px] items-center gap-5 rounded-2xl bg-gradient-to-r from-orange-500 to-orange-600 px-6 text-left text-white shadow-sm transition hover:brightness-105 focus:outline-none focus:ring-4 focus:ring-orange-500/20">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/15">
                            <i data-lucide="scan-face" class="h-7 w-7"></i>
                        </span>
                        <span>
                            <span class="block text-base font-extrabold">Daftarkan Wajah Dulu</span>
                            <span class="mt-1 block text-xs font-medium text-white/90">Wajib mendaftarkan wajah sebelum presensi</span>
                        </span>
                    </button>
                @else
                    <button type="button" data-open-presensi-face class="flex min-h-[96px] w-full max-w-[445px] items-center gap-5 rounded-2xl bg-gradient-to-r from-sirapi-green to-sirapi-green2 px-6 text-left text-white shadow-sm transition hover:brightness-105 focus:outline-none focus:ring-4 focus:ring-sirapi-green/20">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/15">
                            <i data-lucide="scan-line" class="h-7 w-7"></i>
                        </span>
                        <span>
                            <span class="block text-base font-extrabold">Presensi (Scan Wajah)</span>
                            <span class="mt-1 block text-xs font-medium text-white/80">Tekan untuk mulai scan wajah</span>
                        </span>
                    </button>
                    <!-- Hidden form to submit presensi later -->
                    <form id="form-presensi" action="{{ route('pegawai.presensi.submit', $routeParams) }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @endif
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

    <!-- Edit Profile Modal (Gaya Admin Popup) -->
    <div data-profile-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-3 sm:p-4">
        <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
            <!-- Header Popup Admin Style -->
            <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
                <div>
                    <h3 class="text-lg font-bold text-white">Edit Profil Pegawai</h3>
                    <p class="text-xs text-white/80 font-medium">{{ $pegawai->email }}</p>
                </div>
                <button type="button" data-close-profile class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" title="Tutup">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <form action="{{ route('pegawai.profil.update') }}" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
                @csrf
                @method('PUT')

                @if ($errors->any() && ! $errors->has('presensi'))
                    <div class="px-5 pt-4 sm:px-6">
                        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-xs font-semibold text-red-700">
                            {{ $errors->first() }}
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-x-4 gap-y-4 overflow-y-auto px-5 py-5 sm:grid-cols-2 sm:px-6">
                    <!-- Foto Profil -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-extrabold uppercase text-gray-500 mb-1">Foto Profil</label>
                        <input type="file" name="foto" accept="image/*" class="block w-full rounded-xl border border-gray-200 px-3 py-2 text-xs font-medium text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    </div>

                    <!-- Record Wajah Box -->
                    <div class="sm:col-span-2 rounded-xl border border-sirapi-green/20 bg-sirapi-green/5 p-3.5">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#3f8078] text-white shadow-sm">
                                    <i data-lucide="scan-face" class="h-5 w-5"></i>
                                </span>
                                <div>
                                    <span class="block text-xs font-extrabold text-[#35635b]">Record / Rekam Ulang Wajah</span>
                                    <span class="block text-[11px] font-medium text-gray-500">Ambil ulang foto wajah untuk presensi Face Recognition</span>
                                </div>
                            </div>
                            <button type="button" data-open-face class="shrink-0 rounded-xl bg-[#3f8078] px-3.5 py-2 text-xs font-extrabold text-white transition hover:bg-[#35635b]">
                                Rekam Wajah
                            </button>
                        </div>
                    </div>

                    <!-- Nama Pegawai -->
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-gray-500 mb-1">Nama Lengkap *</label>
                        <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}" required class="h-10 w-full rounded-xl border border-gray-200 px-3 text-xs font-bold text-gray-800 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    </div>

                    <!-- NIP -->
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-gray-500 mb-1">NIP *</label>
                        <input type="text" name="nip" value="{{ old('nip', $pegawai->nip) }}" required pattern="[0-9]+" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="h-10 w-full rounded-xl border border-gray-200 px-3 text-xs font-bold text-gray-800 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    </div>

                    <!-- Jabatan -->
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-gray-500 mb-1">Jabatan *</label>
                        <select name="jabatan" required class="h-10 w-full rounded-xl border border-gray-200 bg-white px-3 text-xs font-bold text-gray-800 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                            <option value="">Pilih jabatan</option>
                            @foreach ($jabatanOptions->merge([$pegawai->jabatan])->filter()->unique() as $jabatan)
                                <option value="{{ $jabatan }}" @selected(old('jabatan', $pegawai->jabatan) === $jabatan)>{{ $jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bidang -->
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-gray-500 mb-1">Bidang</label>
                        <select name="bidang" class="h-10 w-full rounded-xl border border-gray-200 bg-white px-3 text-xs font-bold text-gray-800 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                            <option value="">Pilih bidang</option>
                            @foreach ($bidangOptions->merge([$pegawai->bidang])->filter()->unique() as $bidang)
                                <option value="{{ $bidang }}" @selected(old('bidang', $pegawai->bidang) === $bidang)>{{ $bidang }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- No HP -->
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-gray-500 mb-1">No. HP / WhatsApp</label>
                        <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $pegawai->nomor_hp) }}" pattern="[0-9]+" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="h-10 w-full rounded-xl border border-gray-200 px-3 text-xs font-bold text-gray-800 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-gray-500 mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $pegawai->email) }}" required class="h-10 w-full rounded-xl border border-gray-200 px-3 text-xs font-bold text-gray-800 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-gray-500 mb-1">Password Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="h-10 w-full rounded-xl border border-gray-200 px-3 text-xs font-bold text-gray-800 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-gray-500 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="h-10 w-full rounded-xl border border-gray-200 px-3 text-xs font-bold text-gray-800 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    </div>

                    <!-- OTP Password -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-extrabold uppercase text-gray-500 mb-1">OTP Password (Diperlukan jika ubah password)</label>
                        <div class="flex gap-2">
                            <input type="text" name="password_otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" placeholder="Kode OTP 6 digit" class="h-10 min-w-0 flex-1 rounded-xl border border-gray-200 px-3 text-xs font-bold text-gray-800 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                            <button type="button" data-send-password-otp class="h-10 shrink-0 rounded-xl bg-[#3f8078] px-4 text-xs font-extrabold text-white transition hover:bg-[#35635b]">Kirim OTP</button>
                        </div>
                        <p data-password-otp-status class="mt-2 hidden text-xs font-bold"></p>
                    </div>
                </div>

                <!-- Footer Buttons Admin Style -->
                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50/50 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                    <button type="button" data-close-profile class="h-10 rounded-xl border border-gray-200 bg-white px-5 text-xs font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
                    <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#04733f] px-5 text-xs font-bold text-white transition hover:bg-[#035f35]">
                        <i data-lucide="save" class="h-4 w-4"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Face Registration Modal (Gaya Admin Popup) -->
    <div data-face-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-3 sm:p-4">
        <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-lg flex-col overflow-hidden rounded-2xl bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
            <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
                <div>
                    <h3 class="text-lg font-bold text-white">Daftarkan / Record Wajah</h3>
                    <p class="text-xs text-white/80 font-medium">Kamera Presensi Face Recognition</p>
                </div>
                <button type="button" data-close-face class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" title="Tutup">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <div class="p-5 sm:p-6 text-center space-y-4">
                <p class="text-xs text-gray-500 font-medium">Posisikan wajah Anda dengan jelas di tengah kamera, lalu klik tombol Ambil Wajah.</p>
                
                <div class="relative w-full aspect-[4/3] bg-gray-900 rounded-2xl overflow-hidden shadow-inner border border-gray-200">
                    <p id="face-status" class="absolute inset-0 flex items-center justify-center text-white text-xs font-medium z-10 animate-pulse px-4">Memuat kamera dan model...</p>
                    <video id="face-video" class="absolute top-0 left-0 w-full h-full object-cover hidden" style="transform: scaleX(-1);" autoplay muted playsinline></video>
                    <canvas id="face-overlay" class="absolute top-0 left-0 w-full h-full z-20 pointer-events-none" style="transform: scaleX(-1);"></canvas>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" data-close-face class="flex-1 h-10 rounded-xl border border-gray-200 bg-white text-xs font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
                    <button type="button" id="btn-capture-face" class="flex-1 inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#04733f] text-xs font-bold text-white transition hover:bg-[#035f35] hidden">
                        <i data-lucide="scan" class="h-4 w-4"></i>
                        <span>Ambil Wajah</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
                <i data-lucide="scan" class="inline-block h-4 w-4 mr-1"></i> Ambil Wajah
            </button>
        </section>
    </div>

    <!-- Presensi Face Scan Modal -->
    <div data-presensi-face-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-black/45 px-4 py-6">
        <section class="max-h-full w-full max-w-lg overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl relative text-center">
            <button type="button" data-close-presensi-face class="absolute top-4 right-4 text-gray-400 hover:text-gray-700">
                <i data-lucide="x" class="h-6 w-6"></i>
            </button>
            <h2 class="text-lg font-extrabold text-gray-900">Scan Wajah Presensi</h2>
            <p class="text-xs text-gray-500 mt-1 mb-4">Posisikan wajah Anda hingga sistem mengenali Anda.</p>
            
            <div class="relative w-full aspect-[4/3] bg-gray-900 rounded-xl overflow-hidden mb-4 shadow-inner">
                <p id="presensi-face-status" class="absolute inset-0 flex items-center justify-center text-white text-sm font-medium z-10 animate-pulse">Memuat kamera dan model...</p>
                <video id="presensi-face-video" class="absolute top-0 left-0 w-full h-full object-cover hidden" style="transform: scaleX(-1);" autoplay muted playsinline></video>
                <canvas id="presensi-face-overlay" class="absolute top-0 left-0 w-full h-full z-20 pointer-events-none" style="transform: scaleX(-1);"></canvas>
            </div>
        </section>
    </div>

    <script src="{{ asset('js/face-api.min.js') }}"></script>
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

        const faceModal = document.querySelector('[data-face-modal]');
        const openFaceButton = document.querySelector('[data-open-face]');
        const closeFaceButton = document.querySelector('[data-close-face]');
        const faceVideo = document.getElementById('face-video');
        const faceOverlay = document.getElementById('face-overlay');
        const faceStatus = document.getElementById('face-status');
        const btnCaptureFace = document.getElementById('btn-capture-face');
        let faceStream = null;

        async function openFaceModal() {
            closeProfileDropdown();
            faceModal.classList.remove('hidden');
            faceModal.classList.add('flex');
            
            try {
                await Promise.all([
                    faceapi.nets.ssdMobilenetv1.loadFromUri('/models'),
                    faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
                    faceapi.nets.faceRecognitionNet.loadFromUri('/models')
                ]);
                
                faceStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "user",
                        width: { ideal: 640 },
                        height: { ideal: 480 }
                    }
                });
                faceVideo.srcObject = faceStream;
                faceVideo.classList.remove('hidden');
                faceStatus.classList.add('hidden');
                btnCaptureFace.classList.remove('hidden');
            } catch (err) {
                console.error(err);
                faceStatus.innerText = "Gagal memuat kamera. Pastikan izin kamera telah diberikan di browser HP Anda.";
            }
        }

        function closeFaceModal() {
            faceModal.classList.add('hidden');
            faceModal.classList.remove('flex');
            if (faceStream) {
                faceStream.getTracks().forEach(track => track.stop());
                faceStream = null;
            }
            faceVideo.classList.add('hidden');
            btnCaptureFace.classList.add('hidden');
            faceStatus.classList.remove('hidden');
            faceStatus.innerText = "Memuat kamera dan model...";
            const ctx = faceOverlay.getContext('2d');
            ctx.clearRect(0, 0, faceOverlay.width, faceOverlay.height);
        }

        btnCaptureFace.addEventListener('click', async () => {
            btnCaptureFace.disabled = true;
            btnCaptureFace.innerHTML = 'Memproses...';

            const detection = await faceapi.detectSingleFace(faceVideo, new faceapi.SsdMobilenetv1Options({ minConfidence: 0.5 }))
                                           .withFaceLandmarks()
                                           .withFaceDescriptor();

            if (!detection) {
                alert("Wajah tidak terdeteksi. Pastikan wajah terlihat jelas di kamera.");
                btnCaptureFace.disabled = false;
                btnCaptureFace.innerHTML = '<i data-lucide="scan" class="inline-block h-4 w-4 mr-1"></i> Ambil Wajah';
                lucide.createIcons();
                return;
            }

            // Draw box on overlay
            const displaySize = { width: faceVideo.videoWidth, height: faceVideo.videoHeight };
            faceapi.matchDimensions(faceOverlay, displaySize);
            const resizedDetection = faceapi.resizeResults(detection, displaySize);
            const ctx = faceOverlay.getContext('2d');
            ctx.clearRect(0, 0, faceOverlay.width, faceOverlay.height);
            faceapi.draw.drawDetections(faceOverlay, resizedDetection);

            const descriptorArray = Array.from(detection.descriptor);
            
            // Capture image
            const captureCanvas = document.createElement('canvas');
            captureCanvas.width = faceVideo.videoWidth;
            captureCanvas.height = faceVideo.videoHeight;
            const captureCtx = captureCanvas.getContext('2d');
            captureCtx.drawImage(faceVideo, 0, 0, captureCanvas.width, captureCanvas.height);
            const dataUrl = captureCanvas.toDataURL('image/jpeg');

            try {
                const response = await fetch('{{ route('pegawai.profil.face') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ 
                        face_descriptor: JSON.stringify(descriptorArray),
                        foto_wajah: dataUrl
                    })
                });

                const data = await response.json();
                if (data.success) {
                    alert(data.message);
                    closeFaceModal();
                    window.location.reload(); // Reload to update button state
                } else {
                    alert("Gagal menyimpan data wajah.");
                }
            } catch (err) {
                console.error(err);
                alert("Terjadi kesalahan.");
            } finally {
                btnCaptureFace.disabled = false;
                btnCaptureFace.innerHTML = '<i data-lucide="scan" class="inline-block h-4 w-4 mr-1"></i> Ambil Wajah';
                lucide.createIcons();
            }
        });

        const presensiModal = document.querySelector('[data-presensi-face-modal]');
        const openPresensiBtn = document.querySelector('[data-open-presensi-face]');
        const closePresensiBtn = document.querySelector('[data-close-presensi-face]');
        const presensiVideo = document.getElementById('presensi-face-video');
        const presensiOverlay = document.getElementById('presensi-face-overlay');
        const presensiStatus = document.getElementById('presensi-face-status');
        let presensiStream = null;
        let presensiDetectionInterval = null;
        let isPresensiScanning = true;

        @if (!empty($pegawai->face_descriptor))
        const myDescriptor = new Float32Array(JSON.parse(`{!! $pegawai->face_descriptor !!}`));
        const myLabeledDescriptor = new faceapi.LabeledFaceDescriptors('me', [myDescriptor]);
        const presensiFaceMatcher = new faceapi.FaceMatcher([myLabeledDescriptor], 0.45);
        @endif

        async function openPresensiModal() {
            presensiModal.classList.remove('hidden');
            presensiModal.classList.add('flex');
            isPresensiScanning = true;
            
            try {
                await Promise.all([
                    faceapi.nets.ssdMobilenetv1.loadFromUri('/models'),
                    faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
                    faceapi.nets.faceRecognitionNet.loadFromUri('/models')
                ]);
                
                presensiStream = await navigator.mediaDevices.getUserMedia({ video: { width: 640, height: 480 } });
                presensiVideo.srcObject = presensiStream;
                presensiVideo.classList.remove('hidden');
                presensiStatus.classList.add('hidden');
                
                presensiVideo.addEventListener('play', startPresensiDetection);
            } catch (err) {
                console.error(err);
                presensiStatus.innerText = "Gagal memuat kamera atau model.";
            }
        }

        function closePresensiModal() {
            presensiModal.classList.add('hidden');
            presensiModal.classList.remove('flex');
            isPresensiScanning = false;
            if (presensiDetectionInterval) clearInterval(presensiDetectionInterval);
            if (presensiStream) {
                presensiStream.getTracks().forEach(track => track.stop());
                presensiStream = null;
            }
            presensiVideo.classList.add('hidden');
            presensiStatus.classList.remove('hidden');
            presensiStatus.innerText = "Memuat kamera dan model...";
            presensiVideo.removeEventListener('play', startPresensiDetection);
            const ctx = presensiOverlay.getContext('2d');
            ctx.clearRect(0, 0, presensiOverlay.width, presensiOverlay.height);
        }

        function startPresensiDetection() {
            const displaySize = { width: presensiVideo.videoWidth, height: presensiVideo.videoHeight };
            faceapi.matchDimensions(presensiOverlay, displaySize);

            presensiDetectionInterval = setInterval(async () => {
                if (!isPresensiScanning) return;

                const detections = await faceapi.detectAllFaces(presensiVideo, new faceapi.SsdMobilenetv1Options({ minConfidence: 0.5 }))
                                                .withFaceLandmarks()
                                                .withFaceDescriptors();
                
                const resizedDetections = faceapi.resizeResults(detections, displaySize);
                const ctx = presensiOverlay.getContext('2d');
                ctx.clearRect(0, 0, presensiOverlay.width, presensiOverlay.height);

                for (const detection of resizedDetections) {
                    const bestMatch = presensiFaceMatcher.findBestMatch(detection.descriptor);
                    let labelText = "Bukan Anda";
                    let boxColor = "red";

                    if (bestMatch.label === 'me') {
                        labelText = "Wajah Dikenali!";
                        boxColor = "#1F7A6F"; // ijo-semitua
                        
                        if (isPresensiScanning && bestMatch.distance < 0.45) {
                            isPresensiScanning = false;
                            clearInterval(presensiDetectionInterval);
                            presensiStatus.classList.remove('hidden');
                            presensiStatus.innerText = "Berhasil diverifikasi! Mencatat presensi...";
                            presensiStatus.classList.replace('bg-gray-900', 'bg-sirapi-green/80');
                            setTimeout(() => {
                                document.getElementById('form-presensi').submit();
                            }, 1000);
                        }
                    }

                    const box = detection.detection.box;
                    const drawBox = new faceapi.draw.DrawBox(box, { label: labelText, boxColor: boxColor });
                    drawBox.draw(presensiOverlay);
                }
            }, 200);
        }

        openPresensiBtn?.addEventListener('click', openPresensiModal);
        closePresensiBtn?.addEventListener('click', closePresensiModal);
        
        openProfileButtons.forEach((button) => button.addEventListener('click', openProfileModal));
        closeProfileButtons.forEach((button) => button.addEventListener('click', closeProfileModal));
        document.querySelectorAll('[data-open-face]').forEach(btn => {
            btn.addEventListener('click', () => {
                closeProfileModal();
                openFaceModal();
            });
        });
        closeFaceButton?.addEventListener('click', closeFaceModal);
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
