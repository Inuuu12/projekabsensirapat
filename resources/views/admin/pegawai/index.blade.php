@extends('admin.layout.app')

@section('title', 'Data Pegawai')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Data Pegawai</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola dan pantau informasi seluruh pegawai di sini.</p>
        </div>
        <button onclick="openModal('modal-tambah-pegawai')" class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-xl transition shadow-xs self-start sm:self-auto">
            <span class="text-lg leading-none">+</span>
            <span>Tambah Pegawai</span>
        </button>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Pegawai</p>
        <p class="mt-2 text-3xl font-black text-[#35635b]">{{ $totalPegawai ?? $pegawai->count() }}</p>
    </div>





    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-100 px-6 py-5 flex flex-col gap-4">
            <div>
            <div>
                <h2 class="text-base font-extrabold text-gray-800">Daftar Pegawai</h2>
                <p id="text-count-pegawai" class="mt-1 text-xs text-gray-500">Menampilkan {{ $pegawai->count() }} dari {{ $totalPegawai ?? $pegawai->count() }} pegawai.</p>
            </div>
            <form id="form-search-pegawai" method="GET" action="{{ route('admin.pegawai.lihat') }}" class="w-full">
                <div class="grid grid-cols-1 gap-3 lg:grid-cols-[1fr_220px_220px] lg:items-end">
                    <div>
                        <label for="keyword" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">Search</label>
                        <input
                            id="keyword"
                            name="keyword"
                            value="{{ $keyword ?? request('keyword') }}"
                            type="search"
                            class="h-11 w-full rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20"
                            placeholder="Cari nama, NIP, tanggal lahir, jabatan, bidang, no HP, email...">
                    </div>
                    <div>
                        <label for="bidang-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">Bidang</label>
                        <select
                            id="bidang-filter"
                            name="bidang"
                            class="h-11 w-full rounded-xl border border-gray-200 bg-white px-4 text-sm font-medium text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                            <option value="semua" @selected(($bidangFilter ?? 'semua') === 'semua')>Semua Bidang</option>
                            @foreach (($bidangOptions ?? collect()) as $bidang)
                                <option value="{{ $bidang }}" @selected(($bidangFilter ?? 'semua') === $bidang)>{{ $bidang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="jabatan-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">Jabatan</label>
                        <select
                            id="jabatan-filter"
                            name="jabatan"
                            class="h-11 w-full rounded-xl border border-gray-200 bg-white px-4 text-sm font-medium text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                            <option value="semua" @selected(($jabatanFilter ?? 'semua') === 'semua')>Semua Jabatan</option>
                            @foreach (($jabatanOptions ?? collect()) as $jabatan)
                                <option value="{{ $jabatan }}" @selected(($jabatanFilter ?? 'semua') === $jabatan)>{{ $jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto overflow-y-auto max-h-[450px] custom-scrollbar">
            <table class="w-full text-left min-w-[1160px]">
                <thead class="sticky top-0 z-10">
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider outline outline-1 outline-[#35635b]">
                        <th class="px-6 py-4">Foto</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">NIP</th>
                        <th class="px-6 py-4">Tanggal Lahir</th>
                        <th class="px-6 py-4">Jabatan</th>
                        <th class="px-6 py-4">Bidang</th>
                        <th class="px-6 py-4">No HP</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($pegawai as $item)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-6 py-4">
                                @if (!empty($item->foto))
    {{-- Hasil asset('storage/' . $item->foto) akan menjadi http://localhost/storage/pegawai/namafile.jpg --}}
    <img src="{{ asset('storage/' . $item->foto) }}" 
         alt="{{ $item->nama_pegawai }}" 
         class="w-10 h-10 rounded-full object-cover border border-gray-200">
@else
    <img src="{{ asset('foto/profile.png') }}" alt="{{ $item->nama_pegawai }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
@endif
                            </td>
                            <td class="px-6 py-4 font-bold text-[#35635b]">{{ $item->nama_pegawai }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-700">{{ $item->nip }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->tanggal_lahir?->format('d/m/Y') ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->jabatan }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->bidang ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->nomor_hp }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->email }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        type="button"
                                        onclick="openEditPegawai(this)"
                                        data-id="{{ $item->id_pegawai }}"
                                        data-action="{{ route('admin.pegawai.update', $item->id_pegawai) }}"
                                        data-foto-url="{{ $item->foto ? asset('storage/' . $item->foto) : '' }}"
                                        data-nama="{{ $item->nama_pegawai }}"
                                        data-nip="{{ $item->nip }}"
                                        data-tanggal-lahir="{{ $item->tanggal_lahir?->format('Y-m-d') }}"
                                        data-jabatan="{{ $item->jabatan }}"
                                        data-bidang="{{ $item->bidang }}"
                                        data-nomor="{{ $item->nomor_hp }}"
                                        data-email="{{ $item->email }}"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 p-1.5 transition hover:bg-green-100"
                                        title="Edit Pegawai">
                                        <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                        <span class="sr-only">Edit</span>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.pegawai.destroy', $item->id_pegawai) }}', 'Hapus Pegawai?', 'Apakah Anda yakin ingin menghapus pegawai ini?')"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100"
                                        title="Hapus Pegawai">
                                        <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                        <span class="sr-only">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500">Belum ada data pegawai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <section class="bg-white rounded-2xl shadow-xs border border-gray-100 p-5">
            <div class="flex flex-col gap-1">
                <h2 class="text-base font-extrabold text-gray-800">Master Bidang</h2>
                <p class="text-xs text-gray-500">Opsi bidang untuk form tambah dan edit pegawai.</p>
            </div>

            <form method="POST" action="{{ route('admin.pegawai.bidang.store') }}" class="mt-4 flex flex-col gap-3 sm:flex-row">
                @csrf
                <input name="nama_bidang" required class="h-10 min-w-0 flex-1 rounded-lg border border-gray-200 px-3 text-sm text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20" placeholder="Nama bidang baru">
                <button type="submit" class="h-10 rounded-lg bg-[#04733f] px-4 text-sm font-bold text-white transition hover:bg-[#035f35]">Tambah</button>
            </form>

            <div class="mt-5">
                <div class="relative mb-3">
                    <input type="text" id="search-bidang" placeholder="Cari bidang..." class="w-full h-9 rounded-lg border border-gray-200 pl-8 pr-3 text-xs text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="w-full text-left text-xs text-gray-500">
                        <thead class="bg-gray-50 text-gray-700 uppercase">
                            <tr>
                                <th class="px-4 py-3 font-bold w-12">No</th>
                                <th class="px-4 py-3 font-bold">Nama Bidang</th>
                                <th class="px-4 py-3 font-bold text-center w-20">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                    <div id="container-bidang" class="max-h-56 overflow-y-auto custom-scrollbar bg-white">
                        <table class="w-full text-left text-xs text-gray-500">
                            <tbody class="divide-y divide-gray-200">
                                @forelse (($bidangMaster ?? collect()) as $index => $bidang)
                                    <tr class="item-bidang hover:bg-gray-50 transition" data-name="{{ strtolower($bidang->nama_bidang) }}">
                                        <td class="px-4 py-3 w-12 text-center">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $bidang->nama_bidang }}</td>
                                        <td class="px-4 py-3 w-20 text-center">
                                            <form method="POST" action="{{ route('admin.pegawai.bidang.destroy', $bidang->id_bidang) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 p-1 bg-red-50 rounded hover:bg-red-100 transition" title="Hapus bidang">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-4 text-center text-xs text-gray-500">Belum ada master bidang.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white rounded-2xl shadow-xs border border-gray-100 p-5">
            <div class="flex flex-col gap-1">
                <h2 class="text-base font-extrabold text-gray-800">Master Jabatan</h2>
                <p class="text-xs text-gray-500">Opsi jabatan untuk form tambah dan edit pegawai.</p>
            </div>

            <form method="POST" action="{{ route('admin.pegawai.jabatan.store') }}" class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-[1fr_180px_auto]">
                @csrf
                <input name="nama_jabatan" required class="h-10 rounded-lg border border-gray-200 px-3 text-sm text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20" placeholder="Nama jabatan baru">
                <select name="kategori" class="h-10 rounded-lg border border-gray-200 px-3 text-sm text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    <option value="Struktural">Struktural</option>
                    <option value="Jabatan Fungsional">Jabatan Fungsional</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <button type="submit" class="h-10 rounded-lg bg-[#04733f] px-4 text-sm font-bold text-white transition hover:bg-[#035f35]">Tambah</button>
            </form>

            <div class="mt-5">
                <div class="relative mb-3">
                    <input type="text" id="search-jabatan" placeholder="Cari jabatan..." class="w-full h-9 rounded-lg border border-gray-200 pl-8 pr-3 text-xs text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="w-full text-left text-xs text-gray-500">
                        <thead class="bg-gray-50 text-gray-700 uppercase">
                            <tr>
                                <th class="px-4 py-3 font-bold w-12">No</th>
                                <th class="px-4 py-3 font-bold">Nama Jabatan</th>
                                <th class="px-4 py-3 font-bold w-32">Kategori</th>
                                <th class="px-4 py-3 font-bold text-center w-20">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                    <div id="container-jabatan" class="max-h-56 overflow-y-auto custom-scrollbar bg-white">
                        <table class="w-full text-left text-xs text-gray-500">
                            <tbody class="divide-y divide-gray-200">
                                @forelse (($jabatanMaster ?? collect()) as $index => $jabatan)
                                    <tr class="item-jabatan hover:bg-gray-50 transition" data-name="{{ strtolower($jabatan->nama_jabatan . ' ' . $jabatan->kategori) }}">
                                        <td class="px-4 py-3 w-12 text-center">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-800">{{ $jabatan->nama_jabatan }}</td>
                                        <td class="px-4 py-3 w-32"><span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600">{{ $jabatan->kategori ?: 'Lainnya' }}</span></td>
                                        <td class="px-4 py-3 w-20 text-center">
                                            <form method="POST" action="{{ route('admin.pegawai.jabatan.destroy', $jabatan->id_jabatan) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 p-1 bg-red-50 rounded hover:bg-red-100 transition" title="Hapus jabatan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-xs text-gray-500">Belum ada master jabatan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<div id="modal-tambah-pegawai" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Tambah Pegawai</h3>
            <button type="button" onclick="closeModal('modal-tambah-pegawai')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal tambah pegawai">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-tambah-pegawai" method="POST" action="{{ route('admin.pegawai.store') }}" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @if ($errors->any() && !old('_method'))
                <div class="px-5 pt-4 sm:px-6">
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-1 gap-x-4 gap-y-4 overflow-y-auto px-5 py-5 sm:grid-cols-2 sm:px-6">
                @include('admin.pegawai.form-fields')
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closeModal('modal-tambah-pegawai')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#04733f] px-5 text-sm font-bold text-white transition hover:bg-[#035f35]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-pegawai" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Edit Pegawai</h3>
            <button type="button" onclick="closeModal('modal-edit-pegawai')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal edit pegawai">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-edit-pegawai" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-id_pegawai" name="id_pegawai">
            @if ($errors->any() && old('_method') === 'PUT')
                <div class="px-5 pt-4 sm:px-6">
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-1 gap-x-4 gap-y-4 overflow-y-auto px-5 py-5 sm:grid-cols-2 sm:px-6">
                @include('admin.pegawai.form-fields', ['prefix' => 'edit-'])
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closeModal('modal-edit-pegawai')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#04733f] px-5 text-sm font-bold text-white transition hover:bg-[#035f35]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h12l2 2v12H5zM8 5v6h8V5M9 18h6"></path>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (id === 'modal-tambah-pegawai') {
            const form = document.getElementById('form-tambah-pegawai');
            if (form) form.reset();
            setPegawaiPhotoPreview('', '');
        }
        if (modal) modal.classList.replace('hidden', 'flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.replace('flex', 'hidden');
    }

    function openEditPegawai(button) {
        document.getElementById('form-edit-pegawai').action = button.dataset.action;
        document.getElementById('edit-id_pegawai').value = button.dataset.id;
        document.getElementById('edit-foto').value = '';
        document.getElementById('edit-nama_pegawai').value = button.dataset.nama;
        document.getElementById('edit-nip').value = button.dataset.nip;
        document.getElementById('edit-tanggal_lahir').value = button.dataset.tanggalLahir || '';
        document.getElementById('edit-jabatan').value = button.dataset.jabatan;
        document.getElementById('edit-bidang').value = button.dataset.bidang || '';
        document.getElementById('edit-nomor_hp').value = button.dataset.nomor;
        document.getElementById('edit-email').value = button.dataset.email;
        setPegawaiPhotoPreview('edit-', button.dataset.fotoUrl || '');
        openModal('modal-edit-pegawai');
    }

    function setPegawaiPhotoPreview(prefix, url) {
        const preview = document.getElementById(prefix + 'foto-preview');
        const icon = document.getElementById(prefix + 'foto-icon');
        const hapusBtn = document.getElementById(prefix + 'btn-hapus-foto');

        if (url) {
            preview.src = url;
            preview.classList.remove('hidden');
            if (icon) icon.classList.add('hidden');
            if (hapusBtn) hapusBtn.classList.remove('hidden');
        } else {
            preview.src = '{{ asset("foto/profile.png") }}';
            preview.classList.remove('hidden');
            if (icon) icon.classList.add('hidden');
            if (hapusBtn) hapusBtn.classList.add('hidden');
        }
    }

    function removePhoto(prefix) {
        const input = document.getElementById(prefix + 'foto');
        const hapusInput = document.getElementById(prefix + 'hapus_foto');
        
        if (input) input.value = '';
        
        setPegawaiPhotoPreview(prefix, '');
        
        if (hapusInput) hapusInput.value = '1';
    }

    document.querySelectorAll('input[type="file"][data-photo-input]').forEach(input => {
        input.addEventListener('change', function(e) {
            const prefix = this.dataset.photoInput;
            const file = this.files[0];
            const hapusInput = document.getElementById(prefix + 'hapus_foto');
            if (hapusInput) hapusInput.value = '0';
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    setPegawaiPhotoPreview(prefix, e.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                setPegawaiPhotoPreview(prefix, '');
            }
        });
    });

    const masterState = {
        bidang: { expanded: false },
        jabatan: { expanded: false }
    };

    function initMasterList(type) {
        const searchInput = document.getElementById(`search-${type}`);
        if (searchInput) {
            searchInput.addEventListener('input', () => renderMasterList(type));
        }
        renderMasterList(type);
    }

    function renderMasterList(type) {
        const searchInput = document.getElementById(`search-${type}`);
        const container = document.getElementById(`container-${type}`);
        
        if (!container) return;
        
        const items = container.querySelectorAll(`.item-${type}`);
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        
        items.forEach((item) => {
            const name = item.dataset.name || '';
            if (name.includes(searchTerm)) {
                item.style.display = 'table-row';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function initLiveSearch() {
        const form = document.getElementById('form-search-pegawai');
        const searchInput = document.getElementById('keyword');
        const bidangFilter = document.getElementById('bidang-filter');
        const jabatanFilter = document.getElementById('jabatan-filter');
        const tableBody = document.querySelector('table tbody');
        const countText = document.getElementById('text-count-pegawai');
        
        if (!form || !searchInput || !tableBody) return;

        let debounceTimer;

        function fetchResults() {
            const url = new URL(form.action);
            const params = new URLSearchParams(new FormData(form));
            url.search = params.toString();

            // Update URL in browser without reload
            window.history.replaceState({}, '', url);

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const newTbody = doc.querySelector('table tbody');
                if (newTbody) {
                    tableBody.innerHTML = newTbody.innerHTML;
                }

                const newCount = doc.getElementById('text-count-pegawai');
                if (countText && newCount) {
                    countText.innerHTML = newCount.innerHTML;
                }
            });
        }

        searchInput.addEventListener('input', function(e) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fetchResults, 300);
        });

        // Prevent form submission on enter
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });

        if(bidangFilter) {
            bidangFilter.addEventListener('change', fetchResults);
        }
        if(jabatanFilter) {
            jabatanFilter.addEventListener('change', fetchResults);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initMasterList('bidang');
        initMasterList('jabatan');
        initLiveSearch();

        @if($errors->any())
            @if(old('_method') === 'PUT')
                const editId = "{{ old('id_pegawai') }}";
                const editBtn = document.querySelector(`button[data-id="${editId}"]`);
                if (editBtn) {
                    openEditPegawai(editBtn);
                    document.getElementById('edit-nama_pegawai').value = @json(old('nama_pegawai'));
                    document.getElementById('edit-nip').value = @json(old('nip'));
                    document.getElementById('edit-tanggal_lahir').value = @json(old('tanggal_lahir'));
                    document.getElementById('edit-jabatan').value = @json(old('jabatan'));
                    document.getElementById('edit-bidang').value = @json(old('bidang'));
                    document.getElementById('edit-nomor_hp').value = @json(old('nomor_hp'));
                    document.getElementById('edit-email').value = @json(old('email'));
                }
            @else
                openModal('modal-tambah-pegawai');
                document.getElementById('nama_pegawai').value = @json(old('nama_pegawai'));
                document.getElementById('nip').value = @json(old('nip'));
                document.getElementById('tanggal_lahir').value = @json(old('tanggal_lahir'));
                document.getElementById('jabatan').value = @json(old('jabatan'));
                document.getElementById('bidang').value = @json(old('bidang'));
                document.getElementById('nomor_hp').value = @json(old('nomor_hp'));
                document.getElementById('email').value = @json(old('email'));
            @endif
        @endif
    });
</script>
@endpush
@endsection
