@extends('admin.layout.app')

@section('title', 'Detail Agenda')

@section('content')
@php
    $notulen = $dokumen->firstWhere('jenis_dokumen', 'notulen');
    $dokumentasiItems = $dokumen->where('jenis_dokumen', 'dokumentasi')->values();
    $waktuMulai = substr((string) $agenda->waktu, 0, 5);
    $waktuSelesai = $agenda->waktu_selesai ? substr((string) $agenda->waktu_selesai, 0, 5) : null;
    $qrPayload = $qrCode?->qr_codepath;
    $qrImageUrl = $qrPayload ? 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=' . urlencode($qrPayload) : null;
@endphp

<div class="max-w-[1400px] mx-auto space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Detail Agenda</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Informasi agenda, dokumen, dan status absensi.</p>
        </div>
        <a href="{{ route('admin.agenda.lihat', ['kategori_surat' => $agenda->kategori_surat ?? 'internal']) }}" class="inline-flex h-10 items-center justify-center rounded-lg border border-gray-200 bg-white px-4 text-sm font-bold text-gray-700 transition hover:bg-gray-50">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <section class="lg:col-span-7 space-y-6">
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-xs">
                <span class="inline-flex rounded-lg border px-2.5 py-1 text-xs font-bold tracking-wider uppercase {{ $agenda->status_badge_class }}">
                    {{ $agenda->status_label }}
                </span>
                <h2 class="text-xl font-extrabold text-gray-800 mt-4">{{ $agenda->nama_agenda }}</h2>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5 text-sm">
                    <div>
                        <dt class="text-xs font-semibold text-gray-400">Tanggal</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $agenda->tanggal?->translatedFormat('d M Y') ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-gray-400">Waktu</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $waktuMulai ?: '-' }}{{ $waktuSelesai ? ' - ' . $waktuSelesai : '' }} WIB</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold text-gray-400">Tempat</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $agenda->lokasi ?: ($ruang->nama_ruang ?? '-') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-gray-400">Asal Surat</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $agenda->asal_surat ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-gray-400">Kuota</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $agenda->kuota ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="border-2 border-dashed border-gray-200 p-5 rounded-2xl bg-white">
                    <p class="text-sm font-bold text-gray-700">Notulen Agenda</p>
                    @if ($notulen)
                        <p class="mt-1 truncate text-xs font-semibold text-[#35635b]">{{ $notulen->nama_file }}</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ asset('storage/' . $notulen->file_path) }}" target="_blank" class="rounded-lg bg-[#35635b] px-3 py-2 text-xs font-bold text-white hover:bg-[#2b4f49]">Lihat</a>
                            <button type="button" onclick="openDeleteModal('{{ route('admin.agenda.dokumen.destroy', [$agenda->id_agenda, $notulen->id_dokumen]) }}', 'Hapus Notulen?', 'Apakah Anda yakin ingin menghapus notulen agenda ini?')" class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100" title="Hapus Notulen">
                                <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                <span class="sr-only">Hapus</span>
                            </button>
                        </div>
                    @else
                        <p class="text-xs text-gray-400 mt-1">Belum ada dokumen.</p>
                    @endif
                    <form method="POST" action="{{ route('admin.agenda.dokumen.store', $agenda->id_agenda) }}" enctype="multipart/form-data" class="mt-4 space-y-3">
                        @csrf
                        <input type="hidden" name="jenis_dokumen" value="notulen">
                        <input name="dokumen" type="file" accept=".pdf,.doc,.docx" required class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs text-gray-700">
                        <button type="submit" class="w-full rounded-lg bg-[#04733f] px-3 py-2 text-xs font-bold text-white hover:bg-[#035f35]">
                            {{ $notulen ? 'Ganti Notulen' : 'Unggah Notulen' }}
                        </button>
                    </form>
                </div>

                <div class="border-2 border-dashed border-gray-200 p-5 rounded-2xl bg-white">
                    <p class="text-sm font-bold text-gray-700">Dokumentasi Agenda</p>
                    @if ($dokumentasiItems->isNotEmpty())
                        <div class="mt-3 space-y-2">
                            @foreach ($dokumentasiItems as $dokumentasi)
                                <div class="flex items-center justify-between gap-3 rounded-lg bg-gray-50 px-3 py-2">
                                    <p class="min-w-0 truncate text-xs font-semibold text-[#35635b]">{{ $dokumentasi->nama_file }}</p>
                                    <div class="flex shrink-0 gap-2">
                                        <a href="{{ asset('storage/' . $dokumentasi->file_path) }}" target="_blank" class="rounded-lg bg-[#35635b] px-3 py-2 text-xs font-bold text-white hover:bg-[#2b4f49]">Lihat</a>
                                        <button type="button" onclick="openDeleteModal('{{ route('admin.agenda.dokumen.destroy', [$agenda->id_agenda, $dokumentasi->id_dokumen]) }}', 'Hapus Dokumentasi?', 'Apakah Anda yakin ingin menghapus dokumentasi agenda ini?')" class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100" title="Hapus Dokumentasi">
                                            <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                            <span class="sr-only">Hapus</span>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-400 mt-1">Belum ada dokumentasi.</p>
                    @endif
                    <form method="POST" action="{{ route('admin.agenda.dokumen.store', $agenda->id_agenda) }}" enctype="multipart/form-data" class="mt-4 space-y-3">
                        @csrf
                        <input type="hidden" name="jenis_dokumen" value="dokumentasi">
                        <input name="dokumen[]" type="file" accept=".jpg,.jpeg,.png,.webp" multiple required class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs text-gray-700">
                        <button type="submit" class="w-full rounded-lg bg-[#04733f] px-3 py-2 text-xs font-bold text-white hover:bg-[#035f35]">
                            Unggah Dokumentasi
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <section class="lg:col-span-5 space-y-6">
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-xs">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-bold text-gray-800 tracking-wide uppercase">QR Presensi Pegawai</h2>
                        <p class="mt-1 text-xs text-gray-500">QR ini mengarah ke halaman presensi pegawai untuk agenda ini.</p>
                    </div>
                    <span class="rounded-full px-2.5 py-1 text-[10px] font-bold {{ $agenda->status_label === 'Selesai' ? 'bg-amber-100 text-amber-800' : ($agenda->status_qr === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500') }}">
                        {{ $agenda->status_label === 'Selesai' ? 'Selesai (Nonaktif)' : ($agenda->status_qr === 'aktif' ? 'Aktif' : 'Nonaktif') }}
                    </span>
                </div>

                @if ($agenda->status_label === 'Selesai')
                    <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-5 text-center">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-amber-600 mb-2">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 11 0 0118 0z" /></svg>
                        </div>
                        <p class="text-xs font-extrabold text-amber-900">Agenda Rapat Telah Selesai</p>
                        <p class="mt-1 text-[11px] font-medium text-amber-700">QR Code presensi dinonaktifkan otomatis karena agenda rapat telah berakhir.</p>
                    </div>
                @elseif ($qrImageUrl)
                    <div class="mt-5 flex flex-col items-center gap-4">
                        <img src="{{ $qrImageUrl }}" alt="QR Presensi {{ $agenda->nama_agenda }}" class="h-56 w-56 rounded-xl border border-gray-100 bg-white p-3">
                        <div class="w-full rounded-xl bg-gray-50 p-3">
                            <p class="break-all text-[11px] font-semibold text-gray-500">{{ $qrPayload }}</p>
                        </div>
                        <a href="{{ $qrPayload }}" target="_blank" rel="noopener" class="inline-flex w-full items-center justify-center rounded-lg bg-[#35635b] px-4 py-2.5 text-xs font-bold text-white transition hover:bg-[#2b4f49]">
                            Buka Halaman Presensi
                        </a>
                    </div>
                @else
                    <div class="mt-5 rounded-xl border border-dashed border-gray-200 bg-gray-50 p-5 text-center">
                        <p class="text-xs font-semibold text-gray-500">QR belum dibuat untuk agenda ini.</p>
                        <a href="{{ url('/admin/agenda/' . $agenda->id_agenda . '/generate-qr') }}" class="mt-4 inline-flex items-center justify-center rounded-lg bg-[#35635b] px-4 py-2.5 text-xs font-bold text-white transition hover:bg-[#2b4f49]">
                            Generate QR
                        </a>
                    </div>
                @endif
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                <h2 class="text-sm font-bold text-gray-800 tracking-wide uppercase">Peserta Hadir</h2>
                <span class="bg-[#35635b] text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pesertaHadir->count() }} Hadir</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 uppercase tracking-wider text-[10px] border-b border-gray-100">
                            <th class="pb-2 font-semibold">Nama</th>
                            <th class="pb-2 font-semibold">Jabatan</th>
                            <th class="pb-2 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse ($pesertaHadir as $peserta)
                            <tr>
                                <td class="py-3 font-bold text-gray-900">{{ $peserta->nama }}</td>
                                <td class="py-3 text-gray-500">{{ $peserta->jabatan ?: '-' }}</td>
                                <td class="py-3"><span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded text-[10px] font-bold">Hadir</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-6 text-center text-gray-400">Belum ada peserta hadir.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </div>
        </section>
    </div>
</div>
@endsection
