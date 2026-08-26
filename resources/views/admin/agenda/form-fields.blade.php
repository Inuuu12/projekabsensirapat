@php($prefix = $prefix ?? '')
@php($kategori = old('kategori_surat', $kategoriSurat ?? 'internal'))
@php($isMasuk = $kategori === 'masuk')

<input id="{{ $prefix }}kategori_surat" name="kategori_surat" type="hidden" value="{{ $kategori }}">
<input id="{{ $prefix }}status_qr" name="status_qr" type="hidden" value="nonaktif">
<input id="{{ $prefix }}status_fr" name="status_fr" type="hidden" value="0">

@if(! $isMasuk)
    <input id="{{ $prefix }}lokasi" name="lokasi" type="hidden" value="">
    <input id="{{ $prefix }}ditugaskan" name="ditugaskan" type="hidden" value="">
@endif

<div>
    <label class="mb-2 block text-sm font-bold text-[#0e2f27] dark:text-gray-200">Nama Agenda</label>
    <input id="{{ $prefix }}nama_agenda" name="nama_agenda" type="text" required placeholder="Masukkan nama agenda" class="h-11 w-full rounded-lg border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-4 text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-500 dark:placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div>
        <label class="mb-2 block text-sm font-bold text-[#0e2f27] dark:text-gray-200">Tanggal</label>
        <div class="relative">
            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3f4f49] dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V4m8 3V4M5 10h14M6 20h12a1 1 0 001-1V7a1 1 0 00-1-1H6a1 1 0 00-1 1v12a1 1 0 001 1z"></path>
            </svg>
            <input id="{{ $prefix }}tanggal" name="tanggal" type="date" required class="h-11 w-full rounded-lg border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] pl-10 pr-3 text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
        </div>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-[#0e2f27] dark:text-gray-200">Waktu Mulai</label>
        <div class="relative">
            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3f4f49] dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 11 0 0118 0z"></path>
            </svg>
            <input id="{{ $prefix }}waktu" name="waktu" type="time" required class="h-11 w-full rounded-lg border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] pl-10 pr-3 text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
        </div>
    </div>
    <div>
        <label class="mb-2 block text-sm font-bold text-[#0e2f27] dark:text-gray-200">Waktu Selesai</label>
        <div class="relative">
            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3f4f49] dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 11 0 0118 0z"></path>
            </svg>
            <input id="{{ $prefix }}waktu_selesai" name="waktu_selesai" type="time" class="h-11 w-full rounded-lg border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] pl-10 pr-3 text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
        </div>
    </div>
</div>

@if ($isMasuk)
<div class="relative" data-multi-select-container="{{ $prefix }}">
    <label class="mb-2 block text-sm font-bold text-[#0e2f27] dark:text-gray-200">Ditugaskan Kepada (Pilih Pegawai)</label>
    
    <input id="{{ $prefix }}ditugaskan" name="ditugaskan" type="hidden" value="">

    <div id="{{ $prefix }}ditugaskan-trigger" onclick="togglePegawaiDropdown('{{ $prefix }}')" class="min-h-[44px] w-full cursor-pointer rounded-lg border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3 py-2 text-sm text-gray-800 dark:text-white transition focus-within:border-[#35635b] focus-within:bg-white flex flex-wrap items-center gap-1.5 justify-between">
        <div id="{{ $prefix }}ditugaskan-selected-badges" class="flex flex-wrap items-center gap-1.5">
            <span class="text-gray-400 dark:text-gray-500 text-xs italic">Klik untuk memilih pegawai...</span>
        </div>
        <svg class="h-4 w-4 shrink-0 text-[#61706a] dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>

    <div id="{{ $prefix }}ditugaskan-dropdown" class="absolute left-0 right-0 top-full z-50 mt-1 hidden max-h-60 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#152420] p-3 shadow-xl overflow-hidden flex flex-col">
        <input type="text" id="{{ $prefix }}ditugaskan-search" oninput="filterPegawaiList('{{ $prefix }}')" placeholder="Cari nama atau jabatan..." class="mb-2 h-9 w-full rounded-md border border-gray-200 dark:border-[#284c43] bg-gray-50 dark:bg-[#0f1c19] px-3 text-xs text-gray-800 dark:text-white outline-none focus:border-[#35635b] focus:bg-white">

        <div id="{{ $prefix }}ditugaskan-list" class="space-y-3 overflow-y-auto max-h-48 pr-1">
            @php($groupedPegawai = ($pegawaiList ?? collect())->groupBy(fn($p) => !empty(trim($p->bidang)) ? trim($p->bidang) : 'Lainnya / Tanpa Bidang'))
            @forelse ($groupedPegawai as $bidangName => $items)
                <div class="bidang-group space-y-1">
                    <div class="sticky top-0 z-10 bg-[#e8f3ee] dark:bg-[#1b3832] px-2.5 py-1 text-[11px] font-extrabold uppercase tracking-wider text-[#1e4a42] dark:text-emerald-300 rounded-md flex items-center justify-between shadow-2xs">
                        <span>🏢 {{ $bidangName }}</span>
                        <span class="text-[10px] bg-white/70 dark:bg-black/30 px-1.5 py-0.5 rounded text-[#35635b] dark:text-emerald-400 font-bold">{{ count($items) }} Pegawai</span>
                    </div>
                    @foreach ($items as $peg)
                        <label class="flex items-center gap-2.5 rounded-lg px-2.5 py-1.5 text-xs text-gray-700 dark:text-gray-300 hover:bg-[#f4faf7] dark:hover:bg-[#1b332d] cursor-pointer transition">
                            <input type="checkbox" value="{{ $peg->nama_pegawai }}" onchange="updateDitugaskanSelected('{{ $prefix }}')" class="h-4 w-4 rounded border-gray-300 dark:border-[#284c43] text-[#35635b] focus:ring-[#35635b]">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900 dark:text-white">{{ $peg->nama_pegawai }}</span>
                                @if($peg->jabatan)
                                    <span class="text-[10px] text-gray-500 dark:text-gray-400">{{ $peg->jabatan }}</span>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>
            @empty
                <p class="p-2 text-center text-xs text-gray-400">Belum ada data pegawai.</p>
            @endforelse
        </div>
    </div>
