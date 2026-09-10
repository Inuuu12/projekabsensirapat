@extends('admin.layout.app')

@section('title', 'Pengaduan Masyarakat')

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

    $filteredMasukan = $statusFilter === 'semua'
        ? $masukan
        : $masukan->filter(fn ($item) => $statusCategory($item->status) === $statusFilter);

    $totalAduan = $masukan->count();
    $totalMenunggu = $masukan->filter(fn ($item) => $statusCategory($item->status) === 'menunggu')->count();
    $totalDiproses = $masukan->filter(fn ($item) => $statusCategory($item->status) === 'diproses')->count();
    $totalSelesai = $masukan->filter(fn ($item) => $statusCategory($item->status) === 'selesai')->count();
@endphp

<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Stat Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs transition-colors flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Total Pengaduan</p>
                <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ number_format($totalAduan) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200/60 dark:border-emerald-800/40 flex items-center justify-center text-[#35635b] dark:text-emerald-400 font-bold text-lg">
                📋
            </div>
        </div>

        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs transition-colors flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Menunggu</p>
                <p class="mt-2 text-3xl font-black text-rose-600 dark:text-rose-400">{{ number_format($totalMenunggu) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200/60 dark:border-rose-800/40 flex items-center justify-center text-rose-600 dark:text-rose-400 font-bold text-lg">
                ⏳
            </div>
        </div>

        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs transition-colors flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Diproses</p>
                <p class="mt-2 text-3xl font-black text-amber-600 dark:text-amber-400">{{ number_format($totalDiproses) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200/60 dark:border-amber-800/40 flex items-center justify-center text-amber-600 dark:text-amber-400 font-bold text-lg">
                🔄
            </div>
        </div>

        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-5 shadow-xs transition-colors flex items-center justify-between">
            <div>
                <p class="text-[11px] font-extrabold text-gray-400 dark:text-gray-300 uppercase tracking-wider">Selesai</p>
                <p class="mt-2 text-3xl font-black text-emerald-600 dark:text-emerald-400">{{ number_format($totalSelesai) }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200/60 dark:border-emerald-800/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold text-lg">
                ✅
            </div>
        </div>
    </div>

    <!-- Filter Pills (Kunker Style) & Search Card -->
    <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] p-5 sm:p-6 space-y-4 transition-colors">
        <!-- Status Filter Pills -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
            <a href="{{ route('admin.masukkan.lihat', ['status' => 'semua']) }}"
               class="px-5 py-2 rounded-full text-xs font-extrabold transition-all whitespace-nowrap {{ $statusFilter === 'semua' ? 'bg-[#35635b] text-white shadow-sm' : 'bg-gray-100 dark:bg-[#0f1c19] text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
                Semua Aduan ({{ $totalAduan }})
            </a>
            <a href="{{ route('admin.masukkan.lihat', ['status' => 'menunggu']) }}"
               class="px-5 py-2 rounded-full text-xs font-extrabold transition-all whitespace-nowrap {{ $statusFilter === 'menunggu' ? 'bg-rose-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-[#0f1c19] text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
                ⏳ Menunggu ({{ $totalMenunggu }})
            </a>
            <a href="{{ route('admin.masukkan.lihat', ['status' => 'diproses']) }}"
               class="px-5 py-2 rounded-full text-xs font-extrabold transition-all whitespace-nowrap {{ $statusFilter === 'diproses' ? 'bg-amber-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-[#0f1c19] text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
                🔄 Diproses ({{ $totalDiproses }})
            </a>
            <a href="{{ route('admin.masukkan.lihat', ['status' => 'selesai']) }}"
               class="px-5 py-2 rounded-full text-xs font-extrabold transition-all whitespace-nowrap {{ $statusFilter === 'selesai' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-[#0f1c19] text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
                ✅ Selesai ({{ $totalSelesai }})
            </a>
        </div>
    </div>

    <!-- Table Container Section -->
    <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
        <div class="border-b border-gray-100 dark:border-[#233a34] px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Daftar Pengaduan Masyarakat</h2>
                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-300">Menampilkan {{ $filteredMasukan->count() }} dari {{ $totalAduan }} pengaduan.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[1100px]">
                <thead>
                    <tr class="bg-[#35635b] dark:bg-[#1b3832] text-white text-xs font-extrabold uppercase tracking-wider">
                        <th class="px-6 py-4">Pengadu</th>
                        <th class="px-6 py-4">Email & Kontak</th>
                        <th class="px-6 py-4">Isi Aduan</th>
                        <th class="px-6 py-4">Balasan Admin</th>
                        <th class="px-6 py-4">Waktu & Tanggal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#233a34] text-sm">
                    @forelse ($filteredMasukan as $item)
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-[#1b332d] transition">
                            <td class="px-6 py-4 font-extrabold text-gray-900 dark:text-white">
                                {{ $item->nama_pengadu }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200 text-xs">
                                <p class="font-medium">✉️ {{ $item->email }}</p>
                                @if ($item->nomor_hp)
                                    <p class="text-gray-500 dark:text-gray-400">📞 {{ $item->nomor_hp }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200 max-w-xs leading-relaxed text-xs">
                                {{ \Illuminate\Support\Str::limit($item->isi_aduan, 90) }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200 max-w-xs leading-relaxed text-xs">
                                @if ($item->balasan_admin)
                                    <span class="text-emerald-700 dark:text-emerald-300 font-medium">💬 {{ \Illuminate\Support\Str::limit($item->balasan_admin, 80) }}</span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 italic">Belum dibalas</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200 text-xs whitespace-nowrap">
                                <p class="font-bold">{{ optional($item->created_at)->format('H:i') ?? '-' }} WIB</p>
                                <p class="text-gray-500 dark:text-gray-400">{{ optional($item->created_at)->translatedFormat('d M Y') ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.masukkan.update', $item->id_dataaduan) }}">
                                    @csrf
                                    @method('PUT')
                                    @php $cat = $statusCategory($item->status); @endphp
                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="rounded-full px-3 py-1 text-xs font-bold outline-none cursor-pointer border transition {{ $cat === 'selesai' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300 border-emerald-200' : ($cat === 'diproses' ? 'bg-amber-100 text-amber-800 dark:bg-amber-950/80 dark:text-amber-300 border-amber-200' : 'bg-rose-100 text-rose-800 dark:bg-rose-950/80 dark:text-rose-300 border-rose-200') }}">
                                        <option value="Menunggu" @selected($cat === 'menunggu')>⏳ Menunggu</option>
                                        <option value="Diproses" @selected($cat === 'diproses')>🔄 Diproses</option>
                                        <option value="Selesai" @selected($cat === 'selesai')>✅ Selesai</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2 whitespace-nowrap">
                                    <button
                                        type="button"
                                        onclick="openReplyModal(this)"
                                        data-id="{{ $item->id_dataaduan }}"
                                        data-action="{{ route('admin.masukkan.reply', $item->id_dataaduan) }}"
                                        data-pengadu="{{ $item->nama_pengadu }}"
                                        data-aduan="{{ $item->isi_aduan }}"
                                        data-balasan="{{ $item->balasan_admin }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-[#0f513f] dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-emerald-100 dark:hover:bg-emerald-900/60 cursor-pointer shadow-2xs">
                                        💬 Balas
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.masukkan.destroy', $item->id_dataaduan) }}', 'Hapus Pengaduan?', 'Apakah Anda yakin ingin menghapus pengaduan ini?')"
                                        class="inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/50 text-red-700 dark:text-red-300 border border-red-200/80 dark:border-red-800/60 px-3 py-1.5 text-xs font-bold transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer shadow-2xs">
                                        🗑️ Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada pengaduan masyarakat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Balas Aduan -->
<div id="modal-reply-aduan" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-2xl max-w-lg w-full p-6 text-left relative">
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-100 dark:border-[#233a34]">
            <h3 class="text-base font-extrabold text-gray-900 dark:text-white">Balas Pengaduan Masyarakat</h3>
            <button onclick="closeModal('modal-reply-aduan')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">✕</button>
        </div>
        <form id="form-reply-aduan" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="bg-gray-50 dark:bg-[#0f1c19] p-3.5 rounded-xl border border-gray-200 dark:border-[#284c43]">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Pengadu: <span id="reply-pengadu-nama" class="text-gray-900 dark:text-white"></span></p>
                <p id="reply-aduan-teks" class="mt-1 text-xs text-gray-700 dark:text-gray-300 italic"></p>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase mb-1">Respon / Balasan Admin *</label>
                <textarea id="reply-balasan-text" name="balasan_admin" rows="4" required placeholder="Tuliskan respon resmi tindak lanjut pengaduan ini..." class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]"></textarea>
            </div>
            <div class="pt-4 flex justify-end gap-2 border-t border-gray-100 dark:border-[#233a34]">
                <button type="button" onclick="closeModal('modal-reply-aduan')" class="px-4 py-2 text-xs font-bold rounded-xl border border-gray-300 dark:border-[#284c43] text-gray-700 dark:text-gray-300">Batal</button>
                <button type="submit" class="px-5 py-2 text-xs font-bold rounded-xl bg-[#35635b] dark:bg-[#107050] text-white hover:bg-[#2b4f49]">Kirim Balasan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openReplyModal(btn) {
        const form = document.getElementById('form-reply-aduan');
        form.action = btn.dataset.action;
        document.getElementById('reply-pengadu-nama').textContent = btn.dataset.pengadu || '';
        document.getElementById('reply-aduan-teks').textContent = '"' + (btn.dataset.aduan || '') + '"';
        document.getElementById('reply-balasan-text').value = btn.dataset.balasan || '';
        openModal('modal-reply-aduan');
    }
</script>
@endsection
