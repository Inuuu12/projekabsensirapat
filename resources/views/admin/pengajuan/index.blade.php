@extends('admin.layout.app')

@section('title', 'Pengajuan Agenda Pegawai')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs transition-colors">
            <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Total Pengajuan</p>
            <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $pengajuanList->total() }}</p>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-amber-100 dark:border-amber-900/30 rounded-2xl p-5 shadow-xs transition-colors relative overflow-hidden">
            @if ($totalPending > 0)
                <span class="absolute top-4 right-4 flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                </span>
            @endif
            <p class="text-[11px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Menunggu Persetujuan</p>
            <p class="mt-2 text-3xl font-black text-amber-600 dark:text-amber-400">{{ $totalPending }}</p>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-emerald-100 dark:border-emerald-900/30 rounded-2xl p-5 shadow-xs transition-colors">
            <p class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Disetujui</p>
            <p class="mt-2 text-3xl font-black text-emerald-600 dark:text-emerald-400">{{ $totalDisetujui }}</p>
        </div>
        <div class="bg-white dark:bg-[#152420] border border-red-100 dark:border-red-900/30 rounded-2xl p-5 shadow-xs transition-colors">
            <p class="text-[11px] font-bold text-red-600 dark:text-red-400 uppercase tracking-wider">Ditolak</p>
            <p class="mt-2 text-3xl font-black text-red-600 dark:text-red-400">{{ $totalDitolak }}</p>
        </div>
    </div>

    <!-- Status Filter Pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
        <a href="{{ route('admin.pengajuan.index', ['status' => 'semua']) }}"
           class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all whitespace-nowrap {{ ($statusFilter ?? 'semua') === 'semua' ? 'bg-[#35635b] text-white shadow-sm' : 'bg-white dark:bg-[#152420] text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
            Semua Pengajuan
        </a>
        <a href="{{ route('admin.pengajuan.index', ['status' => 'pending']) }}"
           class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all whitespace-nowrap {{ ($statusFilter ?? '') === 'pending' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white dark:bg-[#152420] text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
            Pending ({{ $totalPending }})
        </a>
        <a href="{{ route('admin.pengajuan.index', ['status' => 'disetujui']) }}"
           class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all whitespace-nowrap {{ ($statusFilter ?? '') === 'disetujui' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white dark:bg-[#152420] text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
            Disetujui
        </a>
        <a href="{{ route('admin.pengajuan.index', ['status' => 'ditolak']) }}"
           class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all whitespace-nowrap {{ ($statusFilter ?? '') === 'ditolak' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white dark:bg-[#152420] text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
            Ditolak
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
        <div class="border-b border-gray-100 dark:border-[#233a34] px-5 sm:px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Daftar Pengajuan Agenda Rapat</h2>
                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Pengajuan agenda dari pegawai yang memerlukan verifikasi dan persetujuan admin.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#1b3832]">
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Agenda</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pegawai Pengaju</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ruang Rapat</th>
                        <th class="text-center px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="text-center px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#233a34]">
                    @forelse($pengajuanList as $item)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-[#1a2d29] transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900 dark:text-white">{{ $item->nama_agenda }}</p>
                                @if($item->deskripsi)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-1">{{ $item->deskripsi }}</p>
                                @endif
                                @if($item->penyelenggara)
                                    <span class="inline-block mt-1 text-[10px] px-2 py-0.5 rounded bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-300 font-medium">
                                        Penyelenggara: {{ $item->penyelenggara }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-800 dark:text-white">{{ $item->pegawai->nama_pegawai ?? '-' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">NIP: {{ $item->pegawai->nip ?? '-' }}</p>
                                <p class="text-[10px] text-emerald-600 dark:text-emerald-400 font-bold mt-0.5">
                                    {{ $item->dinas->nama_dinas ?? ($item->kecamatan->nama_kecamatan ?? '-') }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800 dark:text-gray-200">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}{{ $item->waktu_selesai ? ' - ' . \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') : '' }} WIB
                                </p>
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                <p class="font-semibold">{{ $item->ruangRapat->nama_ruang ?? 'Belum Ditentukan' }}</p>
                                @if($item->ruangRapat)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Kapasitas: {{ $item->ruangRapat->kapasitas }} orang</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($item->status === 'disetujui')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-700/50">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Disetujui
                                    </span>
                                @elseif($item->status === 'ditolak')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-700/50" title="{{ $item->catatan_admin }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Ditolak
                                    </span>
                                    @if($item->catatan_admin)
                                        <p class="text-[10px] text-rose-600 dark:text-rose-400 mt-1 max-w-[150px] truncate mx-auto" title="{{ $item->catatan_admin }}">{{ $item->catatan_admin }}</p>
                                    @endif
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-700/50">
                                        <svg class="w-3.5 h-3.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if($item->status === 'pending')
                                        <!-- Form Setujui -->
                                        <form method="POST" action="{{ route('admin.pengajuan.setujui', $item->id_pengajuan) }}" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pengajuan agenda ini?')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-xs transition-all flex items-center gap-1 cursor-pointer" title="Setujui Pengajuan">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Setujui
                                            </button>
                                        </form>

                                        <!-- Tombol Modal Tolak -->
                                        <button onclick="openTolakModal({{ $item->id_pengajuan }}, '{{ addslashes($item->nama_agenda) }}')" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-xs transition-all flex items-center gap-1 cursor-pointer" title="Tolak Pengajuan">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Tolak
                                        </button>
                                    @endif

                                    <!-- Form Hapus -->
                                    <form method="POST" action="{{ route('admin.pengajuan.destroy', $item->id_pengajuan) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengajuan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-white/10 transition-colors cursor-pointer" title="Hapus Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Tidak ada pengajuan agenda rapat yang ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengajuanList->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-[#233a34]">
                {{ $pengajuanList->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Tolak Pengajuan -->
<div id="modal-tolak" class="hidden fixed inset-0 z-[9999] items-center justify-center bg-black/50 backdrop-blur-xs">
    <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-2xl w-full max-w-md mx-4 border border-gray-200 dark:border-[#233a34]">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-[#233a34] flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-800 dark:text-white">Tolak Pengajuan Agenda</h3>
            <button onclick="closeTolakModal()" class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 flex items-center justify-center text-gray-500 dark:text-gray-300 transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="form-tolak" method="POST" action="" class="p-6 space-y-4">
            @csrf
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Agenda: <strong id="tolak-nama-agenda" class="text-gray-800 dark:text-white"></strong></p>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alasan Penolakan (Catatan Admin)</label>
                <textarea name="catatan_admin" rows="3" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-rose-500/30 focus:border-rose-500 resize-none" placeholder="Masukkan alasan penolakan..."></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeTolakModal()" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-[#0f1c19] text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-200 transition-colors cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold shadow-md transition-all cursor-pointer">Tolak Pengajuan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openTolakModal(id, namaAgenda) {
        document.getElementById('tolak-nama-agenda').innerText = namaAgenda;
        document.getElementById('form-tolak').action = `/admin/pengajuan-agenda/${id}/tolak`;
        const modal = document.getElementById('modal-tolak');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeTolakModal() {
        const modal = document.getElementById('modal-tolak');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection
