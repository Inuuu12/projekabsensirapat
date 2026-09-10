@extends('admin.layout.app')

@section('title', 'Daftar Agenda')

@section('header_actions')
<button onclick="openModal('modal-tambah-agenda')" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2 px-4 rounded-xl flex items-center justify-center gap-1.5 transition shadow-xs text-xs border border-transparent dark:border-[#10b981]/30 cursor-pointer">
    <span class="text-base leading-none">+</span>
    <span>Tambah Agenda</span>
</button>
@endsection

@section('content')
@php
    $isRiwayatView = $isRiwayat ?? false;
    $kategoriOptions = array_merge(
        $isRiwayatView ? ['semua' => 'Semua Surat'] : [],
        [
            'internal' => 'Surat Internal',
            'masuk' => 'Surat Masuk',
            'keluar' => 'Surat Keluar',
        ]
    );
    $activeRouteName = $isRiwayatView ? 'admin.agenda.riwayat' : 'admin.agenda.lihat';
    $activeLabel = ($isRiwayatView ? 'Riwayat Agenda Rapat - ' : '') . ($kategoriOptions[$kategoriSurat] ?? 'Semua Surat');
@endphp

<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach (['internal' => 'Surat Internal', 'masuk' => 'Surat Masuk', 'keluar' => 'Surat Keluar'] as $key => $label)
            <a href="{{ route($activeRouteName, ['kategori_surat' => $key]) }}" class="bg-white dark:bg-[#152420] border {{ $kategoriSurat === $key ? 'border-[#35635b] dark:border-emerald-500 ring-2 ring-[#35635b]/10' : 'border-gray-100 dark:border-[#233a34]' }} rounded-xl p-5 shadow-xs transition hover:border-[#35635b] dark:hover:border-emerald-500 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 dark:text-gray-300 uppercase tracking-wider">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-black text-[#35635b] dark:text-emerald-400">{{ $agendaStats[$key] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-[#1a2d29] border border-transparent dark:border-[#233a34] flex items-center justify-center p-2">
                    <img src="{{ asset('assets/foto/Suratlogo.png') }}" alt="{{ $label }}" class="w-full h-full object-contain">
                </div>
            </a>
        @endforeach
    </div>

    <!-- Controls & Search -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex flex-wrap gap-2">
            @foreach ($kategoriOptions as $key => $label)
                <a href="{{ route($activeRouteName, ['kategori_surat' => $key, 'keyword' => request('keyword')]) }}" class="rounded-xl px-4 py-2 text-sm font-bold transition {{ $kategoriSurat === $key ? 'bg-[#35635b] text-white shadow-sm' : 'bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#233a34] text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route($activeRouteName) }}" class="relative w-full lg:w-80">
            <input type="hidden" name="kategori_surat" value="{{ $kategoriSurat }}">
            <input name="keyword" value="{{ request('keyword') }}" type="search" class="bg-white dark:bg-[#0f1c19] text-gray-700 dark:text-white text-sm rounded-xl block w-full px-4 py-3 outline-none border border-gray-200 dark:border-[#284c43] focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 transition shadow-xs placeholder-gray-400 dark:placeholder-gray-500" placeholder="Cari agenda, lokasi, asal surat...">
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white dark:bg-[#152420] rounded-xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
        <div class="border-b border-gray-100 dark:border-[#233a34] px-6 py-4 flex justify-between items-center">
            <div>
                <h2 class="text-base font-extrabold text-gray-800 dark:text-white">{{ $activeLabel }}</h2>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">Menampilkan {{ $agenda->count() }} {{ $isRiwayatView ? 'riwayat agenda selesai' : 'agenda' }} dari database.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[1080px]">
                <thead>
                    <tr class="bg-[#35635b] dark:bg-[#1b3832] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Agenda</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Waktu</th>
                        @if ($kategoriSurat === 'masuk')
                            <th class="px-6 py-4">Ditugaskan</th>
                        @else
                            <th class="px-6 py-4">Kuota</th>
                        @endif
                        <th class="px-6 py-4">Asal Surat</th>
                        <th class="px-6 py-4">Lampiran</th>
                        <th class="px-6 py-4">Tempat</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-[#233a34] text-sm">
                    @forelse ($agenda as $item)
                        @php
                            $itemRuang = $ruang->firstWhere('id_ruangrapat', $item->id_ruangrapat);
                        @endphp
                        <tr class="hover:bg-gray-50/80 dark:hover:bg-[#1b332d] transition">
                            <td class="px-6 py-4 font-bold text-[#35635b] dark:text-emerald-400">{{ $item->nama_agenda }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200 whitespace-nowrap">
                                {{ substr((string) $item->waktu, 0, 5) }}{{ $item->waktu_selesai ? ' - ' . substr((string) $item->waktu_selesai, 0, 5) : '' }}
                            </td>
                            
                            @if ($kategoriSurat === 'masuk')
                                <td class="px-6 py-4 text-gray-700 dark:text-slate-200 font-medium">{{ $item->ditugaskan ?: '-' }}</td>
                            @else
                                <td class="px-6 py-4 text-gray-700 dark:text-slate-200 font-semibold">{{ $item->kuota ?? '-' }}</td>
                            @endif

                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200">{{ $item->asal_surat ?: '-' }}</td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->lampiran)
                                    <button type="button" 
                                            onclick="openDocumentPreview('{{ asset('storage/' . $item->lampiran) }}', 'Lampiran Surat - {{ addslashes($item->nama_agenda) }}', '{{ addslashes(basename($item->lampiran)) }}')" 
                                            class="inline-flex items-center gap-1.5 font-bold text-[#35635b] dark:text-emerald-400 hover:underline cursor-pointer">
                                        <img src="{{ asset('assets/foto/Lampiranlogo.png') }}" alt="Lampiran" class="w-4 h-4 object-contain">
                                        <span>Lihat</span>
                                    </button>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-gray-700 dark:text-slate-200 whitespace-nowrap">{{ $item->lokasi ?: ($itemRuang->nama_ruang ?? '-') }}</td>
                            
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-lg border px-2.5 py-1 text-xs font-bold whitespace-nowrap {{ $item->status_badge_class }}">
                                    {{ $item->status_label }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-1.5 whitespace-nowrap">
                                    <button
                                        type="button"
                                        onclick="openEditAgenda(this)"
                                        data-action="{{ route('admin.agenda.update', $item->id_agenda) }}"
                                        data-nama="{{ $item->nama_agenda }}"
                                        data-kategori="{{ $item->kategori_surat }}"
                                        data-asal="{{ $item->asal_surat }}"
                                        data-ditugaskan="{{ $item->ditugaskan }}"
                                        data-tanggal="{{ $item->tanggal }}"
                                        data-waktu="{{ $item->waktu }}"
                                        data-waktuselesai="{{ $item->waktu_selesai }}"
                                        data-kuota="{{ $item->kuota }}"
                                        data-lokasi="{{ $item->lokasi }}"
                                        data-ruang="{{ $item->id_ruangrapat }}"
                                        data-statusqr="{{ $item->status_qr }}"
                                        data-statusfr="{{ (int) $item->status_fr }}"
                                        data-lampiran="{{ $item->lampiran ? asset('storage/' . $item->lampiran) : '' }}"
                                        data-lampiran-name="{{ basename($item->lampiran ?? '') }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-[#0f513f] dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60 px-2.5 py-1.5 text-xs font-bold transition hover:bg-emerald-100 dark:hover:bg-emerald-900/60 cursor-pointer shadow-2xs"
                                        title="Edit Agenda">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Edit</span>
                                    </button>

                                    <button type="button" 
                                            onclick="openDeleteModal('{{ route('admin.agenda.destroy', $item->id_agenda) }}', 'Hapus Agenda?', 'Apakah Anda yakin ingin menghapus agenda ini?')"
                                            class="inline-flex items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/50 text-red-700 dark:text-red-300 border border-red-200/80 dark:border-red-800/60 px-2.5 py-1.5 text-xs font-bold transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer shadow-2xs" 
                                            title="Hapus Agenda">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </button>

                                    <a href="{{ route('admin.agenda.detail', ['id' => $item->id_agenda]) }}" 
                                       class="inline-flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800/60 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 px-2.5 py-1.5 text-xs font-bold transition hover:bg-slate-200 dark:hover:bg-slate-700/60 cursor-pointer shadow-2xs" 
                                       title="Lihat Detail Agenda">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>Detail</span>
                                    </a>

                                    <a href="{{ url('/admin/agenda/' . $item->id_agenda . '/generate-qr') }}"
                                       class="inline-flex items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-950/50 text-amber-800 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800/60 px-2.5 py-1.5 text-xs font-bold transition hover:bg-amber-100 dark:hover:bg-amber-900/60 cursor-pointer shadow-2xs"
                                       title="Generate QR Presensi">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-6v-4m6 6v10m6-2v-4m-6 0h2m-6-4h2m0 0h2m-6 0h-2m-4 0H4m0 4h2m0 0h2m-6 0v4m0 0h2m-6-4v-4m0 0H4"/></svg>
                                        <span>QR Presensi</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 font-medium">Belum ada agenda untuk {{ strtolower($activeLabel) }}.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex flex-col gap-4 border-t border-gray-100 dark:border-[#233a34] px-6 py-5 text-sm text-slate-600 dark:text-gray-300 sm:flex-row sm:items-center sm:justify-between">
            <p>Menampilkan {{ $agenda->count() }} agenda</p>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH AGENDA -->
<div id="modal-tambah-agenda" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-start justify-between border-b border-gray-100 dark:border-[#233a34] px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-[#152420] shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-[#0f513f] dark:text-emerald-400 shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Tambah Agenda Rapat</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Lengkapi data agenda rapat dan pilih ruang pertemuan</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modal-tambah-agenda')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer" aria-label="Tutup modal">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="form-tambah-agenda" method="POST" action="{{ route('admin.agenda.store') }}" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
                @include('admin.agenda.form-fields')
            </div>
            <div class="flex justify-end items-center gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#0f1c19] px-5 py-4 sm:px-6 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-tambah-agenda')" class="h-10 rounded-xl px-5 text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#0f513f] hover:bg-[#0b3f31] dark:bg-[#107050] dark:hover:bg-[#0c5940] px-6 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    <span>Simpan Agenda</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT AGENDA -->
<div id="modal-edit-agenda" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-start justify-between border-b border-gray-100 dark:border-[#233a34] px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-[#152420] shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-[#0f513f] dark:text-emerald-400 shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Edit Agenda Rapat</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Perbarui rincian informasi agenda rapat terpilih</p>
                </div>
            </div>
            <button type="button" onclick="closeModal('modal-edit-agenda')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer" aria-label="Tutup modal">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="form-edit-agenda" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
                @include('admin.agenda.form-fields', ['prefix' => 'edit-'])
            </div>
            <div class="flex justify-end items-center gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#0f1c19] px-5 py-4 sm:px-6 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-edit-agenda')" class="h-10 rounded-xl px-5 text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#0f513f] hover:bg-[#0b3f31] dark:bg-[#107050] dark:hover:bg-[#0c5940] px-6 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>



@push('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (id === 'modal-tambah-agenda') {
            const form = document.getElementById('form-tambah-agenda');
            if (form) form.reset();
            resetAgendaLampiranPreview('');
            syncAgendaRoomLocation('');
            setDitugaskanFromValue('', '');
            validateRoomCapacity('');
        }
        if (modal) {
            if (modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }

    function openEditAgenda(button) {
        document.getElementById('form-edit-agenda').action = button.dataset.action;
        if(document.getElementById('edit-nama_agenda')) document.getElementById('edit-nama_agenda').value = button.dataset.nama || '';
        if(document.getElementById('edit-kategori_surat')) document.getElementById('edit-kategori_surat').value = button.dataset.kategori || 'internal';
        if(document.getElementById('edit-asal_surat')) document.getElementById('edit-asal_surat').value = button.dataset.asal || '';
        if(document.getElementById('edit-ditugaskan')) {
            document.getElementById('edit-ditugaskan').value = button.dataset.ditugaskan || '';
            setDitugaskanFromValue('edit-', button.dataset.ditugaskan || '');
        }
        if(document.getElementById('edit-tanggal')) document.getElementById('edit-tanggal').value = button.dataset.tanggal || '';
        if(document.getElementById('edit-waktu')) document.getElementById('edit-waktu').value = button.dataset.waktu || '';
        if(document.getElementById('edit-waktu_selesai')) document.getElementById('edit-waktu_selesai').value = button.dataset.waktuselesai || '';
        if(document.getElementById('edit-kuota')) document.getElementById('edit-kuota').value = button.dataset.kuota || '';
        if(document.getElementById('edit-lokasi')) document.getElementById('edit-lokasi').value = button.dataset.lokasi || '';
        if(document.getElementById('edit-id_ruangrapat')) document.getElementById('edit-id_ruangrapat').value = button.dataset.ruang || '';
        if(document.getElementById('edit-status_qr')) document.getElementById('edit-status_qr').value = button.dataset.statusqr || 'nonaktif';
        if(document.getElementById('edit-status_fr')) document.getElementById('edit-status_fr').value = button.dataset.statusfr === '1' ? '1' : '0';
        
        const lampiranUrl = button.dataset.lampiran || '';
        const lampiranName = button.dataset.lampiranName || '';
        if (lampiranUrl && lampiranName) {
            setExistingAgendaLampiran('edit-', lampiranUrl, lampiranName);
        } else {
            resetAgendaLampiranPreview('edit-');
        }

        if (!button.dataset.lokasi) syncAgendaRoomLocation('edit-');
        validateRoomCapacity('edit-');
        
        openModal('modal-edit-agenda');
    }

    function syncAgendaRoomLocation(prefix) {
        const select = document.getElementById(prefix + 'id_ruangrapat');
        const location = document.getElementById(prefix + 'lokasi');
        if (!select || select.tagName !== 'SELECT' || !location || location.type === 'text') return;

        const selected = select.options[select.selectedIndex];
        if (selected && selected.value) {
            location.value = selected.dataset.namaRuang || selected.text.split('(')[0].trim();
        }
        validateRoomCapacity(prefix);
    }

    function validateRoomCapacity(prefix) {
        const roomSelect = document.getElementById(prefix + 'id_ruangrapat');
        const kuotaInput = document.getElementById(prefix + 'kuota');
        const warningEl = document.getElementById(prefix + 'kuota-warning');
        const warningText = document.getElementById(prefix + 'kuota-warning-text');
        
        if (!roomSelect || !kuotaInput || !warningEl || !warningText) return true;
        
        const selectedOption = roomSelect.options[roomSelect.selectedIndex];
        const kapasitas = selectedOption ? parseInt(selectedOption.dataset.kapasitas || '0', 10) : 0;
        const kuota = parseInt(kuotaInput.value || '0', 10);
        const namaRuang = selectedOption ? (selectedOption.dataset.namaRuang || selectedOption.text.split('(')[0].trim()) : 'Ruangan';
        
        if (kapasitas > 0 && kuota > kapasitas) {
            warningText.textContent = `Jumlah kuota (${kuota} orang) melebihi kapasitas ${namaRuang} (maksimal ${kapasitas} orang).`;
            warningEl.classList.remove('hidden');
            warningEl.classList.add('flex');
            kuotaInput.classList.add('border-red-500', 'dark:border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
            return false;
        } else {
            warningEl.classList.add('hidden');
            warningEl.classList.remove('flex');
            kuotaInput.classList.remove('border-red-500', 'dark:border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
            return true;
        }
    }

    function isImageFile(fileName) {
        if (!fileName) return false;
        const ext = fileName.split('.').pop().toLowerCase();
        return ['jpg', 'jpeg', 'png', 'webp', 'gif'].includes(ext);
    }

    function getFileExt(fileName) {
        if (!fileName) return 'FILE';
        return fileName.split('.').pop().toUpperCase();
    }

    function setAgendaFilePreview(prefix, file) {
        const placeholder = document.getElementById(prefix + 'lampiran-placeholder');
        const imgContainer = document.getElementById(prefix + 'lampiran-img-container');
        const imgPreview = document.getElementById(prefix + 'lampiran-img-preview');
        const imgName = document.getElementById(prefix + 'lampiran-img-name');
        const docContainer = document.getElementById(prefix + 'lampiran-doc-container');
        const docName = document.getElementById(prefix + 'lampiran-doc-name');
        const docExt = document.getElementById(prefix + 'lampiran-doc-ext');
        const btnHapus = document.getElementById(prefix + 'btn-hapus-lampiran');
        const hapusInput = document.getElementById(prefix + 'hapus_lampiran');

        if (hapusInput) hapusInput.value = '0';

        if (!file) {
            resetAgendaLampiranPreview(prefix);
            return;
        }

        const isImg = file.type ? file.type.startsWith('image/') : isImageFile(file.name);

        if (isImg) {
            const reader = new FileReader();
            reader.onload = function (e) {
                if (imgPreview) imgPreview.src = e.target.result;
                if (imgName) imgName.textContent = file.name;
                if (imgContainer) imgContainer.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
                if (docContainer) docContainer.classList.add('hidden');
                if (btnHapus) btnHapus.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            if (docName) docName.textContent = file.name;
            if (docExt) docExt.textContent = getFileExt(file.name);
            if (docContainer) docContainer.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
            if (imgContainer) imgContainer.classList.add('hidden');
            if (btnHapus) btnHapus.classList.remove('hidden');
        }
    }

    function setExistingAgendaLampiran(prefix, fileUrl, fileName) {
        const placeholder = document.getElementById(prefix + 'lampiran-placeholder');
        const imgContainer = document.getElementById(prefix + 'lampiran-img-container');
        const imgPreview = document.getElementById(prefix + 'lampiran-img-preview');
        const imgName = document.getElementById(prefix + 'lampiran-img-name');
        const docContainer = document.getElementById(prefix + 'lampiran-doc-container');
        const docName = document.getElementById(prefix + 'lampiran-doc-name');
        const docExt = document.getElementById(prefix + 'lampiran-doc-ext');
        const btnHapus = document.getElementById(prefix + 'btn-hapus-lampiran');
        const hapusInput = document.getElementById(prefix + 'hapus_lampiran');

        if (hapusInput) hapusInput.value = '0';

        if (!fileUrl || !fileName) {
            resetAgendaLampiranPreview(prefix);
            return;
        }

        const isImg = isImageFile(fileName);

        if (isImg) {
            if (imgPreview) imgPreview.src = fileUrl;
            if (imgName) imgName.textContent = fileName;
            if (imgContainer) imgContainer.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
            if (docContainer) docContainer.classList.add('hidden');
            if (btnHapus) btnHapus.classList.remove('hidden');
        } else {
            if (docName) docName.textContent = fileName;
            if (docExt) docExt.textContent = getFileExt(fileName);
            if (docContainer) docContainer.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
            if (imgContainer) imgContainer.classList.add('hidden');
            if (btnHapus) btnHapus.classList.remove('hidden');
        }
    }

    function resetAgendaLampiranPreview(prefix) {
        const placeholder = document.getElementById(prefix + 'lampiran-placeholder');
        const imgContainer = document.getElementById(prefix + 'lampiran-img-container');
        const imgPreview = document.getElementById(prefix + 'lampiran-img-preview');
        const imgName = document.getElementById(prefix + 'lampiran-img-name');
        const docContainer = document.getElementById(prefix + 'lampiran-doc-container');
        const docName = document.getElementById(prefix + 'lampiran-doc-name');
        const btnHapus = document.getElementById(prefix + 'btn-hapus-lampiran');
        const fileInput = document.getElementById(prefix + 'lampiran');

        if (fileInput) fileInput.value = '';
        if (imgPreview) imgPreview.src = '';
        if (imgName) imgName.textContent = '';
        if (docName) docName.textContent = '';
        if (imgContainer) imgContainer.classList.add('hidden');
        if (docContainer) docContainer.classList.add('hidden');
        if (placeholder) placeholder.classList.remove('hidden');
        if (btnHapus) btnHapus.classList.add('hidden');
    }

    function clearAgendaLampiran(prefix) {
        resetAgendaLampiranPreview(prefix);
        const hapusInput = document.getElementById(prefix + 'hapus_lampiran');
        if (hapusInput) hapusInput.value = '1';
    }

    function togglePegawaiDropdown(prefix) {
        const dropdown = document.getElementById(prefix + 'ditugaskan-dropdown');
        if (!dropdown) return;
        dropdown.classList.toggle('hidden');
    }

    function filterPegawaiList(prefix) {
        const searchInput = document.getElementById(prefix + 'ditugaskan-search');
        const filter = searchInput ? searchInput.value.toLowerCase() : '';
        const list = document.getElementById(prefix + 'ditugaskan-list');
        if (!list) return;

        const groups = list.querySelectorAll('.bidang-group');
        if (groups.length > 0) {
            groups.forEach(group => {
                let groupHasVisible = false;
                const labels = group.querySelectorAll('label');
                labels.forEach(label => {
                    const text = label.textContent.toLowerCase();
                    const matches = text.includes(filter);
                    label.style.display = matches ? 'flex' : 'none';
                    if (matches) groupHasVisible = true;
                });
                group.style.display = groupHasVisible ? 'block' : 'none';
            });
        } else {
            const labels = list.querySelectorAll('label');
            labels.forEach(label => {
                const text = label.textContent.toLowerCase();
                label.style.display = text.includes(filter) ? 'flex' : 'none';
            });
        }
    }

    function updateDitugaskanSelected(prefix) {
        const list = document.getElementById(prefix + 'ditugaskan-list');
        const hiddenInput = document.getElementById(prefix + 'ditugaskan');
        const badgesContainer = document.getElementById(prefix + 'ditugaskan-selected-badges');
        if (!list || !hiddenInput || !badgesContainer) return;

        const checkedBoxes = list.querySelectorAll('input[type="checkbox"]:checked');
        const selectedValues = [];

        badgesContainer.innerHTML = '';

        if (checkedBoxes.length === 0) {
            badgesContainer.innerHTML = '<span class="text-gray-400 dark:text-gray-500 text-xs italic">Klik untuk memilih pegawai...</span>';
            hiddenInput.value = '';
            return;
        }

        checkedBoxes.forEach(box => {
            const val = box.value;
            selectedValues.push(val);

            const badge = document.createElement('span');
            badge.className = 'inline-flex items-center gap-1 bg-[#35635b] dark:bg-[#1b4d3e] text-white text-[11px] font-semibold px-2 py-0.5 rounded-md shadow-xs dark:border dark:border-emerald-700/40';
            badge.innerHTML = `<span>${val}</span> <button type="button" class="ml-0.5 text-white/80 hover:text-white font-bold" onclick="uncheckPegawai('${prefix}', '${val.replace(/'/g, "\\'")}')">&times;</button>`;
            badgesContainer.appendChild(badge);
        });

        hiddenInput.value = selectedValues.join(', ');
    }

    function uncheckPegawai(prefix, name) {
        const list = document.getElementById(prefix + 'ditugaskan-list');
        if (!list) return;

        const checkbox = Array.from(list.querySelectorAll('input[type="checkbox"]')).find(cb => cb.value === name);
        if (checkbox) {
            checkbox.checked = false;
            updateDitugaskanSelected(prefix);
        }
    }

    function setDitugaskanFromValue(prefix, valueString) {
        const list = document.getElementById(prefix + 'ditugaskan-list');
        if (!list) return;

        const names = (valueString || '').split(',').map(s => s.trim()).filter(Boolean);
        const checkboxes = list.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach(cb => {
            cb.checked = names.includes(cb.value);
        });

        updateDitugaskanSelected(prefix);
    }

    document.addEventListener('click', function(e) {
        ['', 'edit-'].forEach(prefix => {
            const container = document.querySelector(`[data-multi-select-container="${prefix}"]`);
            const dropdown = document.getElementById(prefix + 'ditugaskan-dropdown');
            if (container && dropdown && !container.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });

    document.querySelectorAll('[data-agenda-room-select]').forEach((select) => {
        select.addEventListener('change', function () {
            syncAgendaRoomLocation(this.dataset.agendaRoomSelect || '');
        });
    });

    document.querySelectorAll('[data-agenda-file-input]').forEach((input) => {
        input.addEventListener('change', function () {
            const prefix = this.dataset.agendaFileInput || '';
            const file = this.files && this.files[0];
            setAgendaFilePreview(prefix, file);
        });
    });

    ['', 'edit-'].forEach(prefix => {
        const kuotaInput = document.getElementById(prefix + 'kuota');
        const roomSelect = document.getElementById(prefix + 'id_ruangrapat');
        if (kuotaInput) {
            kuotaInput.addEventListener('input', () => validateRoomCapacity(prefix));
        }
        if (roomSelect) {
            roomSelect.addEventListener('change', () => validateRoomCapacity(prefix));
        }
    });

    const formTambah = document.getElementById('form-tambah-agenda');
    if (formTambah) {
        formTambah.addEventListener('submit', function (e) {
            if (!validateRoomCapacity('')) {
                e.preventDefault();
                const kuotaInput = document.getElementById('kuota');
                if (kuotaInput) kuotaInput.focus();
            }
        });
    }

    const formEdit = document.getElementById('form-edit-agenda');
    if (formEdit) {
        formEdit.addEventListener('submit', function (e) {
            if (!validateRoomCapacity('edit-')) {
                e.preventDefault();
                const kuotaInput = document.getElementById('edit-kuota');
                if (kuotaInput) kuotaInput.focus();
            }
        });
    }
</script>
@endpush
@endsection
