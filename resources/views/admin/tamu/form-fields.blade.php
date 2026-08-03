@php($prefix = $prefix ?? '')

<div class="col-span-full flex flex-col items-center py-2 sm:py-3">
    <input id="{{ $prefix }}foto_selfie" name="foto_selfie" type="file" accept="image/*" class="hidden" data-tamu-photo-input="{{ $prefix }}">
    <input type="hidden" id="{{ $prefix }}hapus_foto_selfie" name="hapus_foto_selfie" value="0">
    <label for="{{ $prefix }}foto_selfie" class="relative flex h-24 w-24 cursor-pointer items-center justify-center rounded-full border-2 border-dashed border-[#7b8d86] bg-white text-[#6f7d78] transition hover:border-[#35635b] hover:text-[#35635b]">
        <img id="{{ $prefix }}foto_selfie-preview" src="" alt="Preview foto tamu" class="hidden h-full w-full rounded-full object-cover">
        <svg id="{{ $prefix }}foto_selfie-icon" class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 8a3 3 0 11-6 0 3 3 0 016 0zM16 19H8a4 4 0 018 0zM19 7v4m2-2h-4"></path>
        </svg>
        <span class="absolute -bottom-1 -right-1 flex h-7 w-7 items-center justify-center rounded-full border-2 border-white bg-[#0f5d3f] text-white shadow-sm">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3M8 12l4-4m0 0l4 4m-4-4v9"></path>
            </svg>
        </span>
    </label>
    <div class="flex gap-2 mt-3 items-center">
        <label for="{{ $prefix }}foto_selfie" class="cursor-pointer text-xs font-medium text-gray-600 hover:text-[#35635b]">Unggah Foto</label>
        <button type="button" class="text-xs font-medium text-red-500 hover:text-red-700 hidden" id="{{ $prefix }}btn-hapus-foto_selfie" onclick="removeTamuPhoto('{{ $prefix }}')">Hapus Foto</button>
    </div>
</div>

<div>
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">Nama Lengkap <span class="text-red-500">*</span></label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a3 3 0 11-6 0 3 3 0 016 0zM17 20H7a5 5 0 0110 0z"></path>
        </svg>
        <input id="{{ $prefix }}nama" name="nama" type="text" required placeholder="Masukkan nama lengkap" class="h-11 w-full rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
    </div>
</div>

<div>
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">NIK</label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 7h6M9 11h6M9 15h3M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
        </svg>
        <input id="{{ $prefix }}nik" name="nik" type="text" placeholder="Masukkan NIK" class="h-11 w-full rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
    </div>
</div>

<div>
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">Jabatan</label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6h4m-7 4h10m-9 9h8a3 3 0 003-3v-5a2 2 0 00-2-2H7a2 2 0 00-2 2v5a3 3 0 003 3zM9 9V7a3 3 0 016 0v2"></path>
        </svg>
        <input id="{{ $prefix }}jabatan" name="jabatan" type="text" placeholder="Contoh: Manager Operasional" class="h-11 w-full rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
    </div>
</div>

<div>
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">Kontak <span class="text-red-500">*</span></label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 4h10a1 1 0 011 1v14a1 1 0 01-1 1H7a1 1 0 01-1-1V5a1 1 0 011-1zM10 18h4M9 7h6v8H9z"></path>
        </svg>
        <input id="{{ $prefix }}no_hp" name="no_hp" type="text" required placeholder="Masukkan No telp" class="h-11 w-full rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
    </div>
</div>

<div>
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">Asal Instansi <span class="text-red-500">*</span></label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 21h16M6 21V7l6-3 6 3v14M9 10h1m4 0h1M9 14h1m4 0h1"></path>
        </svg>
        <input id="{{ $prefix }}asal_instansi" name="asal_instansi" type="text" required placeholder="Masukkan asal instansi" class="h-11 w-full rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
    </div>
</div>

<div class="sm:col-span-2">
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">Agenda <span class="text-red-500">*</span></label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V4m8 3V4M5 10h14M6 20h12a1 1 0 001-1V7a1 1 0 00-1-1H6a1 1 0 00-1 1v12a1 1 0 001 1z"></path>
        </svg>
        <select id="{{ $prefix }}id_agenda" name="id_agenda" required class="h-11 w-full appearance-none rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-10 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
            <option value="">Pilih agenda</option>
            @foreach ($agenda as $item)
                <option value="{{ $item->id_agenda }}">{{ $item->nama_agenda }}</option>
            @endforeach
        </select>
        <svg class="pointer-events-none absolute right-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>
</div>
