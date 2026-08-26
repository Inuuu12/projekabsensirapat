@php
    $prefix = isset($prefix) ? $prefix : '';
@endphp
<div class="col-span-full">
    <label for="{{ $prefix }}nama_pegawai" class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase mb-1.5">Pihak Dituju *</label>
    <div class="relative">
        <select id="{{ $prefix }}nama_pegawai" name="nama_pegawai" required class="h-10 sm:h-11 w-full appearance-none rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 pr-10 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
            <option value="">-- Pilih Pihak Dituju --</option>
            @foreach ($pegawaiList ?? [] as $p)
                <option value="{{ $p->nama_pegawai }}">{{ $p->nama_pegawai }} {{ $p->jabatan ? "({$p->jabatan})" : ($p->bidang ? "({$p->bidang})" : '') }}</option>
            @endforeach
        </select>
        <svg class="pointer-events-none absolute right-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#61706a] dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>
    <input type="hidden" id="{{ $prefix }}nama_pejabat" name="nama_pejabat">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase mb-1.5">Nama Pengunjung</label>
    <input id="{{ $prefix }}nama_pengunjung" name="nama_pengunjung" type="text" placeholder="Masukkan nama pengunjung" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase mb-1.5">Asal Instansi</label>
    <input id="{{ $prefix }}asal_instansi" name="asal_instansi" type="text" placeholder="Masukkan asal instansi" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase mb-1.5">No HP</label>
    <input id="{{ $prefix }}nomorhp_pengunjung" name="nomorhp_pengunjung" type="text" pattern="[0-9]+" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="08xxxxxxxxxx" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
</div>
<div>
    <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase mb-1.5">Email</label>
    <input id="{{ $prefix }}email_pengunjung" name="email_pengunjung" type="email" placeholder="email@contoh.com" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
</div>
<div class="col-span-full">
    <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase mb-1.5">Keperluan</label>
    <textarea id="{{ $prefix }}keperluan" name="keperluan" rows="3" required placeholder="Masukkan keperluan kunjungan" class="w-full resize-none rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20"></textarea>
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase mb-1.5">Waktu Kunjungan</label>
    <input id="{{ $prefix }}waktu" name="waktu" type="time" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase mb-1.5">Tanggal Kunjungan</label>
    <input id="{{ $prefix }}tanggal_kunjungan" name="tanggal_kunjungan" type="date" required class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
</div>
