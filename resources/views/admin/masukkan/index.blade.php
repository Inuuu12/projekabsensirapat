@extends('admin.layout.app')

@section('title', 'Masukkan / Log Aduan')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <!-- Page Header -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Masukkan</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola dan tindak lanjuti keluhan pengguna.</p>
    </div>

    <!-- Stats Cards Grid (4 cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#DCFCE7] flex items-center justify-center text-[#16A34A] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Aduan</p>
                <p class="text-2xl font-black text-gray-800 leading-none mt-1">1,284</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#FEE2E2] flex items-center justify-center text-[#EF4444] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Menunggu</p>
                <p class="text-2xl font-black text-gray-800 leading-none mt-1">24</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#FEF3C7] flex items-center justify-center text-[#D97706] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Diproses</p>
                <p class="text-2xl font-black text-gray-800 leading-none mt-1">12</p>
            </div>
        </div>

        <div class="bg-white border border-gray-100 shadow-xs rounded-2xl p-4 sm:p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#E0F2FE] flex items-center justify-center text-[#0284C7] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Selesai</p>
                <p class="text-2xl font-black text-gray-800 leading-none mt-1">12</p>
            </div>
        </div>
    </div>

    <!-- Log Aduan Card Wrapper -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <!-- Header & Filter Inside Card -->
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="text-lg font-bold text-gray-800">Log Aduan</h2>
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-gray-500">Filter by:</span>
                <select class="border border-gray-200 bg-white text-gray-700 font-semibold py-2 px-3.5 rounded-xl outline-none hover:bg-gray-50 transition text-xs cursor-pointer">
                    <option>Status: Semua</option>
                    <option>Status: Menunggu</option>
                    <option>Status: Diproses</option>
                    <option>Status: Selesai</option>
                </select>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[950px]">
                <thead>
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">NAMA PENGADU</th>
                        <th class="px-6 py-4">EMAIL</th>
                        <th class="px-6 py-4">ISI ADUAN</th>
                        <th class="px-6 py-4">WAKTU</th>
                        <th class="px-6 py-4">TANGGAL</th>
                        <th class="px-6 py-4 text-center">STATUS</th>
                        <th class="px-6 py-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs sm:text-sm font-medium">
                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-6 py-4 font-bold text-gray-800">Andi Saputra</td>
                        <td class="px-6 py-4 text-gray-600">andi@mail.com</td>
                        <td class="px-6 py-4 text-gray-700 max-w-xs truncate">Laporan penebangan liar di area konservasi blok utara...</td>
                        <td class="px-6 py-4 text-gray-700 font-mono">11:00</td>
                        <td class="px-6 py-4 text-gray-700">24 Okt 2023</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <span class="bg-[#FEE2E2] text-[#EF4444] text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#EF4444]"></span>
                                    Menunggu
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openModal('modal-detail-aduan')" class="p-2 text-gray-500 hover:text-gray-700 transition cursor-pointer" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button onclick="openModal('modal-tindak-lanjut')" class="p-2 text-gray-500 hover:text-gray-700 transition cursor-pointer" title="Tindak Lanjut">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                </button>
                                <button onclick="openModal('modal-hapus-aduan')" class="p-2 text-red-500 hover:text-red-700 transition cursor-pointer" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-6 py-4 font-bold text-gray-800">Bambang Irawan</td>
                        <td class="px-6 py-4 text-gray-600">bambang@mail.com</td>
                        <td class="px-6 py-4 text-gray-700 max-w-xs truncate">Kebakaran lahan kecil di dekat pemukiman warga Desa Rimba Jaya...</td>
                        <td class="px-6 py-4 text-gray-700 font-mono">11:00</td>
                        <td class="px-6 py-4 text-gray-700">24 Okt 2023</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <span class="bg-[#FEF3C7] text-[#D97706] text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#D97706]"></span>
                                    Proses
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openModal('modal-detail-aduan')" class="p-2 text-gray-500 hover:text-gray-700 transition cursor-pointer" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button onclick="openModal('modal-tindak-lanjut')" class="p-2 text-gray-500 hover:text-gray-700 transition cursor-pointer" title="Tindak Lanjut">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                </button>
                                <button onclick="openModal('modal-hapus-aduan')" class="p-2 text-red-500 hover:text-red-700 transition cursor-pointer" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50/80 transition">
                        <td class="px-6 py-4 font-bold text-gray-800">Citra Insani</td>
                        <td class="px-6 py-4 text-gray-600">citra@mail.com</td>
                        <td class="px-6 py-4 text-gray-700 max-w-xs truncate">Permohonan bibit pohon jati untuk penghijauan lahan desa.</td>
                        <td class="px-6 py-4 text-gray-700 font-mono">11:00</td>
                        <td class="px-6 py-4 text-gray-700">24 Okt 2023</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <span class="bg-[#DCFCE7] text-[#16A34A] text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A]"></span>
                                    Selesai
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openModal('modal-detail-aduan')" class="p-2 text-gray-500 hover:text-gray-700 transition cursor-pointer" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                <button onclick="openModal('modal-tindak-lanjut')" class="p-2 text-gray-500 hover:text-gray-700 transition cursor-pointer" title="Tindak Lanjut">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                </button>
                                <button onclick="openModal('modal-hapus-aduan')" class="p-2 text-red-500 hover:text-red-700 transition cursor-pointer" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-between items-center text-xs text-gray-500 font-medium">
            <span>Menampilkan 1-5 dari 42 aduan</span>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-600">&lt;</button>
                <button class="px-3 py-1.5 rounded-lg bg-[#35635b] text-white font-bold">1</button>
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-600">2</button>
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-600">3</button>
                <button class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-600">&gt;</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus Masukkan (matching dummy/Aduan.png) -->
<div id="modal-hapus-aduan" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl text-center space-y-4">
        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-800">Hapus Masukkan?</h3>
        <p class="text-xs text-gray-500 leading-relaxed">Apakah Anda yakin ingin menghapus masukkan ini?</p>
        <div class="flex justify-center gap-3 pt-2">
            <button onclick="closeModal('modal-hapus-aduan')" class="px-5 py-2.5 text-xs font-bold text-gray-700 border border-gray-300 hover:bg-gray-50 rounded-xl cursor-pointer">Batal</button>
            <button onclick="closeModal('modal-hapus-aduan')" class="px-5 py-2.5 text-xs font-bold text-white bg-[#DC2626] hover:bg-red-700 rounded-xl shadow-xs cursor-pointer flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus
            </button>
        </div>
    </div>
</div>

<!-- Modal Detail Aduan -->
<div id="modal-detail-aduan" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <div class="flex justify-between items-center border-b pb-3">
            <h3 class="text-lg font-bold text-gray-800">Detail Masukkan / Aduan</h3>
            <button onclick="closeModal('modal-detail-aduan')" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <div class="space-y-3 text-sm">
            <div><span class="font-bold text-gray-500 text-xs uppercase block">Pengadu</span><p class="font-bold text-gray-800">Andi Saputra (andi@mail.com)</p></div>
            <div><span class="font-bold text-gray-500 text-xs uppercase block">Tanggal & Waktu</span><p class="text-gray-700">24 Okt 2023 - 11:00 WIB</p></div>
            <div><span class="font-bold text-gray-500 text-xs uppercase block">Isi Aduan</span><p class="text-gray-700 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">Laporan penebangan liar di area konservasi blok utara yang berpotensi memicu tanah longsor di musim hujan.</p></div>
        </div>
        <div class="flex justify-end pt-3 border-t">
            <button type="button" onclick="closeModal('modal-detail-aduan')" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] rounded-xl">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Tindak Lanjut -->
<div id="modal-tindak-lanjut" class="fixed inset-0 z-50 bg-black/50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Tindak Lanjuti Aduan</h3>
        <form class="space-y-4" onsubmit="event.preventDefault(); closeModal('modal-tindak-lanjut');">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Ubah Status</label>
                <select class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
                    <option>Menunggu</option>
                    <option selected>Diproses</option>
                    <option>Selesai</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Catatan / Tanggapan Admin</label>
                <textarea class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" rows="3" placeholder="Tulis catatan tindak lanjut..."></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-tindak-lanjut')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs">Simpan Status</button>
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
