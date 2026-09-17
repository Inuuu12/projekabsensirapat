@extends('pegawai.layout.app')

@section('title', 'Pengajuan Agenda')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Header + Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-lg font-black text-gray-900 dark:text-white">Pengajuan Agenda Rapat</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Ajukan rapat baru untuk disetujui oleh admin.</p>
        </div>
        <button onclick="openModal('modal-pengajuan')" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#35635b] hover:bg-[#2a4f48] text-white text-sm font-bold shadow-md transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Ajukan Agenda Baru
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#1b3832]">
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Agenda</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ruangan</th>
                        <th class="text-center px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Catatan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#233a34]">
                    @forelse($pengajuanList as $item)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-[#1a2d29] transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">{{ $item->nama_agenda }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}{{ $item->waktu_selesai ? ' - ' . \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') : '' }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $item->ruangRapat->nama_ruang ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold
                                    {{ $item->status === 'disetujui' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : ($item->status === 'ditolak' ? 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400' : 'bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-xs max-w-[200px] truncate">{{ $item->catatan_admin ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center">
                                <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-sm text-gray-400 dark:text-gray-500 font-medium">Belum ada pengajuan agenda</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Pengajuan -->
<div id="modal-pengajuan" class="hidden fixed inset-0 z-[9999] items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-2xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto border border-gray-200 dark:border-[#233a34]">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 dark:border-[#233a34] flex items-center justify-between sticky top-0 bg-white dark:bg-[#152420] z-10 rounded-t-2xl">
            <h3 class="text-base font-bold text-gray-800 dark:text-white">Ajukan Agenda Rapat Baru</h3>
            <button onclick="closeModal('modal-pengajuan')" class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 flex items-center justify-center text-gray-500 dark:text-gray-300 transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('pegawai.pengajuan.store') }}" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Agenda <span class="text-red-500">*</span></label>
                <input type="text" name="nama_agenda" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500" placeholder="Contoh: Rapat Koordinasi Bulanan">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Ruang Rapat</label>
                    <select name="id_ruangrapat" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                        <option value="">-- Pilih Ruangan --</option>
                        @foreach($ruangList as $ruang)
                            <option value="{{ $ruang->id_ruangrapat }}">{{ $ruang->nama_ruang }} (Kapasitas: {{ $ruang->kapasitas }})</option>
                        @endforeach
                    </select>
                    @if($pegawai->nama_instansi !== '-')
                        <p class="mt-1 text-[11px] text-emerald-600 dark:text-emerald-400 font-medium">
                            * Menampilkan ruangan khusus instansi {{ $pegawai->nama_instansi }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Waktu Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="waktu" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Penyelenggara</label>
                    <input type="text" name="penyelenggara" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500" placeholder="Nama penyelenggara">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Kuota Peserta</label>
                    <input type="number" name="kuota" value="20" min="1" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 resize-none" placeholder="Keterangan rapat (opsional)"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modal-pengajuan')" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-[#0f1c19] border border-gray-200 dark:border-[#284c43] text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#1a2d29] transition-colors cursor-pointer">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#35635b] hover:bg-[#2a4f48] text-white text-sm font-bold shadow-md transition-all cursor-pointer">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</div>
@endsection
