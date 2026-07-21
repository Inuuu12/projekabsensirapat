@extends('admin.layout.app')

@section('title', 'Daftar Agenda')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <!-- Page Title & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Daftar Agenda</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola daftar agenda dinas BAPPENDA.</p>
        </div>
        <button onclick="openModal('modal-tambah')" class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-xl flex items-center justify-center gap-2 transition shadow-xs cursor-pointer self-start sm:self-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Agenda
        </button>
    </div>

    <!-- Search & Stats Header Bar -->
    <div class="space-y-4">
        <!-- Search Bar -->
        <div class="relative w-full max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" class="bg-white text-gray-700 text-sm rounded-xl block w-full pl-10 p-3 outline-none border border-gray-200 focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 transition shadow-xs" placeholder="Cari agenda...">
        </div>

        <!-- Controls & Stats Cards Grid -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-4">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full lg:w-auto">
                <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 flex items-center gap-4 min-w-[190px]">
                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">TOTAL AGENDA</p>
                        <p class="text-2xl font-black text-gray-800 leading-none mt-1">124</p>
                    </div>
                </div>

                <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 flex items-center gap-4 min-w-[190px]">
                    <div class="w-12 h-12 rounded-xl bg-[#FFEDD5] flex items-center justify-center text-[#EA580C] shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">AKAN DATANG</p>
                        <p class="text-2xl font-black text-gray-800 leading-none mt-1">8</p>
                    </div>
                </div>

                <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 flex items-center gap-4 min-w-[190px]">
                    <div class="w-12 h-12 rounded-xl bg-[#DCFCE7] flex items-center justify-center text-[#16A34A] shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">SELESAI</p>
                        <p class="text-2xl font-black text-gray-800 leading-none mt-1">86</p>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                <select class="border border-gray-200 bg-white text-gray-700 font-semibold py-2.5 px-4 rounded-xl outline-none hover:bg-gray-50 transition shadow-xs text-sm cursor-pointer">
                    <option>Surat Internal</option>
                    <option>Surat Eksternal</option>
                </select>

                <button class="border border-gray-200 bg-white text-gray-700 font-semibold py-2.5 px-4 rounded-xl flex items-center gap-2 hover:bg-gray-50 transition shadow-xs text-sm cursor-pointer">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter tanggal
                </button>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Agenda</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Kuota</th>
                        <th class="px-6 py-4">Asal Surat</th>
                        <th class="px-6 py-4">Lampiran</th>
                        <th class="px-6 py-4">Tempat</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @for ($i = 0; $i < 4; $i++)
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-6 py-4 font-bold text-[#35635b]">
                            Rapat Koordinasi Pajak Daerah
                        </td>
                        <td class="px-6 py-4 text-gray-700 font-medium">Juli 15, 2026</td>
                        <td class="px-6 py-4 text-gray-700">09:00 - 11:30 WIB</td>
                        <td class="px-6 py-4 text-gray-700 font-semibold">{{ 100 - ($i * 25) }}</td>
                        <td class="px-6 py-4 text-gray-700">Aplikasi Informatika</td>
                        <td class="px-6 py-4">
                            <a href="#" class="inline-flex items-center gap-1.5 text-[#35635b] hover:underline font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                Lihat Lampiran
                            </a>
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            <div class="flex items-center gap-1.5 font-medium">
                                @if($i == 0)
                                    <svg class="w-4 h-4 text-[#35635b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V5"></path></svg>
                                    Aula Husni Hamid
                                @else
                                    <svg class="w-4 h-4 text-[#35635b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    Zoom Meeting
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <span class="bg-[#FFEDD5] text-[#EA580C] text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#EA580C]"></span>
                                    Ongoing
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openModal('modal-edit')" class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition cursor-pointer" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button onclick="openModal('modal-hapus')" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition cursor-pointer" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                <button onclick="openModal('modal-detail')" class="p-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition cursor-pointer" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-gray-500 font-medium">
            <span>Showing 1 to 10 of 124 entries</span>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-600 cursor-pointer">&lt;</button>
                <button class="px-3 py-1.5 rounded-lg bg-[#35635b] text-white font-bold cursor-pointer">1</button>
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-600 cursor-pointer">2</button>
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-600 cursor-pointer">3</button>
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-600 cursor-pointer">&gt;</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Agenda -->
<div id="modal-tambah" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Tambah Agenda Baru</h3>
        <form class="space-y-4" onsubmit="event.preventDefault(); closeModal('modal-tambah');">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Agenda</label>
                <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="Masukkan nama agenda">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tanggal</label>
                    <input type="date" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Waktu</label>
                    <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="09:00 - 11:30 WIB">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Asal Surat</label>
                <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="Dinas / Instansi asal">
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-tambah')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs">Simpan Agenda</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail Agenda -->
<div id="modal-detail" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <div class="flex justify-between items-center border-b pb-3">
            <h3 class="text-lg font-bold text-gray-800">Detail Agenda</h3>
            <button onclick="closeModal('modal-detail')" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <div class="space-y-3 text-sm">
            <div><span class="font-bold text-gray-500 text-xs uppercase block">Nama Agenda</span><p class="font-bold text-gray-800 text-base">Rapat Koordinasi Pajak Daerah</p></div>
            <div class="grid grid-cols-2 gap-4">
                <div><span class="font-bold text-gray-500 text-xs uppercase block">Tanggal & Waktu</span><p class="text-gray-700">Juli 15, 2026 (09:00 - 11:30 WIB)</p></div>
                <div><span class="font-bold text-gray-500 text-xs uppercase block">Kuota</span><p class="text-gray-700">100 Orang</p></div>
            </div>
            <div><span class="font-bold text-gray-500 text-xs uppercase block">Tempat</span><p class="text-gray-700">Aula Husni Hamid</p></div>
        </div>
        <div class="flex justify-end pt-3 border-t">
            <button type="button" onclick="closeModal('modal-detail')" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] rounded-xl">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Edit Agenda -->
<div id="modal-edit" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Edit Agenda</h3>
        <form class="space-y-4" onsubmit="event.preventDefault(); closeModal('modal-edit');">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Agenda</label>
                <input type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" value="Rapat Koordinasi Pajak Daerah">
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-edit')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Agenda -->
<div id="modal-hapus" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl text-center space-y-4">
        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-base font-bold text-gray-800">Hapus Agenda?</h3>
        <p class="text-xs text-gray-500">Apakah Anda yakin ingin menghapus agenda ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-center gap-3 pt-2">
            <button onclick="closeModal('modal-hapus')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
            <button onclick="closeModal('modal-hapus')" class="px-4 py-2 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-xs">Hapus</button>
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