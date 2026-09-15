@extends('admin.layout.app')

@section('title', 'Master Data Instansi')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Stat Cards Grid (Data Dinas & Data Kecamatan - Kunker/Dashboard Style) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Card 1: Data Dinas -->
        <a href="{{ route('admin.instansi.index', ['tab' => 'dinas']) }}"
           class="bg-white dark:bg-[#152420] border {{ ($tab ?? 'dinas') === 'dinas' ? 'border-[#35635b] ring-2 ring-[#35635b]/20 dark:border-emerald-500' : 'border-gray-100 dark:border-[#233a34] hover:border-gray-300 dark:hover:border-emerald-500/40' }} rounded-2xl p-5 shadow-xs transition-all cursor-pointer block group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">DATA DINAS</p>
                    <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $totalDinas ?? 0 }}</p>
                </div>
            </div>
        </a>

        <!-- Card 2: Data Kecamatan -->
        <a href="{{ route('admin.instansi.index', ['tab' => 'kecamatan']) }}"
           class="bg-white dark:bg-[#152420] border {{ ($tab ?? '') === 'kecamatan' ? 'border-[#35635b] ring-2 ring-[#35635b]/20 dark:border-emerald-500' : 'border-gray-100 dark:border-[#233a34] hover:border-gray-300 dark:hover:border-emerald-500/40' }} rounded-2xl p-5 shadow-xs transition-all cursor-pointer block group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">DATA KECAMATAN</p>
                    <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $totalKecamatan ?? 0 }}</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Category Filter Pills (Outside Card, Left) -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
        <a href="{{ route('admin.instansi.index', ['tab' => 'dinas', 'keyword' => request('keyword')]) }}"
           class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all whitespace-nowrap {{ ($tab ?? 'dinas') === 'dinas' ? 'bg-[#35635b] text-white shadow-sm' : 'bg-white dark:bg-[#152420] text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
            Data Dinas
        </a>
        <a href="{{ route('admin.instansi.index', ['tab' => 'kecamatan', 'keyword' => request('keyword')]) }}"
           class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all whitespace-nowrap {{ ($tab ?? '') === 'kecamatan' ? 'bg-[#35635b] text-white shadow-sm' : 'bg-white dark:bg-[#152420] text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
            Data Kecamatan
        </a>
    </div>

    @if (($tab ?? 'dinas') === 'dinas')
        <!-- TAB 1: DATA DINAS -->
        <div class="space-y-6">
            <!-- Table Section Dinas -->
            <div class="bg-white dark:bg-[#152420] rounded-xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
                <div class="border-b border-gray-100 dark:border-[#233a34] px-5 sm:px-6 py-4 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
                    <!-- Left: Title & Subtitle -->
                    <div class="shrink-0">
                        <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Daftar Dinas & Satuan Kerja</h2>
                        <p id="text-count-dinas" class="mt-0.5 text-xs text-gray-500 dark:text-gray-300">Menampilkan {{ $dinasList->count() }} dari {{ $totalDinas ?? $dinasList->count() }} data dinas.</p>
                    </div>

                    <!-- Middle: Search Bar -->
                    <form id="form-search-dinas" method="GET" action="{{ route('admin.instansi.index') }}" class="flex-1 max-w-xl w-full">
                        <input type="hidden" name="tab" value="dinas">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input
                                id="keyword"
                                name="keyword"
                                value="{{ $keyword ?? request('keyword') }}"
                                type="search"
                                class="h-10 w-full pl-10 pr-4 rounded-xl border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="Cari kode, nama dinas, alamat, telepon, email, kepala dinas...">
                        </div>
                    </form>

                    <!-- Right: Action Button -->
                    <button onclick="openModal('modal-tambah-dinas')" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2.5 px-4 rounded-xl flex items-center justify-center gap-1.5 transition shadow-xs text-xs border border-transparent dark:border-[#10b981]/30 cursor-pointer shrink-0">
                        <span class="text-base leading-none">+</span>
                        <span>Tambah Dinas</span>
                    </button>
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
                                        @if ($item->telepon) <p class="font-medium">{{ $item->telepon }}</p> @endif
                                        @if ($item->email) <p class="text-gray-500 dark:text-gray-400">{{ $item->email }}</p> @endif
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
                                            data-action="{{ route('admin.instansi.dinas.update', $item->id_dinas) }}"
                                            data-kode="{{ $item->kode_dinas }}"
                                            data-nama="{{ $item->nama_dinas }}"
                                            data-alamat="{{ $item->alamat }}"
                                            data-telepon="{{ $item->telepon }}"
                                            data-email="{{ $item->email }}"
                                            data-kepala="{{ $item->kepala_dinas }}"
                                            class="inline-flex items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-[#0f513f] dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-emerald-100 dark:hover:bg-emerald-900/60 cursor-pointer shadow-2xs">
                                            <span>Edit</span>
                                        </button>
                                        <form action="{{ route('admin.instansi.dinas.destroy', $item->id_dinas) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data dinas {{ $item->nama_dinas }}?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/50 text-red-600 dark:text-red-400 border border-red-200/80 dark:border-red-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer shadow-2xs">
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 text-sm font-medium">Belum ada data dinas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- TAB 2: DATA KECAMATAN -->
        <div class="space-y-6">
            <!-- Table Section Kecamatan -->
            <div class="bg-white dark:bg-[#152420] rounded-xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
                <div class="border-b border-gray-100 dark:border-[#233a34] px-5 sm:px-6 py-4 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
                    <!-- Left: Title & Subtitle -->
                    <div class="shrink-0">
                        <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Daftar Kecamatan</h2>
                        <p id="text-count-kecamatan" class="mt-0.5 text-xs text-gray-500 dark:text-gray-300">Menampilkan {{ $kecamatanList->count() }} dari {{ $totalKecamatan ?? $kecamatanList->count() }} data kecamatan.</p>
                    </div>

                    <!-- Middle: Search Bar -->
                    <form id="form-search-kecamatan" method="GET" action="{{ route('admin.instansi.index') }}" class="flex-1 max-w-xl w-full">
                        <input type="hidden" name="tab" value="kecamatan">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input
                                id="keyword"
                                name="keyword"
                                value="{{ $keyword ?? request('keyword') }}"
                                type="search"
                                class="h-10 w-full pl-10 pr-4 rounded-xl border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="Cari kode, nama kecamatan, alamat kantor, telepon, email, camat...">
                        </div>
                    </form>

                    <!-- Right: Action Button -->
                    <button onclick="openModal('modal-tambah-kecamatan')" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2.5 px-4 rounded-xl flex items-center justify-center gap-1.5 transition shadow-xs text-xs border border-transparent dark:border-[#10b981]/30 cursor-pointer shrink-0">
                        <span class="text-base leading-none">+</span>
                        <span>Tambah Kecamatan</span>
                    </button>
                </div>

            <!-- Table Section Kecamatan -->
            <div class="overflow-x-auto">
                <table class="w-full text-left min-w-[900px]">
                    <thead>
                        <tr class="bg-[#35635b] dark:bg-[#1b3832] text-white text-xs font-bold uppercase tracking-wider">
                            <th class="px-6 py-4">Kode</th>
                            <th class="px-6 py-4">Nama Kecamatan</th>
                            <th class="px-6 py-4">Camat</th>
                            <th class="px-6 py-4">Telepon / Email</th>
                            <th class="px-6 py-4">Alamat Kantor</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-[#233a34] text-sm">
                        @forelse ($kecamatanList as $item)
                            <tr class="hover:bg-gray-50/80 dark:hover:bg-[#1b332d] transition">
                                <td class="px-6 py-4 font-extrabold text-gray-900 dark:text-white uppercase">
                                    <span class="px-2.5 py-1 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-[#35635b] dark:text-emerald-400 text-xs font-bold border border-emerald-200/60 dark:border-emerald-800/40">
                                        {{ $item->kode_kecamatan ?: '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-800 dark:text-slate-100">{{ $item->nama_kecamatan }}</td>
                                <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->camat ?: '-' }}</td>
                                <td class="px-6 py-4 text-gray-700 dark:text-slate-200">
                                    <div class="text-xs">
                                        @if ($item->telepon) <p class="font-medium">{{ $item->telepon }}</p> @endif
                                        @if ($item->email) <p class="text-gray-500 dark:text-gray-400">{{ $item->email }}</p> @endif
                                        @if (!$item->telepon && !$item->email) - @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-slate-300 text-xs max-w-xs truncate">{{ $item->alamat_kantor ?: '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2 whitespace-nowrap">
                                        <button
                                            type="button"
                                            onclick="openEditKecamatan(this)"
                                            data-id="{{ $item->id_kecamatan }}"
                                            data-action="{{ route('admin.instansi.kecamatan.update', $item->id_kecamatan) }}"
                                            data-kode="{{ $item->kode_kecamatan }}"
                                            data-nama="{{ $item->nama_kecamatan }}"
                                            data-alamat="{{ $item->alamat_kantor }}"
                                            data-telepon="{{ $item->telepon }}"
                                            data-email="{{ $item->email }}"
                                            data-camat="{{ $item->camat }}"
                                            class="inline-flex items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-[#0f513f] dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-emerald-100 dark:hover:bg-emerald-900/60 cursor-pointer shadow-2xs">
                                            <span>Edit</span>
                                        </button>
                                        <form action="{{ route('admin.instansi.kecamatan.destroy', $item->id_kecamatan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kecamatan {{ $item->nama_kecamatan }}?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/50 text-red-600 dark:text-red-400 border border-red-200/80 dark:border-red-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer shadow-2xs">
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 text-sm font-medium">Belum ada data kecamatan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<!-- Modal Tambah Dinas -->
<div id="modal-tambah-dinas" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-lg flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-start justify-between border-b border-gray-100 dark:border-[#233a34] px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-[#152420] shrink-0">
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-gray-900 dark:text-white">Tambah Data Dinas</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Input data dinas / OPD baru di Kabupaten Bogor</p>
            </div>
            <button type="button" onclick="closeModal('modal-tambah-dinas')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.instansi.dinas.store') }}" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="flex-1 min-h-0 space-y-4 overflow-y-auto p-5 sm:p-6 custom-scrollbar">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Kode Dinas</label>
                    <input type="text" name="kode_dinas" placeholder="Contoh: DISKOMINFO" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Nama Dinas / OPD <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_dinas" required placeholder="Contoh: Dinas Komunikasi dan Informatika" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Kepala Dinas</label>
                    <input type="text" name="kepala_dinas" placeholder="Contoh: Drs. H. Bayu Ramadhani, M.Si" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Telepon</label>
                        <input type="text" name="telepon" placeholder="(021) ..." class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Email</label>
                        <input type="email" name="email" placeholder="diskominfo@bogorkab.go.id" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Alamat</label>
                    <textarea name="alamat" rows="2" placeholder="Jl. Tegar Beriman No. 1..." class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] p-3 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]"></textarea>
                </div>
            </div>
            <div class="flex justify-end items-center gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#0f1c19] px-5 py-4 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-tambah-dinas')" class="h-10 rounded-xl px-5 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer">Batal</button>
                <button type="submit" class="h-10 rounded-xl bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] px-6 text-xs font-bold text-white transition cursor-pointer shadow-sm">Simpan Dinas</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Dinas -->
<div id="modal-edit-dinas" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-lg flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-start justify-between border-b border-gray-100 dark:border-[#233a34] px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-[#152420] shrink-0">
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-gray-900 dark:text-white">Edit Data Dinas</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui rincian informasi data dinas terpilih</p>
            </div>
            <button type="button" onclick="closeModal('modal-edit-dinas')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="form-edit-dinas" method="POST" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="flex-1 min-h-0 space-y-4 overflow-y-auto p-5 sm:p-6 custom-scrollbar">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Kode Dinas</label>
                    <input id="edit-kode_dinas" type="text" name="kode_dinas" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Nama Dinas / OPD <span class="text-red-500">*</span></label>
                    <input id="edit-nama_dinas" type="text" name="nama_dinas" required class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Kepala Dinas</label>
                    <input id="edit-kepala_dinas" type="text" name="kepala_dinas" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Telepon</label>
                        <input id="edit-telepon_dinas" type="text" name="telepon" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Email</label>
                        <input id="edit-email_dinas" type="email" name="email" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Alamat</label>
                    <textarea id="edit-alamat_dinas" name="alamat" rows="2" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] p-3 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]"></textarea>
                </div>
            </div>
            <div class="flex justify-end items-center gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#0f1c19] px-5 py-4 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-edit-dinas')" class="h-10 rounded-xl px-5 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer">Batal</button>
                <button type="submit" class="h-10 rounded-xl bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] px-6 text-xs font-bold text-white transition cursor-pointer shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Kecamatan -->
<div id="modal-tambah-kecamatan" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-lg flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-start justify-between border-b border-gray-100 dark:border-[#233a34] px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-[#152420] shrink-0">
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-gray-900 dark:text-white">Tambah Data Kecamatan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Input data wilayah kecamatan baru di Kabupaten Bogor</p>
            </div>
            <button type="button" onclick="closeModal('modal-tambah-kecamatan')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.instansi.kecamatan.store') }}" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="flex-1 min-h-0 space-y-4 overflow-y-auto p-5 sm:p-6 custom-scrollbar">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Kode Kecamatan</label>
                    <input type="text" name="kode_kecamatan" placeholder="Contoh: KEC-01" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Nama Kecamatan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kecamatan" required placeholder="Contoh: Kecamatan Cibinong" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Nama Camat</label>
                    <input type="text" name="camat" placeholder="Contoh: Drs. H. Ahmad Fauzi, M.Si" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Telepon</label>
                        <input type="text" name="telepon" placeholder="(021) ..." class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Email</label>
                        <input type="email" name="email" placeholder="kecamatan@bogorkab.go.id" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Alamat Kantor</label>
                    <textarea name="alamat_kantor" rows="2" placeholder="Jl. Raya Cibinong No. 1..." class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] p-3 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]"></textarea>
                </div>
            </div>
            <div class="flex justify-end items-center gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#0f1c19] px-5 py-4 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-tambah-kecamatan')" class="h-10 rounded-xl px-5 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer">Batal</button>
                <button type="submit" class="h-10 rounded-xl bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] px-6 text-xs font-bold text-white transition cursor-pointer shadow-sm">Simpan Kecamatan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kecamatan -->
<div id="modal-edit-kecamatan" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-lg flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-start justify-between border-b border-gray-100 dark:border-[#233a34] px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-[#152420] shrink-0">
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-gray-900 dark:text-white">Edit Data Kecamatan</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui rincian informasi data kecamatan terpilih</p>
            </div>
            <button type="button" onclick="closeModal('modal-edit-kecamatan')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="form-edit-kecamatan" method="POST" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="flex-1 min-h-0 space-y-4 overflow-y-auto p-5 sm:p-6 custom-scrollbar">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Kode Kecamatan</label>
                    <input id="edit-kode_kecamatan" type="text" name="kode_kecamatan" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Nama Kecamatan <span class="text-red-500">*</span></label>
                    <input id="edit-nama_kecamatan" type="text" name="nama_kecamatan" required class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Nama Camat</label>
                    <input id="edit-camat" type="text" name="camat" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Telepon</label>
                        <input id="edit-telepon" type="text" name="telepon" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Email</label>
                        <input id="edit-email" type="email" name="email" class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300 mb-1.5">Alamat Kantor</label>
                    <textarea id="edit-alamat_kantor" name="alamat_kantor" rows="2" class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] p-3 text-xs sm:text-sm text-gray-700 dark:text-white outline-none focus:border-[#35635b]"></textarea>
                </div>
            </div>
            <div class="flex justify-end items-center gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#0f1c19] px-5 py-4 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-edit-kecamatan')" class="h-10 rounded-xl px-5 text-xs font-semibold text-gray-600 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer">Batal</button>
                <button type="submit" class="h-10 rounded-xl bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] px-6 text-xs font-bold text-white transition cursor-pointer shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditDinas(button) {
        document.getElementById('form-edit-dinas').action = button.dataset.action;
        document.getElementById('edit-kode_dinas').value = button.dataset.kode || '';
        document.getElementById('edit-nama_dinas').value = button.dataset.nama || '';
        document.getElementById('edit-kepala_dinas').value = button.dataset.kepala || '';
        document.getElementById('edit-telepon_dinas').value = button.dataset.telepon || '';
        document.getElementById('edit-email_dinas').value = button.dataset.email || '';
        document.getElementById('edit-alamat_dinas').value = button.dataset.alamat || '';
        openModal('modal-edit-dinas');
    }

    function openEditKecamatan(button) {
        document.getElementById('form-edit-kecamatan').action = button.dataset.action;
        document.getElementById('edit-kode_kecamatan').value = button.dataset.kode || '';
        document.getElementById('edit-nama_kecamatan').value = button.dataset.nama || '';
        document.getElementById('edit-camat').value = button.dataset.camat || '';
        document.getElementById('edit-telepon').value = button.dataset.telepon || '';
        document.getElementById('edit-email').value = button.dataset.email || '';
        document.getElementById('edit-alamat_kantor').value = button.dataset.alamat || '';
        openModal('modal-edit-kecamatan');
    }
</script>
@endpush
@endsection
