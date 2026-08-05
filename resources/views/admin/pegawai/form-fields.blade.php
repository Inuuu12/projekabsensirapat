@php
    $prefix = $prefix ?? '';
    $bidangMaster = collect($bidangMaster ?? []);
    $jabatanMaster = collect($jabatanMaster ?? []);
@endphp

<div class="col-span-full flex flex-col items-center py-2 sm:py-3">
    <input id="{{ $prefix }}foto" name="foto" type="file" accept="image/*" class="hidden" data-photo-input="{{ $prefix }}">
    <input type="hidden" id="{{ $prefix }}hapus_foto" name="hapus_foto" value="0">
    <label for="{{ $prefix }}foto" class="relative flex h-24 w-24 cursor-pointer items-center justify-center rounded-full border-2 border-dashed border-[#7b8d86] bg-white text-[#6f7d78] transition hover:border-[#35635b] hover:text-[#35635b]">
        <img id="{{ $prefix }}foto-preview" src="" alt="Preview foto" class="hidden h-full w-full rounded-full object-cover">
        <svg id="{{ $prefix }}foto-icon" class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 8a3 3 0 11-6 0 3 3 0 016 0zM16 19H8a4 4 0 018 0zM19 7v4m2-2h-4"></path>
        </svg>
        <span class="absolute -bottom-1 -right-1 flex h-7 w-7 items-center justify-center rounded-full border-2 border-white bg-[#0f5d3f] text-white shadow-sm">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3M8 12l4-4m0 0l4 4m-4-4v9"></path>
            </svg>
        </span>
    </label>
    <div class="flex gap-2 mt-3 items-center">
        <label for="{{ $prefix }}foto" class="cursor-pointer text-xs font-medium text-gray-600 hover:text-[#35635b]">Unggah Foto</label>
        <button type="button" class="text-xs font-medium text-red-500 hover:text-red-700 hidden" id="{{ $prefix }}btn-hapus-foto" onclick="removePhoto('{{ $prefix }}')">Hapus Foto</button>
    </div>
</div>

<div>
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">Nama Lengkap <span class="text-red-500">*</span></label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a3 3 0 11-6 0 3 3 0 016 0zM17 20H7a5 5 0 0110 0z"></path>
        </svg>
        <input id="{{ $prefix }}nama_pegawai" name="nama_pegawai" type="text" required placeholder="Masukkan nama lengkap" class="h-11 w-full rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
    </div>
</div>

<div>
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">NIP <span class="text-red-500">*</span></label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 7h6M9 11h6M9 15h3M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
        </svg>
        <input id="{{ $prefix }}nip" name="nip" type="text" required pattern="[0-9]+" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Masukkan Nomor Induk Pegawai" class="h-11 w-full rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
    </div>
</div>

<div>
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">Tanggal Lahir</label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V4m8 3V4M5 10h14M7 20h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v11a2 2 0 002 2z"></path>
        </svg>
        <input id="{{ $prefix }}tanggal_lahir" name="tanggal_lahir" type="date" class="h-11 w-full rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
    </div>
</div>

<div>
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">Jabatan</label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6h4m-7 4h10m-9 9h8a3 3 0 003-3v-5a2 2 0 00-2-2H7a2 2 0 00-2 2v5a3 3 0 003 3zM9 9V7a3 3 0 016 0v2"></path>
        </svg>
        <select id="{{ $prefix }}jabatan" name="jabatan" required class="h-11 w-full rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
            <option value="">Pilih Jabatan</option>
            @foreach ($jabatanMaster->groupBy(fn ($jabatan) => $jabatan->kategori ?: 'Lainnya') as $kategori => $jabatanItems)
                <optgroup label="{{ $kategori }}">
                    @foreach ($jabatanItems as $jabatan)
                        <option value="{{ $jabatan->nama_jabatan }}">{{ $jabatan->nama_jabatan }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </div>
</div>

<div>
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">Bidang</label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6h4m-7 4h10m-9 9h8a3 3 0 003-3v-5a2 2 0 00-2-2H7a2 2 0 00-2 2v5a3 3 0 003 3zM9 9V7a3 3 0 016 0v2"></path>
        </svg>
        <select id="{{ $prefix }}bidang" name="bidang" class="h-11 w-full rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
            <option value="">Pilih Bidang</option>
            @foreach ($bidangMaster as $bidang)
                <option value="{{ $bidang->nama_bidang }}">{{ $bidang->nama_bidang }}</option>
            @endforeach
        </select>
    </div>
</div>

<div>
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">Email <span class="text-red-500">*</span></label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16v12H4zM4 7l8 6 8-6"></path>
        </svg>
        <input id="{{ $prefix }}email" name="email" type="email" required placeholder="Masukkan Email" class="h-11 w-full rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
    </div>
</div>

<div>
    <label class="mb-1.5 block text-xs font-semibold text-gray-900">Kontak</label>
    <div class="relative">
        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 4h10a1 1 0 011 1v14a1 1 0 01-1 1H7a1 1 0 01-1-1V5a1 1 0 011-1zM10 18h4M9 7h6v8H9z"></path>
        </svg>
        <input id="{{ $prefix }}nomor_hp" name="nomor_hp" type="text" required pattern="[0-9]+" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Masukkan No telp" class="h-11 w-full rounded-lg border border-[#b9c9c1] bg-[#f4faf7] pl-10 pr-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
    </div>
</div>
