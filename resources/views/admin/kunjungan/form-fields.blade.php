@php
    $prefix = isset($prefix) ? $prefix : '';
@endphp
<div class="sm:col-span-2">
    <label for="{{ $prefix }}nama_pegawai" class="block text-xs font-bold text-gray-700 uppercase mb-1">Pihak Dituju *</label>
    <select id="{{ $prefix }}nama_pegawai" name="nama_pegawai" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none bg-white">
        <option value="">-- Pilih Pihak Dituju --</option>
        @foreach ($pegawaiList ?? [] as $p)
            <option value="{{ $p->nama_pegawai }}">{{ $p->nama_pegawai }} {{ $p->jabatan ? "({$p->jabatan})" : ($p->bidang ? "({$p->bidang})" : '') }}</option>
        @endforeach
    </select>
    <input type="hidden" id="{{ $prefix }}nama_pejabat" name="nama_pejabat">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Pengunjung</label>
    <input id="{{ $prefix }}nama_pengunjung" name="nama_pengunjung" type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Asal Instansi</label>
    <input id="{{ $prefix }}asal_instansi" name="asal_instansi" type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">No HP</label>
        <input id="{{ $prefix }}nomorhp_pengunjung" name="nomorhp_pengunjung" type="text" pattern="[0-9]+" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
        <input id="{{ $prefix }}email_pengunjung" name="email_pengunjung" type="email" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
    </div>
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Keperluan</label>
    <textarea id="{{ $prefix }}keperluan" name="keperluan" rows="3" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none"></textarea>
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Waktu Kunjungan</label>
    <input id="{{ $prefix }}waktu" name="waktu" type="time" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tanggal Kunjungan</label>
    <input id="{{ $prefix }}tanggal_kunjungan" name="tanggal_kunjungan" type="date" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
