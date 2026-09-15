@extends('admin.layout.app')

@section('title', 'Manajemen Akun Dinas')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-xl p-5 shadow-xs transition-colors">
            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Total Akun Dinas</p>
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

    <!-- Table Section -->
    <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
        <!-- Card Header: Title (Left), Search & Filters (Middle), Button (Right) -->
        <div class="border-b border-gray-100 dark:border-[#233a34] px-5 sm:px-6 py-4 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
            <!-- Left: Title & Subtitle -->
            <div class="shrink-0">
                <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Daftar Akun Dinas</h2>
                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-300">Menampilkan {{ $akunList->count() }} dari {{ $totalAkun ?? $akunList->count() }} akun dinas.</p>
            </div>

            <!-- Middle: Search Bar & Filters -->
            <form id="form-search-akun-dinas" method="GET" action="{{ route('admin.akun.dinas.index') }}" class="flex-1 max-w-3xl w-full">
                <div class="flex flex-col sm:flex-row items-center gap-2">
                    <div class="relative flex-1 w-full">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input
                            id="keyword"
                            name="keyword"
                            value="{{ $keyword ?? request('keyword') }}"
                            type="search"
                            class="h-10 w-full pl-10 pr-4 rounded-xl border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500"
                            placeholder="Cari nama, username, email, no hp, dinas...">
                    </div>
                    <select
                        id="dinas-filter"
                        name="dinas"
                        onchange="document.getElementById('form-search-akun-dinas').submit()"
                        class="h-10 rounded-xl border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] px-3 text-xs font-medium text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                        <option value="semua" @selected(($dinasFilter ?? 'semua') === 'semua')>Semua Dinas</option>
                        @foreach ($masterDinas as $d)
                            <option value="{{ $d->id_dinas }}" @selected(($dinasFilter ?? 'semua') == $d->id_dinas)>{{ $d->nama_dinas }}</option>
                        @endforeach
                    </select>
                    <select
                        id="status-filter"
                        name="status"
                        onchange="document.getElementById('form-search-akun-dinas').submit()"
                        class="h-10 rounded-xl border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] px-3 text-xs font-medium text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                        <option value="semua" @selected(($statusFilter ?? 'semua') === 'semua')>Semua Status</option>
                        <option value="aktif" @selected(($statusFilter ?? '') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(($statusFilter ?? '') === 'nonaktif')>Nonaktif</option>
                    </select>
                </div>
            </form>

            <!-- Right: Action Button -->
            <button onclick="openModal('modal-tambah-akun-dinas')" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2.5 px-4 rounded-xl flex items-center justify-center gap-1.5 transition shadow-xs text-xs border border-transparent dark:border-[#10b981]/30 cursor-pointer shrink-0">
                <span class="text-base leading-none">+</span>
                <span>Tambah Akun Dinas</span>
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[950px]">
                <thead>
                    <tr class="bg-[#35635b] dark:bg-[#1b3832] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Pengguna & Username</th>
                        <th class="px-6 py-4">Dinas / Instansi</th>
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
                                {{ $item->dinas->nama_dinas ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-700 dark:text-slate-200">
                                @if ($item->email) <p class="font-medium">{{ $item->email }}</p> @endif
                                @if ($item->nomor_hp) <p class="text-gray-500 dark:text-gray-400">{{ $item->nomor_hp }}</p> @endif
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
                                        onclick="openEditAkunDinas(this)"
                                        data-id="{{ $item->id_admin }}"
                                        data-action="{{ route('admin.akun.dinas.update', $item->id_admin) }}"
                                        data-nama="{{ $item->nama }}"
                                        data-username="{{ $item->username }}"
                                        data-dinas="{{ $item->id_dinas }}"
                                        data-email="{{ $item->email }}"
                                        data-hp="{{ $item->nomor_hp }}"
                                        data-status="{{ $item->status }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-[#0f513f] dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-emerald-100 dark:hover:bg-emerald-900/60 cursor-pointer shadow-2xs"
                                        title="Edit Akun">
                                        <span>Edit</span>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openResetPasswordAkun('{{ route('admin.akun.dinas.reset-password', $item->id_admin) }}', '{{ $item->nama }}')"
                                        class="inline-flex items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-950/50 text-amber-800 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-amber-100 dark:hover:bg-amber-900/60 cursor-pointer shadow-2xs"
                                        title="Reset Password">
                                        <span>Reset Password</span>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.akun.dinas.destroy', $item->id_admin) }}', 'Hapus Akun Dinas?', 'Apakah Anda yakin ingin menghapus akun {{ $item->nama }}?')"
                                        class="inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/50 text-red-700 dark:text-red-300 border border-red-200/80 dark:border-red-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer shadow-2xs"
                                        title="Hapus Akun">
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada akun dinas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Akun Dinas -->
<div id="modal-tambah-akun-dinas" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-2xl max-w-lg w-full p-6 text-left relative max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-100 dark:border-[#233a34]">
            <h3 class="text-base font-extrabold text-gray-900 dark:text-white">Tambah Akun Dinas</h3>
            <button onclick="closeModal('modal-tambah-akun-dinas')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">✕</button>
        </div>
        <form action="{{ route('admin.akun.dinas.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Pilih Dinas / OPD *</label>
                <select name="id_dinas" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                    <option value="">-- Pilih Dinas --</option>
                    @foreach ($masterDinas as $d)
                        <option value="{{ $d->id_dinas }}">{{ $d->nama_dinas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Nama Pengelola Akun *</label>
                <input type="text" name="nama" required placeholder="Contoh: Admin Diskominfo" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Username Login *</label>
                    <input type="text" name="username" required placeholder="Contoh: dinas_diskominfo" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Password *</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Email</label>
                    <input type="email" name="email" placeholder="email@bogorkab.go.id" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
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
                <button type="button" onclick="closeModal('modal-tambah-akun-dinas')" class="px-4 py-2 text-xs font-bold rounded-xl border border-gray-300 dark:border-[#284c43] text-gray-700 dark:text-gray-300">Batal</button>
                <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl bg-[#35635b] dark:bg-[#107050] text-white hover:bg-[#2b4f49]">Buat Akun</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Akun Dinas -->
<div id="modal-edit-akun-dinas" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-2xl max-w-lg w-full p-6 text-left relative max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-100 dark:border-[#233a34]">
            <h3 class="text-base font-extrabold text-gray-900 dark:text-white">Edit Akun Dinas</h3>
            <button onclick="closeModal('modal-edit-akun-dinas')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">✕</button>
        </div>
        <form id="form-edit-akun-dinas" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Pilih Dinas / OPD *</label>
                <select id="edit-dinas-id" name="id_dinas" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                    <option value="">-- Pilih Dinas --</option>
                    @foreach ($masterDinas as $d)
                        <option value="{{ $d->id_dinas }}">{{ $d->nama_dinas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Nama Pengelola Akun *</label>
                <input type="text" id="edit-nama-akun" name="nama" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Username Login *</label>
                <input type="text" id="edit-username-akun" name="username" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Email</label>
                    <input type="email" id="edit-email-akun" name="email" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">No. HP / WhatsApp</label>
                    <input type="text" id="edit-hp-akun" name="nomor_hp" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Status Akun *</label>
                <select id="edit-status-akun" name="status" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 dark:border-[#233a34]">
                <button type="button" onclick="closeModal('modal-edit-akun-dinas')" class="px-4 py-2 text-xs font-bold rounded-xl border border-gray-300 dark:border-[#284c43] text-gray-700 dark:text-gray-300">Batal</button>
                <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl bg-[#35635b] dark:bg-[#107050] text-white hover:bg-[#2b4f49]">Perbarui Akun</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reset Password -->
<div id="modal-reset-password" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-2xl max-w-sm w-full p-6 text-left relative">
        <div class="flex justify-between items-center pb-3 mb-3 border-b border-gray-100 dark:border-[#233a34]">
            <h3 class="text-base font-extrabold text-gray-900 dark:text-white">Reset Password</h3>
            <button onclick="closeModal('modal-reset-password')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">✕</button>
        </div>
        <form id="form-reset-password" method="POST" class="space-y-4">
            @csrf
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-300 mb-2">Reset password untuk: <strong id="reset-target-nama" class="text-gray-800 dark:text-white"></strong></p>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Password Baru *</label>
                <input type="password" name="new_password" required minlength="6" placeholder="Masukkan password baru" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div class="pt-3 flex justify-end gap-2 border-t border-gray-100 dark:border-[#233a34]">
                <button type="button" onclick="closeModal('modal-reset-password')" class="px-4 py-2 text-xs font-bold rounded-xl border border-gray-300 dark:border-[#284c43] text-gray-700 dark:text-gray-300">Batal</button>
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

    function openEditAkunDinas(btn) {
        const form = document.getElementById('form-edit-akun-dinas');
        form.action = btn.dataset.action;
        document.getElementById('edit-nama-akun').value = btn.dataset.nama || '';
        document.getElementById('edit-username-akun').value = btn.dataset.username || '';
        document.getElementById('edit-dinas-id').value = btn.dataset.dinas || '';
        document.getElementById('edit-email-akun').value = btn.dataset.email || '';
        document.getElementById('edit-hp-akun').value = btn.dataset.hp || '';
        document.getElementById('edit-status-akun').value = btn.dataset.status || 'aktif';
        openModal('modal-edit-akun-dinas');
    }

    function openResetPasswordAkun(actionUrl, targetNama) {
        const form = document.getElementById('form-reset-password');
        form.action = actionUrl;
        document.getElementById('reset-target-nama').textContent = targetNama;
        openModal('modal-reset-password');
    }
</script>
@endsection
