@extends('admin.layout.app')

@section('title', 'Daftar Kunjungan')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <!-- Page Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Daftar Kunjungan</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola data kunjungan dinas dan publik BAPPENDA.</p>
        </div>
        <button onclick="openModal('modal-tambah-kunjungan')" class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-xl flex items-center justify-center gap-2 transition shadow-xs cursor-pointer self-start sm:self-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Kunjungan
        </button>
    </div>

    <!-- Stats Cards (2 cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl">
        <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#DCFCE7] flex items-center justify-center text-[#16A34A] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Kunjungan</p>
                <p class="text-2xl font-black text-gray-800 leading-none mt-1">1,284</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#c8dbd5]/60 flex items-center justify-center text-[#35635b] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Hari Ini</p>
                <p class="text-2xl font-black text-gray-800 leading-none mt-1">24</p>
            </div>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-xs">
        <div class="flex flex-wrap items-center gap-3">
            <span class="text-xs font-semibold text-gray-500">Filter by:</span>
            <select class="border border-gray-200 bg-white text-gray-700 font-semibold py-2 px-3.5 rounded-xl outline-none hover:bg-gray-50 transition text-xs cursor-pointer">
                <option>Semua Status</option>
                <option>Selesai</option>
                <option>Pending</option>
            </select>
            <input type="date" class="border border-gray-200 bg-white text-gray-700 font-semibold py-2 px-3.5 rounded-xl outline-none hover:bg-gray-50 transition text-xs">
        </div>

        <div class="flex items-center gap-3 self-end md:self-auto">
            <button class="border border-gray-200 bg-white text-gray-700 font-semibold p-2.5 rounded-xl flex items-center justify-center hover:bg-gray-50 transition text-xs" title="Filter">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            </button>
            <button class="border border-gray-200 bg-white text-gray-700 font-semibold p-2.5 rounded-xl flex items-center justify-center hover:bg-gray-50 transition text-xs" title="Export">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[950px]">
                <thead>
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">NAMA</th>
                        <th class="px-6 py-4">EMAIL</th>
                        <th class="px-6 py-4">KEPERLUAN</th>
                        <th class="px-6 py-4">PIHAK DITUJU</th>
                        <th class="px-6 py-4">WAKTU</th>
                        <th class="px-6 py-4">TANGGAL</th>
                        <th class="px-6 py-4">INSTANSI</th>
                        <th class="px-6 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs sm:text-sm font-medium">
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-6 py-4 font-bold text-gray-800">Budi Santoso</td>
                        <td class="px-6 py-4 font-bold text-gray-800">[EMAIL_ADDRESS]</td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs">Koordinasi Pengelolaan Hutan Lindung Wilayah Timur</td>
                        <td class="px-6 py-4 text-gray-700">Bidang ..</td>
                        <td class="px-6 py-4 text-gray-700 font-mono">11:00</td>
                        <td class="px-6 py-4 text-gray-700">12/10/2023</td>
                        <td class="px-6 py-4 text-gray-700">Dinas Kehutanan</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openModal('modal-detail-kunjungan')" class="p-2 text-gray-500 hover:text-gray-700 transition cursor-pointer" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button onclick="openModal('modal-edit-kunjungan')" class="p-2 text-gray-500 hover:text-gray-700 transition cursor-pointer" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-6 py-4 font-bold text-gray-800">Siti Aminah</td>
                        <td class="px-6 py-4 font-bold text-gray-800">email</td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs">Audiensi Kelompok Tani Hutan Desa Makmur</td>
                        <td class="px-6 py-4 text-gray-700">Kadis..</td>
                        <td class="px-6 py-4 text-gray-700 font-mono">13:30</td>
                        <td class="px-6 py-4 text-gray-700">14/10/2023</td>
                        <td class="px-6 py-4 text-gray-700">Dinas Lingkungan Hidup</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openModal('modal-detail-kunjungan')" class="p-2 text-gray-500 hover:text-gray-700 transition cursor-pointer" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button onclick="openModal('modal-edit-kunjungan')" class="p-2 text-gray-500 hover:text-gray-700 transition cursor-pointer" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Kunjungan -->
<div id="modal-tambah-kunjungan" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Tambah Kunjungan Baru</h3>
        <form class="space-y-4" onsubmit="event.preventDefault(); closeModal('modal-tambah-kunjungan');">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Pengunjung</label>
                <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="Nama pengunjung">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Instansi</label>
                <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="Asal instansi">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Keperluan</label>
                <textarea class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" rows="3" placeholder="Keperluan kunjungan"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pihak Dituju</label>
                    <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="Bidang / Pejabat">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Waktu & Tanggal</label>
                    <input type="datetime-local" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-tambah-kunjungan')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs">Simpan Kunjungan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail Kunjungan -->
<div id="modal-detail-kunjungan" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl space-y-4">
        <div class="flex justify-between items-center border-b pb-3">
            <h3 class="text-lg font-bold text-gray-800">Detail Kunjungan</h3>
            <button onclick="closeModal('modal-detail-kunjungan')" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <div class="space-y-3 text-sm">
            <div><span class="font-bold text-gray-500 text-xs uppercase block">Nama</span><p class="font-bold text-gray-800">Budi Santoso</p></div>
            <div><span class="font-bold text-gray-500 text-xs uppercase block">Instansi</span><p class="text-gray-700">Dinas Kehutanan</p></div>
            <div><span class="font-bold text-gray-500 text-xs uppercase block">Keperluan</span><p class="text-gray-700">Koordinasi Pengelolaan Hutan Lindung Wilayah Timur</p></div>
        </div>
        <div class="flex justify-end pt-3 border-t">
            <button type="button" onclick="closeModal('modal-detail-kunjungan')" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] rounded-xl">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Edit Kunjungan -->
<div id="modal-edit-kunjungan" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Edit Data Kunjungan</h3>
        <form class="space-y-4" onsubmit="event.preventDefault(); closeModal('modal-edit-kunjungan');">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Pengunjung</label>
                <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" value="Budi Santoso">
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-edit-kunjungan')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs">Simpan Perubahan</button>
            </div>
        </form>
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
