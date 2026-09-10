@extends('admin.layout.app')

@section('title', 'Data Tamu')

@section('header_actions')
<button onclick="openModal('modal-tambah-tamu')" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2 px-4 rounded-xl flex items-center justify-center gap-1.5 transition shadow-xs text-xs border border-transparent dark:border-[#10b981]/30 cursor-pointer">
    <span class="text-base leading-none">+</span>
    <span>Tambah Tamu</span>
</button>
@endsection

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs transition-colors">
        <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Total Tamu</p>
        <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $totalTamu ?? $tamu->count() }}</p>
    </div>

    <form id="form-search-tamu" method="GET" action="{{ route('admin.tamu.lihat') }}" class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] p-5 transition-colors">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-end">
            <div class="flex-1">
                <label for="keyword" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-300">Search</label>
                <input
                    id="keyword"
                    name="keyword"
                    value="{{ $keyword ?? request('keyword') }}"
                    type="search"
                    class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500"
                    placeholder="Cari nama, NIK, jabatan, no HP, instansi, agenda...">
            </div>
        </div>
    </form>

    <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
        <div class="border-b border-gray-100 dark:border-[#233a34] px-6 py-4">
            <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Daftar Tamu</h2>
            <p id="text-count-tamu" class="mt-1 text-xs text-gray-500 dark:text-gray-300">Menampilkan {{ $tamu->count() }} dari {{ $totalTamu ?? $tamu->count() }} tamu.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[980px]">
                <thead>
                    <tr class="bg-[#35635b] dark:bg-[#1b3832] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Foto Selfie</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">NIK</th>
                        <th class="px-6 py-4">Jabatan</th>
                        <th class="px-6 py-4">No HP</th>
                        <th class="px-6 py-4">Instansi</th>
                        <th class="px-6 py-4">Agenda</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#233a34] text-sm">
                    @forelse ($tamu as $item)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-[#1b332d] transition">
                            <td class="px-6 py-4">
                                @if (!empty($item->foto_selfie) && (file_exists(public_path('storage/' . $item->foto_selfie)) || \Illuminate\Support\Facades\Storage::disk('public')->exists($item->foto_selfie)))
                                    <img src="{{ asset('storage/' . $item->foto_selfie) }}" 
                                         alt="{{ $item->nama }}" 
                                         class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-[#233a34]">
                                @else
                                    <img src="{{ asset('assets/foto/profile.png') }}" alt="{{ $item->nama }}" class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-[#233a34]">
                                @endif
                            </td>
                        
                            <td class="px-6 py-4 font-bold text-[#35635b] dark:text-emerald-400">{{ $item->nama }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->nik ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->jabatan ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->no_hp }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->asal_instansi }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ optional($agenda->firstWhere('id_agenda', $item->id_agenda))->nama_agenda ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2 whitespace-nowrap">
                                    <button
                                        type="button"
                                        onclick="openEditTamu(this)"
                                        data-action="{{ route('admin.tamu.update', $item->id_tamu) }}"
                                        data-foto-selfie-url="{{ $item->foto_selfie ? asset('storage/' . $item->foto_selfie) : '' }}"
                                        data-nama="{{ $item->nama }}"
                                        data-nik="{{ $item->nik }}"
                                        data-jabatan="{{ $item->jabatan }}"
                                        data-nohp="{{ $item->no_hp }}"
                                        data-instansi="{{ $item->asal_instansi }}"
                                        data-agenda="{{ $item->id_agenda }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-[#0f513f] dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-emerald-100 dark:hover:bg-emerald-900/60 cursor-pointer shadow-2xs"
                                        title="Edit Tamu">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Edit</span>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.tamu.destroy', $item->id_tamu) }}', 'Hapus Tamu?', 'Apakah Anda yakin ingin menghapus tamu ini?')"
                                        class="inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/50 text-red-700 dark:text-red-300 border border-red-200/80 dark:border-red-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer shadow-2xs"
                                        title="Hapus Tamu">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada data tamu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-tambah-tamu" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-start justify-between border-b border-gray-100 dark:border-[#233a34] px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-[#152420] shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-[#0f513f] dark:text-emerald-400 shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Tambah Data Tamu</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Input informasi tamu yang berkunjung ke instansi</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modal-tambah-tamu')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer" aria-label="Tutup modal">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="form-tambah-tamu" method="POST" action="{{ route('admin.tamu.store') }}" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="flex-1 min-h-0 grid grid-cols-1 gap-3 sm:gap-4 overflow-y-auto p-4 sm:p-6 sm:grid-cols-2">
                @include('admin.tamu.form-fields')
            </div>
            <div class="flex justify-end items-center gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#0f1c19] px-5 py-4 sm:px-6 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-tambah-tamu')" class="h-10 rounded-xl px-5 text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#0f513f] hover:bg-[#0b3f31] dark:bg-[#107050] dark:hover:bg-[#0c5940] px-6 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    <span>Simpan Tamu</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-tamu" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-start justify-between border-b border-gray-100 dark:border-[#233a34] px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-[#152420] shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-[#0f513f] dark:text-emerald-400 shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Edit Data Tamu</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui rincian informasi data tamu terpilih</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modal-edit-tamu')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer" aria-label="Tutup modal">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="form-edit-tamu" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="flex-1 min-h-0 grid grid-cols-1 gap-3 sm:gap-4 overflow-y-auto p-4 sm:p-6 sm:grid-cols-2">
                @include('admin.tamu.form-fields', ['prefix' => 'edit-'])
            </div>
            <div class="flex justify-end items-center gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#0f1c19] px-5 py-4 sm:px-6 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-edit-tamu')" class="h-10 rounded-xl px-5 text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
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
        if (id === 'modal-tambah-tamu') {
            const form = document.getElementById('form-tambah-tamu');
            if (form) form.reset();
            setTamuPhotoPreview('', '');
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

    function openEditTamu(button) {
        document.getElementById('form-edit-tamu').action = button.dataset.action;
        document.getElementById('edit-foto_selfie').value = '';
        document.getElementById('edit-nama').value = button.dataset.nama || '';
        document.getElementById('edit-nik').value = button.dataset.nik || '';
        document.getElementById('edit-jabatan').value = button.dataset.jabatan || '';
        document.getElementById('edit-no_hp').value = button.dataset.nohp || '';
        document.getElementById('edit-asal_instansi').value = button.dataset.instansi || '';
        document.getElementById('edit-id_agenda').value = button.dataset.agenda || '';
        setTamuPhotoPreview('edit-', button.dataset.fotoSelfieUrl || '');
        openModal('modal-edit-tamu');
    }

    function setTamuPhotoPreview(prefix, url) {
        const preview = document.getElementById(prefix + 'foto_selfie-preview');
        const icon = document.getElementById(prefix + 'foto_selfie-icon');
        const hapusBtn = document.getElementById(prefix + 'btn-hapus-foto_selfie');

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

    function removeTamuPhoto(prefix) {
        const input = document.getElementById(prefix + 'foto_selfie');
        const hapusInput = document.getElementById(prefix + 'hapus_foto_selfie');
        
        if (input) input.value = '';
        
        setTamuPhotoPreview(prefix, '');
        
        if (hapusInput) hapusInput.value = '1';
    }

    document.querySelectorAll('input[type="file"][data-tamu-photo-input]').forEach(input => {
        input.addEventListener('change', function(e) {
            const prefix = this.dataset.tamuPhotoInput;
            const file = this.files[0];
            const hapusInput = document.getElementById(prefix + 'hapus_foto_selfie');
            if (hapusInput) hapusInput.value = '0';
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    setTamuPhotoPreview(prefix, e.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                setTamuPhotoPreview(prefix, '');
            }
        });
    });

    function initLiveSearchTamu() {
        const form = document.getElementById('form-search-tamu');
        const searchInput = document.getElementById('keyword');
        const tableBody = document.querySelector('table tbody');
        const countText = document.getElementById('text-count-tamu');
        
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

                const newCount = doc.getElementById('text-count-tamu');
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
    }

    document.addEventListener('DOMContentLoaded', function() {
        initLiveSearchTamu();
    });
</script>
@endpush
@endsection
