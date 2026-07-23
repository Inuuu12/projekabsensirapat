@extends('admin.layout.app')

@section('title', 'Data Pegawai')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Data Pegawai</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Data pegawai langsung dibaca dari database.</p>
        </div>
        <button onclick="openModal('modal-tambah-pegawai')" class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-xl transition shadow-xs self-start sm:self-auto">Tambah Pegawai</button>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Pegawai</p>
        <p class="mt-2 text-3xl font-black text-[#35635b]">{{ $pegawai->count() }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[920px]">
                <thead>
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Foto</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">NIP</th>
                        <th class="px-6 py-4">Jabatan</th>
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
                            <td class="px-6 py-4 text-gray-700">{{ $item->nomor_hp }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->email }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        type="button"
                                        onclick="openEditPegawai(this)"
                                        data-action="{{ route('admin.pegawai.update', $item->id_pegawai) }}"
                                        data-foto="{{ $item->foto }}"
                                        data-nama="{{ $item->nama_pegawai }}"
                                        data-nip="{{ $item->nip }}"
                                        data-jabatan="{{ $item->jabatan }}"
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
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data pegawai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-tambah-pegawai" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Tambah Pegawai Baru</h3>
        <form method="POST" action="{{ route('admin.pegawai.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @include('admin.pegawai.form-fields')
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-tambah-pegawai')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-pegawai" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Edit Pegawai</h3>
        <form id="form-edit-pegawai" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            @include('admin.pegawai.form-fields', ['prefix' => 'edit-'])
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-edit-pegawai')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl">Simpan</button>
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

    function openEditPegawai(button) {
        document.getElementById('form-edit-pegawai').action = button.dataset.action;
        document.getElementById('edit-foto').value = '';
        document.getElementById('edit-nama_pegawai').value = button.dataset.nama;
        document.getElementById('edit-nip').value = button.dataset.nip;
        document.getElementById('edit-jabatan').value = button.dataset.jabatan;
        document.getElementById('edit-nomor_hp').value = button.dataset.nomor;
        document.getElementById('edit-email').value = button.dataset.email;
        openModal('modal-edit-pegawai');
    }
</script>
@endpush
@endsection
