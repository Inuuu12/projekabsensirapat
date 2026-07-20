<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Umpan Balik - Bappenda</title>
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

                <!-- Menu Kunjungan -->
                <a href="/admin/daftarkunjungan" class="flex items-center space-x-3 px-4 py-3 rounded-lg opacity-80 hover:opacity-100 transition-all font-medium">
                    <span>🏢</span> <span>Kunjungan</span>
                </a>
                
                <!-- Menu Umpan Balik Utama Aktif -->
                <a href="/admin/umpanbalik" class="flex items-center space-x-3 px-4 py-3 rounded-lg font-bold bg-white/20 text-white transition-all">
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
                <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Umpan Balik</h2>
                <p class="text-xs text-gray-400 mt-1">Kelola dan tindak lanjuti keluhan pengguna.</p>
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

        <!-- KARTU STATISTIK ADUAN -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Total Aduan -->
            <div class="bg-white border border-gray-100 p-4 rounded-2xl shadow-xs flex items-center space-x-3">
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg">📁</div>
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wide">Total Aduan</p>
                    <p class="text-xl font-extrabold text-gray-800">1,284</p>
                </div>
            </div>
            <!-- Menunggu -->
            <div class="bg-white border border-gray-100 p-4 rounded-2xl shadow-xs flex items-center space-x-3">
                <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-lg">⏱️</div>
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wide">Menunggu</p>
                    <p class="text-xl font-extrabold text-gray-800">24</p>
                </div>
            </div>
            <!-- Diproses -->
            <div class="bg-white border border-gray-100 p-4 rounded-2xl shadow-xs flex items-center space-x-3">
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-lg">👁️</div>
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wide">Diproses</p>
                    <p class="text-xl font-extrabold text-gray-800">12</p>
                </div>
            </div>
            <!-- Selesai -->
            <div class="bg-white border border-gray-100 p-4 rounded-2xl shadow-xs flex items-center space-x-3">
                <div class="w-10 h-10 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center text-lg">👁️</div>
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wide">Selesai</p>
                    <p class="text-xl font-extrabold text-gray-800">12</p>
                </div>
            </div>
        </div>

        <!-- LOG ADUAN HEADER BAR -->
        <div class="bg-white border border-gray-100 p-4 rounded-t-2xl shadow-xs flex items-center justify-between">
            <h3 class="text-sm font-extrabold text-gray-700">Log Aduan</h3>
            <div class="flex items-center space-x-2 text-xs font-bold text-gray-600">
                <span>Filter by:</span>
                <div class="relative">
                    <select class="bg-gray-50 border border-gray-200 text-xs px-4 py-1.5 rounded-xl text-gray-600 appearance-none pr-8 focus:outline-none">
                        <option>Status: Semua</option>
                        <option>Menunggu</option>
                        <option>Proses</option>
                        <option>Selesai</option>
                    </select>
                    <span class="absolute right-3 top-2 text-[8px] pointer-events-none text-gray-400">▼</span>
                </div>
            </div>
        </div>

        <!-- DATATABLE LOG ADUAN -->
        <div class="bg-white border-x border-gray-100 shadow-xs overflow-hidden">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#4a7a77] text-white font-bold uppercase tracking-wider text-[10px]">
                        <th class="p-4 pl-6 w-1/5">Nama Pengadu</th>
                        <th class="p-4 w-1/5">Email</th>
                        <th class="p-4 w-1/3">Isi Aduan</th>
                        <th class="p-4 text-center">Waktu</th>
                        <th class="p-4 text-center">Tanggal</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 font-medium">
                    <!-- Row 1 (Menunggu) -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-gray-900 font-bold">Andi Saputra</td>
                        <td class="p-4 text-gray-500 font-mono">andi@mail.com</td>
                        <td class="p-4 text-gray-600 max-w-xs truncate">Laporan penebangan liar di area konservasi blok utara...</td>
                        <td class="p-4 text-center text-gray-500 font-mono">11:00</td>
                        <td class="p-4 text-center text-gray-500">24 Okt 2023</td>
                        <td class="p-4 text-center">
                            <span class="bg-rose-100 text-rose-700 px-2.5 py-1 rounded-full text-[10px] font-bold">● Menunggu</span>
                        </td>
                        <td class="p-4 text-center space-x-3">
                            <button class="text-gray-500 hover:text-gray-700 text-sm">👁️</button>
                            <button class="text-gray-500 hover:text-gray-700 text-sm">↩️</button>
                            <button onclick="openModal('modalHapusAduan')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                    <!-- Row 2 (Proses) -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-gray-900 font-bold">Bambang Irawan</td>
                        <td class="p-4 text-gray-500 font-mono">bambang@mail.com</td>
                        <td class="p-4 text-gray-600 max-w-xs truncate">Kebakaran lahan kecil di dekat pemukiman warga Desa Rimba Jaya...</td>
                        <td class="p-4 text-center text-gray-500 font-mono">11:00</td>
                        <td class="p-4 text-center text-gray-500">24 Okt 2023</td>
                        <td class="p-4 text-center">
                            <span class="bg-amber-100 text-amber-700 px-2.5 py-1 rounded-full text-[10px] font-bold">● Proses</span>
                        </td>
                        <td class="p-4 text-center space-x-3">
                            <button class="text-gray-500 hover:text-gray-700 text-sm">👁️</button>
                            <button class="text-gray-500 hover:text-gray-700 text-sm">↩️</button>
                            <button onclick="openModal('modalHapusAduan')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                    <!-- Row 3 (Selesai) -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-gray-900 font-bold">Citra Insani</td>
                        <td class="p-4 text-gray-500 font-mono">citra@mail.com</td>
                        <td class="p-4 text-gray-600 max-w-xs truncate">Permohonan bibit pohon jati untuk penghijauan lahan desa.</td>
                        <td class="p-4 text-center text-gray-500 font-mono">11:00</td>
                        <td class="p-4 text-center text-gray-500">24 Okt 2023</td>
                        <td class="p-4 text-center">
                            <span class="bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-full text-[10px] font-bold">● Selesai</span>
                        </td>
                        <td class="p-4 text-center space-x-3">
                            <button class="text-gray-500 hover:text-gray-700 text-sm">👁️</button>
                            <button class="text-gray-500 hover:text-gray-700 text-sm">↩️</button>
                            <button onclick="openModal('modalHapusAduan')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                    <!-- Row 4 (Selesai) -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="p-4 pl-6 text-gray-900 font-bold">Dedi Wijaya</td>
                        <td class="p-4 text-gray-500 font-mono">dedi@mail.com</td>
                        <td class="p-4 text-gray-600 max-w-xs truncate">Konflik satwa liar masuk ke pemukiman penduduk...</td>
                        <td class="p-4 text-center text-gray-500 font-mono">11:00</td>
                        <td class="p-4 text-center text-gray-500">24 Okt 2023</td>
                        <td class="p-4 text-center">
                            <span class="bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-full text-[10px] font-bold">● Selesai</span>
                        </td>
                        <td class="p-4 text-center space-x-3">
                            <button class="text-gray-500 hover:text-gray-700 text-sm">👁️</button>
                            <button class="text-gray-500 hover:text-gray-700 text-sm">↩️</button>
                            <button onclick="openModal('modalHapusAduan')" class="text-rose-500 hover:text-rose-700 text-sm">🗑️</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- FOOTER PAGINATION BAR -->
        <div class="bg-white border-x border-b border-gray-100 p-4 rounded-b-2xl shadow-xs flex items-center justify-between text-xs text-gray-400 font-bold">
            <div>Menampilkan 1-5 dari 42 aduan</div>
            
            <!-- Pagination Button -->
            <div class="flex items-center space-x-1 text-gray-600">
                <button class="border border-gray-200 w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-50">&lt;</button>
                <button class="w-8 h-8 rounded-lg flex items-center justify-center bg-[#2e624c] text-white">1</button>
                <button class="border border-gray-200 w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-50">2</button>
                <button class="border border-gray-200 w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-50">3</button>
                <button class="border border-gray-200 w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-50">&gt;</button>
            </div>
        </div>
    </main>

    <!-- ==================== MODAL: HAPUS UMPAN BALIK ==================== -->
    <div id="modalHapusAduan" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center m-4">
            <div class="w-12 h-12 bg-rose-50 border border-rose-200 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">⚠️</div>
            <h3 class="text-sm font-extrabold text-gray-800">Hapus Umpan Balik?</h3>
            <p class="text-xs text-gray-400 mt-2">Apakah Anda yakin ingin menghapus aduan ini?</p>
            <div class="flex justify-center space-x-3 mt-6 text-xs font-bold">
                <button type="button" onclick="closeModal('modalHapusAduan')" class="border border-gray-200 text-gray-600 py-2.5 px-5 rounded-lg hover:bg-gray-50">Batal</button>
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