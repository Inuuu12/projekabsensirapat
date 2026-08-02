@extends('admin.layout.app')

@section('title', 'Daftar Kunjungan')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Daftar Kunjungan</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola dan pantau seluruh riwayat kunjungan di sini.</p>
        </div>
        <button onclick="openModal('modal-tambah-kunjungan')" class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-xl transition shadow-xs self-start sm:self-auto">
            <span class="text-lg leading-none">+</span>
            <span></span>Tambah Kunjungan</span>
        </button>
    </div>

    <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-xs">
        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Kunjungan</p>
        <p class="mt-2 text-3xl font-black text-[#35635b]">{{ $totalKunjungan ?? $kunjungan->count() }}</p>
    </div>

    <form method="GET" action="{{ route('admin.kunjungan.lihat') }}" class="bg-white rounded-2xl shadow-xs border border-gray-100 p-5">
        <div class="grid grid-cols-1 gap-3 xl:grid-cols-[1fr_220px_220px_180px] xl:items-end">
            <div>
                <label for="keyword" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">Search</label>
                <input
                    id="keyword"
                    name="keyword"
                    value="{{ $keyword ?? request('keyword') }}"
                    type="search"
                    class="h-11 w-full rounded-xl border border-gray-200 bg-white px-4 text-sm text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20"
                    placeholder="Cari pengunjung, pihak dituju, instansi, no HP, email, keperluan...">
            </div>
            <div>
                <label for="pihak-dituju-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">Pihak Dituju</label>
                <select
                    id="pihak-dituju-filter"
                    name="pihak_dituju"
                    onchange="this.form.submit()"
                    class="h-11 w-full rounded-xl border border-gray-200 bg-white px-4 text-sm font-medium text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    <option value="semua" @selected(($pihakDitujuFilter ?? 'semua') === 'semua')>Semua Pihak</option>
                    @foreach (($pihakDitujuOptions ?? collect()) as $pihakDituju)
                        <option value="{{ $pihakDituju }}" @selected(($pihakDitujuFilter ?? 'semua') === $pihakDituju)>{{ $pihakDituju }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="keperluan-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">Keperluan</label>
                <select
                    id="keperluan-filter"
                    name="keperluan"
                    onchange="this.form.submit()"
                    class="h-11 w-full rounded-xl border border-gray-200 bg-white px-4 text-sm font-medium text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                    <option value="semua" @selected(($keperluanFilter ?? 'semua') === 'semua')>Semua Keperluan</option>
                    @foreach (($keperluanOptions ?? collect()) as $keperluan)
                        <option value="{{ $keperluan }}" @selected(($keperluanFilter ?? 'semua') === $keperluan)>{{ \Illuminate\Support\Str::limit($keperluan, 42) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tanggal-filter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">Tanggal</label>
                <input
                    id="tanggal-filter"
                    name="tanggal"
                    value="{{ $tanggalFilter ?? request('tanggal') }}"
                    type="date"
                    onchange="this.form.submit()"
                    class="h-11 w-full rounded-xl border border-gray-200 bg-white px-4 text-sm font-medium text-gray-700 outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
            </div>
        </div>
    </form>

    <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="border-b border-gray-100 px-6 py-4">
            <h2 class="text-base font-extrabold text-gray-800">Daftar Kunjungan</h2>
            <p class="mt-1 text-xs text-gray-500">Menampilkan {{ $kunjungan->count() }} dari {{ $totalKunjungan ?? $kunjungan->count() }} kunjungan.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[1040px]">
                <thead>
                    <tr class="bg-[#35635b] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Pengunjung</th>
                        <th class="px-6 py-4">Pihak Dituju</th>
                        <th class="px-6 py-4">Instansi</th>
                        <th class="px-6 py-4">No HP</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Keperluan</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($kunjungan as $item)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-6 py-4 font-bold text-[#35635b]">{{ $item->nama_pengunjung ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->nama_pejabat ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->asal_instansi ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->nomorhp_pengunjung ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->email_pengunjung ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->keperluan }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->waktu ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                                {{ $item->tanggal_kunjungan ? \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        type="button"
                                        onclick="openEditKunjungan(this)"
                                        data-action="{{ route('admin.kunjungan.update', $item->id_kunjungan) }}"
                                        data-pejabat="{{ $item->nama_pejabat }}"
                                        data-pengunjung="{{ $item->nama_pengunjung }}"
                                        data-instansi="{{ $item->asal_instansi }}"
                                        data-nomor="{{ $item->nomorhp_pengunjung }}"
                                        data-email="{{ $item->email_pengunjung }}"
                                        data-keperluan="{{ $item->keperluan }}"
                                        data-waktu="{{ $item->waktu }}"
                                        data-tanggal="{{ $item->tanggal_kunjungan }}"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 p-1.5 transition hover:bg-green-100"
                                        title="Edit Kunjungan">
                                        <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                        <span class="sr-only">Edit</span>
                                    </button>
                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ route('admin.kunjungan.destroy', $item->id_kunjungan) }}', 'Hapus Kunjungan?', 'Apakah Anda yakin ingin menghapus kunjungan ini?')"
                                        class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100"
                                        title="Hapus Kunjungan">
                                        <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                        <span class="sr-only">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500">Belum ada data kunjungan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-tambah-kunjungan" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Tambah Kunjungan</h3>
            <button type="button" onclick="closeModal('modal-tambah-kunjungan')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-tambah-kunjungan" method="POST" action="{{ route('admin.kunjungan.store') }}" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="grid grid-cols-1 gap-x-4 gap-y-4 overflow-y-auto px-5 py-5 sm:grid-cols-2 sm:px-6">
                @include('admin.kunjungan.form-fields')
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closeModal('modal-tambah-kunjungan')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
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

<div id="modal-edit-kunjungan" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Edit Kunjungan</h3>
            <button type="button" onclick="closeModal('modal-edit-kunjungan')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>

        <form id="form-edit-kunjungan" method="POST" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-x-4 gap-y-4 overflow-y-auto px-5 py-5 sm:grid-cols-2 sm:px-6">
                @include('admin.kunjungan.form-fields', ['prefix' => 'edit-'])
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closeModal('modal-edit-kunjungan')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
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
        if (modal) modal.classList.replace('hidden', 'flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.replace('flex', 'hidden');
    }

    function openEditKunjungan(button) {
        document.getElementById('form-edit-kunjungan').action = button.dataset.action;
        const pejabatVal = button.dataset.pejabat || '';
        if (document.getElementById('edit-nama_pegawai')) document.getElementById('edit-nama_pegawai').value = pejabatVal;
        if (document.getElementById('edit-nama_pejabat')) document.getElementById('edit-nama_pejabat').value = pejabatVal;
        document.getElementById('edit-nama_pengunjung').value = button.dataset.pengunjung || '';
        document.getElementById('edit-asal_instansi').value = button.dataset.instansi || '';
        document.getElementById('edit-nomorhp_pengunjung').value = button.dataset.nomor || '';
        document.getElementById('edit-email_pengunjung').value = button.dataset.email || '';
        document.getElementById('edit-keperluan').value = button.dataset.keperluan || '';
        document.getElementById('edit-waktu').value = button.dataset.waktu || '';
        document.getElementById('edit-tanggal_kunjungan').value = button.dataset.tanggal || '';
        openModal('modal-edit-kunjungan');
    }
</script>
@endpush
@endsection
