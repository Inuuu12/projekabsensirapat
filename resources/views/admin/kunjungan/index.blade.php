@extends('admin.layout.app')

@section('title', 'Daftar Kunjungan')

@section('header_actions')
<button onclick="openModal('modal-tambah-kunjungan')" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2 px-4 rounded-xl flex items-center justify-center gap-1.5 transition shadow-xs text-xs border border-transparent dark:border-[#10b981]/30 cursor-pointer">
    <span class="text-base leading-none">+</span>
    <span>Tambah Kunjungan</span>
</button>
@endsection

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-xl p-5 shadow-xs transition-colors">
        <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Total Kunjungan</p>
        <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $totalKunjungan ?? $kunjungan->count() }}</p>
    </div>

    <!-- Status Filter Pills (Kunker Style) -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
        <a href="{{ route('admin.kunjungan.lihat') }}"
           class="px-5 py-2 rounded-full text-xs font-extrabold transition-all whitespace-nowrap {{ empty(request('tanggal')) ? 'bg-[#35635b] text-white shadow-sm' : 'bg-white dark:bg-[#152420] text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
            Semua Kunjungan ({{ $totalKunjungan ?? $kunjungan->count() }})
        </a>
        <a href="{{ route('admin.kunjungan.lihat', ['tanggal' => now()->format('Y-m-d')]) }}"
           class="px-5 py-2 rounded-full text-xs font-extrabold transition-all whitespace-nowrap {{ request('tanggal') === now()->format('Y-m-d') ? 'bg-[#35635b] text-white shadow-sm' : 'bg-white dark:bg-[#152420] text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
            📅 Kunjungan Hari Ini
        </a>
    </div>

    <form id="form-search-kunjungan" method="GET" action="{{ route('admin.kunjungan.lihat') }}" class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] p-4 sm:p-5 transition-colors">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-[1fr_200px_200px_180px_auto] xl:items-end gap-3 sm:gap-4">
            <div>
                <label for="keyword" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Search</label>
                <div class="relative">
                    <input
                        id="keyword"
                        name="keyword"
                        value="{{ $keyword ?? request('keyword') }}"
                        type="search"
                        class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] pl-10 pr-4 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500"
                        placeholder="Cari pengunjung, pihak dituju, instansi, no HP, email, keperluan...">
                    <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <label for="pihak-dituju-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Pihak Dituju</label>
                <select
                    id="pihak-dituju-filter"
                    name="pihak_dituju"
                    class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-medium text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    <option value="semua" @selected(($pihakDitujuFilter ?? 'semua') === 'semua')>Semua Pihak</option>
                    @foreach (($pihakDitujuOptions ?? collect()) as $pihakDituju)
                        <option value="{{ $pihakDituju }}" @selected(($pihakDitujuFilter ?? 'semua') === $pihakDituju)>{{ $pihakDituju }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="keperluan-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Keperluan</label>
                <select
                    id="keperluan-filter"
                    name="keperluan"
                    class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-medium text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    <option value="semua" @selected(($keperluanFilter ?? 'semua') === 'semua')>Semua Keperluan</option>
                    @foreach (($keperluanOptions ?? collect()) as $keperluan)
                        <option value="{{ $keperluan }}" @selected(($keperluanFilter ?? 'semua') === $keperluan)>{{ \Illuminate\Support\Str::limit($keperluan, 42) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="tanggal-filter" class="block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Tanggal</label>
                    <button type="button" onclick="clearTanggalFilter()" id="btn-reset-tanggal" class="{{ empty($tanggalFilter) ? 'hidden' : '' }} text-[11px] font-bold text-red-500 hover:underline cursor-pointer">Reset Tgl</button>
                </div>
                <div class="relative">
                    <input
                        id="tanggal-filter"
                        name="tanggal"
                        value="{{ $tanggalFilter ?? request('tanggal') }}"
                        type="date"
                        class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-sm font-medium text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                </div>
            </div>
            <div>
                <a href="{{ route('admin.kunjungan.lihat') }}" class="h-11 inline-flex items-center justify-center gap-1.5 px-4 rounded-xl border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] text-xs font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 transition whitespace-nowrap w-full" title="Reset Semua Filter">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Reset</span>
                </a>
            </div>
        </div>
    </form>

    <div class="bg-white dark:bg-[#152420] rounded-xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
        <div class="border-b border-gray-100 dark:border-[#233a34] px-6 py-4">
            <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Daftar Kunjungan</h2>
            <p id="text-count-kunjungan" class="mt-1 text-xs text-gray-500 dark:text-gray-300">Menampilkan {{ $kunjungan->count() }} dari {{ $totalKunjungan ?? $kunjungan->count() }} kunjungan.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[1040px]">
                <thead>
                    <tr class="bg-[#35635b] dark:bg-[#1b3832] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Pengunjung</th>
                        <th class="px-6 py-4">Pihak Dituju</th>
                        <th class="px-6 py-4">Instansi</th>
                        <th class="px-6 py-4">No HP</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Keperluan</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#233a34] text-sm">
                    @forelse ($kunjungan as $item)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-[#1b332d] transition">
                            <td class="px-6 py-4 font-bold text-[#35635b] dark:text-emerald-400">{{ $item->nama_pengunjung ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->nama_pejabat ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->asal_instansi ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->nomorhp_pengunjung ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->email_pengunjung ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->keperluan }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->waktu ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200 whitespace-nowrap">
                                {{ $item->tanggal_kunjungan ? \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2 whitespace-nowrap">
                                    <button
                                        type="button"
                                        onclick="openEditKunjungan(this)"
                                        data-id="{{ $item->id_kunjungan }}"
                                        data-action="{{ route('admin.kunjungan.update', $item->id_kunjungan) }}"
                                        data-pejabat="{{ $item->nama_pejabat }}"
                                        data-pengunjung="{{ $item->nama_pengunjung }}"
                                        data-instansi="{{ $item->asal_instansi }}"
                                        data-nomor="{{ $item->nomorhp_pengunjung }}"
                                        data-email="{{ $item->email_pengunjung }}"
                                        data-keperluan="{{ $item->keperluan }}"
                                        data-waktu="{{ $item->waktu }}"
                                        data-tanggal="{{ $item->tanggal_kunjungan }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-[#0f513f] dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-emerald-100 dark:hover:bg-emerald-900/60 cursor-pointer shadow-2xs"
                                        title="Edit Kunjungan">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Edit</span>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.kunjungan.destroy', $item->id_kunjungan) }}', 'Hapus Kunjungan?', 'Apakah Anda yakin ingin menghapus kunjungan ini?')"
                                        class="inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/50 text-red-700 dark:text-red-300 border border-red-200/80 dark:border-red-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer shadow-2xs"
                                        title="Hapus Kunjungan">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada data kunjungan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-tambah-kunjungan" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-start justify-between border-b border-gray-100 dark:border-[#233a34] px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-[#152420] shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-[#0f513f] dark:text-emerald-400 shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Tambah Kunjungan Kerja</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Lengkapi formulir di bawah ini untuk menambahkan data kunjungan baru</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modal-tambah-kunjungan')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer" aria-label="Tutup modal">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="form-tambah-kunjungan" method="POST" action="{{ route('admin.kunjungan.store') }}" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @if ($errors->any() && !old('_method'))
                <div class="px-4 pt-3 sm:px-6 sm:pt-4">
                    <div class="rounded-xl border border-red-200 bg-red-50 dark:bg-red-950/50 px-4 py-3 text-sm font-semibold text-red-700 dark:text-red-300">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif
            <div class="flex-1 min-h-0 grid grid-cols-1 gap-3 sm:gap-4 overflow-y-auto p-4 sm:p-6 sm:grid-cols-2">
                @include('admin.kunjungan.form-fields')
            </div>
            <div class="flex justify-end items-center gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#0f1c19] px-5 py-4 sm:px-6 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-tambah-kunjungan')" class="h-10 rounded-xl px-5 text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#0f513f] hover:bg-[#0b3f31] dark:bg-[#107050] dark:hover:bg-[#0c5940] px-6 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    <span>Simpan Kunjungan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-kunjungan" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-start justify-between border-b border-gray-100 dark:border-[#233a34] px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-[#152420] shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-[#0f513f] dark:text-emerald-400 shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Edit Kunjungan Kerja</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui informasi data kunjungan kerja terpilih</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modal-edit-kunjungan')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer" aria-label="Tutup modal">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="form-edit-kunjungan" method="POST" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-id_kunjungan" name="id_kunjungan">
            @if ($errors->any() && old('_method') === 'PUT')
                <div class="px-4 pt-3 sm:px-6 sm:pt-4">
                    <div class="rounded-xl border border-red-200 bg-red-50 dark:bg-red-950/50 px-4 py-3 text-sm font-semibold text-red-700 dark:text-red-300">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif
            <div class="flex-1 min-h-0 grid grid-cols-1 gap-3 sm:gap-4 overflow-y-auto p-4 sm:p-6 sm:grid-cols-2">
                @include('admin.kunjungan.form-fields', ['prefix' => 'edit-'])
            </div>
            <div class="flex justify-end items-center gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#0f1c19] px-5 py-4 sm:px-6 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-edit-kunjungan')" class="h-10 rounded-xl px-5 text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#0f513f] hover:bg-[#0b3f31] dark:bg-[#107050] dark:hover:bg-[#0c5940] px-6 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
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

    function openEditKunjungan(button) {
        document.getElementById('form-edit-kunjungan').action = button.dataset.action;
        document.getElementById('edit-id_kunjungan').value = button.dataset.id;
        const pejabatVal = button.dataset.pejabat || '';
        if (document.getElementById('edit-nama_pegawai')) document.getElementById('edit-nama_pegawai').value = pejabatVal;
        if (document.getElementById('edit-nama_pejabat')) document.getElementById('edit-nama_pejabat').value = pejabatVal;
        document.getElementById('edit-nama_pengunjung').value = button.dataset.pengunjung || '';
        document.getElementById('edit-asal_instansi').value = button.dataset.instansi || '';
        document.getElementById('edit-nomorhp_pengunjung').value = button.dataset.nomor || '';
        document.getElementById('edit-email_pengunjung').value = button.dataset.email || '';
        document.getElementById('edit-keperluan').value = button.dataset.keperluan || '';
        document.getElementById('edit-waktu').value = button.dataset.waktu || '';
        document.getElementById('edit-tanggal_kunjungan').value = button.dataset.tanggal || '';
        openModal('modal-edit-kunjungan');
    }

    function initLiveSearch() {
        const form = document.getElementById('form-search-kunjungan');
        const searchInput = document.getElementById('keyword');
        const pihakFilter = document.getElementById('pihak-dituju-filter');
        const keperluanFilter = document.getElementById('keperluan-filter');
        const tanggalFilter = document.getElementById('tanggal-filter');
        const tableBody = document.querySelector('table tbody');
        const countText = document.getElementById('text-count-kunjungan');
        
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

                const newCount = doc.getElementById('text-count-kunjungan');
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

        if(pihakFilter) {
            pihakFilter.addEventListener('change', fetchResults);
        }
        if(keperluanFilter) {
            keperluanFilter.addEventListener('change', fetchResults);
        }
        if(tanggalFilter) {
            tanggalFilter.addEventListener('change', function() {
                const btnReset = document.getElementById('btn-reset-tanggal');
                if (btnReset) {
                    btnReset.classList.toggle('hidden', !tanggalFilter.value);
                }
                fetchResults();
            });
        }
    }

    function clearTanggalFilter() {
        const input = document.getElementById('tanggal-filter');
        const btnReset = document.getElementById('btn-reset-tanggal');
        if (input) {
            input.value = '';
            if (btnReset) btnReset.classList.add('hidden');
            input.dispatchEvent(new Event('change'));
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initLiveSearch();

        @if($errors->any())
            @if(old('_method') === 'PUT')
                const editId = "{{ old('id_kunjungan') }}";
                const editBtn = document.querySelector(`button[data-id="${editId}"]`);
                if (editBtn) {
                    openEditKunjungan(editBtn);
                    document.getElementById('edit-nama_pegawai').value = @json(old('nama_pegawai'));
                    document.getElementById('edit-nama_pejabat').value = @json(old('nama_pejabat'));
                    document.getElementById('edit-nama_pengunjung').value = @json(old('nama_pengunjung'));
                    document.getElementById('edit-asal_instansi').value = @json(old('asal_instansi'));
                    document.getElementById('edit-nomorhp_pengunjung').value = @json(old('nomorhp_pengunjung'));
                    document.getElementById('edit-email_pengunjung').value = @json(old('email_pengunjung'));
                    document.getElementById('edit-keperluan').value = @json(old('keperluan'));
                    document.getElementById('edit-waktu').value = @json(old('waktu'));
                    document.getElementById('edit-tanggal_kunjungan').value = @json(old('tanggal_kunjungan'));
                }
            @else
                openModal('modal-tambah-kunjungan');
                document.getElementById('nama_pegawai').value = @json(old('nama_pegawai'));
                document.getElementById('nama_pejabat').value = @json(old('nama_pejabat'));
                document.getElementById('nama_pengunjung').value = @json(old('nama_pengunjung'));
                document.getElementById('asal_instansi').value = @json(old('asal_instansi'));
                document.getElementById('nomorhp_pengunjung').value = @json(old('nomorhp_pengunjung'));
                document.getElementById('email_pengunjung').value = @json(old('email_pengunjung'));
                document.getElementById('keperluan').value = @json(old('keperluan'));
                document.getElementById('waktu').value = @json(old('waktu'));
                document.getElementById('tanggal_kunjungan').value = @json(old('tanggal_kunjungan'));
            @endif
        @endif
    });
</script>
@endpush
@endsection
