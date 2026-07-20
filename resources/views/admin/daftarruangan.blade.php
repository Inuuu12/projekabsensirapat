<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda - Daftar Ruang</title>
    <!-- Tailwind CSS v4 sesuai login & daftaragenda -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased flex min-h-screen">
    <x-admin.sidebar active="ruang" />

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="flex-1 p-8 overflow-y-auto">
        <x-admin.navbar title="Daftar Ruangan" subtitle="Selamat datang kembali, Admin!" />

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border border-gray-100 p-4 rounded-xl shadow-xs flex items-center space-x-4">
                <div class="p-3 bg-slate-100 rounded-xl text-lg text-slate-600">🏢</div>
                <div>
                    <p class="text-xs font-bold text-gray-400">Total Ruangan</p>
                    <p class="text-xl font-black text-gray-800 mt-0.5">12</p>
                </div>
            </div>
            <div class="bg-white border border-gray-100 p-4 rounded-xl shadow-xs flex items-center space-x-4">
                <div class="p-3 bg-emerald-50 rounded-xl text-lg text-emerald-600">✓</div>
                <div>
                    <p class="text-xs font-bold text-gray-400">Tersedia</p>
                    <p class="text-xl font-black text-gray-800 mt-0.5">8</p>
                </div>
            </div>
            <div class="bg-white border border-gray-100 p-4 rounded-xl shadow-xs flex items-center space-x-4">
                <div class="p-3 bg-amber-50 rounded-xl text-lg text-amber-500">📅</div>
                <div>
                    <p class="text-xs font-bold text-gray-400">Digunakan</p>
                    <p class="text-xl font-black text-gray-800 mt-0.5">4</p>
                </div>
            </div>
            <div class="bg-white border border-gray-100 p-4 rounded-xl shadow-xs flex items-center space-x-4">
                <div class="p-3 bg-rose-50 rounded-xl text-lg text-rose-600">🛠️</div>
                <div>
                    <p class="text-xs font-bold text-gray-400">Maintenance</p>
                    <p class="text-xl font-black text-gray-800 mt-0.5">0</p>
                </div>
            </div>
        </div>

        <!-- ACTION CONTROLS (Tambah Ruang, Filter, Search) -->
        <div class="flex justify-between items-center mb-4">
            <!-- Filter Kiri -->
            <div class="bg-gray-200/50 p-1 rounded-xl flex space-x-1 text-xs font-bold text-gray-500">
                <button class="bg-white text-gray-800 px-4 py-2 rounded-lg shadow-xs">Semua</button>
                <button class="px-4 py-2 hover:text-gray-800">Tersedia</button>
                <button class="px-4 py-2 hover:text-gray-800">Digunakan</button>
            </div>
            
            <!-- Tombol Tambah Ruang Hijau Cerah -->
            <button onclick="openModal('modalTambah')" class="bg-[#52c462] hover:bg-[#43a851] text-white text-xs font-extrabold px-4 py-2.5 rounded-xl shadow-md flex items-center space-x-2 transition-transform active:scale-98">
                <span class="text-sm font-light">+</span> <span>Tambah Ruang</span>
            </button>
        </div>

        <div class="flex space-x-2 mb-4 justify-end">
            <!-- Search & Filter Lanjut -->
            <div class="relative">
                <input type="text" placeholder="Cari ruangan..." class="bg-gray-200/50 text-xs pl-8 pr-4 py-2.5 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3b6f6c] w-64">
                <span class="absolute left-3 top-3 text-xs opacity-40">🔍</span>
            </div>
            <button class="border border-gray-200 bg-white hover:bg-gray-50 text-gray-600 text-xs font-bold px-4 py-2.5 rounded-xl flex items-center space-x-2 shadow-xs">
                <span>⚡</span> <span>Filter Lanjut</span>
            </button>
        </div>

        <!-- DATATABLE DATA RUANGAN -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-xs overflow-hidden">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#3b6f6c] text-white font-bold">
                        <th class="p-4 pl-6 tracking-wide">Nama Ruangan</th>
                        <th class="p-4 tracking-wide">Kapasitas</th>
                        <th class="p-4 tracking-wide">Status</th>
                        <th class="p-4 text-center tracking-wide w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                    <!-- Item 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 font-bold text-gray-900 flex items-center space-x-3">
                            <span class="p-2.5 bg-cyan-50 border border-cyan-100 text-cyan-700 rounded-xl text-sm">🏢</span>
                            <span>Ruang Rapat Utama</span>
                        </td>
                        <td class="p-4 text-gray-500 font-semibold">20 Orang</td>
                        <td class="p-4">
                            <span class="bg-emerald-50 text-emerald-600 font-extrabold px-3 py-1 rounded-full text-[10px] tracking-wide border border-emerald-100">• Tersedia</span>
                        </td>
                        <td class="p-4 text-center space-x-2">
                            <button onclick="openModal('modalEdit')" class="text-emerald-600 hover:text-emerald-800 text-sm">✏️</button>
                            <button onclick="openModal('modalHapus')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                    <!-- Item 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 font-bold text-gray-900 flex items-center space-x-3">
                            <span class="p-2.5 bg-cyan-50 border border-cyan-100 text-cyan-700 rounded-xl text-sm">🎭</span>
                            <span>Aula Serbaguna</span>
                        </td>
                        <td class="p-4 text-gray-500 font-semibold">100 Orang</td>
                        <td class="p-4">
                            <span class="bg-rose-50 text-rose-500 font-extrabold px-3 py-1 rounded-full text-[10px] tracking-wide border border-rose-100">• Digunakan</span>
                        </td>
                        <td class="p-4 text-center space-x-2">
                            <button onclick="openModal('modalEdit')" class="text-emerald-600 hover:text-emerald-800 text-sm">✏️</button>
                            <button onclick="openModal('modalHapus')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                    <!-- Item 3 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 font-bold text-gray-900 flex items-center space-x-3">
                            <span class="p-2.5 bg-cyan-50 border border-cyan-100 text-cyan-700 rounded-xl text-sm">👤</span>
                            <span>Ruang Kabid</span>
                        </td>
                        <td class="p-4 text-gray-500 font-semibold">5 Orang</td>
                        <td class="p-4">
                            <span class="bg-amber-50 text-amber-600 font-extrabold px-3 py-1 rounded-full text-[10px] tracking-wide border border-amber-100">• Perawatan</span>
                        </td>
                        <td class="p-4 text-center space-x-2">
                            <button onclick="openModal('modalEdit')" class="text-emerald-600 hover:text-emerald-800 text-sm">✏️</button>
                            <button onclick="openModal('modalHapus')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- ==================== MODAL TEMPLATE: TAMBAH RUANG ==================== -->
    <div id="modalTambah" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden m-4">
            <div class="bg-[#3b6f6c] text-white px-6 py-4 flex justify-between items-center">
                <h3 class="font-extrabold text-sm tracking-wide">Tambah Ruang</h3>
                <button onclick="closeModal('modalTambah')" class="text-white/80 hover:text-white text-lg font-bold">&times;</button>
            </div>
            <form action="#" method="POST" class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Nama Ruangan</label>
                    <input type="text" placeholder="Ruang Rapat Paripurna" class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Kapasitas</label>
                        <input type="number" placeholder="50" class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Status</label>
                        <select class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                            <option>Tersedia</option>
                            <option>Digunakan</option>
                            <option>Perawatan</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Foto Ruangan</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center bg-gray-50 hover:bg-gray-100/50 cursor-pointer transition-colors">
                        <span class="text-xl text-gray-400 block mb-1">☁️</span>
                        <p class="text-xs font-bold text-gray-700">Click to update or drag and drop</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">JPG, PNG up to 5MB</p>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100 text-xs font-bold">
                    <button type="button" onclick="closeModal('modalTambah')" class="text-gray-500 hover:text-gray-700 py-2.5 px-4 rounded-xl">Batal</button>
                    <button type="submit" class="bg-[#3b6f6c] hover:bg-[#2d5754] text-white py-2.5 px-5 rounded-xl flex items-center space-x-1 shadow">
                        <span>💾</span> <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL TEMPLATE: EDIT RUANG ==================== -->
    <div id="modalEdit" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden m-4">
            <div class="bg-[#3b6f6c] text-white px-6 py-4 flex justify-between items-center">
                <h3 class="font-extrabold text-sm tracking-wide">Edit Ruang</h3>
                <button onclick="closeModal('modalEdit')" class="text-white/80 hover:text-white text-lg font-bold">&times;</button>
            </div>
            <form action="#" method="POST" class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Nama Ruangan</label>
                    <input type="text" value="Ruang Rapat Paripurna" class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Kapasitas</label>
                        <input type="number" value="50" class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1.5">Status</label>
                        <select class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                            <option>Tersedia</option>
                            <option>Digunakan</option>
                            <option selected>Perawatan</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Foto Ruangan</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center bg-gray-50 hover:bg-gray-100/50 cursor-pointer transition-colors">
                        <span class="text-xl text-gray-400 block mb-1">☁️</span>
                        <p class="text-xs font-bold text-gray-700">Click to update or drag and drop</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">JPG, PNG up to 5MB</p>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100 text-xs font-bold">
                    <button type="button" onclick="closeModal('modalEdit')" class="text-gray-500 hover:text-gray-700 py-2.5 px-4 rounded-xl">Batal</button>
                    <button type="submit" class="bg-[#3b6f6c] hover:bg-[#2d5754] text-white py-2.5 px-5 rounded-xl flex items-center space-x-1 shadow">
                        <span>💾</span> <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL TEMPLATE: CONFIRM HAPUS ==================== -->
    <div id="modalHapus" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center m-4">
            <div class="w-12 h-12 bg-rose-50 border border-rose-200 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">⚠️</div>
            <h3 class="text-sm font-extrabold text-gray-800">Hapus Ruangan?</h3>
            <p class="text-xs text-gray-400 mt-2">Apakah Anda yakin ingin menghapus ruangan ini?</p>
            <div class="flex justify-center space-x-3 mt-6 text-xs font-bold">
                <button type="button" onclick="closeModal('modalHapus')" class="border border-gray-200 text-gray-600 py-2.5 px-5 rounded-xl hover:bg-gray-50">Batal</button>
                <form action="#" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-rose-700 hover:bg-rose-800 text-white py-2.5 px-5 rounded-xl shadow">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Simple JavaScript buat buka/tutup modal -->
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        磨function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>

</body>
</html>