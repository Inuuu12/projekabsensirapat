<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kunjungan - Daftar Kunjungan</title>
    <!-- Tailwind CSS v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased flex min-h-screen">

    <!-- ==================== SIDEBAR LEFT ==================== -->
    <aside class="w-64 bg-[#3b6f6c] text-white flex flex-col justify-between p-5 shrink-0 shadow-lg">
        <div>
            <!-- Branding Bappenda -->
            <div class="flex items-center space-x-3 pb-6 border-b border-white/20 mb-6">
                <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Bappenda" class="h-12 w-auto">
                <div>
                    <h1 class="text-sm font-extrabold tracking-wide uppercase">Bappenda</h1>
                    <p class="text-[10px] text-gray-200 tracking-wider">KABUPATEN BOGOR</p>
                </div>
            </div>

            <!-- Menu Navigasi -->
            <nav class="space-y-1 text-sm">
                <a href="/admin/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg opacity-80 hover:opacity-100 transition-all font-medium">
                    <span>📊</span> <span>Dashboard</span>
                </a>
                
                <!-- Menu Agenda Dropdown -->
                <div>
                    <div class="flex items-center justify-between px-4 py-3 rounded-lg opacity-80 hover:opacity-100 cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <span>📅</span> <span>Agenda</span>
                        </div>
                        <span class="text-xs">▼</span>
                    </div>
                </div>

                <!-- Menu Data Pengguna Dropdown -->
                <div>
                    <div class="flex items-center justify-between px-4 py-3 rounded-lg opacity-80 hover:opacity-100 cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <span>👥</span> <span>Data Pengguna</span>
                        </div>
                        <span class="text-xs">▼</span>
                    </div>
                </div>

                <!-- Menu Kunjungan Utama Aktif (Style Oval Grayish/White-20) -->
                <a href="/admin/daftarkunjungan" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-bold bg-white/20 text-white transition-all">
                    <span>🏢</span> <span>Kunjungan</span>
                </a>
                
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg opacity-80 hover:opacity-100 transition-all font-medium">
                    <span>💬</span> <span>Umpan Balik</span>
                </a>
            </nav>
        </div>

        <!-- Tombol Keluar Kiri Bawah -->
        <form method="POST" action="/admin/logout" class="border-t border-white/10 pt-4">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2.5 rounded-lg text-left opacity-80 hover:opacity-100 transition-all hover:bg-black/10">
                <span>🚪</span> <span class="text-sm font-semibold">Keluar</span>
            </button>
        </form>
    </aside>

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="flex-1 p-8 overflow-y-auto">
        
        <!-- Header Utama & Profile Admin -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Daftar Kunjungan</h2>
                <p class="text-xs text-gray-400 mt-1">Kelola data kunjungan dinas dan publik BAPPENDA.</p>
            </div>
            <!-- Profile Card -->
            <div class="flex items-center space-x-3 bg-[#3b6f6c]/10 px-4 py-2 rounded-full border border-[#3b6f6c]/20 max-w-xs shadow-sm">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=100&auto=format&fit=crop" alt="Admin" class="w-9 h-9 rounded-full object-cover">
                <div class="text-xs">
                    <p class="font-extrabold text-gray-800">{{ $admin->nama ?? $admin->username ?? 'Admin' }}</p>
                    <p class="text-[10px] text-gray-400 font-medium">Super Admin</p>
                </div>
            </div>
        </div>

        <!-- TAMPILAN GREEN ACTION BUTTON (Tambah Kunjungan) -->
        <div class="flex justify-end mb-6">
            <button onclick="openModal('modalTambahKunjungan')" class="bg-[#52c462] hover:bg-[#43a851] text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center space-x-1.5 transition-transform active:scale-98">
                <span class="text-sm font-light">+</span> <span>Tambah Kunjungan</span>
            </button>
        </div>

        <!-- KARTU STATISTIK KUNJUNGAN -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Total Kunjungan -->
            <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-xs flex items-center space-x-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl font-bold">👥</div>
                <div>
                    <p class="text-[11px] text-gray-400 font-bold tracking-wide uppercase">Total Kunjungan</p>
                    <p class="text-2xl font-extrabold text-gray-800 mt-0.5">1,284</p>
                </div>
            </div>
            <!-- Kunjungan Hari Ini -->
            <div class="bg-white border border-gray-100 p-5 rounded-2xl shadow-xs flex items-center space-x-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl font-bold">📅</div>
                <div>
                    <p class="text-[11px] text-gray-400 font-bold tracking-wide uppercase">Hari Ini</p>
                    <p class="text-2xl font-extrabold text-gray-800 mt-0.5">24</p>
                </div>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div class="bg-white border border-gray-100 p-4 rounded-t-2xl shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3 text-xs font-bold text-gray-600">
                <span>Filter by:</span>
                <div class="relative">
                    <select class="bg-gray-50 border border-gray-200 text-xs px-4 py-2 rounded-xl text-gray-600 appearance-none pr-8 focus:outline-none">
                        <option>Semua Status</option>
                        <option>Selesai</option>
                        <option>Pending</option>
                    </select>
                    <span class="absolute right-3 top-2.5 text-[8px] pointer-events-none text-gray-400">▼</span>
                </div>
                <div>
                    <input type="date" class="bg-gray-50 border border-gray-200 text-xs px-4 py-2 rounded-xl text-gray-400 focus:outline-none">
                </div>
            </div>

            <div class="flex items-center space-x-2 text-xs font-bold text-gray-600">
                <button class="border border-gray-200 bg-white hover:bg-gray-50 p-2 rounded-xl flex items-center justify-center shadow-xs">
                    <span>⏳</span>
                </button>
                <button class="border border-gray-200 bg-white hover:bg-gray-50 p-2 rounded-xl flex items-center justify-center shadow-xs">
                    <span>📥</span>
                </button>
            </div>
        </div>

        <!-- DATATABLE DAFTAR KUNJUNGAN -->
        <div class="bg-white border-x border-b border-gray-100 rounded-b-2xl shadow-xs overflow-hidden">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#4a7a77] text-white font-bold uppercase tracking-wider text-[10px]">
                        <th class="p-4 pl-6">Nama</th>
                        <th class="p-4">Keperluan</th>
                        <th class="p-4">Pihak Dituju</th>
                        <th class="p-4 text-center">Waktu</th>
                        <th class="p-4 text-center">Tanggal</th>
                        <th class="p-4">Instansi</th>
                        <th class="p-4 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 font-medium">
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-gray-900 font-bold">Budi Santoso</td>
                        <td class="p-4 text-gray-600 max-w-xs truncate">Koordinasi Pengelolaan Hutan Lindung Wilayah Timur</td>
                        <td class="p-4 text-gray-600">Bidang ..</td>
                        <td class="p-4 text-center text-gray-500 font-mono">11:00</td>
                        <td class="p-4 text-center text-gray-500 font-mono">12/10/2023</td>
                        <td class="p-4 text-gray-600">Dinas Kehutanan</td>
                        <td class="p-4 text-center space-x-3">
                            <button onclick="openModal('modalDetailKunjungan')" class="text-gray-500 hover:text-gray-700 text-sm">👁️</button>
                            <button onclick="openModal('modalEditKunjungan')" class="text-gray-500 hover:text-gray-700 text-sm">✏️</button>
                            <button onclick="openModal('modalHapusKunjungan')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-gray-900 font-bold">Siti Aminah</td>
                        <td class="p-4 text-gray-600 max-w-xs truncate">Audiensi Kelompok Tani Hutan Desa Makmur</td>
                        <td class="p-4 text-gray-600">Kadis..</td>
                        <td class="p-4 text-center text-gray-500 font-mono">13:30</td>
                        <td class="p-4 text-center text-gray-500 font-mono">14/10/2023</td>
                        <td class="p-4 text-gray-600">Dinas Lingkungan Hidup</td>
                        <td class="p-4 text-center space-x-3">
                            <button onclick="openModal('modalDetailKunjungan')" class="text-gray-500 hover:text-gray-700 text-sm">👁️</button>
                            <button onclick="openModal('modalEditKunjungan')" class="text-gray-500 hover:text-gray-700 text-sm">✏️</button>
                            <button onclick="openModal('modalHapusKunjungan')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-gray-900 font-bold">Andi Wijaya</td>
                        <td class="p-4 text-gray-600 max-w-xs truncate">Survei Lapangan Penentuan Batas Kawasan</td>
                        <td class="p-4 text-gray-600">bidang..</td>
                        <td class="p-4 text-center text-gray-500 font-mono">14:00</td>
                        <td class="p-4 text-center text-gray-500 font-mono">15/10/2023</td>
                        <td class="p-4 text-gray-600">Dinas Kehutanan</td>
                        <td class="p-4 text-center space-x-3">
                            <button onclick="openModal('modalDetailKunjungan')" class="text-gray-500 hover:text-gray-700 text-sm">👁️</button>
                            <button onclick="openModal('modalEditKunjungan')" class="text-gray-500 hover:text-gray-700 text-sm">✏️</button>
                            <button onclick="openModal('modalHapusKunjungan')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                    <!-- Row 4 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-gray-900 font-bold">Rina Permata</td>
                        <td class="p-4 text-gray-600 max-w-xs truncate">Penandatanganan MOU Reboisasi Swadaya</td>
                        <td class="p-4 text-gray-600">kabid..</td>
                        <td class="p-4 text-center text-gray-500 font-mono">10:30</td>
                        <td class="p-4 text-center text-gray-500 font-mono">18/10/2023</td>
                        <td class="p-4 text-gray-600">Dinas Kehutanan</td>
                        <td class="p-4 text-center space-x-3">
                            <button onclick="openModal('modalDetailKunjungan')" class="text-gray-500 hover:text-gray-700 text-sm">👁️</button>
                            <button onclick="openModal('modalEditKunjungan')" class="text-gray-500 hover:text-gray-700 text-sm">✏️</button>
                            <button onclick="openModal('modalHapusKunjungan')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- ==================== MODAL: TAMBAH KUNJUNGAN ==================== -->
    <div id="modalTambahKunjungan" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden m-4">
            <div class="bg-[#4a7a77] text-white px-6 py-4 flex justify-between items-center">
                <h3 class="font-extrabold text-sm tracking-wide">Tambah Kunjungan</h3>
                <button onclick="closeModal('modalTambahKunjungan')" class="text-white/80 hover:text-white text-lg font-bold">&times;</button>
            </div>
            
            <form action="#" method="POST" class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Nama Pengunjung <span class="text-rose-500">*</span></label>
                    <input type="text" placeholder="Masukkan nama lengkap pengunjung" class="w-full bg-white border border-gray-300 p-2.5 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Pihak Dituju</label>
                    <input type="text" placeholder="Masukkan nama atau nama bidang pihak yang dituju" class="w-full bg-white border border-gray-300 p-2.5 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Keperluan <span class="text-rose-500">*</span></label>
                    <textarea rows="3" placeholder="Jelaskan secara singkat keperluan kunjungan..." class="w-full bg-white border border-gray-300 p-2.5 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c] resize-none"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Tanggal Kunjungan <span class="text-rose-500">*</span></label>
                        <input type="date" class="w-full bg-white border border-gray-300 p-2.5 rounded-lg text-xs text-gray-500 focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Waktu <span class="text-rose-500">*</span></label>
                        <input type="time" class="w-full bg-white border border-gray-300 p-2.5 rounded-lg text-xs text-gray-500 focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Instansi Asal <span class="text-rose-500">*</span></label>
                    <input type="text" placeholder="Contoh: Dinas Kehutanan, Universitas..." class="w-full bg-white border border-gray-300 p-2.5 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                </div>

                <!-- Footer Modal -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100 text-xs font-bold">
                    <button type="button" onclick="closeModal('modalTambahKunjungan')" class="border border-gray-200 text-gray-500 py-2.5 px-5 rounded-lg hover:bg-gray-50">Batal</button>
                    <button type="submit" class="bg-[#2e624c] hover:bg-[#204938] text-white py-2.5 px-5 rounded-lg flex items-center space-x-1.5 shadow">
                        <span>💾</span> <span>Simpan Kunjungan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL: EDIT KUNJUNGAN ==================== -->
    <div id="modalEditKunjungan" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden m-4">
            <div class="bg-[#4a7a77] text-white px-6 py-4 flex justify-between items-center">
                <h3 class="font-extrabold text-sm tracking-wide">Edit Kunjungan</h3>
                <button onclick="closeModal('modalEditKunjungan')" class="text-white/80 hover:text-white text-lg font-bold">&times;</button>
            </div>
            
            <form action="#" method="POST" class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Nama Pengunjung <span class="text-rose-500">*</span></label>
                    <input type="text" value="Budi Santoso" class="w-full bg-white border border-gray-300 p-2.5 rounded-lg text-xs focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Pihak Dituju</label>
                    <input type="text" value="Bidang .." class="w-full bg-white border border-gray-300 p-2.5 rounded-lg text-xs focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Keperluan <span class="text-rose-500">*</span></label>
                    <textarea rows="3" class="w-full bg-white border border-gray-300 p-2.5 rounded-lg text-xs focus:outline-none resize-none">Koordinasi Pengelolaan Hutan Lindung Wilayah Timur</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Tanggal Kunjungan <span class="text-rose-500">*</span></label>
                        <input type="date" value="2023-10-12" class="w-full bg-white border border-gray-300 p-2.5 rounded-lg text-xs focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Waktu <span class="text-rose-500">*</span></label>
                        <input type="time" value="11:00" class="w-full bg-white border border-gray-300 p-2.5 rounded-lg text-xs focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1">Instansi Asal <span class="text-rose-500">*</span></label>
                    <input type="text" value="Dinas Kehutanan" class="w-full bg-white border border-gray-300 p-2.5 rounded-lg text-xs focus:outline-none">
                </div>

                <!-- Footer Modal -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100 text-xs font-bold">
                    <button type="button" onclick="closeModal('modalEditKunjungan')" class="border border-gray-200 text-gray-500 py-2.5 px-5 rounded-lg hover:bg-gray-50">Batal</button>
                    <button type="submit" class="bg-[#2e624c] hover:bg-[#204938] text-white py-2.5 px-5 rounded-lg flex items-center space-x-1.5 shadow">
                        <span>💾</span> <span>Simpan Kunjungan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL: HAPUS KUNJUNGAN ==================== -->
    <div id="modalHapusKunjungan" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center m-4">
            <div class="w-12 h-12 bg-rose-50 border border-rose-200 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">⚠️</div>
            <h3 class="text-sm font-extrabold text-gray-800">Hapus Kunjungan?</h3>
            <p class="text-xs text-gray-400 mt-2">Apakah Anda yakin ingin menghapus kunjungan ini?</p>
            <div class="flex justify-center space-x-3 mt-6 text-xs font-bold">
                <button type="button" onclick="closeModal('modalHapusKunjungan')" class="border border-gray-200 text-gray-600 py-2.5 px-5 rounded-lg hover:bg-gray-50">Batal</button>
                <form action="#" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-rose-700 hover:bg-rose-800 text-white py-2.5 px-5 rounded-lg shadow">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Open/Close Modals -->
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>

</body>
</html>