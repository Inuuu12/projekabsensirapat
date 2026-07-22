@php($prefix = $prefix ?? '')
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Agenda</label>
    <input id="{{ $prefix }}nama_agenda" name="nama_agenda" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kategori Surat</label>
        <select id="{{ $prefix }}kategori_surat" name="kategori_surat" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
            <option value="internal">Surat Internal</option>
            <option value="masuk">Surat Masuk</option>
            <option value="keluar">Surat Keluar</option>
        </select>
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Asal Surat</label>
        <input id="{{ $prefix }}asal_surat" name="asal_surat" type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
    </div>
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Ditugaskan</label>
    <input id="{{ $prefix }}ditugaskan" name="ditugaskan" type="text" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none" placeholder="Diisi terutama untuk Surat Masuk">
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tanggal</label>
        <input id="{{ $prefix }}tanggal" name="tanggal" type="date" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Waktu</label>
        <input id="{{ $prefix }}waktu" name="waktu" type="time" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
    </div>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kuota</label>
        <input id="{{ $prefix }}kuota" name="kuota" type="number" min="0" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Status QR</label>
        <select id="{{ $prefix }}status_qr" name="status_qr" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
            <option value="nonaktif">Nonaktif</option>
            <option value="aktif">Aktif</option>
        </select>
    </div>
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Lokasi</label>
    <input id="{{ $prefix }}lokasi" name="lokasi" type="text" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Ruang</label>
        <select id="{{ $prefix }}id_ruangrapat" name="id_ruangrapat" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
            <option value="">Pilih ruang</option>
            @foreach ($ruang as $item)
                <option value="{{ $item->id_ruangrapat }}">{{ $item->nama_ruang }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Status Agenda</label>
        <select id="{{ $prefix }}id_statusagenda" name="id_statusagenda" required class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
            <option value="">Pilih status</option>
            @foreach ($statusAgenda as $item)
                <option value="{{ $item->id_statusagenda }}">{{ $item->nama_status }}</option>
            @endforeach
        </select>
    </div>
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Lampiran</label>
    <input id="{{ $prefix }}lampiran" name="lampiran" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm focus:border-[#35635b] outline-none">
</div>
<label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-700">
    <input id="{{ $prefix }}status_fr" name="status_fr" type="checkbox" value="1" class="rounded border-gray-300 text-[#35635b] focus:ring-[#35635b]">
    Aktifkan Face Recognition
</label>
