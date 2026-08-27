@extends('admin.layout.app')

@section('title', 'Daftar Agenda')

@section('content')
@php
    $kategoriOptions = [
        'internal' => 'Surat Internal',
        'masuk' => 'Surat Masuk',
        'keluar' => 'Surat Keluar',
    ];
    $activeLabel = $kategoriOptions[$kategoriSurat] ?? 'Surat Internal';
@endphp

<div class="max-w-[1400px] mx-auto space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] dark:text-white tracking-tight">Daftar Agenda</h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-300 mt-1">Kelola agenda berdasarkan Surat Internal, Surat Masuk, dan Surat Keluar.</p>
        </div>
        <button onclick="openModal('modal-tambah-agenda')" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2.5 px-5 rounded-xl flex items-center justify-center gap-2 transition shadow-xs cursor-pointer self-start sm:self-auto border border-transparent dark:border-[#10b981]/30">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Agenda</span>
        </button>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach ($kategoriOptions as $key => $label)
            <a href="{{ route('admin.agenda.lihat', ['kategori_surat' => $key]) }}" class="bg-white dark:bg-[#152420] border {{ $kategoriSurat === $key ? 'border-[#35635b] dark:border-emerald-500 ring-2 ring-[#35635b]/10' : 'border-gray-100 dark:border-[#233a34]' }} rounded-2xl p-5 shadow-xs transition hover:border-[#35635b] dark:hover:border-emerald-500 flex items-center justify-between">
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
                <a href="{{ route('admin.agenda.lihat', ['kategori_surat' => $key, 'keyword' => request('keyword')]) }}" class="rounded-xl px-4 py-2 text-sm font-bold transition {{ $kategoriSurat === $key ? 'bg-[#35635b] text-white shadow-sm' : 'bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#233a34] text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('admin.agenda.lihat') }}" class="relative w-full lg:w-80">
            <input type="hidden" name="kategori_surat" value="{{ $kategoriSurat }}">
            <input name="keyword" value="{{ request('keyword') }}" type="search" class="bg-white dark:bg-[#0f1c19] text-gray-700 dark:text-white text-sm rounded-xl block w-full px-4 py-3 outline-none border border-gray-200 dark:border-[#284c43] focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 transition shadow-xs placeholder-gray-400 dark:placeholder-gray-500" placeholder="Cari agenda, lokasi, asal surat...">
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] overflow-hidden transition-colors">
        <div class="border-b border-gray-100 dark:border-[#233a34] px-6 py-4 flex justify-between items-center">
            <div>
                <h2 class="text-base font-extrabold text-gray-800 dark:text-white">{{ $activeLabel }}</h2>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">Menampilkan {{ $agenda->count() }} agenda dari database.</p>
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
                                <div class="flex justify-center items-center gap-2">
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
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-green-100 dark:hover:bg-[#23423b] cursor-pointer"
                                        title="Edit Agenda">
                                        <img src="{{ asset('assets/foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                        <span class="sr-only">Edit</span>
                                    </button>

                                    <button type="button" 
                                            onclick="openDeleteModal('{{ route('admin.agenda.destroy', $item->id_agenda) }}', 'Hapus Agenda?', 'Apakah Anda yakin ingin menghapus agenda ini?')"
                                            class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer" 
                                            title="Hapus Agenda">
                                        <img src="{{ asset('assets/foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                        <span class="sr-only">Hapus</span>
                                    </button>

                                    <a href="{{ route('admin.agenda.detail', ['id' => $item->id_agenda]) }}" 
                                       class="flex h-7 w-7 items-center justify-center rounded-lg bg-gray-50 dark:bg-[#1e2f2b] border border-transparent dark:border-[#38564f] p-1.5 transition hover:bg-gray-100 dark:hover:bg-[#2e4c45] cursor-pointer" 
                                       title="Lihat Detail Agenda">
                                        <img src="{{ asset('assets/foto/Detaillogo.png') }}" alt="Detail Agenda" class="h-full w-full object-contain">
                                        <span class="sr-only">Detail</span>
                                    </a>

                                    <a href="{{ url('/admin/agenda/' . $item->id_agenda . '/generate-qr') }}"
                                       class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 border border-transparent dark:border-emerald-900/40 text-[#35635b] dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 transition flex items-center justify-center cursor-pointer text-[10px] font-black"
                                       title="Generate QR Presensi">
                                        QR
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
<div id="modal-tambah-agenda" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Tambah Agenda</h3>
            <button type="button" onclick="closeModal('modal-tambah-agenda')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal tambah agenda">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-tambah-agenda" method="POST" action="{{ route('admin.agenda.store') }}" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
                @include('admin.agenda.form-fields')
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50 dark:bg-[#0f1c19] p-3 sm:px-6 sm:py-4 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-tambah-agenda')" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="w-full sm:w-auto inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#04733f] dark:bg-[#107050] hover:bg-[#035f35] dark:hover:bg-[#0c5940] px-5 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT AGENDA -->
<div id="modal-edit-agenda" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Edit Agenda</h3>
            <button type="button" onclick="closeModal('modal-edit-agenda')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal edit agenda">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-edit-agenda" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
                @include('admin.agenda.form-fields', ['prefix' => 'edit-'])
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50 dark:bg-[#0f1c19] p-3 sm:px-6 sm:py-4 rounded-b-2xl shrink-0">
                <button type="button" onclick="closeModal('modal-edit-agenda')" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="w-full sm:w-auto inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#04733f] dark:bg-[#107050] hover:bg-[#035f35] dark:hover:bg-[#0c5940] px-5 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    <span>Simpan</span>
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
            setAgendaFileLabel('', '');
            syncAgendaRoomLocation('');
            setDitugaskanFromValue('', '');
        }
        if (modal) modal.classList.replace('hidden', 'flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.replace('flex', 'hidden');
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
        setAgendaFileLabel('edit-', '');
        if (!button.dataset.lokasi) syncAgendaRoomLocation('edit-');
        
        openModal('modal-edit-agenda');
    }

    function syncAgendaRoomLocation(prefix) {
        const select = document.getElementById(prefix + 'id_ruangrapat');
        const location = document.getElementById(prefix + 'lokasi');
        if (!select || select.tagName !== 'SELECT' || !location || location.type === 'text') return;

        const selected = select.options[select.selectedIndex];
        if (selected && selected.value) {
            location.value = selected.text.trim();
        }
    }

    function setAgendaFileLabel(prefix, fileName) {
        const label = document.getElementById(prefix + 'lampiran-label');
        if (!label) return;
        label.textContent = fileName || 'Klik atau seret file PDF ke sini';
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
            setAgendaFileLabel(prefix, file ? file.name : '');
        });
    });
</script>
@endpush
@endsection
