<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Agenda - Admin</title>
    <!-- Tailwind CSS v4 sesuai login.blade.php -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- NAVIGATION BAR (Gaya e-Agenda Bappenda) -->
    <nav class="bg-[#3b6f6c] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Sisi Kiri: Logo & Nama Sistem -->
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('foto/logo-bappenda.png') }}" alt="Logo Bappenda" class="h-9 w-auto">
                    <span class="text-xl font-extrabold tracking-wide">e-Agenda</span>
                </div>
                
                <!-- Sisi Kanan: Nama Admin & Logout -->
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs text-gray-200">Log masuk sebagai:</p>
                        <!-- Variabel disamakan dengan dashboard.blade.php -->
                        <p class="text-sm font-bold">{{ $admin->nama ?? $admin->username ?? 'Admin' }}</p>
                    </div>
                    <form method="POST" action="/admin/logout">
                        @csrf
                        <button type="submit" class="bg-[#d49e19] hover:bg-[#b88510] text-white text-xs font-bold py-2 px-4 rounded-lg transition duration-200 shadow-sm active:scale-95">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- UTAMA: KONTEN DETAIL AGENDA -->
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        
        <!-- Tombol Kembali ke Dashboard -->
        <a href="/admin/dashboard" class="inline-flex items-center text-sm font-bold text-[#3b6f6c] mb-6 hover:underline">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Dashboard
        </a>

        <!-- Grid Pembagian Dua Kolom Informasi -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- KOLOM KIRI: INFO AGENDA & DOKUMEN (7 Grid) -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Box Informasi Utama -->
                <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm relative overflow-hidden">
                    <!-- Ornamen estetika sudut seperti halaman login -->
                    <div class="absolute -top-10 -left-10 w-24 h-24 bg-[#3b6f6c]/10 rounded-full"></div>
                    
                    <span class="text-xs font-bold text-[#3b6f6c] tracking-wider uppercase bg-[#3b6f6c]/10 px-2.5 py-1 rounded">Informasi Agenda</span>
                    <h2 class="text-xl font-extrabold text-gray-800 mt-4">Rapat Koordinasi Evaluasi PAD Triwulan III</h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4 text-sm text-gray-600">
                        <div>
                            <p class="text-xs font-semibold text-gray-400">Tanggal</p>
                            <p class="font-medium text-gray-800 mt-0.5">📅 15 Okt 2023</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400">Waktu</p>
                            <p class="font-medium text-gray-800 mt-0.5">🕒 09:00 - 12:00 WIB</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-xs font-semibold text-gray-400">Tempat</p>
                            <p class="font-medium text-gray-800 mt-0.5">📍 Ruang Rapat Utama BAPPENDA Gedung A Lt. 2</p>
                        </div>
                        <div class="sm:col-span-2">
                            <p class="text-xs font-semibold text-gray-400">Asal Surat</p>
                            <p class="font-medium text-gray-800 mt-0.5">Sekretariat Daerah Kabupaten Bogor</p>
                        </div>
                    </div>
                </div>

                <!-- Bagian Upload File Lampiran -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Notulen -->
                    <div class="border-2 border-dashed border-gray-300 p-5 rounded-xl text-center bg-white hover:bg-gray-50 cursor-pointer transition-all">
                        <p class="text-sm font-bold text-gray-700">Notulen Agenda</p>
                        <p class="text-xs text-gray-400 mt-1">Klik atau tarik dokumen di sini</p>
                    </div>
                    <!-- Dokumentasi -->
                    <div class="border-2 border-dashed border-gray-300 p-5 rounded-xl text-center bg-white hover:bg-gray-50 cursor-pointer transition-all">
                        <p class="text-sm font-bold text-gray-700">Dokumentasi Agenda</p>
                        <p class="text-xs text-gray-400 mt-1">Klik atau tarik foto kegiatan (JPG/PNG)</p>
                    </div>
                </div>

                <!-- QR Absensi Switcher Box -->
                <div class="bg-white border border-gray-200 p-6 rounded-xl shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-sm font-bold text-gray-800 tracking-wide">QR ABSENSI GENERATOR</h3>
                            <p class="text-xs text-gray-400">Aktifkan akses scan barcode absensi</p>
                        </div>
                        <!-- Toggle Switch -->
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#3b6f6c]"></div>
                            <span class="ml-2 text-xs font-semibold text-gray-700">Aktif</span>
                        </label>
                    </div>

                    <!-- Kotak QR Code Pegawai & Tamu -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl text-center">
                            <p class="text-xs font-bold text-gray-600 mb-2">QR ABSENSI PEGAWAI</p>
                            <div class="w-24 h-24 bg-white border mx-auto flex items-center justify-center rounded-lg shadow-inner">
                                <div class="w-20 h-20 bg-[#3b6f6c]/10 flex items-center justify-center text-[10px] text-[#3b6f6c] font-mono font-bold">QR CODE</div>
                            </div>
                        </div>
                        <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl text-center">
                            <p class="text-xs font-bold text-gray-600 mb-2">QR ABSENSI TAMU</p>
                            <div class="w-24 h-24 bg-white border mx-auto flex items-center justify-center rounded-lg shadow-inner">
                                <div class="w-20 h-20 bg-[#3b6f6c]/10 flex items-center justify-center text-[10px] text-[#3b6f6c] font-mono font-bold">QR CODE</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: TABEL PESERTA YANG HADIR (5 Grid) -->
            <div class="lg:col-span-5 bg-white border border-gray-200 rounded-xl p-5 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-sm font-bold text-gray-800 tracking-wide uppercase">Peserta Yang Hadir</h3>
                        <span class="bg-[#3b6f6c] text-white text-[10px] font-bold px-2 py-0.5 rounded-full">3 Hadir</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="text-gray-400 uppercase tracking-wider text-[10px] border-b border-gray-100">
                                    <th class="pb-2 font-semibold">Nama</th>
                                    <th class="pb-2 font-semibold">Jabatan</th>
                                    <th class="pb-2 font-semibold">Status</th>
                                    <th class="pb-2 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-700">
                                <tr>
                                    <td class="py-3 font-bold text-gray-900">Budi Santoso</td>
                                    <td class="py-3 text-gray-500">Kepala Bidang</td>
                                    <td class="py-3"><span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded text-[10px] font-bold">Hadir</span></td>
                                    <td class="py-3 text-right">
                                        <button onclick="openModal()" class="text-[#3b6f6c] font-bold hover:underline">👁️ Bukti</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-3 font-bold text-gray-900">Siti Aminah</td>
                                    <td class="py-3 text-gray-500">Staf Analis</td>
                                    <td class="py-3"><span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded text-[10px] font-bold">Hadir</span></td>
                                    <td class="py-3 text-right">
                                        <button onclick="openModal()" class="text-[#3b6f6c] font-bold hover:underline">👁️ Bukti</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-3 font-bold text-gray-900">Diana Putri</td>
                                    <td class="py-3 text-gray-500">Sekretaris</td>
                                    <td class="py-3"><span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded text-[10px] font-bold">Hadir</span></td>
                                    <td class="py-3 text-right">
                                        <button onclick="openModal()" class="text-[#3b6f6c] font-bold hover:underline">👁️ Bukti</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tombol Aksi Simpan Emas (Match Login Button) -->
                <div class="text-right mt-6 pt-4 border-t border-gray-100">
                    <button class="bg-[#d49e19] hover:bg-[#b88510] text-white text-xs font-bold px-5 py-2.5 rounded-lg shadow transition duration-200 active:scale-95">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- ========================================== -->
    <!-- COMPONENT MODAL POPUP: BUKTI ABSENSI -->
    <!-- ========================================== -->
    <div id="buktiModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white w-full max-w-md rounded-xl shadow-2xl overflow-hidden m-4 transform transition-all">
            
            <!-- Header Modal Hijau #3b6f6c -->
            <div class="bg-[#3b6f6c] text-white px-5 py-4 flex justify-between items-center">
                <h3 class="font-bold text-sm tracking-wide">Bukti Absensi Peserta</h3>
                <button onclick="closeModal()" class="text-white/80 hover:text-white text-xl font-bold transition-colors">&times;</button>
            </div>

            <!-- Isi Modal -->
            <div class="p-5 space-y-4">
                <!-- Frame Foto -->
                <div class="w-full h-44 bg-gray-200 rounded-lg overflow-hidden border border-gray-300 shadow-inner">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=600&auto=format&fit=crop" alt="Foto Presensi Pegawai" class="w-full h-full object-cover">
                </div>

                <!-- Info Peserta -->
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div class="bg-gray-50 border border-gray-200 p-3 rounded-lg">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Nama Peserta</p>
                        <p class="font-bold text-gray-800 mt-0.5">Budi Santoso</p>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 p-3 rounded-lg">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Waktu Absen</p>
                        <p class="font-bold text-gray-800 mt-0.5">15 Okt 2023, 09:15 WIB</p>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-200 p-3 rounded-lg text-xs">
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Lokasi Pemotretan</p>
                    <p class="font-bold text-gray-800 mt-0.5">📍 Ruang Rapat Utama (Geotag Valid)</p>
                </div>

                <div class="flex items-center space-x-2 text-xs font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 px-3 py-2 rounded-lg">
                    <span>✓</span>
                    <span>Terverifikasi Sistem e-Agenda</span>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="bg-gray-50 px-5 py-3.5 flex justify-end space-x-2 border-t border-gray-100">
                <button onclick="closeModal()" class="border border-gray-300 hover:bg-gray-100 text-gray-700 text-xs font-bold px-4 py-2 rounded-lg transition-colors">
                    Tutup
                </button>
                <button class="bg-[#d49e19] hover:bg-[#b88510] text-white text-xs font-bold px-4 py-2 rounded-lg shadow transition-colors">
                    📥 Unduh
                </button>
            </div>

        </div>
    </div>

    <!-- Script Modal Toggle -->
    <script>
        function openModal() {
            document.getElementById('buktiModal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('buktiModal').classList.add('hidden');
        }
    </script>
</body>
</html>