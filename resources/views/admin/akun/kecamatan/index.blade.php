@extends('admin.layout.app')

@section('title', 'Manajemen Akun Kecamatan')

@section('header_actions')
<button onclick="openModal('modal-tambah-akun-kecamatan')" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2 px-4 rounded-xl flex items-center justify-center gap-1.5 transition shadow-xs text-xs border border-transparent dark:border-[#10b981]/30 cursor-pointer">
    <span class="text-base leading-none">+</span>
    <span>Tambah Akun Kecamatan</span>
</button>
@endsection

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-xl p-5 shadow-xs transition-colors">
            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Total Akun Kecamatan</p>
            <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $totalAkun ?? $akunList->count() }}</p>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-xl p-5 shadow-xs transition-colors">
            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Akun Aktif</p>
            <p class="mt-2 text-3xl font-black text-emerald-600 dark:text-emerald-400">{{ $totalAktif ?? 0 }}</p>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-xl p-5 shadow-xs transition-colors">
            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Akun Nonaktif</p>
            <p class="mt-2 text-3xl font-black text-amber-600 dark:text-amber-400">{{ $totalNonaktif ?? 0 }}</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <form id="form-search-akun-kecamatan" method="GET" action="{{ route('admin.akun.kecamatan.index') }}" class="bg-white dark:bg-[#152420] rounded-xl shadow-xs border border-gray-100 dark:border-[#233a34] p-4 sm:p-5 transition-colors">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-[1fr_220px_160px_auto] xl:items-end gap-3 sm:gap-4">
            <div>
                <label for="keyword" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Cari Akun</label>
                <div class="relative">
                    <input
                        id="keyword"
                        name="keyword"
                        value="{{ $keyword ?? request('keyword') }}"
                        type="search"
                        class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] pl-10 pr-4 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500"
                        placeholder="Cari nama, username, email, no hp, kecamatan...">
                    <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <label for="kecamatan-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Kecamatan</label>
                <select
                    id="kecamatan-filter"
                    name="kecamatan"
                    class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-medium text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    <option value="semua" @selected(($kecamatanFilter ?? 'semua') === 'semua')>Semua Kecamatan</option>
                    @foreach ($masterKecamatan as $k)
                        <option value="{{ $k->id_kecamatan }}" @selected(($kecamatanFilter ?? 'semua') == $k->id_kecamatan)>{{ $k->nama_kecamatan }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Status</label>
                <select
                    id="status-filter"
                    name="status"
                    class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-medium text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    <option value="semua" @selected(($statusFilter ?? 'semua') === 'semua')>Semua Status</option>
                    <option value="aktif" @selected(($statusFilter ?? '') === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected(($statusFilter ?? '') === 'nonaktif')>Nonaktif</option>
                </select>
            </div>
            <div>
                <a href="{{ route('admin.akun.kecamatan.index') }}" class="h-11 inline-flex items-center justify-center gap-1.5 px-4 rounded-xl border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] text-xs font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 transition whitespace-nowrap w-full" title="Reset Filter">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Reset</span>
                </a>
            </div>
        </div>
    </form>

    <!-- Table Section -->
    <div class="bg-white dark:bg-[#152420] rounded-xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
        <div class="border-b border-gray-100 dark:border-[#233a34] px-6 py-4">
            <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Daftar Akun Kecamatan</h2>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">Menampilkan {{ $akunList->count() }} dari {{ $totalAkun ?? $akunList->count() }} akun kecamatan.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[950px]">
                <thead>
                    <tr class="bg-[#35635b] dark:bg-[#1b3832] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Pengguna & Username</th>
                        <th class="px-6 py-4">Kecamatan</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#233a34] text-sm">
                    @forelse ($akunList as $item)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-[#1b332d] transition">
                            <td class="px-6 py-4">
                                <div class="font-extrabold text-gray-800 dark:text-slate-100">{{ $item->nama }}</div>
                                <div class="text-xs text-gray-500 dark:text-emerald-400/80 font-mono">@ {{ $item->username }}</div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-700 dark:text-slate-200">
                                {{ $item->kecamatan->nama_kecamatan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-700 dark:text-slate-200">
                                @if ($item->email) <p class="font-medium">✉️ {{ $item->email }}</p> @endif
                                @if ($item->nomor_hp) <p class="text-gray-500 dark:text-gray-400">📞 {{ $item->nomor_hp }}</p> @endif
                                @if (!$item->email && !$item->nomor_hp) - @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->status === 'aktif')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60">
                                        ● Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                                        ○ Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2 whitespace-nowrap">
                                    <button
                                        type="button"
                                        onclick="openEditAkunKecamatan(this)"
                                        data-id="{{ $item->id_admin }}"
                                        data-action="{{ route('admin.akun.kecamatan.update', $item->id_admin) }}"
                                        data-nama="{{ $item->nama }}"
                                        data-username="{{ $item->username }}"
                                        data-kecamatan="{{ $item->id_kecamatan }}"
                                        data-email="{{ $item->email }}"
                                        data-hp="{{ $item->nomor_hp }}"
                                        data-status="{{ $item->status }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-[#0f513f] dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-emerald-100 dark:hover:bg-emerald-900/60 cursor-pointer shadow-2xs"
                                        title="Edit Akun">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Edit</span>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openResetPasswordAkunKecamatan('{{ route('admin.akun.kecamatan.reset-password', $item->id_admin) }}', '{{ $item->nama }}')"
                                        class="inline-flex items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-950/50 text-amber-800 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-amber-100 dark:hover:bg-amber-900/60 cursor-pointer shadow-2xs"
                                        title="Reset Password">
                                        🔑 Reset Password
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.akun.kecamatan.destroy', $item->id_admin) }}', 'Hapus Akun Kecamatan?', 'Apakah Anda yakin ingin menghapus akun {{ $item->nama }}?')"
                                        class="inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/50 text-red-700 dark:text-red-300 border border-red-200/80 dark:border-red-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer shadow-2xs"
                                        title="Hapus Akun">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada akun kecamatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Akun Kecamatan -->
<div id="modal-tambah-akun-kecamatan" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-2xl max-w-lg w-full p-6 text-left relative max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-100 dark:border-[#233a34]">
            <h3 class="text-base font-extrabold text-gray-900 dark:text-white">Tambah Akun Kecamatan</h3>
            <button onclick="closeModal('modal-tambah-akun-kecamatan')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">✕</button>
        </div>
        <form action="{{ route('admin.akun.kecamatan.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Pilih Kecamatan *</label>
                <select name="id_kecamatan" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                    <option value="">-- Pilih Kecamatan --</option>
                    @foreach ($masterKecamatan as $k)
                        <option value="{{ $k->id_kecamatan }}">{{ $k->nama_kecamatan }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Nama Pengelola Akun *</label>
                <input type="text" name="nama" required placeholder="Contoh: Admin Kec. Cibinong" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Username Login *</label>
                    <input type="text" name="username" required placeholder="Contoh: camat_cibinong" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Password *</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Email</label>
                    <input type="email" name="email" placeholder="kecamatan@bogorkab.go.id" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">No. HP / WhatsApp</label>
                    <input type="text" name="nomor_hp" placeholder="08xxxxxxxxxx" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Status Akun *</label>
                <select name="status" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 dark:border-[#233a34]">
                <button type="button" onclick="closeModal('modal-tambah-akun-kecamatan')" class="px-4 py-2 text-xs font-bold rounded-xl border border-gray-300 dark:border-[#284c43] text-gray-700 dark:text-gray-300">Batal</button>
                <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl bg-[#35635b] dark:bg-[#107050] text-white hover:bg-[#2b4f49]">Buat Akun</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Akun Kecamatan -->
<div id="modal-edit-akun-kecamatan" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-2xl max-w-lg w-full p-6 text-left relative max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-100 dark:border-[#233a34]">
            <h3 class="text-base font-extrabold text-gray-900 dark:text-white">Edit Akun Kecamatan</h3>
            <button onclick="closeModal('modal-edit-akun-kecamatan')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">✕</button>
        </div>
        <form id="form-edit-akun-kecamatan" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Pilih Kecamatan *</label>
                <select id="edit-kecamatan-id" name="id_kecamatan" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                    <option value="">-- Pilih Kecamatan --</option>
                    @foreach ($masterKecamatan as $k)
                        <option value="{{ $k->id_kecamatan }}">{{ $k->nama_kecamatan }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Nama Pengelola Akun *</label>
                <input type="text" id="edit-nama-akun-kec" name="nama" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Username Login *</label>
                <input type="text" id="edit-username-akun-kec" name="username" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Email</label>
                    <input type="email" id="edit-email-akun-kec" name="email" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">No. HP / WhatsApp</label>
                    <input type="text" id="edit-hp-akun-kec" name="nomor_hp" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Status Akun *</label>
                <select id="edit-status-akun-kec" name="status" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 dark:border-[#233a34]">
                <button type="button" onclick="closeModal('modal-edit-akun-kecamatan')" class="px-4 py-2 text-xs font-bold rounded-xl border border-gray-300 dark:border-[#284c43] text-gray-700 dark:text-gray-300">Batal</button>
                <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl bg-[#35635b] dark:bg-[#107050] text-white hover:bg-[#2b4f49]">Perbarui Akun</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reset Password Kecamatan -->
<div id="modal-reset-password-kecamatan" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-2xl max-w-sm w-full p-6 text-left relative">
        <div class="flex justify-between items-center pb-3 mb-3 border-b border-gray-100 dark:border-[#233a34]">
            <h3 class="text-base font-extrabold text-gray-900 dark:text-white">Reset Password</h3>
            <button onclick="closeModal('modal-reset-password-kecamatan')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">✕</button>
        </div>
        <form id="form-reset-password-kecamatan" method="POST" class="space-y-4">
            @csrf
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-300 mb-2">Reset password untuk: <strong id="reset-target-nama-kecamatan" class="text-gray-800 dark:text-white"></strong></p>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Password Baru *</label>
                <input type="password" name="new_password" required minlength="6" placeholder="Masukkan password baru" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div class="pt-3 flex justify-end gap-2 border-t border-gray-100 dark:border-[#233a34]">
                <button type="button" onclick="closeModal('modal-reset-password-kecamatan')" class="px-4 py-2 text-xs font-bold rounded-xl border border-gray-300 dark:border-[#284c43] text-gray-700 dark:text-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 text-xs font-bold rounded-xl bg-amber-600 text-white hover:bg-amber-700">Simpan Password</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            if (modal.parentElement && modal.parentElement !== document.body) {
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

    function openEditAkunKecamatan(btn) {
        const form = document.getElementById('form-edit-akun-kecamatan');
        form.action = btn.dataset.action;
        document.getElementById('edit-nama-akun-kec').value = btn.dataset.nama || '';
        document.getElementById('edit-username-akun-kec').value = btn.dataset.username || '';
        document.getElementById('edit-kecamatan-id').value = btn.dataset.kecamatan || '';
        document.getElementById('edit-email-akun-kec').value = btn.dataset.email || '';
        document.getElementById('edit-hp-akun-kec').value = btn.dataset.hp || '';
        document.getElementById('edit-status-akun-kec').value = btn.dataset.status || 'aktif';
        openModal('modal-edit-akun-kecamatan');
    }

    function openResetPasswordAkunKecamatan(actionUrl, targetNama) {
        const form = document.getElementById('form-reset-password-kecamatan');
        form.action = actionUrl;
        document.getElementById('reset-target-nama-kecamatan').textContent = targetNama;
        openModal('modal-reset-password-kecamatan');
    }
</script>
@endsection
