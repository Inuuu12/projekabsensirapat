@extends('pegawai.layout.app')

@section('title', 'Kalender Ruang Rapat')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-lg font-black text-gray-900 dark:text-white">Kalender Ruang Rapat</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Lihat jadwal pemakaian dan ketersediaan ruang rapat.</p>
        </div>
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

                <!-- Room Footer Info -->
                <div class="px-5 py-3 border-t border-gray-100 dark:border-[#233a34] bg-gray-50/50 dark:bg-[#111e1b] flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                    <span>Lokasi: {{ $ruang->lokasi ?? 'Kantor Dinas' }}</span>
                    <span class="font-medium text-emerald-600 dark:text-emerald-400">{{ $ruang->fasilitas ? 'Fasilitas Tersedia' : 'Standar' }}</span>
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
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-extrabold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                ${a.status_label || 'Terisi'}
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

    document.addEventListener('DOMContentLoaded', () => {
        renderDateSlider();
        renderRoomAgendas();
    });
</script>
@endpush
@endsection
