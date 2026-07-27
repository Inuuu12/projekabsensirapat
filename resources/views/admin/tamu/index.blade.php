@extends('admin.layout.app')

@section('title', 'Data Tamu')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Data Tamu</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Data tamu langsung terhubung ke database.</p>
        </div>
        <button onclick="openModal('modal-tambah-tamu')" class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-xl transition shadow-xs self-start sm:self-auto">
            <span class="text-lg leading-none">+</span>
            <span></span>Tambah Tamu</span>
        </button>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Tamu</p>
        <p class="mt-2 text-3xl font-black text-[#35635b]">{{ $tamu->count() }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[980px]">
                <thead>
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider">
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
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($tamu as $item)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-6 py-4">
                                @if (!empty($item->foto_selfie) && file_exists(public_path('storage/' . $item->foto_selfie)))
                                    <img src="{{ asset('storage/' . $item->foto_selfie) }}" 
                                         alt="{{ $item->nama }}" 
                                         class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-400">
                                        N/A
                                    </div>
                                @endif
                            </td>
                        
                            <td class="px-6 py-4 font-bold text-[#35635b]">{{ $item->nama }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->nik ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->jabatan ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->no_hp }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->asal_instansi }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ optional($agenda->firstWhere('id_agenda', $item->id_agenda))->nama_agenda ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
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
                                        class="rounded-lg bg-green-50 px-3 py-1.5 text-xs font-bold text-green-700 hover:bg-green-100">
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.tamu.destroy', $item->id_tamu) }}', 'Hapus Tamu?', 'Apakah Anda yakin ingin menghapus tamu ini?')"
                                        class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700 hover:bg-red-100">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada data tamu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-tambah-tamu" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Tambah Tamu</h3>
            <button type="button" onclick="closeModal('modal-tambah-tamu')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal tambah tamu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-tambah-tamu" method="POST" action="{{ route('admin.tamu.store') }}" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="grid grid-cols-1 gap-x-4 gap-y-4 overflow-y-auto px-5 py-5 sm:grid-cols-2 sm:px-6">
                @include('admin.tamu.form-fields')
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closeModal('modal-tambah-tamu')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#04733f] px-5 text-sm font-bold text-white transition hover:bg-[#035f35]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-tamu" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Edit Tamu</h3>
            <button type="button" onclick="closeModal('modal-edit-tamu')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal edit tamu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-edit-tamu" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-x-4 gap-y-4 overflow-y-auto px-5 py-5 sm:grid-cols-2 sm:px-6">
                @include('admin.tamu.form-fields', ['prefix' => 'edit-'])
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closeModal('modal-edit-tamu')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#04733f] px-5 text-sm font-bold text-white transition hover:bg-[#035f35]">
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
        if (id === 'modal-tambah-tamu') {
            const form = document.getElementById('form-tambah-tamu');
            if (form) form.reset();
            setTamuPhotoPreview('', '');
        }
        if (modal) modal.classList.replace('hidden', 'flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.replace('flex', 'hidden');
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
        if (!preview || !icon) return;

        if (url) {
            preview.src = url;
            preview.classList.remove('hidden');
            icon.classList.add('hidden');
            return;
        }

        preview.removeAttribute('src');
        preview.classList.add('hidden');
        icon.classList.remove('hidden');
    }

    document.querySelectorAll('[data-tamu-photo-input]').forEach((input) => {
        input.addEventListener('change', function () {
            const file = this.files && this.files[0];
            const prefix = this.dataset.tamuPhotoInput || '';

            if (!file) {
                setTamuPhotoPreview(prefix, '');
                return;
            }

            setTamuPhotoPreview(prefix, URL.createObjectURL(file));
        });
    });
</script>
@endpush
@endsection
