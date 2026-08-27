@extends('admin.layout.app')

@section('title', 'Masukkan')

@section('content')
@php
    $statusFilter = request('status', 'semua');
    $statusCategory = function ($status) {
        $normalized = strtolower(trim((string) $status));

        return match ($normalized) {
            'pending', 'menunggu' => 'menunggu',
            'diproses', 'proses', 'di baca' => 'diproses',
            'selesai' => 'selesai',
            default => $normalized ?: 'menunggu',
        };
    };

    $statusLabel = function ($status) use ($statusCategory) {
        return match ($statusCategory($status)) {
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            default => $status ?: 'Menunggu',
        };
    };

    $statusBadgeClass = function ($status) use ($statusCategory) {
        return match ($statusCategory($status)) {
            'menunggu' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-950/60 dark:text-red-300 dark:border-red-800/60',
            'diproses' => 'bg-yellow-50 text-yellow-800 border-yellow-200 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800/60',
            'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800/60',
            default => 'bg-slate-100 text-slate-700 border-slate-300 dark:bg-[#1a2e29] dark:text-slate-200 dark:border-[#35584f]',
        };
    };

    $filteredMasukan = $statusFilter === 'semua'
        ? $masukan
        : $masukan->filter(fn ($item) => $statusCategory($item->status) === $statusFilter);

    $totalAduan = $masukan->count();
    $totalMenunggu = $masukan->filter(fn ($item) => $statusCategory($item->status) === 'menunggu')->count();
    $totalDiproses = $masukan->filter(fn ($item) => $statusCategory($item->status) === 'diproses')->count();
    $totalSelesai = $masukan->filter(fn ($item) => $statusCategory($item->status) === 'selesai')->count();
@endphp

