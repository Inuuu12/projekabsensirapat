@extends('admin.layout.app')

@slot('title', 'Daftar Agenda')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Agenda Kegiatan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola jadwal rapat, lokasi, undangan, dan status sistem absensi rapat.</p>
        </div>
        <button class="mt-4 md:mt-0 inline-flex items-center bg-[#387673] hover:bg-[#2d5f5c] text-white text-xs font-bold py-2.5 px-5 rounded-lg shadow-sm transition-all active:scale-95">
            <span class="mr-2 text-sm">+</span> Tambah Agenda Baru
        </button>
    </div>

    <!-- Agenda Table Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-bold text-xs uppercase">
                        <th class="p-4 pl-6">Judul Kegiatan</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Waktu & Lokasi</th>
                        <th class="p-4">Undangan</th>
                        <th class="p-4">Face Recognition</th>
                        <th class="p-4">Status QR</th>
                        <th class="p-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-700">
                    @forelse($agenda as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 font-bold text-gray-900">
                            {{ $item->judul }}
                        </td>
                        <td class="p-4">
                            @if($item->kategori_surat == 'internal->internal')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    Internal to Internal
                                </span>
                            @elseif($item->kategori_surat == 'internal->external')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    Internal to External
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                    External to Internal
                                </span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="x flex-col">
                                <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</span>
                                <span class="text-xs text-gray-400 mt-0.5">{{ substr($item->waktu, 0, 5) }} WIB @ {{ $item->lokasi }}</span>
                            </div>
                        </td>
                        <td class="p-4">
                            @if($item->file_undangan)
                                <a href="{{ asset('storage/' . $item->file_undangan) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-[#387673] hover:underline">
                                    📥 Download PDF
                                </a>
                            @else
                                <span class="text-xs text-gray-400">Tidak ada file</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($item->status_FaceRecognition)
                                <span class="inline-flex items-center text-xs font-semibold text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 mr-1.5 animate-pulse"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center text-xs font-semibold text-gray-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mr-1.5"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($item->status_qr == 'aktif')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-gray-100 text-gray-600">
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="p-4 pr-6 text-right space-x-2">
                            <button class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 hover:bg-gray-100 text-gray-500 hover:text-gray-800 transition-colors" title="Konfigurasi">
                                ⚙️
                            </button>
                            <button class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                🗑️
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-400">
                            Belum ada agenda rapat yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
