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
            'menunggu' => 'bg-red-50 text-red-600 border-red-200',
            'diproses' => 'bg-yellow-50 text-yellow-600 border-yellow-200',
            'selesai' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            default => 'bg-gray-100 text-gray-600 border-gray-200',
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

<div class="mx-auto max-w-[1500px] space-y-7 text-[#08251f]">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-3xl font-black tracking-tight text-[#23374c] sm:text-4xl">Masukkan</h1>
            <p class="mt-1 text-xs font-medium text-slate-500">Kelola dan tindak lanjuti keluhan pengguna.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="flex min-h-24 items-center gap-4 rounded-lg border border-[#b9c9c5] bg-white px-5 py-4">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-200/80 p-2.5">
                <img src="{{ asset('foto/Total Aduan.png') }}" alt="Total Aduan" class="h-full w-full object-contain">
            </div>
            <div>
                <p class="text-sm font-extrabold text-slate-600">Total Aduan</p>
                <p class="mt-1 text-2xl font-black text-[#08251f]">{{ number_format($totalAduan) }}</p>
            </div>
        </div>

        <div class="flex min-h-24 items-center gap-4 rounded-lg border border-[#b9c9c5] bg-white px-5 py-4">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 p-2.5">
                <img src="{{ asset('foto/Menunggu.png') }}" alt="Menunggu" class="h-full w-full object-contain">
            </div>
            <div>
                <p class="text-sm font-extrabold text-slate-600">Menunggu</p>
                <p class="mt-1 text-2xl font-black text-red-600">{{ number_format($totalMenunggu) }}</p>
            </div>
        </div>

        <div class="flex min-h-24 items-center gap-4 rounded-lg border border-[#b9c9c5] bg-white px-5 py-4">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#e9f0ed] p-2.5">
                <img src="{{ asset('foto/process.png') }}" alt="Diproses" class="h-full w-full object-contain">
            </div>
            <div>
                <p class="text-sm font-extrabold text-slate-600">Diproses</p>
                <p class="mt-1 text-2xl font-black text-[#08251f]">{{ number_format($totalDiproses) }}</p>
            </div>
        </div>

        <div class="flex min-h-24 items-center gap-4 rounded-lg border border-[#b9c9c5] bg-white px-5 py-4">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#e9f0ed] p-2.5">
                <img src="{{ asset('foto/Selesai.png') }}" alt="Selesai" class="h-full w-full object-contain">
            </div>
            <div>
                <p class="text-sm font-extrabold text-slate-600">Selesai</p>
                <p class="mt-1 text-2xl font-black text-[#08251f]">{{ number_format($totalSelesai) }}</p>
            </div>
        </div>
    </div>

    <section class="overflow-hidden rounded-lg border border-emerald-200 bg-white shadow-[0_14px_30px_rgba(15,23,42,0.08)]">
        <div class="flex flex-col gap-4 px-6 py-6 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-extrabold text-[#0f513f]">Log Aduan</h2>
            <form method="GET" action="{{ route('admin.masukkan.lihat') }}" class="flex items-center gap-3">
                <label for="status-filter" class="text-sm font-medium text-slate-600">Filter by:</label>
                <select id="status-filter" name="status" onchange="this.form.submit()" class="h-10 rounded-md border border-slate-300 bg-white px-4 text-sm font-medium text-slate-700 outline-none focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
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
                    <tr class="bg-[#397d77] text-sm font-black uppercase tracking-wider text-white">
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
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($filteredMasukan as $item)
                        <tr class="align-middle transition hover:bg-slate-50/80">
                            <td class="px-14 py-8 font-black leading-snug text-[#08251f]">{{ $item->nama_pengadu }}</td>
                            <td class="px-6 py-8 font-medium text-[#08251f]">{{ $item->email }}</td>
                            <td class="max-w-md px-6 py-8 leading-relaxed text-[#08251f]">
                                {{ \Illuminate\Support\Str::limit($item->isi_aduan, 76) }}
                            </td>
                            <td class="max-w-sm px-6 py-8 leading-relaxed text-[#08251f]">
                                @if ($item->balasan_admin)
                                    {{ \Illuminate\Support\Str::limit($item->balasan_admin, 72) }}
                                @else
                                    <span class="text-slate-400">Belum ada balasan</span>
                                @endif
                            </td>
                            <td class="px-6 py-8 font-medium text-[#08251f]">
                                {{ optional($item->created_at)->format('H:i') ?? '-' }}
                            </td>
                            <td class="px-6 py-8 whitespace-nowrap font-medium text-[#08251f]">
                                {{ optional($item->created_at)->translatedFormat('d M Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-8">
                                <form method="POST" action="{{ route('admin.masukkan.update', $item->id_datamasukan) }}">
                                    @csrf
                                    @method('PUT')
                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="rounded-full border px-3 py-1.5 text-xs font-black outline-none {{ $statusBadgeClass($item->status) }}">
                                        <option value="Menunggu" @selected($statusCategory($item->status) === 'menunggu')>Menunggu</option>
                                        <option value="Diproses" @selected($statusCategory($item->status) === 'diproses')>Diproses</option>
                                        <option value="Selesai" @selected($statusCategory($item->status) === 'selesai')>Selesai</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-8">
                                <div class="flex items-center justify-center gap-4">
                                    <button
                                        type="button"
                                        onclick="openMasukkanDetail(this)"
                                        data-action="{{ route('admin.masukkan.update', $item->id_datamasukan) }}"
                                        data-name="{{ $item->nama_pengadu }}"
                                        data-email="{{ $item->email }}"
                                        data-phone="{{ $item->nomor_pengadu }}"
                                        data-status="{{ $statusLabel($item->status) }}"
                                        data-time="{{ optional($item->created_at)->format('H:i') ?? '-' }}"
                                        data-date="{{ optional($item->created_at)->translatedFormat('d M Y') ?? '-' }}"
                                        data-message="{{ $item->isi_aduan }}"
                                        data-reply="{{ $item->balasan_admin }}"
                                        class="text-[#0f6b52] transition hover:text-[#083c30]"
                                        title="Lihat Detail">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12s3.75-6 9.75-6 9.75 6 9.75 6-3.75 6-9.75 6-9.75-6-9.75-6z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        onclick="openMasukkanReply(this)"
                                        data-action="{{ route('admin.masukkan.reply', $item->id_datamasukan) }}"
                                        data-name="{{ $item->nama_pengadu }}"
                                        data-email="{{ $item->email }}"
                                        data-message="{{ $item->isi_aduan }}"
                                        data-reply="{{ $item->balasan_admin }}"
                                        class="text-[#0f6b52] transition hover:text-[#083c30]"
                                        title="Reply">
                                        <img src="{{ asset('foto/Reply.png') }}" alt="Reply" class="h-6 w-6 object-contain">
                                    </button>

                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.masukkan.destroy', $item->id_datamasukan) }}', 'Hapus Masukkan?', 'Apakah Anda yakin ingin menghapus masukkan ini?')"
                                        class="text-red-600 transition hover:text-red-700"
                                        title="Hapus">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h4a2 2 0 012 2v2" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500">Belum ada data masukkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-4 border-t border-slate-200 px-6 py-5 text-sm text-slate-600 sm:flex-row sm:items-center sm:justify-between">
            <p>Menampilkan {{ $filteredMasukan->count() ? '1-' . $filteredMasukan->count() : '0' }} dari {{ $totalAduan }} aduan</p>
            <div class="flex items-center gap-2">
                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-md border border-slate-300 text-[#0f513f]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <span class="flex h-10 w-10 items-center justify-center rounded-md bg-[#0f6b52] font-black text-white">1</span>
                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-md border border-slate-300 font-semibold text-[#08251f]">2</button>
                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-md border border-slate-300 font-semibold text-[#08251f]">3</button>
                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-md border border-slate-300 text-[#0f513f]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </div>
    </section>
</div>

<div id="modal-detail-masukkan" class="fixed inset-0 z-[70] hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-2xl rounded-xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b px-6 py-4">
            <h3 class="text-lg font-black text-[#0f513f]">Detail Aduan</h3>
            <button type="button" onclick="closeMasukkanDetail()" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100" title="Tutup">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div class="space-y-5 px-6 py-5">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">Nama Pengadu</p>
                    <p id="detail-name" class="mt-1 font-bold text-[#08251f]"></p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">Email</p>
                    <p id="detail-email" class="mt-1 font-bold text-[#08251f]"></p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">Kontak</p>
                    <p id="detail-phone" class="mt-1 font-bold text-[#08251f]"></p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">Waktu</p>
                    <p id="detail-time" class="mt-1 font-bold text-[#08251f]"></p>
                </div>
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-wider text-slate-400">Isi Aduan</p>
                <p id="detail-message" class="mt-2 rounded-lg bg-slate-50 p-4 leading-relaxed text-[#08251f]"></p>
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-wider text-slate-400">Balasan Admin</p>
                <p id="detail-reply" class="mt-2 rounded-lg bg-emerald-50 p-4 leading-relaxed text-[#08251f]"></p>
            </div>
        </div>
    </div>
</div>

<div id="modal-reply-masukkan" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-2xl rounded-xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b px-6 py-4">
            <h3 class="text-lg font-black text-[#0f513f]">Reply Masukkan</h3>
            <button type="button" onclick="closeMasukkanReply()" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100" title="Tutup">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form id="reply-form" method="POST" class="space-y-5 px-6 py-5">
            @csrf
            @method('PUT')
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">Nama Pengadu</p>
                    <p id="reply-name" class="mt-1 font-bold text-[#08251f]"></p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-wider text-slate-400">Email</p>
                    <p id="reply-email" class="mt-1 font-bold text-[#08251f]"></p>
                </div>
            </div>
            <div>
                <p class="text-xs font-black uppercase tracking-wider text-slate-400">Isi Aduan</p>
                <p id="reply-message" class="mt-2 rounded-lg bg-slate-50 p-4 leading-relaxed text-[#08251f]"></p>
            </div>
            <div>
                <label for="reply-text" class="block text-xs font-black uppercase tracking-wider text-slate-400">Balasan Admin</label>
                <textarea id="reply-text" name="balasan_admin" rows="5" required class="mt-2 w-full rounded-lg border border-slate-300 p-4 text-sm leading-relaxed text-[#08251f] outline-none focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20" placeholder="Tulis balasan untuk pengadu..."></textarea>
            </div>
            <div class="flex justify-end gap-3 border-t pt-5">
                <button type="button" onclick="closeMasukkanReply()" class="h-11 rounded-md px-5 text-sm font-bold text-slate-600 hover:bg-slate-100">Batal</button>
                <button type="submit" class="h-11 rounded-md bg-[#35635b] px-5 text-sm font-black text-white hover:bg-[#2b4f49]">Kirim Reply</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openMasukkanDetail(button) {
        const modal = document.getElementById('modal-detail-masukkan');
        document.getElementById('detail-name').textContent = button.dataset.name || '-';
        document.getElementById('detail-email').textContent = button.dataset.email || '-';
        document.getElementById('detail-phone').textContent = button.dataset.phone || '-';
        document.getElementById('detail-time').textContent = `${button.dataset.time || '-'} / ${button.dataset.date || '-'}`;
        document.getElementById('detail-message').textContent = button.dataset.message || '-';
        document.getElementById('detail-reply').textContent = button.dataset.reply || 'Belum ada balasan.';
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
</script>
@endpush
