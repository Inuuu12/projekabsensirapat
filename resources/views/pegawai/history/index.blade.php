@extends('pegawai.layout.app')

@section('title', 'History Rapat')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Header -->
    <div>
        <h2 class="text-lg font-black text-gray-900 dark:text-white">History Rapat</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Riwayat kehadiran Anda pada agenda rapat yang telah berlangsung.</p>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-[#1b3832]">
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Agenda</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ruangan</th>
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lokasi Presensi</th>
                        <th class="text-center px-6 py-3.5 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bukti</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#233a34]">
                    @forelse($historyList as $i => $item)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-[#1a2d29] transition-colors">
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 font-medium">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">{{ $item->nama_agenda ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $item->waktu ? \Carbon\Carbon::parse($item->waktu)->format('H:i') : '-' }} WIB</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $item->nama_ruang ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-xs max-w-[180px] truncate">{{ $item->lokasi_presensi ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($item->foto_kehadiran)
                                    <button onclick="openModal('modal-bukti-{{ $i }}')" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-[#35635b]/10 dark:bg-emerald-900/20 text-[#35635b] dark:text-emerald-400 text-xs font-bold hover:bg-[#35635b]/20 dark:hover:bg-emerald-900/40 transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Lihat
                                    </button>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center">
                                <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-sm text-gray-400 dark:text-gray-500 font-medium">Belum ada riwayat rapat</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Photo Proof Modals -->
@foreach($historyList as $i => $item)
    @if($item->foto_kehadiran)
        <div id="modal-bukti-{{ $i }}" class="hidden fixed inset-0 z-[9999] items-center justify-center bg-black/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-2xl max-w-lg mx-4 overflow-hidden border border-gray-200 dark:border-[#233a34]">
                <div class="px-5 py-3 border-b border-gray-100 dark:border-[#233a34] flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white">Bukti Kehadiran</h3>
                    <button onclick="closeModal('modal-bukti-{{ $i }}')" class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 flex items-center justify-center text-gray-500 dark:text-gray-300 transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-4">
                    <img src="{{ route('storage.media', $item->foto_kehadiran) }}" alt="Bukti Presensi" class="w-full rounded-xl object-contain max-h-[400px]">
                    <p class="text-xs text-gray-400 dark:text-gray-500 text-center mt-2">{{ $item->nama_agenda ?? '-' }} &bull; {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') : '' }}</p>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection
