@php
    $settingAlamat = \App\Services\AppSetting::get('sirapi_alamat', 'Jl. Tegar Beriman No.1, Pakansari, Kec. Cibinong, Kabupaten Bogor, Jawa Barat 16914');
    $settingTelepon = \App\Services\AppSetting::get('sirapi_telepon', '(021) 8758605');
    $settingEmail = \App\Services\AppSetting::get('sirapi_email', 'diskominfo@bogorkab.go.id');
    $settingInstagram = \App\Services\AppSetting::get('sirapi_instagram_url', 'https://www.instagram.com/diskominfokabbogor?igsh=MXNkbDF1dDIyN3FrZg==');
    $settingFacebook = \App\Services\AppSetting::get('sirapi_facebook_url', 'https://www.facebook.com/share/1RYDNtxEpS/');
    $settingYoutube = \App\Services\AppSetting::get('sirapi_youtube_channel_url', 'https://youtube.com/@kabupatenbogor?si=PAPn9ARUMrvRwMYy');

    $settingBidangMaster = \App\Models\Bidang::orderBy('nama_bidang')->get();
    $settingJabatanMaster = \App\Models\Jabatan::orderByRaw("
            CASE
                WHEN kategori = 'Struktural' THEN 0
                WHEN kategori = 'Jabatan Fungsional' THEN 1
                ELSE 2
            END
        ")
        ->orderBy('nama_jabatan')
        ->get();

    $activeTab = session('setting_tab', 'publik');
@endphp

<!-- Modal Popup Pengaturan (Top Corner Trigger) -->
<div id="modal-setting-popup" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-4xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        
        <!-- Modal Header -->
        <div class="flex items-start justify-between border-b border-gray-100 dark:border-[#233a34] px-5 py-4 sm:px-6 sm:py-5 bg-white dark:bg-[#152420] shrink-0">
            <div class="flex items-center gap-3.5">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-[#35635b] dark:text-emerald-400 shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-extrabold text-gray-900 dark:text-white leading-tight">Pengaturan Aplikasi</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola informasi publik dan data master aplikasi RAPID</p>
                </div>
            </div>
            
            <button type="button" onclick="closeModal('modal-setting-popup')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 cursor-pointer" aria-label="Tutup modal">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Tab Switcher Header (Kunker Filter Style) -->
        <div class="px-5 py-3 border-b border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#0f1c19] flex items-center gap-2 overflow-x-auto shrink-0 scrollbar-none">
            <button type="button" id="tab-btn-publik" onclick="switchPopupSettingTab('publik')"
                class="px-5 py-2 rounded-full text-xs font-extrabold transition-all whitespace-nowrap cursor-pointer {{ $activeTab === 'publik' ? 'bg-[#35635b] text-white shadow-sm' : 'bg-white dark:bg-[#152420] text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
                Pengaturan Publik
            </button>
            <button type="button" id="tab-btn-admin" onclick="switchPopupSettingTab('admin')"
                class="px-5 py-2 rounded-full text-xs font-extrabold transition-all whitespace-nowrap cursor-pointer {{ $activeTab === 'admin' ? 'bg-[#35635b] text-white shadow-sm' : 'bg-white dark:bg-[#152420] text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 border border-gray-200 dark:border-[#284c43]' }}">
                Pengaturan Admin (Master Data)
            </button>
        </div>

        <!-- Modal Body Content -->
        <div class="flex-1 min-h-0 overflow-y-auto p-5 sm:p-6 custom-scrollbar">
            
            <!-- TAB 1: PENGATURAN PUBLIK -->
            <div id="tab-content-publik" class="{{ $activeTab === 'publik' ? 'block' : 'hidden' }} space-y-5">
                <div class="border-b border-gray-100 dark:border-[#233a34] pb-3">
                    <h4 class="text-sm font-extrabold text-gray-800 dark:text-white">Informasi Kontak Footer Publik</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Ubah alamat kantor, nomor telepon, dan email yang tampil pada bagian bawah (footer) halaman publik.</p>
                </div>

                <form method="POST" action="{{ route('admin.pengaturan.publik.update') }}" class="space-y-4">
                    @csrf
                    
                    <div class="space-y-1">
                        <label for="popup_alamat" class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300">Alamat Kantor</label>
                        <textarea id="popup_alamat" name="alamat" rows="2" required
                            class="w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] p-3 text-xs sm:text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">{{ old('alamat', $settingAlamat) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="popup_telepon" class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300">Nomor Telepon</label>
                            <input id="popup_telepon" name="telepon" type="text" value="{{ old('telepon', $settingTelepon) }}" required
                                class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                        </div>

                        <div class="space-y-1">
                            <label for="popup_email" class="block text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300">Email Instansi</label>
                            <input id="popup_email" name="email" type="email" value="{{ old('email', $settingEmail) }}" required
                                class="h-10 w-full rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-700 dark:text-white outline-none transition focus:border-[#35635b] focus:ring-2 focus:ring-[#35635b]/20">
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-100 dark:border-[#233a34] space-y-3">
                        <h4 class="text-xs font-extrabold uppercase tracking-wider text-gray-500 dark:text-gray-400">Media Sosial</h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="space-y-1">
                                <label for="popup_instagram_url" class="block text-xs font-bold text-gray-600 dark:text-gray-300">Instagram</label>
                                <input id="popup_instagram_url" name="instagram_url" type="url" value="{{ old('instagram_url', $settingInstagram) }}"
                                    class="h-9 w-full rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b]">
                            </div>

                            <div class="space-y-1">
                                <label for="popup_facebook_url" class="block text-xs font-bold text-gray-600 dark:text-gray-300">Facebook</label>
                                <input id="popup_facebook_url" name="facebook_url" type="url" value="{{ old('facebook_url', $settingFacebook) }}"
                                    class="h-9 w-full rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b]">
                            </div>

                            <div class="space-y-1">
                                <label for="popup_youtube_url" class="block text-xs font-bold text-gray-600 dark:text-gray-300">YouTube</label>
                                <input id="popup_youtube_url" name="youtube_url" type="url" value="{{ old('youtube_url', $settingYoutube) }}"
                                    class="h-9 w-full rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] px-3 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b]">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] text-white font-bold py-2 px-5 rounded-xl transition shadow-xs text-xs cursor-pointer">
                            Simpan Pengaturan Publik
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 2: PENGATURAN ADMIN (MASTER DATA) -->
            <div id="tab-content-admin" class="{{ $activeTab === 'admin' ? 'block' : 'hidden' }} grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Master Bidang -->
                <section class="bg-gray-50/60 dark:bg-[#0f1c19] rounded-xl border border-gray-200 dark:border-[#233a34] p-4">
                    <div class="flex flex-col gap-0.5">
                        <h4 class="text-sm font-extrabold text-gray-800 dark:text-white">Master Bidang</h4>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">Opsi bidang untuk form data pegawai</p>
                    </div>

                    <form method="POST" action="{{ route('admin.pengaturan.bidang.store') }}" class="mt-3 flex gap-2">
                        @csrf
                        <input name="nama_bidang" required class="h-9 min-w-0 flex-1 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#152420] px-3 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b]" placeholder="Nama bidang baru">
                        <button type="submit" class="h-9 rounded-lg bg-[#35635b] dark:bg-[#107050] px-3.5 text-xs font-bold text-white transition hover:bg-[#2b4f49] cursor-pointer shrink-0">Tambah</button>
                    </form>

                    <div class="mt-3">
                        <div class="relative mb-2">
                            <input type="text" id="popup-search-bidang" placeholder="Cari bidang..." class="w-full h-8 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#152420] pl-8 pr-3 text-[11px] text-gray-700 dark:text-white outline-none transition focus:border-[#35635b]">
                            <svg class="absolute left-2.5 top-2 h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        
                        <div class="border border-gray-200 dark:border-[#284c43] rounded-lg overflow-hidden bg-white dark:bg-[#152420]">
                            <table class="w-full text-left text-xs text-gray-500 dark:text-gray-300">
                                <thead class="bg-gray-100 dark:bg-[#1b3832] text-gray-700 dark:text-white uppercase font-bold text-[10px]">
                                    <tr>
                                        <th class="px-3 py-2 w-10 text-center">No</th>
                                        <th class="px-3 py-2">Nama Bidang</th>
                                        <th class="px-3 py-2 text-center w-16">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="popup-container-bidang" class="max-h-44 overflow-y-auto custom-scrollbar">
                                <table class="w-full text-left text-xs text-gray-500 dark:text-gray-300">
                                    <tbody class="divide-y divide-gray-100 dark:divide-[#233a34]">
                                        @forelse (($settingBidangMaster ?? collect()) as $index => $bidang)
                                            <tr class="popup-item-bidang hover:bg-gray-50 dark:hover:bg-[#1b332d] transition" data-name="{{ strtolower($bidang->nama_bidang) }}">
                                                <td class="px-3 py-2 w-10 text-center text-[11px]">{{ $index + 1 }}</td>
                                                <td class="px-3 py-2 font-medium text-gray-800 dark:text-white text-xs">{{ $bidang->nama_bidang }}</td>
                                                <td class="px-3 py-2 w-16 text-center">
                                                    <form method="POST" action="{{ route('admin.pengaturan.bidang.destroy', $bidang->id_bidang) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus bidang ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1 bg-red-50 dark:bg-red-950/40 rounded hover:bg-red-100 dark:hover:bg-red-900/60 transition cursor-pointer" title="Hapus bidang">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-3 py-3 text-center text-xs text-gray-500 dark:text-gray-400">Belum ada master bidang.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Master Jabatan -->
                <section class="bg-gray-50/60 dark:bg-[#0f1c19] rounded-xl border border-gray-200 dark:border-[#233a34] p-4">
                    <div class="flex flex-col gap-0.5">
                        <h4 class="text-sm font-extrabold text-gray-800 dark:text-white">Master Jabatan</h4>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">Opsi jabatan untuk form data pegawai</p>
                    </div>

                    <form method="POST" action="{{ route('admin.pengaturan.jabatan.store') }}" class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-[1fr_130px_auto]">
                        @csrf
                        <input name="nama_jabatan" required class="h-9 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#152420] px-3 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b]" placeholder="Nama jabatan baru">
                        <select name="kategori" class="h-9 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#152420] px-2 text-xs text-gray-700 dark:text-white outline-none transition focus:border-[#35635b]">
                            <option value="Struktural">Struktural</option>
                            <option value="Jabatan Fungsional">Fungsional</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <button type="submit" class="h-9 rounded-lg bg-[#35635b] dark:bg-[#107050] px-3.5 text-xs font-bold text-white transition hover:bg-[#2b4f49] cursor-pointer">Tambah</button>
                    </form>

                    <div class="mt-3">
                        <div class="relative mb-2">
                            <input type="text" id="popup-search-jabatan" placeholder="Cari jabatan..." class="w-full h-8 rounded-lg border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#152420] pl-8 pr-3 text-[11px] text-gray-700 dark:text-white outline-none transition focus:border-[#35635b]">
                            <svg class="absolute left-2.5 top-2 h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        
                        <div class="border border-gray-200 dark:border-[#284c43] rounded-lg overflow-hidden bg-white dark:bg-[#152420]">
                            <table class="w-full text-left text-xs text-gray-500 dark:text-gray-300">
                                <thead class="bg-gray-100 dark:bg-[#1b3832] text-gray-700 dark:text-white uppercase font-bold text-[10px]">
                                    <tr>
                                        <th class="px-3 py-2 w-10 text-center">No</th>
                                        <th class="px-3 py-2">Nama Jabatan</th>
                                        <th class="px-3 py-2 w-24">Kategori</th>
                                        <th class="px-3 py-2 text-center w-16">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="popup-container-jabatan" class="max-h-44 overflow-y-auto custom-scrollbar">
                                <table class="w-full text-left text-xs text-gray-500 dark:text-gray-300">
                                    <tbody class="divide-y divide-gray-100 dark:divide-[#233a34]">
                                        @forelse (($settingJabatanMaster ?? collect()) as $index => $jabatan)
                                            <tr class="popup-item-jabatan hover:bg-gray-50 dark:hover:bg-[#1b332d] transition" data-name="{{ strtolower($jabatan->nama_jabatan . ' ' . $jabatan->kategori) }}">
                                                <td class="px-3 py-2 w-10 text-center text-[11px]">{{ $index + 1 }}</td>
                                                <td class="px-3 py-2 font-medium text-gray-800 dark:text-white text-xs">{{ $jabatan->nama_jabatan }}</td>
                                                <td class="px-3 py-2 w-24"><span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold bg-gray-100 dark:bg-[#1a2d29] text-gray-600 dark:text-gray-300">{{ $jabatan->kategori ?: 'Lainnya' }}</span></td>
                                                <td class="px-3 py-2 w-16 text-center">
                                                    <form method="POST" action="{{ route('admin.pengaturan.jabatan.destroy', $jabatan->id_jabatan) }}" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus jabatan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1 bg-red-50 dark:bg-red-950/40 rounded hover:bg-red-100 dark:hover:bg-red-900/60 transition cursor-pointer" title="Hapus jabatan">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-3 py-3 text-center text-xs text-gray-500 dark:text-gray-400">Belum ada master jabatan.</td>
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

        <!-- Modal Footer -->
        <div class="flex justify-end items-center border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#0f1c19] px-5 py-3 shrink-0">
            <button type="button" onclick="closeModal('modal-setting-popup')" class="h-9 rounded-xl px-5 text-xs font-bold text-gray-600 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-200 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    function switchPopupSettingTab(tab) {
        const publikTabBtn = document.getElementById('tab-btn-publik');
        const adminTabBtn = document.getElementById('tab-btn-admin');
        const publikContent = document.getElementById('tab-content-publik');
        const adminContent = document.getElementById('tab-content-admin');

        const activeClasses = ['bg-[#35635b]', 'text-white', 'shadow-sm'];
        const inactiveClasses = ['bg-white', 'dark:bg-[#152420]', 'text-gray-600', 'dark:text-gray-300', 'hover:bg-gray-100', 'dark:hover:bg-white/10', 'border', 'border-gray-200', 'dark:border-[#284c43]'];

        if (tab === 'publik') {
            publikContent.classList.remove('hidden');
            publikContent.classList.add('block');
            adminContent.classList.remove('block');
            adminContent.classList.add('hidden');

            publikTabBtn.classList.add(...activeClasses);
            publikTabBtn.classList.remove(...inactiveClasses);

            adminTabBtn.classList.remove(...activeClasses);
            adminTabBtn.classList.add(...inactiveClasses);
        } else {
            adminContent.classList.remove('hidden');
            adminContent.classList.add('block');
            publikContent.classList.remove('block');
            publikContent.classList.add('hidden');

            adminTabBtn.classList.add(...activeClasses);
            adminTabBtn.classList.remove(...inactiveClasses);

            publikTabBtn.classList.remove(...activeClasses);
            publikTabBtn.classList.add(...inactiveClasses);
        }
    }

    function initPopupMasterList(type) {
        const searchInput = document.getElementById(`popup-search-${type}`);
        const container = document.getElementById(`popup-container-${type}`);
        if (!searchInput || !container) return;

        searchInput.addEventListener('input', function() {
            const items = container.querySelectorAll(`.popup-item-${type}`);
            const searchTerm = this.value.toLowerCase();
            
            items.forEach((item) => {
                const name = item.dataset.name || '';
                if (name.includes(searchTerm)) {
                    item.style.display = 'table-row';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initPopupMasterList('bidang');
        initPopupMasterList('jabatan');

        @if(session('setting_tab'))
            openModal('modal-setting-popup');
            switchPopupSettingTab("{{ session('setting_tab') }}");
        @endif
    });
</script>
