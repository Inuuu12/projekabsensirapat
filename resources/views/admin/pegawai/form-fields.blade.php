@php($prefix = $prefix ?? '')

<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Pegawai</label>
    <input id="{{ $prefix }}nama_pegawai" name="nama_pegawai" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">NIP</label>
    <input id="{{ $prefix }}nip" name="nip" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Jabatan</label>
    <input id="{{ $prefix }}jabatan" name="jabatan" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">No HP</label>
    <input id="{{ $prefix }}nomor_hp" name="nomor_hp" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
    <input id="{{ $prefix }}email" name="email" type="email" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div><label class="block text-xs font-bold text-gray-700 uppercase mb-1">Foto</label>
    <input id="{{ $prefix }}foto" name="foto" type="file" accept="image/*" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
    