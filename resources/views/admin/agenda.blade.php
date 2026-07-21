@extends('admin.layout.app')

@slot('title', 'Dashboard Admin')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Agenda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAFAFA;
        }
        /* Custom Scrollbar for table */
        ::-webkit-scrollbar { height: 8px; width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; rounded-full; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="text-gray-800 p-4 md:p-8 min-h-screen">

    <div class="max-w-[1400px] mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        

        <!-- Controls Section (Search, Stats, Buttons, Filters) -->
        <div class="flex flex-col lg:flex-row justify-between items-end gap-6 mb-6">
            
            <!-- Left Side: Search and Stats -->
            <div class="w-full lg:w-auto flex-1">
                <!-- Search Bar -->
                <div class="relative w-full md:w-96 mb-6">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" class="bg-[#F4F4F5] text-gray-700 text-sm rounded-lg block w-full pl-10 p-2.5 outline-none border border-transparent focus:border-[#426E65] transition" placeholder="Cari agenda...">
                </div>

                <!-- Stat Cards -->
                <div class="flex flex-wrap gap-4">
                    <!-- Card 1: Total Agenda -->
                    <div class="border border-gray-100 shadow-sm rounded-xl p-4 flex items-center gap-4 bg-white min-w-[200px]">
                        <div class="w-12 h-12 rounded-full bg-[#E2E8F0] flex items-center justify-center text-[#475569]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide">TOTAL AGENDA</p>
                            <p class="text-2xl font-extrabold text-[#1F2937] leading-none mt-1">124</p>
                        </div>
                    </div>

                    <!-- Card 2: Akan Datang -->
                    <div class="border border-gray-100 shadow-sm rounded-xl p-4 flex items-center gap-4 bg-white min-w-[200px]">
                        <div class="w-12 h-12 rounded-full bg-[#FFEDD5] flex items-center justify-center text-[#EA580C]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide">AKAN DATANG</p>
                            <p class="text-2xl font-extrabold text-[#1F2937] leading-none mt-1">8</p>
                        </div>
                    </div>

                    <!-- Card 3: Selesai -->
                    <div class="border border-gray-100 shadow-sm rounded-xl p-4 flex items-center gap-4 bg-white min-w-[200px]">
                        <div class="w-12 h-12 rounded-full bg-[#F3E8FF] flex items-center justify-center text-[#9333EA]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide">SELESAI</p>
                            <p class="text-2xl font-extrabold text-[#1F2937] leading-none mt-1">86</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Action Button and Filters -->
            <div class="w-full lg:w-auto flex flex-col items-start lg:items-end gap-4">
                <button class="bg-[#22C55E] hover:bg-[#16A34A] text-white font-bold py-2.5 px-5 rounded-lg flex items-center gap-2 transition shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Agenda
                </button>
                
                <div class="flex flex-wrap gap-3">
                    <!-- Dropdown Surat Masuk -->
                    <button class="border border-gray-300 bg-white text-gray-700 font-medium py-2 px-4 rounded-lg flex items-center gap-6 hover:bg-gray-50 transition shadow-sm">
                        Surat Masuk
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Button Filter Tanggal -->
                    <button class="border border-gray-300 bg-white text-gray-700 font-medium py-2 px-4 rounded-lg flex items-center gap-2 hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter tanggal
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto rounded-t-xl border border-gray-200">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-[#426E65] text-white text-sm font-semibold">
                        <th class="px-4 py-3">Nama Agenda</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Ditugaskan</th>
                        <th class="px-4 py-3">Asal Surat</th>
                        <th class="px-4 py-3">Lampiran</th>
                        <th class="px-4 py-3">Tempat</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    
                    <!-- Row 1 -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-4 text-[#3C8271] font-bold text-sm leading-tight">
                            Rapat<br>Koordinasi<br>Pendidikan
                        </td>
                        <td class="px-4 py-4 text-gray-700 text-sm">Juli 15, 2026</td>
                        <td class="px-4 py-4 text-gray-700 text-sm">09:00 - 11:30<br><span class="text-xs text-gray-400">WIB</span></td>
                        <td class="px-4 py-4 text-gray-700 text-sm">Bidang<br>APTIKA</td>
                        <td class="px-4 py-4 text-gray-700 text-sm">Dinas Pendidikan</td>
                        <td class="px-4 py-4">
                            <a href="#" class="flex items-center gap-1.5 text-[#426E65] hover:underline font-bold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                Lihat<br>Lampiran
                            </a>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1.5 text-[#426E65] font-semibold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Zoom Meeting
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center">
                                <span class="bg-[#FFEDD5] text-[#EA580C] text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
                                    <div class="w-2 h-2 rounded-full bg-[#EA580C]"></div>
                                    Ongoing
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button class="p-1.5 bg-green-50 text-green-600 rounded-md hover:bg-green-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button class="p-1.5 bg-red-50 text-red-600 rounded-md hover:bg-red-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                <button class="p-1.5 text-gray-500 hover:text-gray-700 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-4 text-[#3C8271] font-bold text-sm leading-tight">
                            Rapat<br>Koordinasi<br>Pajak Daerah
                        </td>
                        <td class="px-4 py-4 text-gray-700 text-sm">Juli 15, 2026</td>
                        <td class="px-4 py-4 text-gray-700 text-sm">09:00 - 11:30<br><span class="text-xs text-gray-400">WIB</span></td>
                        <td class="px-4 py-4 text-gray-700 text-sm">Bidang<br>Publikasi</td>
                        <td class="px-4 py-4 text-gray-700 text-sm">Dinas</td>
                        <td class="px-4 py-4">
                            <a href="#" class="flex items-center gap-1.5 text-[#426E65] hover:underline font-bold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                Lihat<br>Lampiran
                            </a>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1.5 text-[#426E65] font-semibold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Zoom Meeting
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center">
                                <span class="bg-[#FFEDD5] text-[#EA580C] text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
                                    <div class="w-2 h-2 rounded-full bg-[#EA580C]"></div>
                                    Ongoing
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button class="p-1.5 bg-green-50 text-green-600 rounded-md hover:bg-green-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button class="p-1.5 bg-red-50 text-red-600 rounded-md hover:bg-red-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                <button class="p-1.5 text-gray-500 hover:text-gray-700 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-4 text-[#3C8271] font-bold text-sm leading-tight">
                            Rapat<br>Koordinasi<br>Pajak Daerah
                        </td>
                        <td class="px-4 py-4 text-gray-700 text-sm">Juli 15, 2026</td>
                        <td class="px-4 py-4 text-gray-700 text-sm">09:00 - 11:30<br><span class="text-xs text-gray-400">WIB</span></td>
                        <td class="px-4 py-4 text-gray-700 text-sm">Bidang</td>
                        <td class="px-4 py-4 text-gray-700 text-sm">Dinas</td>
                        <td class="px-4 py-4">
                            <a href="#" class="flex items-center gap-1.5 text-[#426E65] hover:underline font-bold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                Lihat<br>Lampiran
                            </a>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1.5 text-[#426E65] font-semibold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Zoom Meeting
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center">
                                <span class="bg-[#FFEDD5] text-[#EA580C] text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
                                    <div class="w-2 h-2 rounded-full bg-[#EA580C]"></div>
                                    Ongoing
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button class="p-1.5 bg-green-50 text-green-600 rounded-md hover:bg-green-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button class="p-1.5 bg-red-50 text-red-600 rounded-md hover:bg-red-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                <button class="p-1.5 text-gray-500 hover:text-gray-700 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-4 text-[#3C8271] font-bold text-sm leading-tight">
                            Rapat<br>Koordinasi<br>Pajak Daerah
                        </td>
                        <td class="px-4 py-4 text-gray-700 text-sm">Juli 15, 2026</td>
                        <td class="px-4 py-4 text-gray-700 text-sm">09:00 - 11:30<br><span class="text-xs text-gray-400">WIB</span></td>
                        <td class="px-4 py-4 text-gray-700 text-sm">Bidang</td>
                        <td class="px-4 py-4 text-gray-700 text-sm">Dinas</td>
                        <td class="px-4 py-4">
                            <a href="#" class="flex items-center gap-1.5 text-[#426E65] hover:underline font-bold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                Lihat<br>Lampiran
                            </a>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-1.5 text-[#426E65] font-semibold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Zoom Meeting
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center">
                                <span class="bg-[#FFEDD5] text-[#EA580C] text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
                                    <div class="w-2 h-2 rounded-full bg-[#EA580C]"></div>
                                    Ongoing
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <button class="p-1.5 bg-green-50 text-green-600 rounded-md hover:bg-green-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <button class="p-1.5 bg-red-50 text-red-600 rounded-md hover:bg-red-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                <button class="p-1.5 text-gray-500 hover:text-gray-700 transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-[#F8FAFC] border border-t-0 border-gray-200 rounded-b-xl px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <span class="text-sm text-gray-500 font-medium">Showing 1 to 10 of 124 entries</span>
            
            <div class="flex items-center gap-1">
                <button class="px-3 py-1.5 border border-gray-300 rounded bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50" disabled>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button class="px-3.5 py-1.5 border border-transparent rounded bg-[#3C8271] text-white font-medium shadow-sm">1</button>
                <button class="px-3.5 py-1.5 border border-gray-300 rounded bg-white text-gray-700 font-medium hover:bg-gray-50">2</button>
                <button class="px-3.5 py-1.5 border border-gray-300 rounded bg-white text-gray-700 font-medium hover:bg-gray-50">3</button>
                <button class="px-3 py-1.5 border border-gray-300 rounded bg-white text-gray-500 hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>

    </div>

</body>
</html>
@endsection