</div>
@else
<div>
    <label class="mb-2 block text-sm font-bold text-[#0e2f27] dark:text-gray-200">Kuota</label>
    <input id="{{ $prefix }}kuota" name="kuota" type="number" min="0" placeholder="Kuota agenda" class="h-11 w-full rounded-lg border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-4 text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-500 dark:placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
</div>
@endif

<div>
    <label class="mb-2 block text-sm font-bold text-[#0e2f27] dark:text-gray-200">Asal Surat</label>
    <input id="{{ $prefix }}asal_surat" name="asal_surat" type="text" placeholder="Instansi/Bagian asal surat" class="h-11 w-full rounded-lg border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-4 text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-500 dark:placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
</div>

@if ($isMasuk)
<div>
    <label class="mb-2 block text-sm font-bold text-[#0e2f27] dark:text-gray-200">Tempat / Lokasi Kegiatan</label>
    <input id="{{ $prefix }}lokasi" name="lokasi" type="text" required placeholder="Contoh: Gedung Tegar Beriman / Ruang Rapat Instansi Luar" class="h-11 w-full rounded-lg border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-4 text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-500 dark:placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
    <input id="{{ $prefix }}id_ruangrapat" name="id_ruangrapat" type="hidden" value="{{ $ruang->first()->id_ruangrapat ?? 1 }}">
</div>
@else
<div>
    <label class="mb-2 block text-sm font-bold text-[#0e2f27] dark:text-gray-200">Tempat</label>
    <div class="relative">
        <select id="{{ $prefix }}id_ruangrapat" name="id_ruangrapat" required data-agenda-room-select="{{ $prefix }}" class="h-11 w-full appearance-none rounded-lg border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-4 pr-10 text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
            <option value="">Pilih ruang</option>
            @foreach ($ruang as $item)
                <option value="{{ $item->id_ruangrapat }}">{{ $item->nama_ruang }}</option>
            @endforeach
        </select>
        <svg class="pointer-events-none absolute right-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a] dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>
</div>
@endif

<div>
    <label class="mb-2 block text-sm font-bold text-[#0e2f27] dark:text-gray-200">Lampiran Surat Undangan</label>
    <input id="{{ $prefix }}lampiran" name="lampiran" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="hidden" data-agenda-file-input="{{ $prefix }}">
    <label for="{{ $prefix }}lampiran" class="flex min-h-[98px] cursor-pointer flex-col items-center justify-center rounded-lg border border-dashed border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-4 py-4 text-center transition hover:border-[#35635b] hover:bg-white dark:hover:bg-[#152420]">
        <svg class="mb-2 h-6 w-6 text-[#04733f] dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h7l5 5v13H7zM14 3v5h5M9 15h6M9 18h4"></path>
        </svg>
        <span id="{{ $prefix }}lampiran-label" class="text-sm font-medium text-[#0e2f27] dark:text-gray-200">Klik atau seret file PDF ke sini</span>
        <span class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Maksimal 5MB</span>
    </label>
</div>
