@extends('admin.layout.app')

@section('title', 'Master Data Dinas')

@section('header_actions')
<button onclick="openModal('modal-tambah-dinas')" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2 px-4 rounded-xl flex items-center justify-center gap-1.5 transition shadow-xs text-xs border border-transparent dark:border-[#10b981]/30 cursor-pointer">
    <span class="text-base leading-none">+</span>
    <span>Tambah Dinas</span>
</button>
@endsection

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Stat Card -->
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-xl p-5 shadow-xs transition-colors">
        <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Total Master Dinas</p>
        <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $totalDinas ?? $dinasList->count() }}</p>
    </div>

    <!-- Filter & Search Bar -->
    <form id="form-search-dinas" method="GET" action="{{ route('admin.dinas.index') }}" class="bg-white dark:bg-[#152420] rounded-xl shadow-xs border border-gray-100 dark:border-[#233a34] p-4 sm:p-5 transition-colors">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-[1fr_auto] xl:items-end gap-3 sm:gap-4">
            <div>
                <label for="keyword" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Cari Dinas / OPD</label>
                <div class="relative">
                    <input
                        id="keyword"
                        name="keyword"
                        value="{{ $keyword ?? request('keyword') }}"
                        type="search"
                        class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] pl-10 pr-4 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500"
                        placeholder="Cari kode, nama dinas, alamat, telepon, email, kepala dinas...">
                    <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <a href="{{ route('admin.dinas.index') }}" class="h-11 inline-flex items-center justify-center gap-1.5 px-4 rounded-xl border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] text-xs font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 transition whitespace-nowrap w-full" title="Reset Filter">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Reset</span>
                </a>
            </div>
        </div>
    </form>

    <!-- Table Section -->
    <div class="bg-white dark:bg-[#152420] rounded-xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
        <div class="border-b border-gray-100 dark:border-[#233a34] px-6 py-4">
            <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Daftar Dinas & Satuan Kerja</h2>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">Menampilkan {{ $dinasList->count() }} dari {{ $totalDinas ?? $dinasList->count() }} data dinas.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[900px]">
                <thead>
                    <tr class="bg-[#35635b] dark:bg-[#1b3832] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Nama Dinas / OPD</th>
                        <th class="px-6 py-4">Kepala Dinas</th>
                        <th class="px-6 py-4">Telepon / Email</th>
                        <th class="px-6 py-4">Alamat</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#233a34] text-sm">
                    @forelse ($dinasList as $item)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-[#1b332d] transition">
                            <td class="px-6 py-4 font-extrabold text-gray-900 dark:text-white uppercase">
                                <span class="px-2.5 py-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-[#35635b] dark:text-emerald-400 text-xs font-bold border border-emerald-200/60 dark:border-emerald-800/40">
                                    {{ $item->kode_dinas ?: '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800 dark:text-slate-100">{{ $item->nama_dinas }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->kepala_dinas ?: '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">
                                <div class="text-xs">
                                    @if ($item->telepon) <p class="font-medium">📞 {{ $item->telepon }}</p> @endif
                                    @if ($item->email) <p class="text-gray-500 dark:text-gray-400">✉️ {{ $item->email }}</p> @endif
                                    @if (!$item->telepon && !$item->email) - @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-slate-300 text-xs max-w-xs truncate">{{ $item->alamat ?: '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2 whitespace-nowrap">
                                    <button
                                        type="button"
                                        onclick="openEditDinas(this)"
                                        data-id="{{ $item->id_dinas }}"
                                        data-action="{{ route('admin.dinas.update', $item->id_dinas) }}"
                                        data-kode="{{ $item->kode_dinas }}"
                                        data-nama="{{ $item->nama_dinas }}"
                                        data-alamat="{{ $item->alamat }}"
                                        data-telepon="{{ $item->telepon }}"
                                        data-email="{{ $item->email }}"
                                        data-kepala="{{ $item->kepala_dinas }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-[#0f513f] dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-emerald-100 dark:hover:bg-emerald-900/60 cursor-pointer shadow-2xs">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Edit</span>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.dinas.destroy', $item->id_dinas) }}', 'Hapus Dinas?', 'Apakah Anda yakin ingin menghapus data dinas ini?')"
                                        class="inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/50 text-red-700 dark:text-red-300 border border-red-200/80 dark:border-red-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer shadow-2xs">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada data dinas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Dinas -->
<div id="modal-tambah-dinas" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-2xl max-w-lg w-full p-6 text-left relative max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-100 dark:border-[#233a34]">
            <h3 class="text-base font-extrabold text-gray-900 dark:text-white">Tambah Master Dinas</h3>
            <button onclick="closeModal('modal-tambah-dinas')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">✕</button>
        </div>
        <form action="{{ route('admin.dinas.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Kode Dinas / Singkatan</label>
                <input type="text" name="kode_dinas" placeholder="Contoh: DISKOMINFO" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Nama Dinas / OPD *</label>
                <input type="text" name="nama_dinas" required placeholder="Contoh: Dinas Komunikasi dan Informatika" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Nama Kepala Dinas / Pimpinan</label>
                <input type="text" name="kepala_dinas" placeholder="Nama Kepala Dinas lengkap beserta gelar" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">No Telepon</label>
                    <input type="text" name="telepon" placeholder="(021) 875xxx" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Email Resmi</label>
                    <input type="email" name="email" placeholder="dinas@bogorkab.go.id" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Alamat Kantor</label>
                <textarea name="alamat" rows="2" placeholder="Alamat lengkap kantor dinas" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]"></textarea>
            </div>
            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 dark:border-[#233a34]">
                <button type="button" onclick="closeModal('modal-tambah-dinas')" class="px-4 py-2 text-xs font-bold rounded-xl border border-gray-300 dark:border-[#284c43] text-gray-700 dark:text-gray-300">Batal</button>
                <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl bg-[#35635b] dark:bg-[#107050] text-white hover:bg-[#2b4f49]">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Dinas -->
<div id="modal-edit-dinas" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-2xl max-w-lg w-full p-6 text-left relative max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-100 dark:border-[#233a34]">
            <h3 class="text-base font-extrabold text-gray-900 dark:text-white">Edit Master Dinas</h3>
            <button onclick="closeModal('modal-edit-dinas')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">✕</button>
        </div>
        <form id="form-edit-dinas" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Kode Dinas / Singkatan</label>
                <input type="text" id="edit-kode-dinas" name="kode_dinas" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Nama Dinas / OPD *</label>
                <input type="text" id="edit-nama-dinas" name="nama_dinas" required class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Nama Kepala Dinas / Pimpinan</label>
                <input type="text" id="edit-kepala-dinas" name="kepala_dinas" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">No Telepon</label>
                    <input type="text" id="edit-telepon-dinas" name="telepon" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Email Resmi</label>
                    <input type="email" id="edit-email-dinas" name="email" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Alamat Kantor</label>
                <textarea id="edit-alamat-dinas" name="alamat" rows="2" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]"></textarea>
            </div>
            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 dark:border-[#233a34]">
                <button type="button" onclick="closeModal('modal-edit-dinas')" class="px-4 py-2 text-xs font-bold rounded-xl border border-gray-300 dark:border-[#284c43] text-gray-700 dark:text-gray-300">Batal</button>
                <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl bg-[#35635b] dark:bg-[#107050] text-white hover:bg-[#2b4f49]">Perbarui Data</button>
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

    function openEditDinas(btn) {
        const form = document.getElementById('form-edit-dinas');
        form.action = btn.dataset.action;
        document.getElementById('edit-kode-dinas').value = btn.dataset.kode || '';
        document.getElementById('edit-nama-dinas').value = btn.dataset.nama || '';
        document.getElementById('edit-kepala-dinas').value = btn.dataset.kepala || '';
        document.getElementById('edit-telepon-dinas').value = btn.dataset.telepon || '';
        document.getElementById('edit-email-dinas').value = btn.dataset.email || '';
        document.getElementById('edit-alamat-dinas').value = btn.dataset.alamat || '';
        openModal('modal-edit-dinas');
    }
</script>
@endsection
