@extends('admin.layout.app')

@section('title', 'Data Pegawai')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] dark:text-white tracking-tight">Data Pegawai</h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-300 mt-1">Kelola dan pantau informasi seluruh pegawai di sini.</p>
        </div>
        <button onclick="openModal('modal-tambah-pegawai')" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2.5 px-5 rounded-xl transition shadow-xs self-start sm:self-auto cursor-pointer border border-transparent dark:border-[#10b981]/30">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Pegawai</span>
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs transition-colors">
            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Total Pegawai</p>
            <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $totalPegawai ?? $pegawai->count() }}</p>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-emerald-100 dark:border-emerald-900/30 rounded-2xl p-5 shadow-xs transition-colors">
            <p class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Pegawai Aktif</p>
            <p class="mt-2 text-3xl font-black text-emerald-600 dark:text-emerald-400">{{ $totalAktif ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-amber-100 dark:border-amber-900/30 rounded-2xl p-5 shadow-xs transition-colors relative overflow-hidden">
            @if (($totalPending ?? 0) > 0)
                <span class="absolute top-4 right-4 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                </span>
            @endif
            <p class="text-[11px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Menunggu Verifikasi</p>
            <p class="mt-2 text-3xl font-black text-amber-600 dark:text-amber-400">{{ $totalPending ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-red-100 dark:border-red-900/30 rounded-2xl p-5 shadow-xs transition-colors">
            <p class="text-[11px] font-bold text-red-600 dark:text-red-400 uppercase tracking-wider">Ditolak</p>
            <p class="mt-2 text-3xl font-black text-red-600 dark:text-red-400">{{ $totalDitolak ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
        <div class="border-b border-gray-100 dark:border-[#233a34] px-6 py-5 flex flex-col gap-4">
            <div>
                <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Daftar Pegawai</h2>
                <p id="text-count-pegawai" class="mt-1 text-xs text-gray-500 dark:text-gray-300">Menampilkan {{ $pegawai->count() }} dari {{ $totalPegawai ?? $pegawai->count() }} pegawai.</p>
            </div>
            <form id="form-search-pegawai" method="GET" action="{{ route('admin.pegawai.lihat') }}" class="w-full">
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-[1fr_180px_180px_180px] lg:items-end">
                    <div class="sm:col-span-2 lg:col-span-1">
                        <label for="keyword" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Search</label>
                        <input
                            id="keyword"
                            name="keyword"
                            value="{{ $keyword ?? request('keyword') }}"
                            type="search"
                            class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500"
                            placeholder="Cari nama, NIP, tanggal lahir, jabatan, bidang, no HP, email...">
                    </div>
                    <div>
                        <label for="status-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Status Akun</label>
                        <select
                            id="status-filter"
                            name="status"
                            onchange="document.getElementById('form-search-pegawai').submit()"
                            class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-medium text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                            <option value="semua" @selected(($statusFilter ?? 'semua') === 'semua')>Semua Status</option>
                            <option value="aktif" @selected(($statusFilter ?? 'semua') === 'aktif')>Aktif ({{ $totalAktif ?? 0 }})</option>
                            <option value="pending" @selected(($statusFilter ?? 'semua') === 'pending')>Menunggu Verifikasi ({{ $totalPending ?? 0 }})</option>
                            <option value="ditolak" @selected(($statusFilter ?? 'semua') === 'ditolak')>Ditolak ({{ $totalDitolak ?? 0 }})</option>
                        </select>
                    </div>
                    <div>
                        <label for="bidang-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Bidang</label>
                        <select
                            id="bidang-filter"
                            name="bidang"
                            onchange="document.getElementById('form-search-pegawai').submit()"
                            class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-medium text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                            <option value="semua" @selected(($bidangFilter ?? 'semua') === 'semua')>Semua Bidang</option>
                            @foreach (($bidangOptions ?? collect()) as $bidang)
                                <option value="{{ $bidang }}" @selected(($bidangFilter ?? 'semua') === $bidang)>{{ $bidang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="jabatan-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Jabatan</label>
                        <select
                            id="jabatan-filter"
                            name="jabatan"
                            onchange="document.getElementById('form-search-pegawai').submit()"
                            class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-medium text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                            <option value="semua" @selected(($jabatanFilter ?? 'semua') === 'semua')>Semua Jabatan</option>
                            @foreach (($jabatanOptions ?? collect()) as $jabatan)
                                <option value="{{ $jabatan }}" @selected(($jabatanFilter ?? 'semua') === $jabatan)>{{ $jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto overflow-y-auto max-h-[450px] custom-scrollbar">
            <table class="w-full text-left min-w-[1280px]">
                <thead class="sticky top-0 z-10">
                    <tr class="bg-[#35635b] dark:bg-[#1b3832] text-white text-xs font-bold uppercase tracking-wider outline outline-1 outline-[#35635b] dark:outline-[#1b3832]">
                        <th class="px-6 py-4">Foto</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">NIP</th>
                        <th class="px-6 py-4">Tanggal Lahir</th>
                        <th class="px-6 py-4">Jabatan</th>
                        <th class="px-6 py-4">Bidang</th>
                        <th class="px-6 py-4">No HP</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Status Akun</th>
                        <th class="px-6 py-4">Data Wajah</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#233a34] text-sm">
                    @forelse ($pegawai as $item)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-[#1b332d] transition">
                            <td class="px-6 py-4">
                                @if (!empty($item->foto))
                                    <img src="{{ asset('storage/' . $item->foto) }}" 
                                         alt="{{ $item->nama_pegawai }}" 
                                         class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-[#233a34]">
                                @else
                                    <img src="{{ asset('assets/foto/profile.png') }}" alt="{{ $item->nama_pegawai }}" class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-[#233a34]">
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-[#35635b] dark:text-emerald-400">{{ $item->nama_pegawai }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-700 dark:text-slate-200">{{ $item->nip }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->tanggal_lahir?->format('d/m/Y') ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->jabatan }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->bidang ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->nomor_hp }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-xs font-bold whitespace-nowrap {{ $item->status_badge_class }}">
                                    {{ $item->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if (!is_null($item->face_descriptor))
                                    @if ($item->foto_wajah)
                                        <div class="flex items-center gap-2">
                                            <img src="{{ asset('storage/' . $item->foto_wajah) }}" alt="Bukti Wajah" class="w-8 h-8 rounded-lg object-cover border border-green-200 dark:border-emerald-800 shadow-xs cursor-pointer hover:scale-150 transition-transform origin-left">
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-green-100 dark:bg-emerald-950/60 text-green-700 dark:text-emerald-300 border border-transparent dark:border-emerald-800/50">Terdaftar</span>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-green-100 dark:bg-emerald-950/60 text-green-700 dark:text-emerald-300 border border-transparent dark:border-emerald-800/50">Terdaftar</span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-[10px] font-bold bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">Belum</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-1.5">
                                    @if ($item->isPending() || $item->isDitolak())
                                        <form method="POST" action="{{ route('admin.pegawai.verifikasi', $item->id_pegawai) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status_verifikasi" value="aktif">
                                            <button
                                                type="submit"
                                                onclick="return confirm('Setujui dan aktifkan akun pegawai ini?')"
                                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/50 dark:hover:bg-emerald-900/60 border border-emerald-200 dark:border-emerald-800 text-emerald-600 dark:text-emerald-400 p-1.5 transition cursor-pointer"
                                                title="Setujui / Aktifkan Akun">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                <span class="sr-only">Setujui</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if ($item->isPending() || $item->isAktif())
                                        <form method="POST" action="{{ route('admin.pegawai.verifikasi', $item->id_pegawai) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status_verifikasi" value="ditolak">
                                            <button
                                                type="submit"
                                                onclick="return confirm('Tolak/nonaktifkan akun pegawai ini? Pegawai tidak akan bisa login atau presensi.')"
                                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/50 dark:hover:bg-rose-900/60 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400 p-1.5 transition cursor-pointer"
                                                title="Tolak / Nonaktifkan Akun">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                <span class="sr-only">Tolak</span>
                                            </button>
                                        </form>
                                    @endif

                                    <button
                                        type="button"
                                        onclick="openEditPegawai(this)"
                                        data-id="{{ $item->id_pegawai }}"
                                        data-action="{{ route('admin.pegawai.update', $item->id_pegawai) }}"
                                        data-foto-url="{{ $item->foto ? asset('storage/' . $item->foto) : '' }}"
                                        data-nama="{{ $item->nama_pegawai }}"
                                        data-nip="{{ $item->nip }}"
                                        data-tanggal-lahir="{{ $item->tanggal_lahir?->format('Y-m-d') }}"
                                        data-jabatan="{{ $item->jabatan }}"
                                        data-bidang="{{ $item->bidang }}"
                                        data-nomor="{{ $item->nomor_hp }}"
                                        data-email="{{ $item->email }}"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-green-100 dark:hover:bg-[#23423b] cursor-pointer"
                                        title="Edit Pegawai">
                                        <img src="{{ asset('assets/foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                        <span class="sr-only">Edit</span>
                                    </button>
                                    @if (!is_null($item->face_descriptor))
                                    <form method="POST" action="{{ route('admin.pegawai.reset-wajah', $item->id_pegawai) }}" onsubmit="return confirm('Apakah Anda yakin ingin mereset data wajah pegawai ini? Pegawai harus mendaftarkan ulang wajahnya saat presensi berikutnya.');" class="inline">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-950/40 border border-transparent dark:border-amber-900/40 p-1.5 text-amber-600 dark:text-amber-400 transition hover:bg-amber-100 dark:hover:bg-amber-900/60 cursor-pointer"
                                            title="Reset Data Wajah (Biarkan pegawai daftar ulang wajah)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
                                            <span class="sr-only">Reset Wajah</span>
                                        </button>
                                    </form>
                                    @endif
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.pegawai.destroy', $item->id_pegawai) }}', 'Hapus Pegawai?', 'Apakah Anda yakin ingin menghapus pegawai ini?')"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer"
                                        title="Hapus Pegawai">
                                        <img src="{{ asset('assets/foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                        <span class="sr-only">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada data pegawai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <section class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] p-5 transition-colors">
            <div class="flex flex-col gap-1">
                <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Master Bidang</h2>
                <p class="text-xs text-gray-500 dark:text-gray-300">Opsi bidang untuk form tambah dan edit pegawai.</p>
            </div>

            <form method="POST" action="{{ route('admin.pegawai.bidang.store') }}" class="mt-4 flex flex-col gap-3 sm:flex-row">
                @csrf
                <input name="nama_bidang" required class="h-10 min-w-0 flex-1 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20" placeholder="Nama bidang baru">
                <button type="submit" class="h-10 rounded-lg bg-[#04733f] px-4 text-sm font-bold text-white transition hover:bg-[#035f35] cursor-pointer">Tambah</button>
            </form>

            <div class="mt-5">
                <div class="relative mb-3">
                    <input type="text" id="search-bidang" placeholder="Cari bidang..." class="w-full h-9 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] pl-8 pr-3 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500">
                    <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                
                <div class="border border-gray-200 dark:border-[#284c43] rounded-lg overflow-hidden">
                    <table class="w-full text-left text-xs text-gray-500 dark:text-gray-300">
                        <thead class="bg-gray-50 dark:bg-[#1b3832] text-gray-700 dark:text-white uppercase font-bold">
                            <tr>
                                <th class="px-4 py-3 font-bold w-12">No</th>
                                <th class="px-4 py-3 font-bold">Nama Bidang</th>
                                <th class="px-4 py-3 font-bold text-center w-20">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                    <div id="container-bidang" class="max-h-56 overflow-y-auto custom-scrollbar bg-white dark:bg-[#152420]">
                        <table class="w-full text-left text-xs text-gray-500 dark:text-gray-300">
                            <tbody class="divide-y divide-gray-200 dark:divide-[#233a34]">
                                @forelse (($bidangMaster ?? collect()) as $index => $bidang)
                                    <tr class="item-bidang hover:bg-gray-50 dark:hover:bg-[#1b332d] transition" data-name="{{ strtolower($bidang->nama_bidang) }}">
                                        <td class="px-4 py-3 w-12 text-center">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">{{ $bidang->nama_bidang }}</td>
                                        <td class="px-4 py-3 w-20 text-center">
                                            <form method="POST" action="{{ route('admin.pegawai.bidang.destroy', $bidang->id_bidang) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 p-1 bg-red-50 dark:bg-red-950/40 rounded hover:bg-red-100 dark:hover:bg-red-900/60 transition cursor-pointer" title="Hapus bidang">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-4 text-center text-xs text-gray-500 dark:text-gray-400">Belum ada master bidang.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] p-5 transition-colors">
            <div class="flex flex-col gap-1">
                <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Master Jabatan</h2>
                <p class="text-xs text-gray-500 dark:text-gray-300">Opsi jabatan untuk form tambah dan edit pegawai.</p>
            </div>

            <form method="POST" action="{{ route('admin.pegawai.jabatan.store') }}" class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-[1fr_180px_auto]">
                @csrf
                <input name="nama_jabatan" required class="h-10 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20" placeholder="Nama jabatan baru">
                <select name="kategori" class="h-10 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    <option value="Struktural">Struktural</option>
                    <option value="Jabatan Fungsional">Jabatan Fungsional</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <button type="submit" class="h-10 rounded-lg bg-[#04733f] px-4 text-sm font-bold text-white transition hover:bg-[#035f35] cursor-pointer">Tambah</button>
            </form>

            <div class="mt-5">
                <div class="relative mb-3">
                    <input type="text" id="search-jabatan" placeholder="Cari jabatan..." class="w-full h-9 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] pl-8 pr-3 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500">
                    <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                
                <div class="border border-gray-200 dark:border-[#284c43] rounded-lg overflow-hidden">
                    <table class="w-full text-left text-xs text-gray-500 dark:text-gray-300">
                        <thead class="bg-gray-50 dark:bg-[#1b3832] text-gray-700 dark:text-white uppercase font-bold">
                            <tr>
                                <th class="px-4 py-3 font-bold w-12">No</th>
                                <th class="px-4 py-3 font-bold">Nama Jabatan</th>
                                <th class="px-4 py-3 font-bold w-32">Kategori</th>
                                <th class="px-4 py-3 font-bold text-center w-20">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                    <div id="container-jabatan" class="max-h-56 overflow-y-auto custom-scrollbar bg-white dark:bg-[#152420]">
                        <table class="w-full text-left text-xs text-gray-500 dark:text-gray-300">
                            <tbody class="divide-y divide-gray-200 dark:divide-[#233a34]">
                                @forelse (($jabatanMaster ?? collect()) as $index => $jabatan)
                                    <tr class="item-jabatan hover:bg-gray-50 dark:hover:bg-[#1b332d] transition" data-name="{{ strtolower($jabatan->nama_jabatan . ' ' . $jabatan->kategori) }}">
                                        <td class="px-4 py-3 w-12 text-center">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">{{ $jabatan->nama_jabatan }}</td>
                                        <td class="px-4 py-3 w-32"><span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 dark:bg-[#1a2d29] text-gray-600 dark:text-gray-300">{{ $jabatan->kategori ?: 'Lainnya' }}</span></td>
                                        <td class="px-4 py-3 w-20 text-center">
                                            <form method="POST" action="{{ route('admin.pegawai.jabatan.destroy', $jabatan->id_jabatan) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 p-1 bg-red-50 dark:bg-red-950/40 rounded hover:bg-red-100 dark:hover:bg-red-900/60 transition cursor-pointer" title="Hapus jabatan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-xs text-gray-500 dark:text-gray-400">Belum ada master jabatan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div id="modal-tambah-pegawai" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Tambah Pegawai</h3>
            <button type="button" onclick="closeModal('modal-tambah-pegawai')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal tambah pegawai">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-tambah-pegawai" method="POST" action="{{ route('admin.pegawai.store') }}" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @if ($errors->any() && !old('_method'))
                <div class="px-4 pt-3 sm:px-6 sm:pt-4">
                    <div class="rounded-xl border border-red-200 bg-red-50 dark:bg-red-950/50 px-4 py-3 text-sm font-semibold text-red-700 dark:text-red-300">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif
            <div class="flex-1 min-h-0 grid grid-cols-1 gap-3 sm:gap-4 overflow-y-auto p-4 sm:p-6 sm:grid-cols-2">
                @include('admin.pegawai.form-fields')
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50 dark:bg-[#0f1c19] p-3 sm:px-6 sm:py-4 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-tambah-pegawai')" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="w-full sm:w-auto inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#04733f] dark:bg-[#107050] hover:bg-[#035f35] dark:hover:bg-[#0c5940] px-5 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-pegawai" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Edit Pegawai</h3>
            <button type="button" onclick="closeModal('modal-edit-pegawai')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal edit pegawai">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-edit-pegawai" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-id_pegawai" name="id_pegawai">
            @if ($errors->any() && old('_method') === 'PUT')
                <div class="px-4 pt-3 sm:px-6 sm:pt-4">
                    <div class="rounded-xl border border-red-200 bg-red-50 dark:bg-red-950/50 px-4 py-3 text-sm font-semibold text-red-700 dark:text-red-300">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif
            <div class="flex-1 min-h-0 grid grid-cols-1 gap-3 sm:gap-4 overflow-y-auto p-4 sm:p-6 sm:grid-cols-2">
                @include('admin.pegawai.form-fields', ['prefix' => 'edit-'])
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50 dark:bg-[#0f1c19] p-3 sm:px-6 sm:py-4 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-edit-pegawai')" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="w-full sm:w-auto inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#04733f] dark:bg-[#107050] hover:bg-[#035f35] dark:hover:bg-[#0c5940] px-5 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (id === 'modal-tambah-pegawai') {
            const form = document.getElementById('form-tambah-pegawai');
            if (form) form.reset();
            setPegawaiPhotoPreview('', '');
        }
        if (modal) {
            if (modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }

    function openEditPegawai(button) {
        document.getElementById('form-edit-pegawai').action = button.dataset.action;
        document.getElementById('edit-id_pegawai').value = button.dataset.id;
        document.getElementById('edit-foto').value = '';
        document.getElementById('edit-nama_pegawai').value = button.dataset.nama;
        document.getElementById('edit-nip').value = button.dataset.nip;
        document.getElementById('edit-tanggal_lahir').value = button.dataset.tanggalLahir || '';
        document.getElementById('edit-jabatan').value = button.dataset.jabatan;
        document.getElementById('edit-bidang').value = button.dataset.bidang || '';
        document.getElementById('edit-nomor_hp').value = button.dataset.nomor;
        document.getElementById('edit-email').value = button.dataset.email;
        setPegawaiPhotoPreview('edit-', button.dataset.fotoUrl || '');
        openModal('modal-edit-pegawai');
    }

    function setPegawaiPhotoPreview(prefix, url) {
        const preview = document.getElementById(prefix + 'foto-preview');
        const icon = document.getElementById(prefix + 'foto-icon');
        const hapusBtn = document.getElementById(prefix + 'btn-hapus-foto');

        if (url) {
            preview.src = url;
            preview.classList.remove('hidden');
            if (icon) icon.classList.add('hidden');
            if (hapusBtn) hapusBtn.classList.remove('hidden');
        } else {
            preview.src = '{{ asset("assets/foto/profile.png") }}';
            preview.classList.remove('hidden');
            if (icon) icon.classList.add('hidden');
            if (hapusBtn) hapusBtn.classList.add('hidden');
        }
    }

    function removePhoto(prefix) {
        const input = document.getElementById(prefix + 'foto');
        const hapusInput = document.getElementById(prefix + 'hapus_foto');
        
        if (input) input.value = '';
        
        setPegawaiPhotoPreview(prefix, '');
        
        if (hapusInput) hapusInput.value = '1';
    }

    document.querySelectorAll('input[type="file"][data-photo-input]').forEach(input => {
        input.addEventListener('change', function(e) {
            const prefix = this.dataset.photoInput;
            const file = this.files[0];
            const hapusInput = document.getElementById(prefix + 'hapus_foto');
            if (hapusInput) hapusInput.value = '0';
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    setPegawaiPhotoPreview(prefix, e.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                setPegawaiPhotoPreview(prefix, '');
            }
        });
    });

    const masterState = {
        bidang: { expanded: false },
        jabatan: { expanded: false }
    };

    function initMasterList(type) {
        const searchInput = document.getElementById(`search-${type}`);
        if (searchInput) {
            searchInput.addEventListener('input', () => renderMasterList(type));
        }
        renderMasterList(type);
    }

    function renderMasterList(type) {
        const searchInput = document.getElementById(`search-${type}`);
        const container = document.getElementById(`container-${type}`);
        
        if (!container) return;
        
        const items = container.querySelectorAll(`.item-${type}`);
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        
        items.forEach((item) => {
            const name = item.dataset.name || '';
            if (name.includes(searchTerm)) {
                item.style.display = 'table-row';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function initLiveSearch() {
        const form = document.getElementById('form-search-pegawai');
        const searchInput = document.getElementById('keyword');
        const bidangFilter = document.getElementById('bidang-filter');
        const jabatanFilter = document.getElementById('jabatan-filter');
        const tableBody = document.querySelector('table tbody');
        const countText = document.getElementById('text-count-pegawai');
        
        if (!form || !searchInput || !tableBody) return;

        let debounceTimer;

        function fetchResults() {
            const url = new URL(form.action);
            const params = new URLSearchParams(new FormData(form));
            url.search = params.toString();

            // Update URL in browser without reload
            window.history.replaceState({}, '', url);

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const newTbody = doc.querySelector('table tbody');
                if (newTbody) {
                    tableBody.innerHTML = newTbody.innerHTML;
                }

                const newCount = doc.getElementById('text-count-pegawai');
                if (countText && newCount) {
                    countText.innerHTML = newCount.innerHTML;
                }
            });
        }

        searchInput.addEventListener('input', function(e) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fetchResults, 300);
        });

        // Prevent form submission on enter
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });

        if(bidangFilter) {
            bidangFilter.addEventListener('change', fetchResults);
        }
        if(jabatanFilter) {
            jabatanFilter.addEventListener('change', fetchResults);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initMasterList('bidang');
        initMasterList('jabatan');
        initLiveSearch();

        @if($errors->any())
            @if(old('_method') === 'PUT')
                const editId = "{{ old('id_pegawai') }}";
                const editBtn = document.querySelector(`button[data-id="${editId}"]`);
                if (editBtn) {
                    openEditPegawai(editBtn);
                    document.getElementById('edit-nama_pegawai').value = @json(old('nama_pegawai'));
                    document.getElementById('edit-nip').value = @json(old('nip'));
                    document.getElementById('edit-tanggal_lahir').value = @json(old('tanggal_lahir'));
                    document.getElementById('edit-jabatan').value = @json(old('jabatan'));
                    document.getElementById('edit-bidang').value = @json(old('bidang'));
                    document.getElementById('edit-nomor_hp').value = @json(old('nomor_hp'));
                    document.getElementById('edit-email').value = @json(old('email'));
                }
            @else
                openModal('modal-tambah-pegawai');
                document.getElementById('nama_pegawai').value = @json(old('nama_pegawai'));
                document.getElementById('nip').value = @json(old('nip'));
                document.getElementById('tanggal_lahir').value = @json(old('tanggal_lahir'));
                document.getElementById('jabatan').value = @json(old('jabatan'));
                document.getElementById('bidang').value = @json(old('bidang'));
                document.getElementById('nomor_hp').value = @json(old('nomor_hp'));
                document.getElementById('email').value = @json(old('email'));
            @endif
        @endif
    });
</script>
@endpush
@endsection
