@extends('pegawai.layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Greeting -->
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-6 shadow-xs">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#35635b] to-[#1a332d] flex items-center justify-center text-white font-bold text-xl overflow-hidden shrink-0">
                @if($pegawai->foto)
                    <img src="{{ route('storage.media', $pegawai->foto) }}" alt="Foto" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr($pegawai->nama_pegawai, 0, 1)) }}
                @endif
            </div>
            <div>
                <h2 class="text-xl font-black text-gray-900 dark:text-white">Selamat {{ now()->timezone('Asia/Jakarta')->format('H') < 12 ? 'Pagi' : (now()->timezone('Asia/Jakarta')->format('H') < 15 ? 'Siang' : (now()->timezone('Asia/Jakarta')->format('H') < 18 ? 'Sore' : 'Malam')) }}, {{ $pegawai->nama_pegawai }}!</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $pegawai->jabatan ?? 'Pegawai' }} &bull; {{ $pegawai->bidang ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <!-- Total Rapat Diikuti -->
        <div class="relative overflow-hidden bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs transition-all hover:border-emerald-500/50 hover:shadow-md group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Rapat Diikuti</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tight mt-3">{{ number_format($totalRapatDiikuti ?? 0) }}</p>
        </div>

        <!-- Pengajuan Pending -->
        <div class="relative overflow-hidden bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs transition-all hover:border-amber-500/50 hover:shadow-md group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pengajuan Pending</span>
                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tight mt-3">{{ number_format($totalPengajuanPending ?? 0) }}</p>
        </div>

        <!-- Booking Disetujui -->
        <div class="relative overflow-hidden bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs transition-all hover:border-cyan-500/50 hover:shadow-md group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Disetujui</span>
                <div class="w-9 h-9 rounded-xl bg-cyan-50 dark:bg-cyan-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tight mt-3">{{ number_format($totalBookingDisetujui ?? 0) }}</p>
        </div>

        <!-- Ruang Rapat -->
        <div class="relative overflow-hidden bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs transition-all hover:border-indigo-500/50 hover:shadow-md group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ruang Rapat</span>
                <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H7m4 0v10"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-gray-900 dark:text-white tracking-tight mt-3">{{ number_format($ruangList->count()) }}</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left: Agenda Mendatang -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-xs overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-[#233a34] flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider">Agenda Rapat Mendatang</h3>
                    <a href="{{ route('pegawai.booking.index') }}" class="text-xs font-semibold text-[#35635b] dark:text-emerald-400 hover:underline">Lihat Kalender →</a>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-[#233a34]">
                    @forelse($agendaMendatang as $agenda)
                        <div class="px-6 py-4 hover:bg-gray-50/50 dark:hover:bg-[#1a2d29] transition-colors">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-sm text-gray-800 dark:text-white truncate">{{ $agenda->nama_agenda }}</p>
                                    <div class="flex items-center gap-3 mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="3" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M8 2v4M16 2v4M3 9h18"/></svg>
                                            {{ \Carbon\Carbon::parse($agenda->tanggal)->translatedFormat('d M Y') }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ \Carbon\Carbon::parse($agenda->waktu)->format('H:i') }} WIB
                                        </span>
                                    </div>
                                </div>
                                <div class="shrink-0">
                                    @if($agenda->ruangRapat)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-[10px] font-bold">
                                            {{ $agenda->ruangRapat->nama_ruang }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center">
                            <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="3" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M8 2v4M16 2v4M3 9h18"/></svg>
                            <p class="text-sm text-gray-400 dark:text-gray-500 font-medium">Tidak ada agenda mendatang</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Riwayat Pengajuan Terakhir -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-xs overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-[#233a34] flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider">Pengajuan Terbaru</h3>
                    <a href="{{ route('pegawai.pengajuan.index') }}" class="text-xs font-semibold text-[#35635b] dark:text-emerald-400 hover:underline">Lihat Semua →</a>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-[#233a34]">
                    @forelse($riwayatPengajuanTerbaru as $pengajuan)
                        <div class="px-6 py-4 hover:bg-gray-50/50 dark:hover:bg-[#1a2d29] transition-colors">
                            <div class="flex items-center justify-between gap-3">
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-sm text-gray-800 dark:text-white truncate">{{ $pengajuan->nama_agenda }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $pengajuan->created_at ? \Carbon\Carbon::parse($pengajuan->created_at)->translatedFormat('d M Y') : '-' }}</p>
                                </div>
                                <span class="shrink-0 inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold
                                    {{ $pengajuan->status === 'disetujui' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : ($pengajuan->status === 'ditolak' ? 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400' : 'bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400') }}">
                                    {{ ucfirst($pengajuan->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center">
                            <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-sm text-gray-400 dark:text-gray-500 font-medium">Belum ada pengajuan</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-xs p-6">
                <h3 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('pegawai.pengajuan.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-gray-50 dark:bg-[#1a2d29] border border-gray-100 dark:border-[#233a34] hover:border-[#35635b]/50 dark:hover:border-emerald-500/30 hover:shadow-md transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-[#35635b]/10 dark:bg-emerald-900/30 flex items-center justify-center group-hover:bg-[#35635b]/20 dark:group-hover:bg-emerald-900/50 transition-colors">
                            <svg class="w-5 h-5 text-[#35635b] dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300 text-center">Ajukan Agenda</span>
                    </a>
                    <a href="{{ route('pegawai.booking.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-gray-50 dark:bg-[#1a2d29] border border-gray-100 dark:border-[#233a34] hover:border-[#35635b]/50 dark:hover:border-emerald-500/30 hover:shadow-md transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-[#35635b]/10 dark:bg-emerald-900/30 flex items-center justify-center group-hover:bg-[#35635b]/20 dark:group-hover:bg-emerald-900/50 transition-colors">
                            <svg class="w-5 h-5 text-[#35635b] dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="17" rx="3" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M8 2v4M16 2v4M3 9h18"/></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300 text-center">Cek Kalender</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
