@extends('pegawai.layout.app')

@section('title', 'Kalender Booking & Pengajuan Agenda')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-sm font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-sm font-semibold space-y-1 shadow-xs">
            <div class="flex items-center gap-2 font-bold mb-1">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Gagal Mengajukan Agenda:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5 pl-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header + Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-lg font-black text-gray-900 dark:text-white">Kalender Booking Ruangan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Lihat jadwal pemakaian ruang rapat dan ajukan agenda rapat baru.</p>
        </div>
        <button onclick="openBookingModal()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#35635b] hover:bg-[#2a4f48] text-white text-sm font-bold shadow-md transition-all cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Ajukan Agenda Rapat Baru
        </button>
    </div>

    <!-- Date Slider Bar -->
    <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-xs p-4">
        <div class="flex items-center gap-3">
            <button onclick="shiftDateSlider(-7)" class="shrink-0 w-8 h-8 rounded-lg bg-gray-100 dark:bg-[#1a2d29] hover:bg-gray-200 dark:hover:bg-[#233a34] flex items-center justify-center text-gray-500 dark:text-gray-400 transition-colors cursor-pointer" title="7 Hari Sebelumnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div id="date-slider" class="flex-1 flex gap-2 overflow-x-auto scrollbar-hide pb-1">
                <!-- Dates filled by JS -->
            </div>
            <button onclick="shiftDateSlider(7)" class="shrink-0 w-8 h-8 rounded-lg bg-gray-100 dark:bg-[#1a2d29] hover:bg-gray-200 dark:hover:bg-[#233a34] flex items-center justify-center text-gray-500 dark:text-gray-400 transition-colors cursor-pointer" title="7 Hari Selanjutnya">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    <!-- Room Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5" id="room-cards">
        @foreach($ruangList as $ruang)
            <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-xs overflow-hidden transition-all hover:shadow-md hover:border-[#35635b]/30 flex flex-col justify-between">
                <div>
                    <!-- Room Header -->
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-[#233a34] flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-sm text-gray-800 dark:text-white">{{ $ruang->nama_ruang }}</h3>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Kapasitas: {{ $ruang->kapasitas }} orang</p>
                        </div>
                        <div class="w-9 h-9 rounded-xl bg-[#35635b]/10 dark:bg-emerald-900/30 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-[#35635b] dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H7m4 0v10"></path></svg>
                        </div>
                    </div>

                    <!-- Room Agenda Schedule for Selected Date -->
                    <div class="px-5 py-4 room-agenda-list space-y-2" data-ruang-id="{{ $ruang->id_ruangrapat }}">
                        <p class="text-xs text-gray-400 dark:text-gray-500 text-center py-3">Pilih tanggal untuk melihat jadwal</p>
                    </div>
                </div>

                <!-- Room Action Button -->
                <div class="p-4 border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#111e1b]">
                    <button onclick="openBookingModalForRoom({{ $ruang->id_ruangrapat }}, '{{ addslashes($ruang->nama_ruang) }}')"
                            class="w-full py-2.5 px-4 rounded-xl bg-[#35635b] hover:bg-[#2a4f48] text-white text-xs font-bold shadow-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Booking Ruangan Ini</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    @if($ruangList->isEmpty())
        <div class="bg-white dark:bg-[#152420] border border-gray-100 dark:border-[#233a34] rounded-2xl shadow-xs p-10 text-center">
            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path></svg>
            <p class="text-sm text-gray-400 dark:text-gray-500 font-medium">Belum ada ruang rapat terdaftar untuk instansi Anda.</p>
        </div>
    @endif
</div>

<!-- MODAL POPUP BOOKING & PENGAJUAN AGENDA -->
<div id="modal-booking-pengajuan" class="hidden fixed inset-0 z-[9999] items-center justify-center bg-black/50 backdrop-blur-xs p-4 overflow-y-auto">
    <div class="bg-white dark:bg-[#152420] rounded-2xl shadow-2xl w-full max-w-3xl my-6 border border-gray-200 dark:border-[#233a34] overflow-hidden transform transition-all">
        
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-100 dark:border-[#233a34] flex items-center justify-between sticky top-0 bg-white dark:bg-[#152420] z-10">
            <div>
                <h3 class="text-base font-bold text-gray-800 dark:text-white">Booking & Ajukan Agenda Baru</h3>
                <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Instansi: {{ $pegawai->nama_instansi }}</p>
            </div>
            <button onclick="closeBookingModal()" class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 flex items-center justify-center text-gray-500 dark:text-gray-300 transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Form Pengajuan -->
        <form id="form-booking-pengajuan" method="POST" action="{{ route('pegawai.pengajuan.store') }}" onsubmit="return validateFormBeforeSubmit(event)" class="p-6 space-y-5 max-h-[82vh] overflow-y-auto">
            @csrf

            <!-- Tanggal & Ruang Rapat -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Rapat <span class="text-red-500">*</span></label>
                    <input type="date" id="modal-field-tanggal" name="tanggal" required onchange="onModalFieldChange()" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Ruang Rapat <span class="text-red-500">*</span></label>
                    <select id="modal-field-ruangan" name="id_ruangrapat" required onchange="onModalFieldChange()" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                        <option value="">-- Pilih Ruangan --</option>
                        @foreach($ruangList as $ruang)
                            <option value="{{ $ruang->id_ruangrapat }}">{{ $ruang->nama_ruang }} (Kapasitas: {{ $ruang->kapasitas }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Visual Kartu Jam Terisi (AYO Style: Hanya Tampilkan yang Sudah Terisi) -->
            <div id="modal-conflict-box" class="hidden transition-all"></div>

            <!-- Input Jam Sendiri: Waktu Mulai & Waktu Selesai -->
            <div class="space-y-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Waktu Mulai <span class="text-red-500">*</span></label>
                        <input type="time" id="modal-field-waktu-mulai" name="waktu" required oninput="validateTimeInputsLive()" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Waktu Selesai</label>
                        <input type="time" id="modal-field-waktu-selesai" name="waktu_selesai" oninput="validateTimeInputsLive()" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 transition-all">
                    </div>
                </div>

                <!-- Live Feedback Indikator Jam Bentrok / Tersedia -->
                <div id="live-time-feedback" class="hidden text-xs rounded-xl p-3 font-semibold transition-all"></div>
            </div>

            <!-- Nama Agenda -->
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Agenda <span class="text-red-500">*</span></label>
                <input type="text" name="nama_agenda" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500" placeholder="Contoh: Rapat Koordinasi Bulanan APTIKA">
            </div>

            <!-- Penyelenggara & Kuota -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Penyelenggara</label>
                    <input type="text" name="penyelenggara" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500" placeholder="Nama penyelenggara / bidang">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Kuota Peserta</label>
                    <input type="number" name="kuota" value="20" min="1" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi / Catatan Rapat</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-[#284c43] bg-white dark:bg-[#0f1c19] text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 resize-none" placeholder="Keterangan agenda rapat (opsional)"></textarea>
            </div>

            <!-- Footer Buttons -->
            <div class="flex justify-end gap-3 pt-3 border-t border-gray-100 dark:border-[#233a34]">
                <button type="button" onclick="closeBookingModal()" class="px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-[#0f1c19] border border-gray-200 dark:border-[#284c43] text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-[#1a2d29] transition-colors cursor-pointer">Batal</button>
                <button type="submit" id="btn-submit-pengajuan" class="px-5 py-2.5 rounded-xl bg-[#35635b] hover:bg-[#2a4f48] text-white text-sm font-bold shadow-md transition-all cursor-pointer">Kirim Pengajuan Agenda</button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@push('scripts')
<script>
    const agendaData = @json($agendaByDate);
    const hariLabel = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
    const bulanLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    
    let sliderStartDate = new Date();
    sliderStartDate.setHours(0,0,0,0);
    const dayOfWeek = sliderStartDate.getDay();
    sliderStartDate.setDate(sliderStartDate.getDate() - ((dayOfWeek + 6) % 7));

    let selectedDateStr = formatDate(new Date());

    function formatDate(d) {
        return d.getFullYear() + '-' + String(d.getMonth()+1).padStart(2,'0') + '-' + String(d.getDate()).padStart(2,'0');
    }

    function formatDateFormatted(ds) {
        if (!ds) return '-';
        const parts = ds.split('-');
        if (parts.length < 3) return ds;
        const year = parts[0];
        const monthIndex = parseInt(parts[1], 10) - 1;
        const day = parseInt(parts[2], 10);
        return `${day} ${bulanLabel[monthIndex]} ${year}`;
    }

    function calculateDurationMinutes(startStr, endStr) {
        if (!startStr) return '60 Menit';
        const s = startStr.substring(0, 5);
        const e = endStr ? endStr.substring(0, 5) : null;
        if (!e) return '60 Menit';
        const [h1, m1] = s.split(':').map(Number);
        const [h2, m2] = e.split(':').map(Number);
        let diff = (h2 * 60 + m2) - (h1 * 60 + m1);
        if (diff <= 0) diff += 1440;
        return `${diff} Menit`;
    }

    function renderDateSlider() {
        const slider = document.getElementById('date-slider');
        slider.innerHTML = '';
        const today = formatDate(new Date());

        for (let i = 0; i < 14; i++) {
            const d = new Date(sliderStartDate);
            d.setDate(d.getDate() + i);
            const ds = formatDate(d);
            const isToday = ds === today;
            const isSelected = ds === selectedDateStr;

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `flex flex-col items-center justify-center min-w-[54px] px-2.5 py-2.5 rounded-xl transition-all cursor-pointer shrink-0 ${
                isSelected
                    ? 'bg-[#35635b] text-white shadow-md font-bold'
                    : isToday
                        ? 'bg-emerald-50 dark:bg-emerald-900/20 text-[#35635b] dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800'
                        : 'hover:bg-gray-100 dark:hover:bg-[#1a2d29] text-gray-600 dark:text-gray-400 border border-transparent'
            }`;
            btn.innerHTML = `
                <span class="text-[10px] font-bold uppercase tracking-wider ${isSelected ? 'text-emerald-200' : ''}">${hariLabel[d.getDay()]}</span>
                <span class="text-lg font-black mt-0.5">${d.getDate()}</span>
                <span class="text-[9px] font-semibold ${isSelected ? 'text-emerald-200' : 'text-gray-400 dark:text-gray-500'}">${bulanLabel[d.getMonth()]}</span>
            `;
            btn.onclick = () => selectDate(ds);
            slider.appendChild(btn);
        }
    }

    function selectDate(ds) {
        selectedDateStr = ds;
        renderDateSlider();
        renderRoomAgendas();
    }

    function shiftDateSlider(days) {
        sliderStartDate.setDate(sliderStartDate.getDate() + days);
        renderDateSlider();
    }

    function renderRoomAgendas() {
        document.querySelectorAll('.room-agenda-list').forEach(container => {
            const ruangId = container.dataset.ruangId;
            const dateAgendas = agendaData[selectedDateStr] || [];
            const roomAgendas = dateAgendas.filter(a => String(a.id_ruangrapat) === String(ruangId));

            if (roomAgendas.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-5 text-center">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60 mb-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Ruangan Kosong (Tersedia)
                        </div>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500">Belum ada agenda terdaftar di tanggal ini</p>
                    </div>
                `;
            } else {
                container.innerHTML = roomAgendas.map(a => `
                    <div class="p-3.5 rounded-xl bg-amber-50/70 dark:bg-amber-950/30 border border-amber-200/80 dark:border-amber-900/50 space-y-1.5">
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-extrabold ${
                                a.status_badge === 'disetujui'
                                    ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300'
                                    : 'bg-amber-200 text-amber-900 dark:bg-amber-900/80 dark:text-amber-200'
                            }">
                                <span class="w-1.5 h-1.5 rounded-full ${a.status_badge === 'disetujui' ? 'bg-emerald-500' : 'bg-amber-500'}"></span>
                                ${a.status_label || 'Terbooking'}
                            </span>
                            <span class="text-xs font-black text-amber-900 dark:text-amber-300 bg-amber-100 dark:bg-amber-900/60 px-2 py-0.5 rounded-lg border border-amber-200 dark:border-amber-700/50">
                                🕒 ${a.waktu || '-'}${a.waktu_selesai ? ' - ' + a.waktu_selesai : ''} WIB
                            </span>
                        </div>
                        <p class="text-xs font-bold text-gray-900 dark:text-white leading-snug">${a.nama_agenda}</p>
                    </div>
                `).join('');
            }
        });
    }

    function openBookingModalForRoom(ruangId, namaRuang) {
        const modal = document.getElementById('modal-booking-pengajuan');
        document.getElementById('modal-field-tanggal').value = selectedDateStr;
        document.getElementById('modal-field-ruangan').value = ruangId;
        
        onModalFieldChange();

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function openBookingModal() {
        const modal = document.getElementById('modal-booking-pengajuan');
        document.getElementById('modal-field-tanggal').value = selectedDateStr;
        
        onModalFieldChange();

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeBookingModal() {
        const modal = document.getElementById('modal-booking-pengajuan');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function onModalFieldChange() {
        const selectedDate = document.getElementById('modal-field-tanggal').value;
        const selectedRuangId = document.getElementById('modal-field-ruangan').value;
        const conflictBox = document.getElementById('modal-conflict-box');

        if (!selectedDate || !selectedRuangId) {
            conflictBox.classList.add('hidden');
            return;
        }

        const dateAgendas = agendaData[selectedDate] || [];
        const roomAgendas = dateAgendas.filter(a => String(a.id_ruangrapat) === String(selectedRuangId));
        const selectElem = document.getElementById('modal-field-ruangan');
        const ruangName = selectElem.options[selectElem.selectedIndex]?.text || 'Ruangan Dipilih';

        conflictBox.classList.remove('hidden');

        // Jika BELUM ADA agenda yang dibooking pada tanggal ini
        if (roomAgendas.length === 0) {
            conflictBox.className = 'rounded-2xl p-4 bg-emerald-50/80 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-300';
            conflictBox.innerHTML = `
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-black text-emerald-800 dark:text-emerald-300">Seluruh Jam Masih Tersedia</span>
                </div>
                <p class="text-[11px] text-emerald-700 dark:text-emerald-400 mt-1">
                    Belum ada jadwal yang terisi/dibooking pada tanggal <strong>${formatDateFormatted(selectedDate)}</strong> di ruangan ini. Silakan input jam mulai & selesai sesuai kebutuhan rapat Anda.
                </p>
            `;
            return;
        }

        // Jika SUDAH ADA jadwal yang terisi, HANYA TAMPILKAN yang sudah terisi (AYO Indonesia Style)
        let bookedCardsHtml = roomAgendas.map(a => {
            const start = a.waktu ? a.waktu.substring(0, 5) : '-';
            const end = a.waktu_selesai ? a.waktu_selesai.substring(0, 5) : 'Selesai';
            const duration = calculateDurationMinutes(a.waktu, a.waktu_selesai);

            return `
                <div class="p-3.5 rounded-2xl border border-gray-200/90 dark:border-white/10 bg-gray-100/80 dark:bg-white/5 text-center flex flex-col items-center justify-center select-none shadow-2xs">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-400">${duration}</span>
                    <span class="text-sm font-black text-gray-800 dark:text-white my-1">${start} - ${end} WIB</span>
                    <span class="text-xs font-black text-rose-600 dark:text-rose-400">Booked</span>
                    <span class="text-[10px] font-medium text-gray-500 dark:text-gray-400 truncate max-w-full mt-0.5" title="${a.nama_agenda}">
                        ${a.nama_agenda}
                    </span>
                </div>
            `;
        }).join('');

        conflictBox.className = 'rounded-2xl p-4 bg-gray-50 dark:bg-[#111e1b] border border-gray-200 dark:border-[#284c43] space-y-3';
        conflictBox.innerHTML = `
            <div class="flex items-center justify-between gap-2">
                <div>
                    <h4 class="text-xs font-black text-gray-800 dark:text-white uppercase tracking-wider">Jadwal yang Sudah Terisi (Booked)</h4>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Tanggal: <strong class="text-emerald-600 dark:text-emerald-400">${formatDateFormatted(selectedDate)}</strong></p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-900/50 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    <span>${roomAgendas.length} Jadwal Terisi</span>
                </span>
            </div>

            <!-- Grid Jadwal yang Sudah Terisi (AYO Style) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                ${bookedCardsHtml}
            </div>

            <p class="text-[11px] text-amber-700 dark:text-amber-400 font-semibold bg-amber-50 dark:bg-amber-950/30 p-2.5 rounded-xl border border-amber-200 dark:border-amber-900/40">
                ⚠️ Jam di atas sudah dibooking. Silakan input jam rapat Anda pada form di bawah di luar rentang jam tersebut agar tidak bentrok.
            </p>
        `;

        // Re-validasi input waktu jika sebelumnya sudah terisi
        validateTimeInputsLive();
    }

    function timeToMinutes(tStr) {
        if (!tStr) return null;
        const [h, m] = tStr.substring(0, 5).split(':').map(Number);
        return h * 60 + m;
    }

    function setInputStatus(isError, isSuccess) {
        const inMulai = document.getElementById('modal-field-waktu-mulai');
        const inSelesai = document.getElementById('modal-field-waktu-selesai');
        const btnSubmit = document.getElementById('btn-submit-pengajuan');

        [inMulai, inSelesai].forEach(el => {
            if (!el) return;
            el.classList.remove('border-rose-500', 'ring-2', 'ring-rose-500/30', 'border-emerald-500', 'ring-emerald-500/30');
            if (isError) {
                el.classList.add('border-rose-500', 'ring-2', 'ring-rose-500/30');
            } else if (isSuccess) {
                el.classList.add('border-emerald-500', 'ring-2', 'ring-emerald-500/30');
            }
        });

        if (btnSubmit) {
            btnSubmit.disabled = isError;
            if (isError) {
                btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
    }

    function validateFormBeforeSubmit(e) {
        validateTimeInputsLive();
        const btnSubmit = document.getElementById('btn-submit-pengajuan');
        if (btnSubmit && btnSubmit.disabled) {
            if (e) e.preventDefault();
            return false;
        }
        return true;
    }

    function validateTimeInputsLive() {
        const inMulai = document.getElementById('modal-field-waktu-mulai');
        const inSelesai = document.getElementById('modal-field-waktu-selesai');
        const feedback = document.getElementById('live-time-feedback');
        const selectedDate = document.getElementById('modal-field-tanggal')?.value;
        const selectedRuangId = document.getElementById('modal-field-ruangan')?.value;

        if (!inMulai || !feedback) return;

        const valMulai = inMulai.value;
        const valSelesai = inSelesai?.value;

        // Jika waktu mulai belum diisi
        if (!valMulai) {
            feedback.classList.add('hidden');
            setInputStatus(false, false);
            return;
        }

        const startMin = timeToMinutes(valMulai);
        let endMin = timeToMinutes(valSelesai);

        // Jika waktu selesai diisi tapi lebih kecil / sama dengan waktu mulai
        if (endMin !== null && endMin <= startMin) {
            feedback.className = 'text-xs rounded-xl p-3 font-semibold transition-all bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-900/60 text-amber-800 dark:text-amber-300 block';
            feedback.innerHTML = `
                <div class="flex items-center gap-2">
                    <span class="text-base">⚠️</span>
                    <div>Waktu selesai harus lebih lambat dari waktu mulai.</div>
                </div>
            `;
            setInputStatus(true, false);
            return;
        }

        // Default durasi 1 jam jika belum mengisi waktu selesai
        const checkEndMin = endMin !== null ? endMin : startMin + 60;

        // Ambil agenda pada tanggal dan ruangan yang dipilih
        const dateAgendas = agendaData[selectedDate] || [];
        const roomAgendas = dateAgendas.filter(a => String(a.id_ruangrapat) === String(selectedRuangId));

        let conflictAgenda = null;
        for (const a of roomAgendas) {
            const aStart = timeToMinutes(a.waktu);
            let aEnd = timeToMinutes(a.waktu_selesai);
            if (aStart === null) continue;
            if (aEnd === null) aEnd = aStart + 60;

            // Logika Overlap: start < existing_end && end > existing_start
            if (startMin < aEnd && checkEndMin > aStart) {
                conflictAgenda = a;
                break;
            }
        }

        if (conflictAgenda) {
            const aStartStr = conflictAgenda.waktu ? conflictAgenda.waktu.substring(0, 5) : '-';
            const aEndStr = conflictAgenda.waktu_selesai ? conflictAgenda.waktu_selesai.substring(0, 5) : 'Selesai';

            feedback.className = 'text-xs rounded-xl p-3 font-semibold transition-all bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-900/60 text-rose-700 dark:text-rose-300 block animate-shake';
            feedback.innerHTML = `
                <div class="flex items-start gap-2.5">
                    <span class="text-lg leading-none">⛔</span>
                    <div>
                        <div class="font-black text-rose-800 dark:text-rose-200 text-xs uppercase tracking-wide">Waktu Tidak Tersedia (Bentrok)!</div>
                        <div class="text-[11px] text-rose-700 dark:text-rose-300 mt-1 leading-relaxed">
                            Jam yang Anda input bentrok dengan agenda: <strong class="underline">${conflictAgenda.nama_agenda}</strong> (Pukul <strong>${aStartStr} - ${aEndStr} WIB</strong>).
                            Silakan ganti jam rapat Anda di luar rentang jam tersebut.
                        </div>
                    </div>
                </div>
            `;
            setInputStatus(true, false);
        } else {
            feedback.className = 'text-xs rounded-xl p-3 font-semibold transition-all bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900/60 text-emerald-800 dark:text-emerald-300 block';
            feedback.innerHTML = `
                <div class="flex items-center gap-2">
                    <span class="text-base">✅</span>
                    <div>
                        <span class="font-black text-emerald-800 dark:text-emerald-200">Jam Tersedia!</span>
                        <span class="text-[11px] text-emerald-700 dark:text-emerald-300 ml-1">Ruangan kosong pada pukul <strong>${valMulai}${valSelesai ? ' - ' + valSelesai : ''} WIB</strong>.</span>
                    </div>
                </div>
            `;
            setInputStatus(false, true);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderDateSlider();
        renderRoomAgendas();
    });
</script>
@endpush
@endsection
