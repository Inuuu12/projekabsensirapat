@extends('admin.layout.app')

@section('title', 'Daftar Ruangan')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] dark:text-white tracking-tight">Daftar Ruangan</h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-300 mt-1">Menampilkan informasi dan ketersediaan ruangan secara langsung.</p>
        </div>
        <button onclick="openModal('modal-tambah-ruang')" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2.5 px-5 rounded-xl flex items-center gap-2 transition shadow-xs self-start sm:self-auto cursor-pointer border border-transparent dark:border-[#10b981]/30">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Ruang</span>
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs flex items-center justify-between transition-colors">
            <div>
                <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Ruangan Tersedia</p>
                <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $totalTersedia ?? $ruang->where('status', 'tersedia')->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-[#1a2d29] border border-transparent dark:border-[#233a34] flex items-center justify-center p-2">
                <img src="{{ asset('assets/foto/ruangantersedia.png') }}" alt="Ruangan Tersedia" class="w-full h-full object-contain">
            </div>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs flex items-center justify-between transition-colors">
            <div>
                <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Ruangan Terpakai</p>
                <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $totalTerpakai ?? $ruang->where('status', 'terpakai')->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-[#1a2d29] border border-transparent dark:border-[#233a34] flex items-center justify-center p-2">
                <img src="{{ asset('assets/foto/ruanganterpakai.png') }}" alt="Ruangan Terpakai" class="w-full h-full object-contain">
            </div>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs flex items-center justify-between transition-colors">
            <div>
                <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Total Ruangan</p>
                <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $totalRuangan ?? $ruang->count() }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-[#1a2d29] border border-transparent dark:border-[#233a34] flex items-center justify-center p-2">
                <img src="{{ asset('assets/foto/totalruangan.png') }}" alt="Total Ruangan" class="w-full h-full object-contain">
            </div>
        </div>
    </div>

    <section class="overflow-hidden rounded-2xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#152420] shadow-xs transition-colors">
        <div class="flex flex-col gap-4 border-b border-gray-100 dark:border-[#233a34] px-6 py-6 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-extrabold text-[#0f513f] dark:text-white">Data Ruangan</h2>
            <form method="GET" action="{{ route('admin.ruang.lihat') }}" class="flex items-center gap-3">
                <label for="status-filter" class="text-sm font-medium text-slate-600 dark:text-gray-300">Filter by:</label>
                <select id="status-filter" name="status" onchange="this.form.submit()" class="h-10 rounded-md border border-slate-300 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-medium text-slate-700 dark:text-white outline-none focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    <option value="semua" @selected(($statusFilter ?? 'semua') === 'semua')>Status: Semua</option>
                    <option value="tersedia" @selected(($statusFilter ?? 'semua') === 'tersedia')>Tersedia</option>
                    <option value="terpakai" @selected(($statusFilter ?? 'semua') === 'terpakai')>Terpakai</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[860px]">
                <thead>
                    <tr class="bg-[#35635b] dark:bg-[#1b3832] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Ruangan</th>
                        <th class="px-6 py-4">Kapasitas</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#233a34] text-sm">
                    @forelse ($ruang as $item)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-[#1b332d] transition">
                            <td class="px-6 py-4 font-bold text-gray-800 dark:text-white">{{ $item->nama_ruang }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->kapasitas }} orang</td>
                            <td class="px-6 py-4">
                                @if (($item->status ?? 'tersedia') === 'terpakai')
                                    <span class="inline-flex rounded-lg bg-amber-50 dark:bg-amber-950/50 px-3 py-1 text-xs font-bold text-amber-700 dark:text-amber-300 border border-transparent dark:border-amber-800/50">Terpakai</span>
                                @else
                                    <span class="inline-flex rounded-lg bg-emerald-50 dark:bg-emerald-950/50 px-3 py-1 text-xs font-bold text-emerald-700 dark:text-emerald-300 border border-transparent dark:border-emerald-800/50">Tersedia</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->keterangan }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        type="button"
                                        onclick="openEditRuang(this)"
                                        data-action="{{ route('admin.ruang.update', $item->id_ruangrapat) }}"
                                        data-nama="{{ $item->nama_ruang }}"
                                        data-kapasitas="{{ $item->kapasitas }}"
                                        data-status="{{ $item->status ?? 'tersedia' }}"
                                        data-keterangan="{{ $item->keterangan }}"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-green-100 dark:hover:bg-[#23423b]"
                                        title="Edit Ruangan">
                                        <img src="{{ asset('assets/foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                        <span class="sr-only">Edit</span>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.ruang.destroy', $item->id_ruangrapat) }}', 'Hapus Ruangan?', 'Apakah Anda yakin ingin menghapus ruangan ini?')"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60"
                                        title="Hapus Ruangan">
                                        <img src="{{ asset('assets/foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                        <span class="sr-only">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada data ruangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-4 border-t border-gray-100 dark:border-[#233a34] px-6 py-5 text-sm text-slate-600 dark:text-gray-300 sm:flex-row sm:items-center sm:justify-between">
            <p>Menampilkan {{ $ruang->count() ? '1-' . $ruang->count() : '0' }} dari {{ $totalRuangan ?? $ruang->count() }} ruangan</p>
        </div>
    </section>
</div>

<div id="modal-tambah-ruang" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Tambah Ruangan</h3>
            <button type="button" onclick="closeModal('modal-tambah-ruang')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal tambah ruangan">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-tambah-ruang" method="POST" action="{{ route('admin.ruang.store') }}" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Nama Ruangan</label>
                    <input name="nama_ruang" type="text" required placeholder="Masukkan nama ruangan" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Kapasitas (Orang)</label>
                    <input name="kapasitas" type="number" min="1" required placeholder="Contoh: 30" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Status</label>
                    <div class="relative">
                        <select name="status" required class="h-10 sm:h-11 w-full appearance-none rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 pr-10 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
                            <option value="tersedia">Tersedia</option>
                            <option value="terpakai">Terpakai</option>
                        </select>
                        <svg class="pointer-events-none absolute right-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a] dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Keterangan</label>
                    <textarea name="keterangan" rows="3" required placeholder="Masukkan keterangan fasilitas ruangan..." class="w-full resize-none rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10"></textarea>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50 dark:bg-[#0f1c19] p-3 sm:px-6 sm:py-4 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-tambah-ruang')" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
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

<div id="modal-edit-ruang" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Edit Ruangan</h3>
            <button type="button" onclick="closeModal('modal-edit-ruang')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal edit ruangan">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-edit-ruang" method="POST" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Nama Ruangan</label>
                    <input id="edit-ruang-nama" name="nama_ruang" type="text" required placeholder="Masukkan nama ruangan" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Kapasitas (Orang)</label>
                    <input id="edit-ruang-kapasitas" name="kapasitas" type="number" min="1" required placeholder="Kapasitas ruangan" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Status</label>
                    <div class="relative">
                        <select id="edit-ruang-status" name="status" required class="h-10 sm:h-11 w-full appearance-none rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 pr-10 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
                            <option value="tersedia">Tersedia</option>
                            <option value="terpakai">Terpakai</option>
                        </select>
                        <svg class="pointer-events-none absolute right-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a] dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Keterangan</label>
                    <textarea id="edit-ruang-keterangan" name="keterangan" rows="3" required placeholder="Masukkan keterangan ruangan" class="w-full resize-none rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10"></textarea>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50 dark:bg-[#0f1c19] p-3 sm:px-6 sm:py-4 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-edit-ruang')" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
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
        if (id === 'modal-tambah-ruang') {
            const form = document.getElementById('form-tambah-ruang');
            if (form) form.reset();
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

    function openEditRuang(button) {
        document.getElementById('form-edit-ruang').action = button.dataset.action;
        document.getElementById('edit-ruang-nama').value = button.dataset.nama;
        document.getElementById('edit-ruang-kapasitas').value = button.dataset.kapasitas;
        document.getElementById('edit-ruang-status').value = button.dataset.status || 'tersedia';
        document.getElementById('edit-ruang-keterangan').value = button.dataset.keterangan;
        openModal('modal-edit-ruang');
    }
</script>
@endpush
@endsection
