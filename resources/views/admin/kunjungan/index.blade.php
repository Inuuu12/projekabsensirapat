@extends('admin.layout.app')

@section('title', 'Daftar Kunjungan')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] dark:text-white tracking-tight">Daftar Kunjungan</h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-300 mt-1">Kelola dan pantau seluruh riwayat kunjungan di sini.</p>
        </div>
        <button onclick="openModal('modal-tambah-kunjungan')" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2.5 px-5 rounded-xl transition shadow-xs self-start sm:self-auto cursor-pointer border border-transparent dark:border-[#10b981]/30">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Kunjungan</span>
        </button>
    </div>

    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs transition-colors">
        <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Total Kunjungan</p>
        <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $totalKunjungan ?? $kunjungan->count() }}</p>
    </div>

    <form id="form-search-kunjungan" method="GET" action="{{ route('admin.kunjungan.lihat') }}" class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] p-5 transition-colors">
        <div class="grid grid-cols-1 gap-3 xl:grid-cols-[1fr_220px_220px_180px] xl:items-end">
            <div>
                <label for="keyword" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Search</label>
                <input
                    id="keyword"
                    name="keyword"
                    value="{{ $keyword ?? request('keyword') }}"
                    type="search"
                    class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500"
                    placeholder="Cari pengunjung, pihak dituju, instansi, no HP, email, keperluan...">
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
                <label for="tanggal-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Tanggal</label>
                <input
                    id="tanggal-filter"
                    name="tanggal"
                    value="{{ $tanggalFilter ?? request('tanggal') }}"
                    type="date"
                    class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-medium text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
            </div>
        </div>
    </form>

    <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
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
                                <div class="flex justify-center gap-2">
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
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-green-100 dark:hover:bg-[#23423b] cursor-pointer"
                                        title="Edit Kunjungan">
                                        <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                        <span class="sr-only">Edit</span>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.kunjungan.destroy', $item->id_kunjungan) }}', 'Hapus Kunjungan?', 'Apakah Anda yakin ingin menghapus kunjungan ini?')"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer"
                                        title="Hapus Kunjungan">
                                        <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                        <span class="sr-only">Hapus</span>
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

<div id="modal-tambah-kunjungan" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] border border-transparent dark:border-[#284c43] shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Tambah Kunjungan</h3>
            <button type="button" onclick="closeModal('modal-tambah-kunjungan')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-tambah-kunjungan" method="POST" action="{{ route('admin.kunjungan.store') }}" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @if ($errors->any() && !old('_method'))
                <div class="px-5 pt-4 sm:px-6">
                    <div class="rounded-xl border border-red-200 bg-red-50 dark:bg-red-950/50 px-4 py-3 text-sm font-semibold text-red-700 dark:text-red-300">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-1 gap-x-4 gap-y-4 overflow-y-auto px-5 py-5 sm:grid-cols-2 sm:px-6">
                @include('admin.kunjungan.form-fields')
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50 dark:bg-[#0f1c19] px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closeModal('modal-tambah-kunjungan')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 dark:text-gray-300 transition hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#04733f] px-5 text-sm font-bold text-white transition hover:bg-[#035f35] cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-kunjungan" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] border border-transparent dark:border-[#284c43] shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Edit Kunjungan</h3>
            <button type="button" onclick="closeModal('modal-edit-kunjungan')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-edit-kunjungan" method="POST" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-id_kunjungan" name="id_kunjungan">
            @if ($errors->any() && old('_method') === 'PUT')
                <div class="px-5 pt-4 sm:px-6">
                    <div class="rounded-xl border border-red-200 bg-red-50 dark:bg-red-950/50 px-4 py-3 text-sm font-semibold text-red-700 dark:text-red-300">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-1 gap-x-4 gap-y-4 overflow-y-auto px-5 py-5 sm:grid-cols-2 sm:px-6">
                @include('admin.kunjungan.form-fields', ['prefix' => 'edit-'])
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50 dark:bg-[#0f1c19] px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closeModal('modal-edit-kunjungan')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 dark:text-gray-300 transition hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#04733f] px-5 text-sm font-bold text-white transition hover:bg-[#035f35] cursor-pointer">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.replace('hidden', 'flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.replace('flex', 'hidden');
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
            tanggalFilter.addEventListener('change', fetchResults);
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
