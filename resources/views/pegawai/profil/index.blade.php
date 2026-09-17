@extends('pegawai.layout.app')

@section('title', 'Data Diri')

@section('content')
<div class="max-w-[900px] mx-auto space-y-6">

    <!-- Profile Card -->
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-xs overflow-hidden">
        <!-- Top Banner -->
        <div class="h-28 bg-gradient-to-r from-[#35635b] to-[#1a332d] relative">
            <div class="absolute -bottom-10 left-6">
                <div class="w-20 h-20 rounded-2xl border-4 border-white dark:border-[#152420] bg-[#35635b] shadow-lg flex items-center justify-center text-white font-black text-2xl overflow-hidden">
                    @if($pegawai->foto)
                        <img src="{{ route('storage.media', $pegawai->foto) }}" alt="Foto Profil" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($pegawai->nama_pegawai, 0, 1)) }}
                    @endif
                </div>
            </div>
        </div>

        <div class="pt-14 px-6 pb-6">
            <h2 class="text-xl font-black text-gray-900 dark:text-white">{{ $pegawai->nama_pegawai }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $pegawai->jabatan ?? '-' }} &bull; {{ $pegawai->bidang ?? '-' }}</p>

            <!-- Status Badge -->
            <div class="mt-4 flex flex-wrap gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold
                    {{ $pegawai->status_verifikasi === 'aktif' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : ($pegawai->status_verifikasi === 'ditolak' ? 'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400' : 'bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400') }}">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                    {{ ucfirst($pegawai->status_verifikasi) }}
                </span>
                @if($pegawai->face_descriptor)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-bold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Face AI Terdaftar
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800/50 text-gray-500 dark:text-gray-400 text-xs font-bold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        Face AI Belum Terdaftar
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Data Diri Info -->
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-[#233a34]">
            <h3 class="text-sm font-bold text-gray-800 dark:text-white uppercase tracking-wider">Informasi Data Diri</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-8">
                <div>
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Nama Lengkap</label>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white mt-1">{{ $pegawai->nama_pegawai }}</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">NIP</label>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white mt-1">{{ $pegawai->nip ?: '-' }}</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Email</label>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white mt-1">{{ $pegawai->email }}</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Nomor HP</label>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white mt-1">{{ $pegawai->nomor_hp ?: '-' }}</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tanggal Lahir</label>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white mt-1">{{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Jabatan</label>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white mt-1">{{ $pegawai->jabatan ?: '-' }}</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Bidang</label>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white mt-1">{{ $pegawai->bidang ?: '-' }}</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Status Akun</label>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white mt-1">{{ ucfirst($pegawai->status_verifikasi) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
