@extends('admin.layout.app')

@section('title', 'Daftar Ruangan')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <!-- Page Title & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Daftar Ruangan</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Selamat datang kembali, Admin!</p>
        </div>
        <button onclick="openModal('modal-tambah-ruang')" class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-xl flex items-center justify-center gap-2 transition shadow-xs cursor-pointer self-start sm:self-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Ruang
        </button>
    </div>

    <!-- Stats Cards (4 cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-700 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V5"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Ruangan</p>
                <p class="text-2xl font-black text-gray-800 leading-none mt-1">12</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#DCFCE7] flex items-center justify-center text-[#16A34A] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Tersedia</p>
                <p class="text-2xl font-black text-gray-800 leading-none mt-1">8</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#FEF3C7] flex items-center justify-center text-[#D97706] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Digunakan</p>
                <p class="text-2xl font-black text-gray-800 leading-none mt-1">4</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#FEE2E2] flex items-center justify-center text-[#EF4444] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Maintenance</p>
                <p class="text-2xl font-black text-gray-800 leading-none mt-1">0</p>
            </div>
        </div>
    </div>

    <!-- Filter & Search Controls -->
    <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4">
        <!-- Filter Tabs -->
        <div class="bg-gray-100 p-1 rounded-xl flex items-center self-start text-xs font-semibold text-gray-600">
            <button class="px-4 py-2 rounded-lg bg-white font-bold text-gray-800 shadow-xs">Semua</button>
            <button class="px-4 py-2 rounded-lg hover:text-gray-900 transition">Tersedia</button>
            <button class="px-4 py-2 rounded-lg hover:text-gray-900 transition">Digunakan</button>
        </div>

        <!-- Search & Filter Button -->
        <div class="flex items-center gap-3">
            <div class="relative flex-1 sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" class="bg-white text-gray-700 text-xs rounded-xl block w-full pl-9 p-2.5 outline-none border border-gray-200 focus:border-[#35635b] transition shadow-xs" placeholder="Cari ruangan...">
            </div>
            <button class="border border-gray-200 bg-white text-gray-700 font-semibold py-2 px-3.5 rounded-xl flex items-center gap-2 hover:bg-gray-50 transition shadow-xs text-xs">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter Lanjut
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Ruangan</th>
                        <th class="px-6 py-4">Kapasitas</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm font-medium">
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-6 py-4 flex items-center gap-3 font-bold text-gray-800">
                            <div class="w-10 h-10 rounded-xl bg-[#c8dbd5]/60 flex items-center justify-center text-[#22443e]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V5"></path></svg>
                            </div>
                            Ruang Rapat Utama
                        </td>
                        <td class="px-6 py-4 text-gray-600">20 Orang</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <span class="bg-[#DCFCE7] text-[#16A34A] text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A]"></span>
                                    Tersedia
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openModal('modal-edit-ruang')" class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button onclick="openModal('modal-hapus-ruang')" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-6 py-4 flex items-center gap-3 font-bold text-gray-800">
                            <div class="w-10 h-10 rounded-xl bg-[#c8dbd5]/60 flex items-center justify-center text-[#22443e]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V5"></path></svg>
                            </div>
                            Aula Serbaguna
                        </td>
                        <td class="px-6 py-4 text-gray-600">100 Orang</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <span class="bg-[#FEE2E2] text-[#EF4444] text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#EF4444]"></span>
                                    Digunakan
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openModal('modal-edit-ruang')" class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button onclick="openModal('modal-hapus-ruang')" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-6 py-4 flex items-center gap-3 font-bold text-gray-800">
                            <div class="w-10 h-10 rounded-xl bg-[#c8dbd5]/60 flex items-center justify-center text-[#22443e]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V5"></path></svg>
                            </div>
                            Ruang Kabid
                        </td>
                        <td class="px-6 py-4 text-gray-600">5 Orang</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <span class="bg-[#FEF3C7] text-[#D97706] text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#D97706]"></span>
                                    Perawatan
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openModal('modal-edit-ruang')" class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button onclick="openModal('modal-hapus-ruang')" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Ruang -->
<div id="modal-tambah-ruang" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Tambah Ruangan Baru</h3>
        <form class="space-y-4" onsubmit="event.preventDefault(); closeModal('modal-tambah-ruang');">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Ruangan</label>
                <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="Contoh: Ruang Rapat Mini">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kapasitas (Orang)</label>
                <input type="number" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="20">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Status</label>
                <select class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
                    <option>Tersedia</option>
                    <option>Digunakan</option>
                    <option>Perawatan</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-tambah-ruang')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs">Simpan Ruangan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Ruang -->
<div id="modal-edit-ruang" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Edit Ruangan</h3>
        <form class="space-y-4" onsubmit="event.preventDefault(); closeModal('modal-edit-ruang');">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Ruangan</label>
                <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" value="Ruang Rapat Utama">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kapasitas (Orang)</label>
                <input type="number" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" value="20">
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-edit-ruang')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Ruang -->
<div id="modal-hapus-ruang" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl text-center space-y-4">
        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        <h3 class="text-base font-bold text-gray-800">Hapus Ruangan?</h3>
        <p class="text-xs text-gray-500">Apakah Anda yakin ingin menghapus ruangan ini?</p>
        <div class="flex justify-center gap-3 pt-2">
            <button onclick="closeModal('modal-hapus-ruang')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
            <button onclick="closeModal('modal-hapus-ruang')" class="px-4 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-xs">Hapus</button>
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