<div class="mx-auto max-w-[1500px] space-y-7 text-[#08251f] dark:text-slate-100">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] dark:text-white tracking-tight">Pengaduan</h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-300 mt-1">Kelola dan tindak lanjuti keluhan pengguna.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="flex min-h-24 items-center gap-4 rounded-2xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#152420] px-5 py-4 shadow-xs transition-colors">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-200/80 dark:bg-emerald-900/50 p-2.5">
                <img src="{{ asset('assets/foto/Total Aduan.png') }}" alt="Total Aduan" class="h-full w-full object-contain">
            </div>
            <div>
                <p class="text-sm font-extrabold text-slate-600 dark:text-gray-300">Total Aduan</p>
                <p class="mt-1 text-2xl font-black text-[#08251f] dark:text-emerald-400">{{ number_format($totalAduan) }}</p>
            </div>
        </div>

        <div class="flex min-h-24 items-center gap-4 rounded-2xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#152420] px-5 py-4 shadow-xs transition-colors">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/50 p-2.5">
                <img src="{{ asset('assets/foto/Menunggu.png') }}" alt="Menunggu" class="h-full w-full object-contain">
            </div>
            <div>
                <p class="text-sm font-extrabold text-slate-600 dark:text-gray-300">Menunggu</p>
                <p class="mt-1 text-2xl font-black text-red-600 dark:text-rose-400">{{ number_format($totalMenunggu) }}</p>
            </div>
        </div>

        <div class="flex min-h-24 items-center gap-4 rounded-2xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#152420] px-5 py-4 shadow-xs transition-colors">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#e9f0ed] dark:bg-[#1b3832] p-2.5">
                <img src="{{ asset('assets/foto/process.png') }}" alt="Diproses" class="h-full w-full object-contain">
            </div>
            <div>
                <p class="text-sm font-extrabold text-slate-600 dark:text-gray-300">Diproses</p>
                <p class="mt-1 text-2xl font-black text-[#08251f] dark:text-amber-400">{{ number_format($totalDiproses) }}</p>
            </div>
        </div>

        <div class="flex min-h-24 items-center gap-4 rounded-2xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#152420] px-5 py-4 shadow-xs transition-colors">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#e9f0ed] dark:bg-[#1b3832] p-2.5">
                <img src="{{ asset('assets/foto/Selesai.png') }}" alt="Selesai" class="h-full w-full object-contain">
            </div>
            <div>
                <p class="text-sm font-extrabold text-slate-600 dark:text-gray-300">Selesai</p>
                <p class="mt-1 text-2xl font-black text-[#08251f] dark:text-emerald-400">{{ number_format($totalSelesai) }}</p>
            </div>
        </div>
    </div>

    <section class="overflow-hidden rounded-2xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#152420] shadow-xs transition-colors">
        <div class="flex flex-col gap-4 border-b border-gray-100 dark:border-[#233a34] px-6 py-6 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-extrabold text-[#0f513f] dark:text-white">Log Aduan</h2>
            <form method="GET" action="{{ route('admin.masukkan.lihat') }}" class="flex items-center gap-3">
                <label for="status-filter" class="text-sm font-medium text-slate-600 dark:text-gray-300">Filter by:</label>
                <select id="status-filter" name="status" onchange="this.form.submit()" class="h-10 rounded-md border border-slate-300 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm font-medium text-slate-700 dark:text-white outline-none focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    <option value="semua" @selected($statusFilter === 'semua')>Status: Semua</option>
                    <option value="menunggu" @selected($statusFilter === 'menunggu')>Menunggu</option>
                    <option value="diproses" @selected($statusFilter === 'diproses')>Diproses</option>
                    <option value="selesai" @selected($statusFilter === 'selesai')>Selesai</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1260px] text-left">
                <thead>
                    <tr class="bg-[#397d77] dark:bg-[#1b3832] text-sm font-black uppercase tracking-wider text-white">
                        <th class="px-14 py-6">Nama<br>Pengadu</th>
                        <th class="px-6 py-6">Email</th>
                        <th class="px-6 py-6">Isi Aduan</th>
                        <th class="px-6 py-6">Balasan Admin</th>
                        <th class="px-6 py-6">Waktu</th>
                        <th class="px-6 py-6">Tanggal</th>
                        <th class="px-6 py-6">Status</th>
                        <th class="px-6 py-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-[#233a34] text-sm">
                    @forelse ($filteredMasukan as $item)
                        <tr class="align-middle transition hover:bg-slate-50/80 dark:hover:bg-[#1b332d]">
                            <td class="px-14 py-8 font-black leading-snug text-[#08251f] dark:text-white">{{ $item->nama_pengadu }}</td>
                            <td class="px-6 py-8 font-medium text-[#08251f] dark:text-slate-200">{{ $item->email }}</td>
                            <td class="max-w-md px-6 py-8 leading-relaxed text-[#08251f] dark:text-slate-200">
                                {{ \Illuminate\Support\Str::limit($item->isi_aduan, 76) }}
                            </td>
                            <td class="max-w-sm px-6 py-8 leading-relaxed text-[#08251f] dark:text-slate-200">
                                @if ($item->balasan_admin)
                                    {{ \Illuminate\Support\Str::limit($item->balasan_admin, 72) }}
                                @else
                                    <span class="text-slate-400 dark:text-gray-500">Belum ada balasan</span>
                                @endif
                            </td>
                            <td class="px-6 py-8 font-medium text-[#08251f] dark:text-slate-200">
                                {{ optional($item->created_at)->format('H:i') ?? '-' }}
                            </td>
                            <td class="px-6 py-8 whitespace-nowrap font-medium text-[#08251f] dark:text-slate-200">
                                {{ optional($item->created_at)->translatedFormat('d M Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-8">
                                <form method="POST" action="{{ route('admin.masukkan.update', $item->id_datamasukan) }}">
                                    @csrf
                                    @method('PUT')
                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="rounded-full border px-3 py-1.5 text-xs font-black outline-none {{ $statusBadgeClass($item->status) }} dark:bg-[#0f1c19]">
                                        <option value="Menunggu" @selected($statusCategory($item->status) === 'menunggu')>Menunggu</option>
                                        <option value="Diproses" @selected($statusCategory($item->status) === 'diproses')>Diproses</option>
                                        <option value="Selesai" @selected($statusCategory($item->status) === 'selesai')>Selesai</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-8">
                                <div class="flex items-center justify-center gap-4">
                                    @php
                                        $hasItemPhoto = !empty($item->foto)
                                            && $item->foto !== 'aduan/default.jpg'
                                            && file_exists(public_path('storage/' . $item->foto));
                                        $itemPhotoUrl = $hasItemPhoto ? asset('storage/' . $item->foto) : '';
                                    @endphp
                                    <button
                                        type="button"
                                        onclick="openMasukkanDetail(this)"
                                        data-action="{{ route('admin.masukkan.update', $item->id_datamasukan) }}"
                                        data-name="{{ $item->nama_pengadu }}"
                                        data-email="{{ $item->email }}"
                                        data-phone="{{ $item->nomor_pengadu }}"
                                        data-photo="{{ $itemPhotoUrl }}"
                                        data-status="{{ $statusLabel($item->status) }}"
                                        data-time="{{ optional($item->created_at)->format('H:i') ?? '-' }}"
                                        data-date="{{ optional($item->created_at)->translatedFormat('d M Y') ?? '-' }}"
                                        data-message="{{ $item->isi_aduan }}"
                                        data-reply="{{ $item->balasan_admin }}"
                                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-gray-100 dark:hover:bg-[#23423b] cursor-pointer"
                                        title="Lihat Detail">
                                        <img src="{{ asset('assets/foto/Detaillogo.png') }}" alt="Detail" class="h-full w-full object-contain">
                                        <span class="sr-only">Lihat Detail</span>
                                    </button>

                                    <button
                                        type="button"
                                        onclick="openMasukkanReply(this)"
                                        data-action="{{ route('admin.masukkan.reply', $item->id_datamasukan) }}"
                                        data-name="{{ $item->nama_pengadu }}"
                                        data-email="{{ $item->email }}"
                                        data-message="{{ $item->isi_aduan }}"
                                        data-reply="{{ $item->balasan_admin }}"
                                        class="text-[#0f6b52] dark:text-emerald-400 transition hover:text-[#083c30] cursor-pointer"
                                        title="Reply">
                                        <img src="{{ asset('assets/foto/Reply.png') }}" alt="Reply" class="h-6 w-6 object-contain">
                                    </button>

                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.masukkan.destroy', $item->id_datamasukan) }}', 'Hapus Masukkan?', 'Apakah Anda yakin ingin menghapus masukkan ini?')"
                                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer"
                                        title="Hapus">
                                        <img src="{{ asset('assets/foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                        <span class="sr-only">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500 dark:text-gray-400">Belum ada data pengaduan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-4 border-t border-gray-100 dark:border-[#233a34] px-6 py-5 text-sm text-slate-600 dark:text-gray-300 sm:flex-row sm:items-center sm:justify-between">
            <p>Menampilkan {{ $filteredMasukan->count() ? '1-' . $filteredMasukan->count() : '0' }} dari {{ $totalAduan }} aduan</p>
            <div class="flex items-center gap-2">
                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-md border border-slate-300 dark:border-[#284c43] text-[#0f513f] dark:text-emerald-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <span class="flex h-10 w-10 items-center justify-center rounded-md bg-[#0f6b52] font-black text-white">1</span>
                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-md border border-slate-300 dark:border-[#284c43] font-semibold text-[#08251f] dark:text-gray-300">2</button>
                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-md border border-slate-300 dark:border-[#284c43] font-semibold text-[#08251f] dark:text-gray-300">3</button>
                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-md border border-slate-300 dark:border-[#284c43] text-[#0f513f] dark:text-emerald-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </div>
    </section>
</div>

<div id="modal-detail-masukkan" class="fixed inset-0 z-[70] hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto w-full max-w-2xl max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] flex flex-col rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43] overflow-hidden">
        <div class="flex items-center justify-between rounded-t-2xl border-b border-gray-100 dark:border-[#233a34] px-5 sm:px-6 py-4 shrink-0 bg-white dark:bg-[#163830]">
            <h3 class="text-base sm:text-lg font-black text-[#0f513f] dark:text-white">Detail Aduan</h3>
            <button type="button" onclick="closeMasukkanDetail()" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:text-white/80 dark:hover:bg-white/10 cursor-pointer" title="Tutup">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div class="flex-1 min-h-0 space-y-4 sm:space-y-5 p-4 sm:p-6 overflow-y-auto">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-gray-400">Nama Pengadu</p>
                    <p id="detail-name" class="mt-1 font-bold text-[#08251f] dark:text-white"></p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-gray-400">Email</p>
                    <p id="detail-email" class="mt-1 font-bold text-[#08251f] dark:text-white"></p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-gray-400">Kontak</p>
                    <p id="detail-phone" class="mt-1 font-bold text-[#08251f] dark:text-white"></p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-gray-400">Waktu</p>
                    <p id="detail-time" class="mt-1 font-bold text-[#08251f] dark:text-white"></p>
                </div>
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-gray-400">Isi Aduan</p>
                <p id="detail-message" class="mt-2 rounded-lg bg-slate-50 dark:bg-[#0f1c19] border border-gray-100 dark:border-[#284c43] p-4 leading-relaxed text-[#08251f] dark:text-slate-100"></p>
            </div>
            <div id="detail-photo-container" class="hidden">
                <p class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-gray-400">Lampiran Foto</p>
                <div class="mt-2 flex items-center gap-3">
                    <button type="button" 
                            id="detail-photo-btn"
                            onclick="openAdminPhotoModal()" 
                            class="group relative inline-block overflow-hidden rounded-lg border border-slate-200 dark:border-[#284c43] bg-slate-50 dark:bg-[#0f1c19] transition hover:border-[#35635b] hover:shadow-md cursor-pointer text-left"
                            title="Klik untuk memperbesar foto">
                        <img id="detail-photo-img" src="" alt="Lampiran Foto" class="max-h-48 w-auto rounded-lg object-contain transition duration-200 group-hover:scale-105">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100 rounded-lg">
                            <span class="rounded-md bg-white/90 px-2.5 py-1 text-xs font-bold text-[#08251f] shadow-sm flex items-center gap-1.5">
                                <span>🔍</span>
                                <span>Perbesar Foto</span>
                            </span>
                        </div>
                    </button>
                    <div class="text-xs text-slate-500 dark:text-gray-400">
                        <p class="font-medium text-slate-700 dark:text-gray-300">Lampiran foto aduan</p>
                        <p class="text-[11px] text-slate-400 dark:text-gray-500 mt-0.5">Klik foto untuk melihat dalam ukuran penuh dengan fitur zoom & pan.</p>
                    </div>
                </div>
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-gray-400">Balasan Admin</p>
                <p id="detail-reply" class="mt-2 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-100 dark:border-emerald-900/40 p-4 leading-relaxed text-[#08251f] dark:text-emerald-300"></p>
            </div>
        </div>
        <div class="flex justify-end gap-3 border-t border-gray-100 dark:border-[#233a34] p-3 sm:px-6 sm:py-3.5 bg-gray-50 dark:bg-[#0f1c19] rounded-b-2xl shrink-0">
            <button type="button" onclick="closeMasukkanDetail()" class="w-full sm:w-auto h-11 sm:h-9 rounded-xl px-5 text-xs font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-200/60 dark:hover:bg-white/5 cursor-pointer transition">Tutup</button>
        </div>
    </div>
</div>

<div id="modal-reply-masukkan" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto w-full max-w-2xl max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] flex flex-col rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43] overflow-hidden">
        <div class="flex items-center justify-between rounded-t-2xl border-b border-gray-100 dark:border-[#233a34] px-5 sm:px-6 py-4 shrink-0 bg-white dark:bg-[#163830]">
            <h3 class="text-base sm:text-lg font-black text-[#0f513f] dark:text-white">Reply Masukkan</h3>
            <button type="button" onclick="closeMasukkanReply()" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:text-white/80 dark:hover:bg-white/10 cursor-pointer" title="Tutup">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form id="reply-form" method="POST" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="flex-1 min-h-0 space-y-4 sm:space-y-5 p-4 sm:p-6 overflow-y-auto">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-gray-400">Nama Pengadu</p>
                        <p id="reply-name" class="mt-1 font-bold text-[#08251f] dark:text-white"></p>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-gray-400">Email</p>
                        <p id="reply-email" class="mt-1 font-bold text-[#08251f] dark:text-white"></p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400 dark:text-gray-400">Isi Aduan</p>
                    <p id="reply-message" class="mt-2 rounded-lg bg-slate-50 dark:bg-[#0f1c19] border border-gray-100 dark:border-[#284c43] p-4 leading-relaxed text-[#08251f] dark:text-slate-100"></p>
                </div>
                <div>
                    <label for="reply-text" class="block text-xs font-black uppercase tracking-wider text-slate-400 dark:text-gray-400">Balasan Admin</label>
                    <textarea id="reply-text" name="balasan_admin" rows="4" required class="mt-2 w-full rounded-lg border border-slate-300 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] p-4 text-sm leading-relaxed text-[#08251f] dark:text-white outline-none focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500" placeholder="Tulis balasan untuk pengadu..."></textarea>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] p-3 sm:px-6 sm:py-4 bg-gray-50 dark:bg-[#0f1c19] rounded-b-2xl shrink-0">
                <button type="button" onclick="closeMasukkanReply()" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="w-full sm:w-auto inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#35635b] dark:bg-[#107050] hover:bg-[#2b4f49] dark:hover:bg-[#0c5940] px-5 text-xs sm:text-sm font-bold text-white cursor-pointer transition shadow-sm">Kirim Reply</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Preview Foto Lampiran Pop-Up Admin (Z-Index 90 di atas modal detail) -->
<div id="admin-photo-preview-modal" class="fixed inset-0 z-[90] hidden items-center justify-center bg-black/80 backdrop-blur-sm p-3 sm:p-6 transition-all duration-300">
    <div class="relative w-full max-w-5xl rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43] overflow-hidden flex flex-col max-h-[94vh] animate-in fade-in zoom-in-95 duration-200">
        <!-- Header Modal -->
        <div class="rounded-t-2xl bg-[#0f513f] text-white px-5 py-3.5 flex flex-wrap items-center justify-between gap-3 shrink-0 border-b border-white/10">
            <div class="flex items-center space-x-2.5">
                <span class="text-base">🖼️</span>
                <div>
                    <h3 class="text-xs sm:text-sm font-bold text-white leading-tight">Lampiran Foto Aduan</h3>
                    <p id="admin-modal-photo-author" class="text-[10px] text-white/70">Pengadu: -</p>
                </div>
            </div>

            <!-- Zoom Controls & Close Button -->
            <div class="flex items-center space-x-2">
                <div class="flex items-center bg-white/10 rounded-lg p-1 space-x-1 border border-white/10">
                    <button type="button" onclick="adminZoomOut()" class="w-7 h-7 rounded-md bg-transparent hover:bg-white/20 text-white flex items-center justify-center text-xs font-bold transition cursor-pointer" title="Perkecil (Zoom Out)">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
                    </button>
                    <span id="admin-zoom-level-badge" class="px-2 text-[11px] font-mono font-bold text-white min-w-[44px] text-center">100%</span>
                    <button type="button" onclick="adminZoomIn()" class="w-7 h-7 rounded-md bg-transparent hover:bg-white/20 text-white flex items-center justify-center text-xs font-bold transition cursor-pointer" title="Perbesar (Zoom In)">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    </button>
                    <button type="button" onclick="adminResetZoom()" class="px-2 h-7 rounded-md bg-transparent hover:bg-white/20 text-white flex items-center justify-center text-[10px] font-bold transition cursor-pointer" title="Reset Zoom">
                        Reset
                    </button>
                </div>

                <button type="button" onclick="closeAdminPhotoModal()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-sm font-bold transition cursor-pointer ml-1" title="Tutup">
                    ✕
                </button>
            </div>
        </div>

        <!-- Konten Gambar (Lebar & Bersih dengan Drag/Pan Bebas ke Segala Arah) -->
        <div id="admin-photo-container" class="relative p-4 sm:p-6 bg-[#161d1b] flex-1 flex items-center justify-center overflow-hidden min-h-[55vh] max-h-[76vh] select-none">
            <div class="transition-transform duration-100 ease-out origin-center flex items-center justify-center will-change-transform" id="admin-zoom-wrapper">
                <img id="admin-lightbox-img" 
                     src="" 
                     alt="Lampiran Foto Aduan" 
                     ondblclick="adminToggleZoom()"
                     class="max-h-[72vh] w-auto max-w-full object-contain rounded-lg shadow-lg border border-white/10 bg-[#0e1412] cursor-grab transition-all">
            </div>
        </div>

        <!-- Footer Modal -->
        <div class="px-5 py-3 bg-white dark:bg-[#152420] border-t border-gray-100 dark:border-[#233a34] flex flex-wrap items-center justify-between gap-3 shrink-0">
            <p class="text-[11px] text-gray-500 dark:text-gray-400 flex items-center space-x-1.5">
                <span>💡</span>
                <span>Gunakan tombol <span class="font-bold text-gray-700 dark:text-gray-200">Zoom</span> / Scroll mouse, lalu <span class="font-bold text-gray-700 dark:text-gray-200">drag (geser mouse)</span> bebas ke segala arah.</span>
            </p>
            <div class="flex items-center space-x-2.5">
                <a id="admin-modal-photo-download" href="#" target="_blank" download class="text-xs text-[#0f513f] dark:text-emerald-400 hover:text-[#083c30] font-bold px-3.5 py-2 rounded-lg hover:bg-emerald-50 dark:hover:bg-[#1b3832] border border-emerald-200 dark:border-[#284c43] transition-colors flex items-center space-x-1.5">
                    <span>⬇️</span>
                    <span>Unduh Gambar</span>
                </a>
                <button type="button" onclick="closeAdminPhotoModal()" class="bg-gray-100 dark:bg-[#0f1c19] hover:bg-gray-200 dark:hover:bg-[#1b3832] text-gray-700 dark:text-gray-300 text-xs font-bold px-4 py-2 rounded-lg transition-colors cursor-pointer border border-transparent dark:border-[#284c43]">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentAdminPhotoUrl = '';
    let currentAdminPhotoAuthor = '';

    function openMasukkanDetail(button) {
        const modal = document.getElementById('modal-detail-masukkan');
        const authorName = button.dataset.name || '-';
        document.getElementById('detail-name').textContent = authorName;
        document.getElementById('detail-email').textContent = button.dataset.email || '-';
        document.getElementById('detail-phone').textContent = button.dataset.phone || '-';
        document.getElementById('detail-time').textContent = `${button.dataset.time || '-'} / ${button.dataset.date || '-'}`;
        document.getElementById('detail-message').textContent = button.dataset.message || '-';
        document.getElementById('detail-reply').textContent = button.dataset.reply || 'Belum ada balasan.';

        const photoContainer = document.getElementById('detail-photo-container');
        const photoImg = document.getElementById('detail-photo-img');
        const photoUrl = button.dataset.photo;

        currentAdminPhotoUrl = photoUrl || '';
        currentAdminPhotoAuthor = authorName;

        if (photoUrl) {
            photoImg.src = photoUrl;
            photoContainer.classList.remove('hidden');
        } else {
            photoContainer.classList.add('hidden');
            photoImg.src = '';
        }

        modal.classList.replace('hidden', 'flex');
    }

    function closeMasukkanDetail() {
        document.getElementById('modal-detail-masukkan').classList.replace('flex', 'hidden');
    }

    function openMasukkanReply(button) {
        const modal = document.getElementById('modal-reply-masukkan');
        document.getElementById('reply-form').action = button.dataset.action;
        document.getElementById('reply-name').textContent = button.dataset.name || '-';
        document.getElementById('reply-email').textContent = button.dataset.email || '-';
        document.getElementById('reply-message').textContent = button.dataset.message || '-';
        document.getElementById('reply-text').value = button.dataset.reply || '';
        modal.classList.replace('hidden', 'flex');
    }

    function closeMasukkanReply() {
        document.getElementById('modal-reply-masukkan').classList.replace('flex', 'hidden');
    }

    // ==========================================
    // ADMIN PHOTO LIGHTBOX POP-UP & ZOOM / PAN
    // ==========================================
    const adminPhotoModal = document.getElementById('admin-photo-preview-modal');
    const adminPhotoContainer = document.getElementById('admin-photo-container');
    const adminLightboxImg = document.getElementById('admin-lightbox-img');
    const adminZoomWrapper = document.getElementById('admin-zoom-wrapper');
    const adminZoomLevelBadge = document.getElementById('admin-zoom-level-badge');
    const adminModalPhotoAuthor = document.getElementById('admin-modal-photo-author');
    const adminModalPhotoDownload = document.getElementById('admin-modal-photo-download');

    let adminZoom = 1;
    let adminTranslateX = 0;
    let adminTranslateY = 0;
    let isAdminDragging = false;
    let adminStartX = 0;
    let adminStartY = 0;

    const minZoom = 1.0;
    const maxZoom = 3.5;
    const zoomStep = 0.25;

    function applyAdminTransform() {
        if (!adminZoomWrapper) return;
        adminZoomWrapper.style.transform = `translate(${adminTranslateX}px, ${adminTranslateY}px) scale(${adminZoom})`;
        if (adminZoomLevelBadge) {
            adminZoomLevelBadge.textContent = `${Math.round(adminZoom * 100)}%`;
        }
        if (adminPhotoContainer) {
            if (adminZoom > 1) {
                adminPhotoContainer.classList.add('cursor-grab');
                if (isAdminDragging) {
                    adminPhotoContainer.classList.add('cursor-grabbing');
                } else {
                    adminPhotoContainer.classList.remove('cursor-grabbing');
                }
            } else {
                adminPhotoContainer.classList.remove('cursor-grab', 'cursor-grabbing');
            }
        }
    }

    function adminZoomIn() {
        if (adminZoom < maxZoom) {
            adminZoom = Math.min(maxZoom, Math.round((adminZoom + zoomStep) * 100) / 100);
            applyAdminTransform();
        }
    }

    function adminZoomOut() {
        if (adminZoom > minZoom) {
            adminZoom = Math.max(minZoom, Math.round((adminZoom - zoomStep) * 100) / 100);
            if (adminZoom <= 1) {
                adminTranslateX = 0;
                adminTranslateY = 0;
            }
            applyAdminTransform();
        }
    }

    function adminResetZoom() {
        adminZoom = 1;
        adminTranslateX = 0;
        adminTranslateY = 0;
        applyAdminTransform();
    }

    function adminToggleZoom() {
        if (adminZoom === 1) {
            adminZoom = 2;
        } else {
            adminZoom = 1;
            adminTranslateX = 0;
            adminTranslateY = 0;
        }
        applyAdminTransform();
    }

    // Drag / Pan Logic (Mouse)
    adminPhotoContainer?.addEventListener('mousedown', (e) => {
        if (e.button !== 0) return;
        if (adminZoom > 1) {
            isAdminDragging = true;
            adminStartX = e.clientX - adminTranslateX;
            adminStartY = e.clientY - adminTranslateY;
            adminPhotoContainer.classList.add('cursor-grabbing');
            e.preventDefault();
        }
    });

    window.addEventListener('mousemove', (e) => {
        if (!isAdminDragging) return;
        adminTranslateX = e.clientX - adminStartX;
        adminTranslateY = e.clientY - adminStartY;
        applyAdminTransform();
    });

    window.addEventListener('mouseup', () => {
        if (isAdminDragging) {
            isAdminDragging = false;
            if (adminPhotoContainer) adminPhotoContainer.classList.remove('cursor-grabbing');
        }
    });

    // Touch Drag (Mobile / Tablet)
    adminPhotoContainer?.addEventListener('touchstart', (e) => {
        if (e.touches.length === 1 && adminZoom > 1) {
            isAdminDragging = true;
            adminStartX = e.touches[0].clientX - adminTranslateX;
            adminStartY = e.touches[0].clientY - adminTranslateY;
        }
    }, { passive: true });

    window.addEventListener('touchmove', (e) => {
        if (!isAdminDragging || e.touches.length !== 1) return;
        adminTranslateX = e.touches[0].clientX - adminStartX;
        adminTranslateY = e.touches[0].clientY - adminStartY;
        applyAdminTransform();
    }, { passive: true });

    window.addEventListener('touchend', () => {
        isAdminDragging = false;
    });

    // Mouse Wheel Zoom
    adminPhotoContainer?.addEventListener('wheel', (e) => {
        e.preventDefault();
        if (e.deltaY < 0) {
            adminZoomIn();
        } else {
            adminZoomOut();
        }
    }, { passive: false });

    function openAdminPhotoModal() {
        if (!adminPhotoModal || !adminLightboxImg || !currentAdminPhotoUrl) return;
        adminResetZoom();
        adminLightboxImg.src = currentAdminPhotoUrl;
        if (adminModalPhotoAuthor) {
            adminModalPhotoAuthor.textContent = `Pengadu: ${currentAdminPhotoAuthor || 'Anonim'}`;
        }
        if (adminModalPhotoDownload) {
            adminModalPhotoDownload.href = currentAdminPhotoUrl;
        }
        adminPhotoModal.classList.remove('hidden');
        adminPhotoModal.classList.add('flex');
    }

    function closeAdminPhotoModal() {
        if (!adminPhotoModal) return;
        adminPhotoModal.classList.add('hidden');
        adminPhotoModal.classList.remove('flex');
        if (adminLightboxImg) adminLightboxImg.src = '';
        adminResetZoom();
    }

    // Tutup jika klik backdrop / latar belakang hitam
    adminPhotoModal?.addEventListener('click', (e) => {
        if (e.target === adminPhotoModal) {
            closeAdminPhotoModal();
        }
    });

    // Tutup jika tombol ESC ditekan
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !adminPhotoModal?.classList.contains('hidden')) {
            closeAdminPhotoModal();
        }
    });
</script>
@endpush
