@extends('admin.layout.app')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Header Banner -->
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl p-6 shadow-xs transition-colors flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-gray-900 dark:text-white">Pengaturan & Master Data</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kelola konfigurasi informasi publik dan data master aplikasi RAPID</p>
        </div>

        <!-- Tab Selection (Kunker Filter Style) -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
            <a href="{{ route('admin.pengaturan.index', ['tab' => 'publik']) }}"
               class="px-5 py-2.5 rounded-full text-xs font-extrabold transition-all whitespace-nowrap flex items-center gap-2 {{ ($tab ?? 'publik') === 'publik' ? 'bg-[#35635b] text-white shadow-sm' : 'bg-gray-100 dark:bg-[#0f1c19] text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
                <span>Pengaturan Publik</span>
            </a>
            <a href="{{ route('admin.pengaturan.index', ['tab' => 'admin']) }}"
               class="px-5 py-2.5 rounded-full text-xs font-extrabold transition-all whitespace-nowrap flex items-center gap-2 {{ ($tab ?? '') === 'admin' ? 'bg-[#35635b] text-white shadow-sm' : 'bg-gray-100 dark:bg-[#0f1c19] text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
                <span>Pengaturan Admin (Master Data)</span>
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 dark:bg-emerald-950/50 p-4 text-xs font-bold text-emerald-800 dark:text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-xl border border-rose-200 bg-rose-50 dark:bg-rose-950/50 p-4 text-xs font-bold text-rose-800 dark:text-rose-300">
            {{ session('error') }}
        </div>
    @endif

    @if (($tab ?? 'publik') === 'publik')
        <!-- TAB 1: PENGATURAN PUBLIK -->
        <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] p-6 transition-colors space-y-6">
            <div class="border-b border-gray-100 dark:border-[#233a34] pb-4">
                <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Informasi Kontak & Footer Publik</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Informasi di bawah ini akan ditampilkan pada footer halaman depan publik (beranda, berita, agenda, dll)</p>
            </div>

            <form method="POST" action="{{ route('admin.pengaturan.publik.update') }}" class="space-y-5">
                @csrf
                
                <div class="space-y-1.5">
                    <label for="alamat" class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300">Alamat Kantor</label>
                    <textarea id="alamat" name="alamat" rows="3" required
                        class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] p-3 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20"
                        placeholder="Masukkan alamat kantor instansi...">{{ old('alamat', $alamat) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label for="telepon" class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300">Nomor Telepon</label>
                        <input id="telepon" name="telepon" type="text" value="{{ old('telepon', $telepon) }}" required
                            class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20"
                            placeholder="Contoh: (021) 8758605">
                    </div>

                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300">Email Instansi</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $email) }}" required
                            class="h-11 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-4 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20"
                            placeholder="Contoh: diskominfo@bogorkab.go.id">
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 dark:border-[#233a34] space-y-4">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-gray-500 dark:text-gray-400">Tautan Media Sosial</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="space-y-1.5">
                            <label for="instagram_url" class="block text-xs font-bold text-gray-600 dark:text-gray-300">URL Instagram</label>
                            <input id="instagram_url" name="instagram_url" type="url" value="{{ old('instagram_url', $instagramUrl) }}"
                                class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20"
                                placeholder="https://instagram.com/...">
                        </div>

                        <div class="space-y-1.5">
                            <label for="facebook_url" class="block text-xs font-bold text-gray-600 dark:text-gray-300">URL Facebook</label>
                            <input id="facebook_url" name="facebook_url" type="url" value="{{ old('facebook_url', $facebookUrl) }}"
                                class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20"
                                placeholder="https://facebook.com/...">
                        </div>

                        <div class="space-y-1.5">
                            <label for="youtube_url" class="block text-xs font-bold text-gray-600 dark:text-gray-300">URL Channel YouTube</label>
                            <input id="youtube_url" name="youtube_url" type="url" value="{{ old('youtube_url', $youtubeUrl) }}"
                                class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20"
                                placeholder="https://youtube.com/...">
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2.5 px-6 rounded-xl transition shadow-sm text-xs cursor-pointer">
                        Simpan Pengaturan Publik
                    </button>
                </div>
            </form>
        </div>

    @else
        <!-- TAB 2: PENGATURAN ADMIN (MASTER DATA) -->
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <!-- Master Bidang -->
            <section class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] p-5 transition-colors">
                <div class="flex flex-col gap-1">
                    <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Master Bidang</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-300">Opsi bidang untuk form data pegawai.</p>
                </div>

                <form method="POST" action="{{ route('admin.pengaturan.bidang.store') }}" class="mt-4 flex flex-col gap-3 sm:flex-row">
                    @csrf
                    <input name="nama_bidang" required class="h-10 min-w-0 flex-1 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20" placeholder="Nama bidang baru">
                    <button type="submit" class="h-10 rounded-lg bg-[#35635b] dark:bg-[#107050] px-4 text-sm font-bold text-white transition hover:bg-[#2b4f49] cursor-pointer">Tambah</button>
                </form>

                <div class="mt-5">
                    <div class="relative mb-3">
                        <input type="text" id="search-bidang" placeholder="Cari bidang..." class="w-full h-9 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] pl-8 pr-3 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500">
                        <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    
                    <div class="border border-gray-200 dark:border-[#284c43] rounded-lg overflow-hidden">
                        <table class="w-full text-left text-xs text-gray-500 dark:text-gray-300">
                            <thead class="bg-gray-50 dark:bg-[#1b3832] text-gray-700 dark:text-white uppercase font-bold">
                                <tr>
                                    <th class="px-4 py-3 font-bold w-12">No</th>
                                    <th class="px-4 py-3 font-bold">Nama Bidang</th>
                                    <th class="px-4 py-3 font-bold text-center w-20">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="container-bidang" class="max-h-72 overflow-y-auto custom-scrollbar bg-white dark:bg-[#152420]">
                            <table class="w-full text-left text-xs text-gray-500 dark:text-gray-300">
                                <tbody class="divide-y divide-gray-200 dark:divide-[#233a34]">
                                    @forelse (($bidangMaster ?? collect()) as $index => $bidang)
                                        <tr class="item-bidang hover:bg-gray-50 dark:hover:bg-[#1b332d] transition" data-name="{{ strtolower($bidang->nama_bidang) }}">
                                            <td class="px-4 py-3 w-12 text-center">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">{{ $bidang->nama_bidang }}</td>
                                            <td class="px-4 py-3 w-20 text-center">
                                                <form method="POST" action="{{ route('admin.pengaturan.bidang.destroy', $bidang->id_bidang) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus bidang ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1 bg-red-50 dark:bg-red-950/40 rounded hover:bg-red-100 dark:hover:bg-red-900/60 transition cursor-pointer" title="Hapus bidang">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-4 text-center text-xs text-gray-500 dark:text-gray-400">Belum ada master bidang.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Master Jabatan -->
            <section class="bg-white dark:bg-[#152420] rounded-2xl shadow-xs border border-gray-100 dark:border-[#233a34] p-5 transition-colors">
                <div class="flex flex-col gap-1">
                    <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Master Jabatan</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-300">Opsi jabatan untuk form data pegawai.</p>
                </div>

                <form method="POST" action="{{ route('admin.pengaturan.jabatan.store') }}" class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-[1fr_180px_auto]">
                    @csrf
                    <input name="nama_jabatan" required class="h-10 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20" placeholder="Nama jabatan baru">
                    <select name="kategori" class="h-10 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3 text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                        <option value="Struktural">Struktural</option>
                        <option value="Jabatan Fungsional">Jabatan Fungsional</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <button type="submit" class="h-10 rounded-lg bg-[#35635b] dark:bg-[#107050] px-4 text-sm font-bold text-white transition hover:bg-[#2b4f49] cursor-pointer">Tambah</button>
                </form>

                <div class="mt-5">
                    <div class="relative mb-3">
                        <input type="text" id="search-jabatan" placeholder="Cari jabatan..." class="w-full h-9 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] pl-8 pr-3 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20 placeholder-gray-400 dark:placeholder-gray-500">
                        <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    
                    <div class="border border-gray-200 dark:border-[#284c43] rounded-lg overflow-hidden">
                        <table class="w-full text-left text-xs text-gray-500 dark:text-gray-300">
                            <thead class="bg-gray-50 dark:bg-[#1b3832] text-gray-700 dark:text-white uppercase font-bold">
                                <tr>
                                    <th class="px-4 py-3 font-bold w-12">No</th>
                                    <th class="px-4 py-3 font-bold">Nama Jabatan</th>
                                    <th class="px-4 py-3 font-bold w-32">Kategori</th>
                                    <th class="px-4 py-3 font-bold text-center w-20">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="container-jabatan" class="max-h-72 overflow-y-auto custom-scrollbar bg-white dark:bg-[#152420]">
                            <table class="w-full text-left text-xs text-gray-500 dark:text-gray-300">
                                <tbody class="divide-y divide-gray-200 dark:divide-[#233a34]">
                                    @forelse (($jabatanMaster ?? collect()) as $index => $jabatan)
                                        <tr class="item-jabatan hover:bg-gray-50 dark:hover:bg-[#1b332d] transition" data-name="{{ strtolower($jabatan->nama_jabatan . ' ' . $jabatan->kategori) }}">
                                            <td class="px-4 py-3 w-12 text-center">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">{{ $jabatan->nama_jabatan }}</td>
                                            <td class="px-4 py-3 w-32"><span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 dark:bg-[#1a2d29] text-gray-600 dark:text-gray-300">{{ $jabatan->kategori ?: 'Lainnya' }}</span></td>
                                            <td class="px-4 py-3 w-20 text-center">
                                                <form method="POST" action="{{ route('admin.pengaturan.jabatan.destroy', $jabatan->id_jabatan) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus jabatan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1 bg-red-50 dark:bg-red-950/40 rounded hover:bg-red-100 dark:hover:bg-red-900/60 transition cursor-pointer" title="Hapus jabatan">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-4 text-center text-xs text-gray-500 dark:text-gray-400">Belum ada master jabatan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function initMasterList(type) {
        const searchInput = document.getElementById(`search-${type}`);
        if (searchInput) {
            searchInput.addEventListener('input', () => renderMasterList(type));
        }
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

    document.addEventListener('DOMContentLoaded', function() {
        initMasterList('bidang');
        initMasterList('jabatan');
    });
</script>
@endpush
@endsection
