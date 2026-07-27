@php($prefix = $prefix ?? '')

<input id="{{ $prefix }}kategori_surat" name="kategori_surat" type="hidden" value="{{ old('kategori_surat', $kategoriSurat ?? 'internal') }}">
<input id="{{ $prefix }}lokasi" name="lokasi" type="hidden" value="">
<input id="{{ $prefix }}id_statusagenda" name="id_statusagenda" type="hidden" value="{{ $statusAgenda->first()->id_statusagenda ?? '' }}">
<input id="{{ $prefix }}status_qr" name="status_qr" type="hidden" value="nonaktif">
<input id="{{ $prefix }}status_fr" name="status_fr" type="hidden" value="0">
<input id="{{ $prefix }}ditugaskan" name="ditugaskan" type="hidden" value="">

<div>
    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Nama Agenda</label>
    <input id="{{ $prefix }}nama_agenda" name="nama_agenda" type="text" required placeholder="Masukkan nama agenda" class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div>
        <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Tanggal</label>
        <div class="relative">
            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3f4f49]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V4m8 3V4M5 10h14M6 20h12a1 1 0 001-1V7a1 1 0 00-1-1H6a1 1 0 00-1 1v12a1 1 0 001 1z"></path>
            </svg>
            <input id="{{ $prefix }}tanggal" name="tanggal" type="date" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
        </div>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Waktu Mulai</label>
        <div class="relative">
            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3f4f49]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <input id="{{ $prefix }}waktu" name="waktu" type="time" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
        </div>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Waktu Selesai</label>
        <div class="relative">
            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3f4f49]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <input id="{{ $prefix }}waktu_selesai" name="waktu_selesai" type="time" class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
        </div>
    </div>
</div>

<div>
    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Kuota</label>
    <input id="{{ $prefix }}kuota" name="kuota" type="number" min="0" placeholder="Kuota agenda" class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
</div>

<div>
    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Asal Surat</label>
    <input id="{{ $prefix }}asal_surat" name="asal_surat" type="text" placeholder="Instansi/Bagian asal surat" class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
</div>

<div>
    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Tempat</label>
    <div class="relative">
        <select id="{{ $prefix }}id_ruangrapat" name="id_ruangrapat" required data-agenda-room-select="{{ $prefix }}" class="h-11 w-full appearance-none rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 pr-10 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
            <option value="">Pilih ruang</option>
            @foreach ($ruang as $item)
                <option value="{{ $item->id_ruangrapat }}">{{ $item->nama_ruang }}</option>
            @endforeach
        </select>
        <svg class="pointer-events-none absolute right-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>
</div>

<div>
    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Lampiran Surat Undangan</label>
    <input id="{{ $prefix }}lampiran" name="lampiran" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="hidden" data-agenda-file-input="{{ $prefix }}">
    <label for="{{ $prefix }}lampiran" class="flex min-h-[98px] cursor-pointer flex-col items-center justify-center rounded-lg border border-dashed border-[#c9ddd4] bg-[#f4faf7] px-4 py-4 text-center transition hover:border-[#35635b] hover:bg-white">
        <svg class="mb-2 h-6 w-6 text-[#04733f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h7l5 5v13H7zM14 3v5h5M9 15h6M9 18h4"></path>
        </svg>
        <span id="{{ $prefix }}lampiran-label" class="text-sm font-medium text-[#0e2f27]">Klik atau seret file PDF ke sini</span>
        <span class="mt-0.5 text-xs text-gray-500">Maksimal 5MB</span>
    </label>
</div>
