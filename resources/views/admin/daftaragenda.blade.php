<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Agenda — Diskominfo Kabupaten Bogor</title>

    {{-- Tailwind CSS CDN & Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#f4f7f6] font-sans antialiased text-[#1c2b2a]">

<div class="flex min-h-screen">

    {{-- Sidebar Komponen --}}
    <x-admin.sidebar active="agenda" />

    {{-- Main Content --}}
    <main class="flex-1 p-6 lg:p-8 overflow-y-auto">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-[#0d3b38]">Daftar Agenda</h1>
                <p class="text-sm text-[#6b7d7b] mt-1">Kelola dan pantau seluruh jadwal agenda</p>
            </div>
            {{-- Admin Profile Chip --}}
            <div class="flex items-center gap-3 bg-[#124e49] text-white px-4 py-2 rounded-full shadow-sm">
                <img src="https://i.pravatar.cc/80?img=47" alt="Foto admin" class="w-9 h-9 rounded-full object-cover border-2 border-white/50">
                <div>
                    <p class="text-xs font-bold leading-tight">Admin</p>
                    <p class="text-[10px] text-[#bcd8d3]">Super Admin</p>
                </div>
            </div>
        </div>

        {{-- Search Bar --}}
        <div class="relative mb-6">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-[#9db3af]">🔍</span>
            <input type="text" placeholder="Cari agenda..." class="w-full pl-11 pr-4 py-3 bg-white border border-[#e7ece9] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1f7266]">
        </div>

        {{-- Stat Cards dengan Aset Logo PNG --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white border border-[#e7ece9] p-4 rounded-2xl flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-[#e6f6f1] flex items-center justify-center p-2.5">
                    <img src="{{ asset('foto/Totalagendalogo.png') }}" alt="Total Agenda" class="w-full h-full object-contain">
                </div>
                <div>
                    <p class="text-[11px] uppercase tracking-wider text-[#6b7d7b] font-semibold">Total Agenda</p>
                    <p class="text-2xl font-black text-[#1c2b2a]">124</p>
                </div>
            </div>
            <div class="bg-white border border-[#e7ece9] p-4 rounded-2xl flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-[#fdefe0] flex items-center justify-center p-2.5">
                    <img src="{{ asset('foto/Akandatanglogo.png') }}" alt="Akan Datang" class="w-full h-full object-contain">
                </div>
                <div>
                    <p class="text-[11px] uppercase tracking-wider text-[#6b7d7b] font-semibold">Akan Datang</p>
                    <p class="text-2xl font-black text-[#1c2b2a]">8</p>
                </div>
            </div>
            <div class="bg-white border border-[#e7ece9] p-4 rounded-2xl flex items-center gap-4 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-[#e5f7ea] flex items-center justify-center p-2.5">
                    <img src="{{ asset('foto/Selesailogo.png') }}" alt="Selesai" class="w-full h-full object-contain">
                </div>
                <div>
                    <p class="text-[11px] uppercase tracking-wider text-[#6b7d7b] font-semibold">Selesai</p>
                    <p class="text-2xl font-black text-[#1c2b2a]">86</p>
                </div>
            </div>
        </div>

        {{-- Action Bar --}}
        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3 mb-6">
            <div class="flex items-center gap-3">
                <button class="bg-white border border-[#e7ece9] px-4 py-2.5 rounded-xl text-sm font-semibold text-[#1c2b2a] flex items-center gap-2">
                    Surat Keluar ▾
                </button>
                <button class="bg-white border border-[#e7ece9] px-4 py-2.5 rounded-xl text-sm font-semibold text-[#1c2b2a] flex items-center gap-2">
                    ☰ Filter tanggal
                </button>
            </div>
            <button class="bg-[#2fae5c] hover:bg-[#279449] text-white font-bold px-5 py-2.5 rounded-xl text-sm shadow transition">
                + Tambah Agenda
            </button>
        </div>

        {{-- Table Card --}}
        <div class="bg-white border border-[#e7ece9] rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-[#124e49] text-[#eaf5f3] text-xs font-bold">
                        <tr>
                            <th class="p-4">Nama Agenda</th>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4">Waktu</th>
                            <th class="p-4">Kuota</th>
                            <th class="p-4">Asal Surat</th>
                            <th class="p-4">Lampiran</th>
                            <th class="p-4">Tempat</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e7ece9] text-sm text-[#3a4a48]">
                        @for ($i = 0; $i < 4; $i++)
                        <tr class="hover:bg-[#f8fbfa] transition">
                            <td class="p-4 font-bold text-[#124e49]">Rapat Koordinasi Pajak Daerah</td>
                            <td class="p-4 whitespace-nowrap">Juli 15, 2026</td>
                            <td class="p-4 whitespace-nowrap">09:00 – 11:30 WIB</td>
                            <td class="p-4">100</td>
                            <td class="p-4">Aplikasi Informatika</td>
                            <td class="p-4">
                                <span class="text-[#1f7266] font-semibold flex items-center gap-1.5 cursor-pointer">
                                    <img src="{{ asset('foto/Lampiranlogo.png') }}" alt="Lampiran" class="w-4 h-4 object-contain">
                                    Lihat Lampiran
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap">🎥 Zoom Meeting</td>
                            <td class="p-4">
                                <span class="bg-[#fdf1de] text-[#b9791a] px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#e6a13c]"></span> Ongoing
                                </span>
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Edit --}}
                                    <button class="w-8 h-8 rounded-lg bg-[#e6f6f1] flex items-center justify-center p-1.5 hover:bg-[#d5f1e8] transition" title="Edit Agenda">
                                        <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="w-full h-full object-contain">
                                    </button>
                                    
                                    {{-- Delete --}}
                                    <button class="w-8 h-8 rounded-lg bg-[#fdeceb] flex items-center justify-center p-1.5 hover:bg-[#fbdad8] transition" title="Hapus Agenda">
                                        <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="w-full h-full object-contain">
                                    </button>
                                    
                                    {{-- Detail --}}
                                    <a href="{{ route('admin.agenda.detail') }}" class="w-8 h-8 rounded-lg bg-[#eef1f1] flex items-center justify-center p-1.5 hover:bg-gray-200 transition" title="Detail Agenda">
                                        <img src="{{ asset('foto/Detaillogo.png') }}" alt="Detail" class="w-full h-full object-contain">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            {{-- Table Footer / Pagination --}}
            <div class="p-4 border-t border-[#e7ece9] flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-[#6b7d7b]">
                <span>Showing 1 to 10 of 124 entries</span>
                <div class="flex items-center gap-1">
                    <button class="w-8 h-8 border border-[#e7ece9] rounded-lg bg-white">‹</button>
                    <button class="w-8 h-8 border border-[#124e49] bg-[#124e49] text-white font-bold rounded-lg">1</button>
                    <button class="w-8 h-8 border border-[#e7ece9] rounded-lg bg-white">2</button>
                    <button class="w-8 h-8 border border-[#e7ece9] rounded-lg bg-white">3</button>
                    <button class="w-8 h-8 border border-[#e7ece9] rounded-lg bg-white">›</button>
                </div>
            </div>
        </div>

    </main>
</div>

</body>
</html>