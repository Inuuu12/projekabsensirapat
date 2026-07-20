<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - Data Tamu</title>
    <!-- Tailwind CSS v4 -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased flex min-h-screen">
    <x-admin.sidebar active="tamu" />

    <!-- ==================== MAIN CONTENT ==================== -->
    <main class="flex-1 p-8 overflow-y-auto">
        <x-admin.navbar title="Data Tamu" subtitle="Kelola data tamu dan peserta eksternal." />

        <!-- CONTROLS ROW -->
        <div class="bg-white border border-gray-100 p-4 rounded-t-2xl shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex flex-1 items-center space-x-3">
                <div class="relative">
                    <select class="bg-gray-50 border border-gray-200 text-xs px-4 py-2.5 rounded-xl font-bold text-gray-600 appearance-none pr-8 focus:outline-none">
                        <option>10 Baris</option>
                        <option>25 Baris</option>
                        <option>50 Baris</option>
                    </select>
                    <span class="absolute right-3 top-3.5 text-[8px] pointer-events-none text-gray-400">▼</span>
                </div>
                <div class="relative flex-1 max-w-md">
                    <input type="text" placeholder="Cari tamu..." class="w-full bg-gray-50 border border-gray-200 text-xs pl-9 pr-4 py-2.5 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                    <span class="absolute left-3 top-3 text-xs opacity-40">🔍</span>
                </div>
            </div>

            <div class="flex items-center space-x-2 text-xs font-bold text-gray-600">
                <button class="border border-gray-200 bg-white hover:bg-gray-50 px-4 py-2.5 rounded-xl flex items-center space-x-1.5 shadow-xs">
                    <span>⏳</span> <span>Filter</span>
                </button>
                <button class="border border-gray-200 bg-white hover:bg-gray-50 px-4 py-2.5 rounded-xl flex items-center space-x-1.5 shadow-xs">
                    <span>📥</span> <span>Export</span>
                </button>
                <button onclick="openModal('modalTambahTamu')" class="bg-[#52c462] hover:bg-[#43a851] text-white px-4 py-2.5 rounded-xl shadow-md flex items-center space-x-1.5 transition-transform active:scale-98">
                    <span class="text-sm font-light">+</span> <span>Tambah Tamu</span>
                </button>
            </div>
        </div>

        <!-- DATATABLE DATA TAMU -->
        <div class="bg-white border-x border-b border-gray-100 rounded-b-2xl shadow-xs overflow-hidden">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#3b6f6c] text-white font-bold uppercase tracking-wider text-[10px]">
                        <th class="p-4 pl-6 text-center w-12">No</th>
                        <th class="p-4 w-16 text-center">Foto</th>
                        <th class="p-4">Nama</th>
                        <th class="p-4">NIK/NIP</th>
                        <th class="p-4">Instansi</th>
                        <th class="p-4">Kontak</th>
                        <th class="p-4">Email</th>
                        <th class="p-4 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 font-medium">
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-center text-gray-900 font-bold">1</td>
                        <td class="p-4 text-center">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=100" alt="Foto" class="w-8 h-8 rounded-full object-cover mx-auto border shadow-xs">
                        </td>
                        <td class="p-4 font-bold text-gray-900">H. Arif Rahman, S.E.</td>
                        <td class="p-4 text-gray-500 font-mono">19750817<br>200012 1 002</td>
                        <td class="p-4">Dinas Pendidikan</td>
                        <td class="p-4">081290992233</td>
                        <td class="p-4 text-gray-500">arifrahman@gmail.com</td>
                        <td class="p-4 text-center space-x-2">
                            <button onclick="openModal('modalEditTamu')" class="text-emerald-600 hover:text-emerald-800 text-sm">✏️</button>
                            <button onclick="openModal('modalHapusTamu')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-center text-gray-900 font-bold">2</td>
                        <td class="p-4 text-center">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=100" alt="Foto" class="w-8 h-8 rounded-full object-cover mx-auto border shadow-xs">
                        </td>
                        <td class="p-4 font-bold text-gray-900">Siti Aminah, M.Si.</td>
                        <td class="p-4 text-gray-500 font-mono">19800322<br>200501 2 005</td>
                        <td class="p-4">Pt. sehat</td>
                        <td class="p-4">081333212465</td>
                        <td class="p-4 text-gray-500">sitiaminah@gmail.com</td>
                        <td class="p-4 text-center space-x-2">
                            <button onclick="openModal('modalEditTamu')" class="text-emerald-600 hover:text-emerald-800 text-sm">✏️</button>
                            <button onclick="openModal('modalHapusTamu')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-center text-gray-900 font-bold">3</td>
                        <td class="p-4 text-center">
                            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=100" alt="Foto" class="w-8 h-8 rounded-full object-cover mx-auto border shadow-xs">
                        </td>
                        <td class="p-4 font-bold text-gray-900">Budi Santoso, S.Kom.</td>
                        <td class="p-4 text-gray-500 font-mono">19851110<br>201004 1 001</td>
                        <td class="p-4">Pt. Sukses</td>
                        <td class="p-4">081333212465</td>
                        <td class="p-4 text-gray-500">budisantoso@gmail.com</td>
                        <td class="p-4 text-center space-x-2">
                            <button onclick="openModal('modalEditTamu')" class="text-emerald-600 hover:text-emerald-800 text-sm">✏️</button>
                            <button onclick="openModal('modalHapusTamu')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                    <!-- Row 4 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-center text-gray-900 font-bold">4</td>
                        <td class="p-4 text-center">
                            <div class="w-8 h-8 bg-emerald-100 text-emerald-700 font-bold rounded-full flex items-center justify-center mx-auto text-[10px] border border-emerald-200">DW</div>
                        </td>
                        <td class="p-4 font-bold text-gray-900">Dian Wulandari, S.H.</td>
                        <td class="p-4 text-gray-500 font-mono">19900505<br>201503 2 008</td>
                        <td class="p-4">Dinas</td>
                        <td class="p-4">081333212465</td>
                        <td class="p-4 text-gray-500">dianwulandari@gmail.com</td>
                        <td class="p-4 text-center space-x-2">
                            <button onclick="openModal('modalEditTamu')" class="text-emerald-600 hover:text-emerald-800 text-sm">✏️</button>
                            <button onclick="openModal('modalHapusTamu')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="p-4 bg-white border-t border-gray-100 text-[11px] text-gray-400 font-semibold">
                Menampilkan 1 sampai 4 dari 120 tamu
            </div>
        </div>
    </main>

    <!-- ==================== MODAL: TAMBAH TAMU ==================== -->
    <div id="modalTambahTamu" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden m-4">
            <div class="bg-[#3b6f6c] text-white px-6 py-4 flex justify-between items-center">
                <h3 class="font-extrabold text-sm tracking-wide">Tambah Tamu</h3>
                <button onclick="closeModal('modalTambahTamu')" class="text-white/80 hover:text-white text-lg font-bold">&times;</button>
            </div>
            
            <form action="#" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                <!-- Upload Foto Lingkaran -->
                <div class="flex flex-col items-center justify-center mb-2">
                    <div class="relative w-20 h-20 border-2 border-dashed border-gray-300 rounded-full flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition-colors group">
                        <span class="text-gray-400 group-hover:text-gray-600 text-lg">👤+</span>
                        <div class="absolute bottom-0 right-0 bg-[#3b6f6c] text-white rounded-full p-1 border-2 border-white text-[10px]">📷</div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold mt-2 uppercase tracking-wide">Unggah Foto</span>
                </div>

                <!-- Form Inputs -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="text" placeholder="Masukkan nama lengkap" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">👤</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">NIK <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="text" placeholder="Masukkan Nomor Induk Karyawan" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">💳</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Instansi</label>
                        <div class="relative">
                            <input type="text" placeholder="Contoh: Analis Kebijakan" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">💼</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Kontak</label>
                        <div class="relative">
                            <input type="text" placeholder="Masukkan No telp" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">📞</span>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 mb-1">Email</label>
                        <div class="relative">
                            <input type="email" placeholder="Masukkan Email" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">✉️</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100 text-xs font-bold">
                    <button type="button" onclick="closeModal('modalTambahTamu')" class="text-gray-500 hover:text-gray-700 py-2.5 px-4 rounded-xl">Batal</button>
                    <button type="submit" class="bg-[#3b6f6c] hover:bg-[#2d5754] text-white py-2.5 px-5 rounded-xl flex items-center space-x-1.5 shadow">
                        <span>💾</span> <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL: EDIT TAMU ==================== -->
    <div id="modalEditTamu" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden m-4">
            <div class="bg-[#3b6f6c] text-white px-6 py-4 flex justify-between items-center">
                <h3 class="font-extrabold text-sm tracking-wide">Edit Tamu</h3>
                <button onclick="closeModal('modalEditTamu')" class="text-white/80 hover:text-white text-lg font-bold">&times;</button>
            </div>
            
            <form action="#" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                <div class="flex flex-col items-center justify-center mb-2">
                    <div class="relative w-20 h-20 border-2 border-dashed border-gray-300 rounded-full flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 cursor-pointer transition-colors group">
                        <span class="text-gray-400 group-hover:text-gray-600 text-lg">👤+</span>
                        <div class="absolute bottom-0 right-0 bg-[#3b6f6c] text-white rounded-full p-1 border-2 border-white text-[10px]">📷</div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold mt-2 uppercase tracking-wide">Unggah Foto</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="text" value="H. Arif Rahman, S.E." class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">👤</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">NIK <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="text" value="19750817 200012 1 002" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">💳</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Instansi</label>
                        <div class="relative">
                            <input type="text" value="Dinas Pendidikan" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">💼</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Kontak</label>
                        <div class="relative">
                            <input type="text" value="081290992233" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">📞</span>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 mb-1">Email</label>
                        <div class="relative">
                            <input type="email" value="arifrahman@gmail.com" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">✉️</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100 text-xs font-bold">
                    <button type="button" onclick="closeModal('modalEditTamu')" class="text-gray-500 hover:text-gray-700 py-2.5 px-4 rounded-xl">Batal</button>
                    <button type="submit" class="bg-[#3b6f6c] hover:bg-[#2d5754] text-white py-2.5 px-5 rounded-xl flex items-center space-x-1.5 shadow">
                        <span>💾</span> <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL: HAPUS TAMU ==================== -->
    <div id="modalHapusTamu" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center m-4">
            <div class="w-12 h-12 bg-rose-50 border border-rose-200 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">⚠️</div>
            <h3 class="text-sm font-extrabold text-gray-800">Hapus Tamu?</h3>
            <p class="text-xs text-gray-400 mt-2">Apakah Anda yakin ingin menghapus pegawai ini?</p>
            <div class="flex justify-center space-x-3 mt-6 text-xs font-bold">
                <button type="button" onclick="closeModal('modalHapusTamu')" class="border border-gray-200 text-gray-600 py-2.5 px-5 rounded-xl hover:bg-gray-50">Batal</button>
                <form action="#" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-rose-700 hover:bg-rose-800 text-white py-2.5 px-5 rounded-xl shadow">Hapus</button>
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