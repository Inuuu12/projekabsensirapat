@extends('admin.layout.app')

@section('title', 'Detail Agenda')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Detail Agenda</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Informasi agenda, dokumen, dan status absensi.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <section class="lg:col-span-7 space-y-6">
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-xs">
                <span class="text-xs font-bold text-[#35635b] tracking-wider uppercase bg-[#35635b]/10 px-2.5 py-1 rounded-lg">Informasi Agenda</span>
                <h2 class="text-xl font-extrabold text-gray-800 mt-4">Rapat Koordinasi Evaluasi PAD Triwulan III</h2>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5 text-sm">
                    <div>
                        <dt class="text-xs font-semibold text-gray-400">Tanggal</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">15 Okt 2023</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-gray-400">Waktu</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">09:00 - 12:00 WIB</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold text-gray-400">Tempat</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">Ruang Rapat Utama BAPPENDA Gedung A Lt. 2</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold text-gray-400">Asal Surat</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">Sekretariat Daerah Kabupaten Bogor</dd>
                    </div>
                </dl>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="border-2 border-dashed border-gray-200 p-5 rounded-2xl text-center bg-white">
                    <p class="text-sm font-bold text-gray-700">Notulen Agenda</p>
                    <p class="text-xs text-gray-400 mt-1">Belum ada dokumen.</p>
                </div>
                <div class="border-2 border-dashed border-gray-200 p-5 rounded-2xl text-center bg-white">
                    <p class="text-sm font-bold text-gray-700">Dokumentasi Agenda</p>
                    <p class="text-xs text-gray-400 mt-1">Belum ada dokumentasi.</p>
                </div>
            </div>
        </section>

        <section class="lg:col-span-5 bg-white border border-gray-100 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                <h2 class="text-sm font-bold text-gray-800 tracking-wide uppercase">Peserta Hadir</h2>
                <span class="bg-[#35635b] text-white text-[10px] font-bold px-2 py-0.5 rounded-full">3 Hadir</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 uppercase tracking-wider text-[10px] border-b border-gray-100">
                            <th class="pb-2 font-semibold">Nama</th>
                            <th class="pb-2 font-semibold">Jabatan</th>
                            <th class="pb-2 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr>
                            <td class="py-3 font-bold text-gray-900">Budi Santoso</td>
                            <td class="py-3 text-gray-500">Kepala Bidang</td>
                            <td class="py-3"><span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded text-[10px] font-bold">Hadir</span></td>
                        </tr>
                        <tr>
                            <td class="py-3 font-bold text-gray-900">Siti Aminah</td>
                            <td class="py-3 text-gray-500">Staf Analis</td>
                            <td class="py-3"><span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded text-[10px] font-bold">Hadir</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection
