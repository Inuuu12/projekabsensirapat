<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - Data Pegawai</title>
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

                <!-- Menu Data Pengguna Dropdown (Active) -->
                <div>
                    <div class="flex items-center justify-between px-4 py-3 rounded-lg font-bold bg-white/10">
                        <div class="flex items-center space-x-3">
                            <span>👥</span> <span>Data Pengguna</span>
                        </div>
                        <span class="text-xs">▲</span>
                    </div>
                    <div class="pl-9 mt-1 space-y-1 text-xs">
                        <!-- Submenu Data Pegawai Aktif (Gaya Oval/Pill Grayish) -->
                        <a href="/admin/datapegawai" class="block py-2 px-3 font-bold bg-white/20 rounded-lg text-white">Data Pegawai</a>
                        <a href="/admin/datatamu" class="block py-2 opacity-80 hover:opacity-100">Data Tamu</a>
                    </div>
                </div>

                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg opacity-80 hover:opacity-100 transition-all font-medium">
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
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Data Pegawai</h2>
                <p class="text-xs text-gray-400 mt-1">Selamat datang kembali, Admin!</p>
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

        <!-- CONTROLS ROW (Show Entries, Search, Filter, Export, Tambah) -->
        <div class="bg-white border border-gray-100 p-4 rounded-t-2xl shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Sisi Kiri: Entries & Search -->
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
                    <input type="text" placeholder="Cari pegawai..." class="w-full bg-gray-50 border border-gray-200 text-xs pl-9 pr-4 py-2.5 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                    <span class="absolute left-3 top-3 text-xs opacity-40">🔍</span>
                </div>
            </div>

            <!-- Sisi Kanan: Action Buttons -->
            <div class="flex items-center space-x-2 text-xs font-bold text-gray-600">
                <button class="border border-gray-200 bg-white hover:bg-gray-50 px-4 py-2.5 rounded-xl flex items-center space-x-1.5 shadow-xs">
                    <span>⏳</span> <span>Filter</span>
                </button>
                <button class="border border-gray-200 bg-white hover:bg-gray-50 px-4 py-2.5 rounded-xl flex items-center space-x-1.5 shadow-xs">
                    <span>📥</span> <span>Export</span>
                </button>
                <button onclick="openModal('modalTambahPegawai')" class="bg-[#52c462] hover:bg-[#43a851] text-white px-4 py-2.5 rounded-xl shadow-md flex items-center space-x-1.5 transition-transform active:scale-98">
                    <span class="text-sm font-light">+</span> <span>Tambah Pegawai</span>
                </button>
            </div>
        </div>

        <!-- DATATABLE DATA PEGAWAI -->
        <div class="bg-white border-x border-b border-gray-100 rounded-b-2xl shadow-xs overflow-hidden">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#3b6f6c] text-white font-bold uppercase tracking-wider text-[10px]">
                        <th class="p-4 pl-6 text-center w-12">No</th>
                        <th class="p-4 w-16 text-center">Foto</th>
                        <th class="p-4">Nama Pegawai</th>
                        <th class="p-4">NIP</th>
                        <th class="p-4">Jabatan</th>
                        <th class="p-4">Bidang</th>
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
                        <td class="p-4">Kepala Badan</td>
                        <td class="p-4 text-gray-500">Sekretariat</td>
                        <td class="p-4">081290992233</td>
                        <td class="p-4 text-gray-500">arifrahman@gmail.com</td>
                        <td class="p-4 text-center space-x-2">
                            <button onclick="openModal('modalEditPegawai')" class="text-emerald-600 hover:text-emerald-800 text-sm">✏️</button>
                            <button onclick="openModal('modalHapusPegawai')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
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
                        <td class="p-4">Sekretaris</td>
                        <td class="p-4 text-gray-500">Sekretariat</td>
                        <td class="p-4">081333212465</td>
                        <td class="p-4 text-gray-500">sitiaminah@gmail.com</td>
                        <td class="p-4 text-center space-x-2">
                            <button onclick="openModal('modalEditPegawai')" class="text-emerald-600 hover:text-emerald-800 text-sm">✏️</button>
                            <button onclick="openModal('modalHapusPegawai')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
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
                        <td class="p-4">Kepala Bidang</td>
                        <td class="p-4 text-gray-500">Pajak Daerah I</td>
                        <td class="p-4">081333212465</td>
                        <td class="p-4 text-gray-500">budisantoso@gmail.com</td>
                        <td class="p-4 text-center space-x-2">
                            <button onclick="openModal('modalEditPegawai')" class="text-emerald-600 hover:text-emerald-800 text-sm">✏️</button>
                            <button onclick="openModal('modalHapusPegawai')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                    <!-- Row 4 (Inisial Bulat Hijau Muda jika foto kosong) -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-center text-gray-900 font-bold">4</td>
                        <td class="p-4 text-center">
                            <div class="w-8 h-8 bg-emerald-100 text-emerald-700 font-bold rounded-full flex items-center justify-center mx-auto text-[10px] border border-emerald-200">DW</div>
                        </td>
                        <td class="p-4 font-bold text-gray-900">Dian Wulandari, S.H.</td>
                        <td class="p-4 text-gray-500 font-mono">19900505<br>201503 2 008</td>
                        <td class="p-4">Analis Pajak</td>
                        <td class="p-4 text-gray-500">Pajak Daerah II</td>
                        <td class="p-4">081333212465</td>
                        <td class="p-4 text-gray-500">dianwulandari@gmail.com</td>
                        <td class="p-4 text-center space-x-2">
                            <button onclick="openModal('modalEditPegawai')" class="text-emerald-600 hover:text-emerald-800 text-sm">✏️</button>
                            <button onclick="openModal('modalHapusPegawai')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Info Pagination bawah -->
            <div class="p-4 bg-white border-t border-gray-100 text-[11px] text-gray-400 font-semibold">
                Menampilkan 1 sampai 4 dari 120 pegawai
            </div>
        </div>
    </main>

    <!-- ==================== MODAL: TAMBAH PEGAWAI ==================== -->
    <div id="modalTambahPegawai" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden m-4">
            <!-- Header Modal Hijau -->
            <div class="bg-[#3b6f6c] text-white px-6 py-4 flex justify-between items-center">
                <h3 class="font-extrabold text-sm tracking-wide">Tambah Pegawai</h3>
                <button onclick="closeModal('modalTambahPegawai')" class="text-white/80 hover:text-white text-lg font-bold">&times;</button>
            </div>
            
            <form action="#" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                <!-- Upload Lingkaran Tengah -->
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
                        <label class="block text-xs font-bold text-gray-600 mb-1">NIP <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="text" placeholder="Masukkan Nomor Induk Pegawai" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">💳</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Jabatan</label>
                        <div class="relative">
                            <input type="text" placeholder="Contoh: Analis Kebijakan" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">💼</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Bidang</label>
                        <div class="relative">
                            <input type="text" placeholder="Contoh: Sekertariat" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">🏢</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Email</label>
                        <div class="relative">
                            <input type="email" placeholder="Masukkan Email" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">✉️</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Kontak</label>
                        <div class="relative">
                            <input type="text" placeholder="Masukkan No telp" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-[#3b6f6c]">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">📞</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100 text-xs font-bold">
                    <button type="button" onclick="closeModal('modalTambahPegawai')" class="text-gray-500 hover:text-gray-700 py-2.5 px-4 rounded-xl">Batal</button>
                    <button type="submit" class="bg-[#3b6f6c] hover:bg-[#2d5754] text-white py-2.5 px-5 rounded-xl flex items-center space-x-1.5 shadow transition-colors">
                        <span>💾</span> <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL: EDIT PEGAWAI ==================== -->
    <div id="modalEditPegawai" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden m-4">
            <div class="bg-[#3b6f6c] text-white px-6 py-4 flex justify-between items-center">
                <h3 class="font-extrabold text-sm tracking-wide">Edit Pegawai</h3>
                <button onclick="closeModal('modalEditPegawai')" class="text-white/80 hover:text-white text-lg font-bold">&times;</button>
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
                        <label class="block text-xs font-bold text-gray-600 mb-1">NIP <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input type="text" value="19750817 200012 1 002" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">💳</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Jabatan</label>
                        <div class="relative">
                            <input type="text" value="Kepala Badan" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">💼</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Bidang</label>
                        <div class="relative">
                            <input type="text" value="Sekretariat" class="w-full bg-gray-50 border border-gray-200 pl-8 pr-4 py-2.5 rounded-xl text-xs focus:outline-none">
                            <span class="absolute left-3 top-3 text-[10px] opacity-40">🏢</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100 text-xs font-bold">
                    <button type="button" onclick="closeModal('modalEditPegawai')" class="text-gray-500 hover:text-gray-700 py-2.5 px-4 rounded-xl">Batal</button>
                    <button type="submit" class="bg-[#3b6f6c] hover:bg-[#2d5754] text-white py-2.5 px-5 rounded-xl flex items-center space-x-1.5 shadow">
                        <span>💾</span> <span>Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL: HAPUS PEGAWAI ==================== -->
    <div id="modalHapusPegawai" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center m-4">
            <div class="w-12 h-12 bg-rose-50 border border-rose-200 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">⚠️</div>
            <h3 class="text-sm font-extrabold text-gray-800">Hapus Pegawai?</h3>
            <p class="text-xs text-gray-400 mt-2">Apakah Anda yakin ingin menghapus pegawai ini?</p>
            <div class="flex justify-center space-x-3 mt-6 text-xs font-bold">
                <button type="button" onclick="closeModal('modalHapusPegawai')" class="border border-gray-200 text-gray-600 py-2.5 px-5 rounded-xl hover:bg-gray-50">Batal</button>
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