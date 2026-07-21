@extends('admin.layout.app')

@section('title', 'Data Tamu')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Data Tamu</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Selamat datang kembali, Admin!</p>
        </div>
        <button onclick="openModal('modal-tambah-tamu')" class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-xl flex items-center justify-center gap-2 transition shadow-xs cursor-pointer self-start sm:self-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Tamu
        </button>
    </div>

    <!-- Controls Bar -->
    <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-xs">
        <div class="flex flex-wrap items-center gap-3">
            <select class="border border-gray-200 bg-white text-gray-700 font-semibold py-2 px-3.5 rounded-xl outline-none hover:bg-gray-50 transition text-xs cursor-pointer">
                <option>10 Baris</option>
                <option>25 Baris</option>
                <option>50 Baris</option>
            </select>

            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" class="bg-gray-50 text-gray-700 text-xs rounded-xl block w-full pl-9 p-2.5 outline-none border border-transparent focus:border-[#35635b] focus:bg-white transition" placeholder="Cari tamu...">
            </div>
        </div>

        <div class="flex items-center gap-3 self-end md:self-auto">
            <button class="border border-gray-200 bg-white text-gray-700 font-semibold py-2 px-3.5 rounded-xl flex items-center gap-2 hover:bg-gray-50 transition text-xs">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>

            <button class="border border-gray-200 bg-white text-gray-700 font-semibold py-2 px-3.5 rounded-xl flex items-center gap-2 hover:bg-gray-50 transition text-xs">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4 w-12">NO</th>
                        <th class="px-6 py-4 w-16">FOTO</th>
                        <th class="px-6 py-4">NAMA</th>
                        <th class="px-6 py-4">INSTANSI</th>
                        <th class="px-6 py-4">KONTAK</th>
                        <th class="px-6 py-4">EMAIL</th>
                        <th class="px-6 py-4">STATUS</th>
                        <th class="px-6 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs sm:text-sm font-medium">
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-6 py-4 font-bold text-gray-500">1</td>
                        <td class="px-6 py-4">
                            <div class="w-9 h-9 rounded-full bg-[#35635b]/20 flex items-center justify-center font-bold text-[#35635b]">AR</div>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800">H. Arif Rahman, S.E.</td>
                        <td class="px-6 py-4 text-gray-700">Dinas Pendidikan</td>
                        <td class="px-6 py-4 text-gray-700 font-mono">081290992233</td>
                        <td class="px-6 py-4 text-gray-600">arifrahman@gmail.com</td>
                        <td class="px-6 py-4">
                            <span class="bg-[#DCFCE7] text-[#16A34A] text-xs font-bold px-3 py-1 rounded-full">Agenda</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openModal('modal-edit-tamu')" class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button onclick="openModal('modal-hapus-tamu')" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-6 py-4 font-bold text-gray-500">2</td>
                        <td class="px-6 py-4">
                            <div class="w-9 h-9 rounded-full bg-[#35635b]/20 flex items-center justify-center font-bold text-[#35635b]">SA</div>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800">Siti Aminah, M.Si.</td>
                        <td class="px-6 py-4 text-gray-700">Pt. Sehat</td>
                        <td class="px-6 py-4 text-gray-700 font-mono">081333212465</td>
                        <td class="px-6 py-4 text-gray-600">sitiaminah@gmail.com</td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full">Tanpa Agenda</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openModal('modal-edit-tamu')" class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button onclick="openModal('modal-hapus-tamu')" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-between items-center text-xs text-gray-500 font-medium">
            <span>Menampilkan 1 sampai 2 dari 120 tamu</span>
        </div>
    </div>
</div>

<!-- Modal Tambah Tamu -->
<div id="modal-tambah-tamu" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Tambah Tamu Baru</h3>
        <form class="space-y-4" onsubmit="event.preventDefault(); closeModal('modal-tambah-tamu');">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Tamu</label>
                <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="Nama lengkap">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Instansi</label>
                <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="Asal instansi / perusahaan">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kontak</label>
                    <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="0812...">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                    <input type="email" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="email@domain.com">
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-tambah-tamu')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs">Simpan Tamu</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Tamu -->
<div id="modal-edit-tamu" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Edit Data Tamu</h3>
        <form class="space-y-4" onsubmit="event.preventDefault(); closeModal('modal-edit-tamu');">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Tamu</label>
                <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" value="H. Arif Rahman, S.E.">
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-edit-tamu')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Tamu -->
<div id="modal-hapus-tamu" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl text-center space-y-4">
        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        <h3 class="text-base font-bold text-gray-800">Hapus Data Tamu?</h3>
        <p class="text-xs text-gray-500">Apakah Anda yakin ingin menghapus data tamu ini?</p>
        <div class="flex justify-center gap-3 pt-2">
            <button onclick="closeModal('modal-hapus-tamu')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
            <button onclick="closeModal('modal-hapus-tamu')" class="px-4 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-xs">Hapus</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if(modal) modal.classList.replace('hidden', 'flex');
    }
    function closeModal(id) {
        const modal = document.getElementById(id);
        if(modal) modal.classList.replace('flex', 'hidden');
    }
</script>
@endpush
@endsection
