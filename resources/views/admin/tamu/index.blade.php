@extends('admin.layout.app')

@section('title', 'Data Tamu')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Data Tamu</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Data tamu langsung terhubung ke database.</p>
        </div>
        <button onclick="openModal('modal-tambah-tamu')" class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-xl transition shadow-xs self-start sm:self-auto">Tambah Tamu</button>
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
                                        data-foto-selfie="{{ $item->foto_selfie }}"
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
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada data tamu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-tambah-tamu" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Tambah Tamu Baru</h3>
        <form method="POST" action="{{ route('admin.tamu.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.tamu.form-fields')
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-tambah-tamu')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-tamu" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Edit Tamu</h3>
        <form id="form-edit-tamu" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            @include('admin.tamu.form-fields', ['prefix' => 'edit-'])
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-edit-tamu')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
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

    function openEditTamu(button) {
        document.getElementById('form-edit-tamu').action = button.dataset.action;
        document.getElementById('edit-foto_selfie').value = '';
        document.getElementById('edit-nama').value = button.dataset.nama || '';
        document.getElementById('edit-nik').value = button.dataset.nik || '';
        document.getElementById('edit-jabatan').value = button.dataset.jabatan || '';
        document.getElementById('edit-no_hp').value = button.dataset.nohp || '';
        document.getElementById('edit-asal_instansi').value = button.dataset.instansi || '';
        document.getElementById('edit-id_agenda').value = button.dataset.agenda || '';
        openModal('modal-edit-tamu');
    }
</script>
@endpush
@endsection
