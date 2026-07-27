@extends('admin.layout.app')

@section('title', 'Data Pegawai')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Data Pegawai</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Data pegawai langsung dibaca dari database.</p>
        </div>
        <button onclick="openModal('modal-tambah-pegawai')" class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-xl transition shadow-xs self-start sm:self-auto">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Pegawai</span>
        </button>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Pegawai</p>
        <p class="mt-2 text-3xl font-black text-[#35635b]">{{ $pegawai->count() }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[1040px]">
                <thead>
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Foto</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">NIP</th>
                        <th class="px-6 py-4">Jabatan</th>
                        <th class="px-6 py-4">Bidang</th>
                        <th class="px-6 py-4">No HP</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($pegawai as $item)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-6 py-4">
                                @if (!empty($item->foto))
    {{-- Hasil asset('storage/' . $item->foto) akan menjadi http://localhost/storage/pegawai/namafile.jpg --}}
    <img src="{{ asset('storage/' . $item->foto) }}" 
         alt="{{ $item->nama_pegawai }}" 
         class="w-10 h-10 rounded-full object-cover border border-gray-200">
@else
    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-400">
        N/A
    </div>
@endif
                            </td>
                            <td class="px-6 py-4 font-bold text-[#35635b]">{{ $item->nama_pegawai }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-700">{{ $item->nip }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->jabatan }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->bidang ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->nomor_hp }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->email }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        type="button"
                                        onclick="openEditPegawai(this)"
                                        data-action="{{ route('admin.pegawai.update', $item->id_pegawai) }}"
                                        data-foto-url="{{ $item->foto ? asset('storage/' . $item->foto) : '' }}"
                                        data-nama="{{ $item->nama_pegawai }}"
                                        data-nip="{{ $item->nip }}"
                                        data-jabatan="{{ $item->jabatan }}"
                                        data-bidang="{{ $item->bidang }}"
                                        data-nomor="{{ $item->nomor_hp }}"
                                        data-email="{{ $item->email }}"
                                        class="rounded-lg bg-green-50 px-3 py-1.5 text-xs font-bold text-green-700 hover:bg-green-100">
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.pegawai.destroy', $item->id_pegawai) }}', 'Hapus Pegawai?', 'Apakah Anda yakin ingin menghapus pegawai ini?')"
                                        class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700 hover:bg-red-100">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada data pegawai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-tambah-pegawai" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Tambah Pegawai</h3>
            <button type="button" onclick="closeModal('modal-tambah-pegawai')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal tambah pegawai">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-tambah-pegawai" method="POST" action="{{ route('admin.pegawai.store') }}" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="grid grid-cols-1 gap-x-4 gap-y-4 overflow-y-auto px-5 py-5 sm:grid-cols-2 sm:px-6">
                @include('admin.pegawai.form-fields')
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closeModal('modal-tambah-pegawai')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
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

<div id="modal-edit-pegawai" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Edit Pegawai</h3>
            <button type="button" onclick="closeModal('modal-edit-pegawai')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal edit pegawai">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-edit-pegawai" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-x-4 gap-y-4 overflow-y-auto px-5 py-5 sm:grid-cols-2 sm:px-6">
                @include('admin.pegawai.form-fields', ['prefix' => 'edit-'])
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closeModal('modal-edit-pegawai')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
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
        if (id === 'modal-tambah-pegawai') {
            const form = document.getElementById('form-tambah-pegawai');
            if (form) form.reset();
            setPegawaiPhotoPreview('', '');
        }
        if (modal) modal.classList.replace('hidden', 'flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.replace('flex', 'hidden');
    }

    function openEditPegawai(button) {
        document.getElementById('form-edit-pegawai').action = button.dataset.action;
        document.getElementById('edit-foto').value = '';
        document.getElementById('edit-nama_pegawai').value = button.dataset.nama;
        document.getElementById('edit-nip').value = button.dataset.nip;
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

    document.querySelectorAll('[data-photo-input]').forEach((input) => {
        input.addEventListener('change', function () {
            const file = this.files && this.files[0];
            const prefix = this.dataset.photoInput || '';

            if (!file) {
                setPegawaiPhotoPreview(prefix, '');
                return;
            }

            setPegawaiPhotoPreview(prefix, URL.createObjectURL(file));
        });
    });
</script>
@endpush
@endsection
