@extends('admin.layout.app')

@section('title', 'Daftar Ruangan')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Daftar Ruangan</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Data ruangan langsung terhubung ke database.</p>
        </div>
        <button onclick="openModal('modal-tambah-ruang')" class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-xl flex items-center gap-2 transition shadow-xs self-start sm:self-auto">
            Tambah Ruang
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Ruangan</p>
            <p class="mt-2 text-3xl font-black text-[#35635b]">{{ $ruang->count() }}</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Kapasitas</p>
            <p class="mt-2 text-3xl font-black text-[#35635b]">{{ $ruang->sum('kapasitas') }}</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Terakhir Diupdate</p>
            <p class="mt-2 text-sm font-bold text-gray-700">{{ optional($ruang->first()?->updated_at)->format('d M Y') ?? '-' }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[760px]">
                <thead>
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Ruangan</th>
                        <th class="px-6 py-4">Kapasitas</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($ruang as $item)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $item->nama_ruang }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->kapasitas }} orang</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->keterangan }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        type="button"
                                        onclick="openEditRuang(this)"
                                        data-action="{{ route('admin.ruang.update', $item->id_ruangrapat) }}"
                                        data-nama="{{ $item->nama_ruang }}"
                                        data-kapasitas="{{ $item->kapasitas }}"
                                        data-keterangan="{{ $item->keterangan }}"
                                        class="rounded-lg bg-green-50 px-3 py-1.5 text-xs font-bold text-green-700 hover:bg-green-100">
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.ruang.destroy', $item->id_ruangrapat) }}', 'Hapus Ruangan?', 'Apakah Anda yakin ingin menghapus ruangan ini?')"
                                        class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700 hover:bg-red-100">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data ruangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-tambah-ruang" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Tambah Ruangan Baru</h3>
        <form method="POST" action="{{ route('admin.ruang.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Ruangan</label>
                <input name="nama_ruang" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kapasitas</label>
                <input name="kapasitas" type="number" min="1" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Keterangan</label>
                <input name="keterangan" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-tambah-ruang')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-ruang" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Edit Ruangan</h3>
        <form id="form-edit-ruang" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Ruangan</label>
                <input id="edit-ruang-nama" name="nama_ruang" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kapasitas</label>
                <input id="edit-ruang-kapasitas" name="kapasitas" type="number" min="1" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Keterangan</label>
                <input id="edit-ruang-keterangan" name="keterangan" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-edit-ruang')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs">Simpan</button>
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

    function openEditRuang(button) {
        document.getElementById('form-edit-ruang').action = button.dataset.action;
        document.getElementById('edit-ruang-nama').value = button.dataset.nama;
        document.getElementById('edit-ruang-kapasitas').value = button.dataset.kapasitas;
        document.getElementById('edit-ruang-keterangan').value = button.dataset.keterangan;
        openModal('modal-edit-ruang');
    }
</script>
@endpush
@endsection
