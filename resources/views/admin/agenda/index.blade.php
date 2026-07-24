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
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Daftar Agenda</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola agenda berdasarkan Surat Internal, Surat Masuk, dan Surat Keluar.</p>
        </div>
        <button onclick="openModal('modal-tambah-agenda')" class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-xl flex items-center justify-center gap-2 transition shadow-xs cursor-pointer self-start sm:self-auto">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Agenda</span>
        </button>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach ($kategoriOptions as $key => $label)
            <a href="{{ route('admin.agenda.lihat', ['kategori_surat' => $key]) }}" class="bg-white border {{ $kategoriSurat === $key ? 'border-[#35635b] ring-2 ring-[#35635b]/10' : 'border-gray-100' }} rounded-2xl p-5 shadow-xs transition hover:border-[#35635b] flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-black text-[#35635b]">{{ $agendaStats[$key] ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center p-2">
                    <img src="{{ asset('foto/Suratlogo.png') }}" alt="{{ $label }}" class="w-full h-full object-contain">
                </div>
            </a>
        @endforeach
    </div>

    <!-- Controls & Search -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex flex-wrap gap-2">
            @foreach ($kategoriOptions as $key => $label)
                <a href="{{ route('admin.agenda.lihat', ['kategori_surat' => $key, 'keyword' => request('keyword')]) }}" class="rounded-xl px-4 py-2 text-sm font-bold transition {{ $kategoriSurat === $key ? 'bg-[#35635b] text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('admin.agenda.lihat') }}" class="relative w-full lg:w-80">
            <input type="hidden" name="kategori_surat" value="{{ $kategoriSurat }}">
            <input name="keyword" value="{{ request('keyword') }}" type="search" class="bg-white text-gray-700 text-sm rounded-xl block w-full px-4 py-3 outline-none border border-gray-200 focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 transition shadow-xs" placeholder="Cari agenda, lokasi, asal surat...">
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
            <div>
                <h2 class="text-base font-extrabold text-gray-800">{{ $activeLabel }}</h2>
                <p class="mt-1 text-xs text-gray-500">Menampilkan {{ $agenda->count() }} agenda dari database.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[1080px]">
                <thead>
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider">
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
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($agenda as $item)
                        @php
                            $itemRuang = $ruang->firstWhere('id_ruangrapat', $item->id_ruangrapat);
                            $itemStatus = $statusAgenda->firstWhere('id_statusagenda', $item->id_statusagenda);
                        @endphp
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-6 py-4 font-bold text-[#35635b]">{{ $item->nama_agenda }}</td>
                            <td class="px-6 py-4 text-gray-700 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-700 whitespace-nowrap">{{ $item->waktu }}</td>
                            
                            @if ($kategoriSurat === 'masuk')
                                <td class="px-6 py-4 text-gray-700 font-medium">{{ $item->ditugaskan ?: '-' }}</td>
                            @else
                                <td class="px-6 py-4 text-gray-700 font-semibold">{{ $item->kuota ?? '-' }}</td>
                            @endif

                            <td class="px-6 py-4 text-gray-700">{{ $item->asal_surat ?: '-' }}</td>
                            
                            {{-- Lampiran dengan Logo --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->lampiran)
                                    <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank" class="inline-flex items-center gap-1.5 font-bold text-[#35635b] hover:underline">
                                        <img src="{{ asset('foto/Lampiranlogo.png') }}" alt="Lampiran" class="w-4 h-4 object-contain">
                                        <span>Lihat</span>
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-gray-700 whitespace-nowrap">{{ $item->lokasi ?: ($itemRuang->nama_ruang ?? '-') }}</td>
                            
                            <td class="px-6 py-4">
                                <span class="bg-[#35635b]/10 text-[#35635b] text-xs font-bold px-2.5 py-1 rounded-lg whitespace-nowrap">
                                    {{ $itemStatus->nama_status ?? 'Scheduled' }}
                                </span>
                            </td>

                            {{-- Group Tombol Aksi (Edit, Hapus, Detail) --}}
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-2">
                                    {{-- Tombol Edit --}}
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
                                        data-kuota="{{ $item->kuota }}"
                                        data-lokasi="{{ $item->lokasi }}"
                                        data-ruang="{{ $item->id_ruangrapat }}"
                                        data-status="{{ $item->id_statusagenda }}"
                                        data-statusqr="{{ $item->status_qr }}"
                                        data-statusfr="{{ (int) $item->status_fr }}"
                                        class="w-8 h-8 rounded-lg bg-green-50 p-1.5 hover:bg-green-100 transition flex items-center justify-center cursor-pointer"
                                        title="Edit Agenda">
                                        <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="w-full h-full object-contain">
                                    </button>

                                    {{-- Tombol Hapus Custom Modal --}}
                                    <button type="button" 
                                            onclick="openDeleteModal('{{ route('admin.agenda.destroy', $item->id_agenda) }}', 'Hapus Agenda?', 'Apakah Anda yakin ingin menghapus agenda ini?')"
                                            class="w-8 h-8 rounded-lg bg-red-50 p-1.5 hover:bg-red-100 transition flex items-center justify-center cursor-pointer" 
                                            title="Hapus Agenda">
                                        <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="w-full h-full object-contain">
                                    </button>

                                    {{-- Tombol Ke Detail Agenda --}}
                                    <a href="{{ route('admin.agenda.detail', ['id' => $item->id_agenda]) }}" 
                                       class="w-8 h-8 rounded-lg bg-gray-50 p-1.5 hover:bg-gray-100 transition flex items-center justify-center cursor-pointer" 
                                       title="Lihat Detail Agenda">
                                        <img src="{{ asset('foto/Detaillogo.png') }}" alt="Detail Agenda" class="w-full h-full object-contain">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500 font-medium">Belum ada agenda untuk {{ strtolower($activeLabel) }}.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH AGENDA -->
<div id="modal-tambah-agenda" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Tambah Agenda</h3>
        <form method="POST" action="{{ route('admin.agenda.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @include('admin.agenda.form-fields')
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-tambah-agenda')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs cursor-pointer">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT AGENDA -->
<div id="modal-edit-agenda" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl space-y-4 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3">Edit Agenda</h3>
        <form id="form-edit-agenda" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            @include('admin.agenda.form-fields', ['prefix' => 'edit-'])
            <div class="flex justify-end gap-3 pt-3 border-t">
                <button type="button" onclick="closeModal('modal-edit-agenda')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 rounded-xl cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-[#35635b] hover:bg-[#2b4f49] rounded-xl shadow-xs cursor-pointer">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>



@push('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
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
        if(document.getElementById('edit-ditugaskan')) document.getElementById('edit-ditugaskan').value = button.dataset.ditugaskan || '';
        if(document.getElementById('edit-tanggal')) document.getElementById('edit-tanggal').value = button.dataset.tanggal || '';
        if(document.getElementById('edit-waktu')) document.getElementById('edit-waktu').value = button.dataset.waktu || '';
        if(document.getElementById('edit-kuota')) document.getElementById('edit-kuota').value = button.dataset.kuota || '';
        if(document.getElementById('edit-lokasi')) document.getElementById('edit-lokasi').value = button.dataset.lokasi || '';
        if(document.getElementById('edit-id_ruangrapat')) document.getElementById('edit-id_ruangrapat').value = button.dataset.ruang || '';
        if(document.getElementById('edit-id_statusagenda')) document.getElementById('edit-id_statusagenda').value = button.dataset.status || '';
        if(document.getElementById('edit-status_qr')) document.getElementById('edit-status_qr').value = button.dataset.statusqr || 'nonaktif';
        if(document.getElementById('edit-status_fr')) document.getElementById('edit-status_fr').checked = button.dataset.statusfr === '1';
        
        openModal('modal-edit-agenda');
    }
</script>
@endpush
@endsection