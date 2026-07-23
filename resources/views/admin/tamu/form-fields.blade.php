@php($prefix = $prefix ?? '')
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama</label>
    <input id="{{ $prefix }}nama" name="nama" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">NIK</label>
    <input id="{{ $prefix }}nik" name="nik" type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Jabatan</label>
    <input id="{{ $prefix }}jabatan" name="jabatan" type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">No HP</label>
    <input id="{{ $prefix }}no_hp" name="no_hp" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Asal Instansi</label>
    <input id="{{ $prefix }}asal_instansi" name="asal_instansi" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Agenda</label>
    <select id="{{ $prefix }}id_agenda" name="id_agenda" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
        <option value="">Pilih agenda</option>
        @foreach ($agenda as $item)
            <option value="{{ $item->id_agenda }}">{{ $item->nama_agenda }}</option>
        @endforeach
    </select>
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Foto</label>
    <input id="{{ $prefix }}foto_selfie" name="foto_selfie" type="file" accept="image/*" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">

</div>
    
