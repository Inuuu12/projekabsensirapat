@extends('admin.layout.app')

@section('title', 'Konten Publik')

@section('content')
@php
    $imageUrl = function ($path, $fallback = 'foto/Suratlogo.png') {
        if (! $path) {
            return asset($fallback);
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (str_starts_with($path, 'foto/') || str_starts_with($path, 'uploads/')) {
            return asset($path);
        }

        return asset('storage/' . $path);
    };
    $galleryImagePath = fn ($item) => $item->file_path ?? $item->gambar ?? null;
    $galleryDate = fn ($item) => $item->agenda?->tanggal ?? $item->tanggal ?? $item->created_at ?? null;
    $galleryTitle = fn ($item) => $item->agenda?->nama_agenda ?? 'Dokumentasi Agenda';
@endphp

<div class="max-w-[1400px] mx-auto space-y-6">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] dark:text-white tracking-tight">Konten Publik</h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-300 mt-1">Kelola dan publikasikan informasi berita, galeri, ucapan ulang tahun, serta video ke portal publik.</p>
    </div>

    <section class="bg-white dark:bg-[#152420] rounded-2xl border border-gray-100 dark:border-[#233a34] shadow-xs p-5 transition-colors">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Tambah Konten</h2>
                <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">Pilih jenis konten publik yang ingin ditambahkan.</p>
            </div>
        </div>
        <div class="mt-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <button type="button" onclick="openPublicModal('modal-tambah-berita')" class="flex items-center justify-between gap-4 rounded-xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#0f1c19] p-4 text-left shadow-xs transition hover:border-[#35635b] hover:bg-gray-50 dark:hover:bg-[#1b3832] cursor-pointer">
                <span>
                    <span class="block text-sm font-extrabold text-gray-800 dark:text-white">Berita</span>
                    <span class="mt-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Tambah berita publik</span>
                </span>
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gray-50 dark:bg-[#152420] p-2">
                    <img src="{{ asset('foto/Beritalogo.png') }}" alt="Berita" class="h-full w-full object-contain">
                </span>
            </button>
            <a href="{{ route('admin.agenda.lihat') }}" class="flex items-center justify-between gap-4 rounded-xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#0f1c19] p-4 text-left shadow-xs transition hover:border-[#35635b] hover:bg-gray-50 dark:hover:bg-[#1b3832] cursor-pointer">
                <span>
                    <span class="block text-sm font-extrabold text-gray-800 dark:text-white">Galeri</span>
                    <span class="mt-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Unggah dokumentasi agenda</span>
                </span>
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gray-50 dark:bg-[#152420] p-2">
                    <img src="{{ asset('foto/Galerilogo.png') }}" alt="Galeri" class="h-full w-full object-contain">
                </span>
            </a>
            <button type="button" onclick="openPublicModal('modal-tambah-video')" class="flex items-center justify-between gap-4 rounded-xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#0f1c19] p-4 text-left shadow-xs transition hover:border-[#35635b] hover:bg-gray-50 dark:hover:bg-[#1b3832] cursor-pointer">
                <span>
                    <span class="block text-sm font-extrabold text-gray-800 dark:text-white">Video</span>
                    <span class="mt-1 block text-xs font-medium text-gray-500 dark:text-gray-400">Tambah link YouTube</span>
                </span>
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gray-50 dark:bg-[#152420] p-2">
                    <img src="{{ asset('foto/Videologo.png') }}" alt="Video" class="h-full w-full object-contain">
                </span>
            </button>
        </div>
    </section>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <section class="bg-white dark:bg-[#152420] rounded-2xl border border-gray-100 dark:border-[#233a34] shadow-xs overflow-hidden transition-colors">
            <div class="flex items-center justify-between gap-3 border-b border-gray-100 dark:border-[#233a34] px-6 py-4">
                <div>
                    <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Berita Publik</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">{{ $berita->count() }} berita di database.</p>
                </div>
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('admin.publik.berita.sync') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-[#35635b] px-3 py-2 text-xs font-bold text-white shadow-xs transition hover:bg-[#284c46] cursor-pointer" title="Sinkronkan berita dari Pemkab Bogor & Diskominfo">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Sync</span>
                        </button>
                    </form>
                    @if ($berita->count() > 6)
                        <button type="button" onclick="openPublicModal('modal-semua-berita')" class="rounded-lg border border-gray-200 dark:border-[#284c43] px-3 py-2 text-xs font-bold text-gray-700 dark:text-gray-300 transition hover:bg-gray-50 dark:hover:bg-white/5 cursor-pointer">
                            Selengkapnya
                        </button>
                    @endif
                </div>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-[#233a34] max-h-[500px] overflow-y-auto">
                @forelse ($berita->take(12) as $item)
                    <div class="p-4 flex items-center gap-4 hover:bg-gray-50/50 dark:hover:bg-[#1b332d] transition group">
                        <div onclick="openDetailBerita(this)"
                             data-judul="{{ $item->judul }}"
                             data-isi="{{ $item->isi_berita }}"
                             data-tanggal="{{ $item->tanggal?->translatedFormat('d F Y') }}"
                             data-sumber="{{ $item->sumber }}"
                             data-gambar="{{ $imageUrl($item->gambar) }}"
                             class="w-16 h-16 rounded-xl bg-gray-100 dark:bg-[#0f1c19] bg-cover bg-center shrink-0 border border-transparent dark:border-[#284c43] cursor-pointer transition-transform duration-200 group-hover:scale-105" 
                             title="Klik untuk membaca berita"
                             style="background-image: url('{{ $imageUrl($item->gambar) }}')"></div>
                        <div class="min-w-0 flex-1 cursor-pointer"
                             onclick="openDetailBerita(this)"
                             data-judul="{{ $item->judul }}"
                             data-isi="{{ $item->isi_berita }}"
                             data-tanggal="{{ $item->tanggal?->translatedFormat('d F Y') }}"
                             data-sumber="{{ $item->sumber }}"
                             data-gambar="{{ $imageUrl($item->gambar) }}">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ $item->judul }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-300 mt-0.5">{{ $item->tanggal?->translatedFormat('d M Y') }} &bull; {{ $item->sumber }}</p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button
                                type="button"
                                onclick="openEditBerita(this)"
                                data-action="{{ route('admin.publik.berita.update', $item->id_berita) }}"
                                data-judul="{{ $item->judul }}"
                                data-isi="{{ $item->isi_berita }}"
                                data-tanggal="{{ $item->tanggal?->format('Y-m-d') }}"
                                data-sumber="{{ $item->sumber }}"
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-green-100 dark:hover:bg-[#23423b] cursor-pointer"
                                title="Edit Berita">
                                <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                <span class="sr-only">Edit</span>
                            </button>
                            <form method="POST" action="{{ route('admin.publik.berita.destroy', $item->id_berita) }}">
                                @csrf
                                @method('DELETE')
                                <button class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer" title="Hapus Berita">
                                    <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                    <span class="sr-only">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500 dark:text-gray-400">Belum ada berita.</p>
                @endforelse
            </div>
        </section>

        <section class="bg-white dark:bg-[#152420] rounded-2xl border border-gray-100 dark:border-[#233a34] shadow-xs overflow-hidden transition-colors">
            <div class="flex items-center justify-between gap-3 border-b border-gray-100 dark:border-[#233a34] px-6 py-4">
                <div>
                    <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Galeri Publik</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">{{ $galeri->count() }} dokumentasi agenda.</p>
                </div>
                @if ($galeri->count() > 6)
                    <button type="button" onclick="openPublicModal('modal-semua-galeri')" class="rounded-lg border border-gray-200 dark:border-[#284c43] px-3 py-2 text-xs font-bold text-gray-700 dark:text-gray-300 transition hover:bg-gray-50 dark:hover:bg-white/5 cursor-pointer">
                        Selengkapnya
                    </button>
                @endif
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4">
                @forelse ($galeri->take(6) as $item)
                    <div class="rounded-xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#0f1c19] overflow-hidden group">
                        <div onclick="openDocumentPreview('{{ $imageUrl($galleryImagePath($item), 'foto/Agendahariini.png') }}', 'Dokumentasi - {{ addslashes($galleryTitle($item)) }}', '{{ addslashes(basename($galleryImagePath($item))) }}')" 
                             class="aspect-[4/3] bg-gray-100 dark:bg-[#152420] bg-cover bg-center cursor-pointer transition-transform duration-200 group-hover:scale-105" 
                             title="Klik untuk melihat foto"
                             style="background-image: url('{{ $imageUrl($galleryImagePath($item), 'foto/Agendahariini.png') }}')"></div>
                        <div class="border-b border-gray-100 dark:border-[#233a34] px-3 py-2">
                            <p class="truncate text-xs font-bold text-gray-800 dark:text-white">{{ $galleryTitle($item) }}</p>
                            <p class="mt-0.5 text-[10px] text-gray-500 dark:text-gray-400">{{ optional($galleryDate($item))->translatedFormat('d M Y') ?? '-' }}</p>
                        </div>
                        <div class="flex justify-center gap-2 p-2">
                            <button
                                type="button"
                                onclick="openEditGaleri(this)"
                                data-action="{{ route('admin.agenda.dokumen.store', $item->id_agenda) }}"
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-green-100 dark:hover:bg-[#23423b] cursor-pointer"
                                title="Ganti Dokumentasi">
                                <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                <span class="sr-only">Edit</span>
                            </button>
                            <form method="POST" action="{{ route('admin.agenda.dokumen.destroy', [$item->id_agenda, $item->id_dokumen]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer" title="Hapus Dokumentasi">
                                    <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                    <span class="sr-only">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 p-2 text-sm text-gray-500 dark:text-gray-400">Belum ada foto galeri.</p>
                @endforelse
            </div>
        </section>

        <section class="bg-white dark:bg-[#152420] rounded-2xl border border-gray-100 dark:border-[#233a34] shadow-xs overflow-hidden transition-colors">
            <div class="flex items-center justify-between gap-3 border-b border-gray-100 dark:border-[#233a34] px-6 py-4">
                <div>
                    <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Ulang Tahun Publik</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">{{ $ulangTahun->count() }} pegawai memiliki tanggal lahir.</p>
                </div>
                @if ($ulangTahun->count() > 6)
                    <button type="button" onclick="openPublicModal('modal-semua-ulang-tahun')" class="rounded-lg border border-gray-200 dark:border-[#284c43] px-3 py-2 text-xs font-bold text-gray-700 dark:text-gray-300 transition hover:bg-gray-50 dark:hover:bg-white/5 cursor-pointer">
                        Selengkapnya
                    </button>
                @endif
            </div>
            <div class="divide-y divide-gray-100 dark:divide-[#233a34]">
                @forelse ($ulangTahun->take(6) as $item)
                    <div class="p-4 flex items-center justify-between gap-4 hover:bg-gray-50/50 dark:hover:bg-[#1b332d] transition">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $item->nama }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-300">{{ $item->tanggal?->translatedFormat('d M') }}</p>
                        </div>
                        <a href="{{ route('admin.pegawai.lihat') }}" class="rounded-lg border border-gray-200 dark:border-[#284c43] px-3 py-2 text-xs font-bold text-gray-700 dark:text-gray-300 transition hover:bg-gray-50 dark:hover:bg-white/5">Data Pegawai</a>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500 dark:text-gray-400">Belum ada pegawai yang memiliki tanggal lahir.</p>
                @endforelse
            </div>
        </section>

        <section class="bg-white dark:bg-[#152420] rounded-2xl border border-gray-100 dark:border-[#233a34] shadow-xs overflow-hidden transition-colors">
            <div class="flex items-center justify-between gap-3 border-b border-gray-100 dark:border-[#233a34] px-6 py-4">
                <div>
                    <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Video Publik</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">{{ $video->count() }} video di database.</p>
                </div>
                @if ($video->count() > 6)
                    <button type="button" onclick="openPublicModal('modal-semua-video')" class="rounded-lg border border-gray-200 dark:border-[#284c43] px-3 py-2 text-xs font-bold text-gray-700 dark:text-gray-300 transition hover:bg-gray-50 dark:hover:bg-white/5 cursor-pointer">
                        Selengkapnya
                    </button>
                @endif
            </div>
            <div class="divide-y divide-gray-100 dark:divide-[#233a34]">
                @forelse ($video->take(6) as $item)
                    <div class="p-4 flex items-center justify-between gap-4 hover:bg-gray-50/50 dark:hover:bg-[#1b332d] transition">
                        <div class="min-w-0">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $item->judul }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-300">{{ optional($item->created_at)->translatedFormat('d M Y') }} &bull; YouTube</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                onclick="openEditVideo(this)"
                                data-action="{{ route('admin.publik.video.update', $item->id_video) }}"
                                data-judul="{{ $item->judul }}"
                                data-deskripsi="{{ $item->deskripsi }}"
                                data-url="{{ $item->youtube_url }}"
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-green-100 dark:hover:bg-[#23423b] cursor-pointer"
                                title="Edit Video">
                                <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                <span class="sr-only">Edit</span>
                            </button>
                            <form method="POST" action="{{ route('admin.publik.video.destroy', $item->id_video) }}">
                                @csrf
                                @method('DELETE')
                                <button class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer" title="Hapus Video">
                                    <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                    <span class="sr-only">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500 dark:text-gray-400">Belum ada data video.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>

<div id="modal-semua-galeri" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[88vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <div>
                <h3 class="text-base sm:text-lg font-bold">Semua Dokumentasi Agenda</h3>
                <p class="mt-0.5 text-xs text-white/70">{{ $galeri->count() }} foto dari dokumentasi agenda</p>
            </div>
            <button type="button" onclick="closePublicModal('modal-semua-galeri')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal semua galeri">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <div class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-5">
            <div class="grid grid-cols-1 gap-3 sm:gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($galeri as $item)
                    <div class="overflow-hidden rounded-xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#0f1c19] group shadow-xs transition hover:border-[#35635b] dark:hover:border-emerald-500/40">
                        <div onclick="openDocumentPreview('{{ $imageUrl($galleryImagePath($item), 'foto/Agendahariini.png') }}', 'Dokumentasi - {{ addslashes($galleryTitle($item)) }}', '{{ addslashes(basename($galleryImagePath($item))) }}')" 
                             class="aspect-[4/3] bg-gray-100 dark:bg-[#152420] bg-cover bg-center cursor-pointer transition-transform duration-200 group-hover:scale-105" 
                             title="Klik untuk melihat foto"
                             style="background-image: url('{{ $imageUrl($galleryImagePath($item), 'foto/Agendahariini.png') }}')"></div>
                        <div class="border-b border-gray-100 dark:border-[#233a34] px-3.5 py-2.5">
                            <p class="truncate text-xs font-bold text-gray-800 dark:text-white">{{ $galleryTitle($item) }}</p>
                            <p class="mt-0.5 text-[10px] text-gray-500 dark:text-gray-400">{{ optional($galleryDate($item))->translatedFormat('d M Y') ?? '-' }}</p>
                        </div>
                        <div class="flex justify-end gap-2 p-2 bg-gray-50/50 dark:bg-[#152420]/50">
                            <button
                                type="button"
                                onclick="openEditGaleri(this)"
                                data-action="{{ route('admin.agenda.dokumen.store', $item->id_agenda) }}"
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-green-100 dark:hover:bg-[#23423b] cursor-pointer"
                                title="Ganti Dokumentasi">
                                <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                <span class="sr-only">Edit</span>
                            </button>
                            <form method="POST" action="{{ route('admin.agenda.dokumen.destroy', [$item->id_agenda, $item->id_dokumen]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer" title="Hapus Dokumentasi">
                                    <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                    <span class="sr-only">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500 dark:text-gray-400 sm:col-span-2 lg:col-span-3">Belum ada dokumentasi agenda.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div id="modal-semua-berita" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[88vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <div>
                <h3 class="text-base sm:text-lg font-bold">Semua Berita Publik</h3>
                <p class="mt-0.5 text-xs text-white/70">{{ $berita->count() }} berita di database</p>
            </div>
            <button type="button" onclick="closePublicModal('modal-semua-berita')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal semua berita">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <div class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-5">
            <div class="grid grid-cols-1 gap-3 sm:gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($berita as $item)
                    <div class="flex items-center gap-3.5 rounded-xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#0f1c19] p-3 group shadow-xs transition hover:border-[#35635b] dark:hover:border-emerald-500/40 min-h-[80px]">
                        <div onclick="openDetailBerita(this)"
                             data-judul="{{ $item->judul }}"
                             data-isi="{{ $item->isi_berita }}"
                             data-tanggal="{{ $item->tanggal?->translatedFormat('d F Y') }}"
                             data-sumber="{{ $item->sumber }}"
                             data-gambar="{{ $imageUrl($item->gambar) }}"
                             class="h-14 w-14 sm:h-16 sm:w-16 shrink-0 rounded-lg bg-gray-100 dark:bg-[#152420] bg-cover bg-center cursor-pointer transition-transform duration-200 group-hover:scale-105 border border-gray-100 dark:border-[#284c43]" 
                             title="Klik untuk membaca berita"
                             style="background-image: url('{{ $imageUrl($item->gambar) }}')"></div>
                        <div class="min-w-0 flex-1 cursor-pointer"
                             onclick="openDetailBerita(this)"
                             data-judul="{{ $item->judul }}"
                             data-isi="{{ $item->isi_berita }}"
                             data-tanggal="{{ $item->tanggal?->translatedFormat('d F Y') }}"
                             data-sumber="{{ $item->sumber }}"
                             data-gambar="{{ $imageUrl($item->gambar) }}">
                             <h4 class="line-clamp-2 text-xs sm:text-sm font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors leading-snug">{{ $item->judul }}</h4>
                            <p class="mt-1 text-[10px] text-gray-500 dark:text-gray-300">{{ $item->tanggal?->translatedFormat('d M Y') }} &bull; {{ $item->sumber }}</p>
                        </div>
                        <div class="flex flex-col justify-center gap-1.5 shrink-0">
                            <button
                                type="button"
                                onclick="openEditBerita(this)"
                                data-action="{{ route('admin.publik.berita.update', $item->id_berita) }}"
                                data-judul="{{ $item->judul }}"
                                data-isi="{{ $item->isi_berita }}"
                                data-tanggal="{{ $item->tanggal?->format('Y-m-d') }}"
                                data-sumber="{{ $item->sumber }}"
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-green-100 dark:hover:bg-[#23423b] cursor-pointer"
                                title="Edit Berita">
                                <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                <span class="sr-only">Edit</span>
                            </button>
                            <form method="POST" action="{{ route('admin.publik.berita.destroy', $item->id_berita) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer" title="Hapus Berita">
                                    <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                    <span class="sr-only">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500 dark:text-gray-400 sm:col-span-2 lg:col-span-3">Belum ada berita publik.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div id="modal-semua-ulang-tahun" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[88vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <div>
                <h3 class="text-base sm:text-lg font-bold">Semua Ulang Tahun Publik</h3>
                <p class="mt-0.5 text-xs text-white/70">{{ $ulangTahun->count() }} pegawai memiliki tanggal lahir</p>
            </div>
            <button type="button" onclick="closePublicModal('modal-semua-ulang-tahun')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal semua ulang tahun">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <div class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-5">
            <div class="grid grid-cols-1 gap-3 sm:gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($ulangTahun as $item)
                    <div class="flex items-center justify-between gap-3 sm:gap-4 rounded-xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#0f1c19] p-3.5 sm:p-4 shadow-xs">
                        <div>
                            <h3 class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">{{ $item->nama }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-300 mt-0.5">{{ $item->tanggal?->translatedFormat('d M') }}</p>
                        </div>
                        <a href="{{ route('admin.pegawai.lihat') }}" class="rounded-xl border border-gray-200 dark:border-[#284c43] px-3 py-1.5 text-xs font-bold text-gray-700 dark:text-gray-300 transition hover:bg-gray-50 dark:hover:bg-white/5">Data Pegawai</a>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500 dark:text-gray-400 sm:col-span-2 lg:col-span-3">Belum ada pegawai yang memiliki tanggal lahir.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div id="modal-semua-video" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[88vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <div>
                <h3 class="text-base sm:text-lg font-bold">Semua Video Publik</h3>
                <p class="mt-0.5 text-xs text-white/70">{{ $video->count() }} video di database</p>
            </div>
            <button type="button" onclick="closePublicModal('modal-semua-video')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal semua video">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <div class="flex-1 min-h-0 overflow-y-auto p-4 sm:p-5">
            <div class="grid grid-cols-1 gap-3 sm:gap-4 lg:grid-cols-2">
                @forelse ($video as $item)
                    <div class="overflow-hidden rounded-xl border border-gray-100 dark:border-[#233a34] bg-white dark:bg-[#0f1c19] shadow-xs">
                        <div class="aspect-video bg-gray-100 dark:bg-[#152420]">
                            <iframe
                                src="{{ $item->youtube_embed_url }}"
                                title="{{ $item->judul }}"
                                class="h-full w-full"
                                loading="lazy"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                        <div class="border-b border-gray-100 dark:border-[#233a34] px-4 py-3">
                            <h4 class="truncate text-xs sm:text-sm font-bold text-gray-900 dark:text-white">{{ $item->judul }}</h4>
                            <p class="mt-1 text-[10px] sm:text-xs text-gray-500 dark:text-gray-300">{{ optional($item->created_at)->translatedFormat('d M Y') }} &bull; YouTube</p>
                            @if ($item->deskripsi)
                                <p class="mt-1.5 line-clamp-2 text-xs text-gray-600 dark:text-gray-300">{{ $item->deskripsi }}</p>
                            @endif
                        </div>
                        <div class="flex justify-end gap-2 p-2.5 bg-gray-50/50 dark:bg-[#152420]/50">
                            <button
                                type="button"
                                onclick="openEditVideo(this)"
                                data-action="{{ route('admin.publik.video.update', $item->id_video) }}"
                                data-judul="{{ $item->judul }}"
                                data-deskripsi="{{ $item->deskripsi }}"
                                data-url="{{ $item->youtube_url }}"
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-green-100 dark:hover:bg-[#23423b] cursor-pointer"
                                title="Edit Video">
                                <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                <span class="sr-only">Edit</span>
                            </button>
                            <form method="POST" action="{{ route('admin.publik.video.destroy', $item->id_video) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer" title="Hapus Video">
                                    <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                    <span class="sr-only">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500 dark:text-gray-400 lg:col-span-2">Belum ada data video.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div id="modal-detail-berita" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Detail Berita</h3>
            <button type="button" onclick="closePublicModal('modal-detail-berita')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal detail berita">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
            <div id="detail-berita-gambar-wrap" class="hidden overflow-hidden rounded-xl bg-gray-100 dark:bg-[#0f1c19]">
                <img id="detail-berita-gambar" src="" alt="Thumbnail Berita" class="h-44 sm:h-60 w-full object-cover">
            </div>
            <div>
                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                    <span id="detail-berita-tanggal"></span>
                    <span>•</span>
                    <span id="detail-berita-sumber" class="font-bold text-[#35635b] dark:text-emerald-400"></span>
                </div>
                <h4 id="detail-berita-judul" class="mt-1.5 text-sm sm:text-base font-extrabold text-gray-900 dark:text-white"></h4>
            </div>
            <div id="detail-berita-isi" class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed border-t border-gray-100 dark:border-[#233a34] pt-3.5"></div>
        </div>
        <div class="flex justify-end gap-3 border-t border-gray-100 dark:border-[#233a34] p-3 sm:px-6 sm:py-3.5 bg-gray-50 dark:bg-[#0f1c19] rounded-b-2xl shrink-0">
            <button type="button" onclick="closePublicModal('modal-detail-berita')" class="w-full sm:w-auto h-10 sm:h-9 rounded-xl px-5 text-xs font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-200/60 dark:hover:bg-white/5 cursor-pointer transition">Tutup</button>
        </div>
    </div>
</div>

<div id="modal-tambah-berita" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-lg flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Tambah Berita</h3>
            <button type="button" onclick="closePublicModal('modal-tambah-berita')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal tambah berita">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.publik.berita.store') }}" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <input type="hidden" name="gambar_url" id="tambah-berita-gambar-url">
            <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
                <!-- Tempel Link URL Input -->
                <div>
                    <label class="mb-1.5 block text-xs font-extrabold text-[#0e2f27] dark:text-gray-200 uppercase tracking-wider">🔗 Tempel Link / URL Berita</label>
                    <input name="url" id="fetch-berita-url" type="url" placeholder="https://bogorkab.go.id/berita/... atau link berita lain" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10">
                    <p class="mt-1.5 text-[11px] text-gray-500 dark:text-gray-400">Judul, Ringkasan, Tanggal, Gambar, dan Sumber akan otomatis diambil dari link di atas.</p>
                </div>

                <!-- Optional Manual Collapsible -->
                <div class="pt-2 border-t border-gray-100 dark:border-[#233a34]">
                    <button type="button" onclick="document.getElementById('manual-berita-fields').classList.toggle('hidden')" class="text-xs font-bold text-[#35635b] dark:text-emerald-400 hover:underline flex items-center gap-1 cursor-pointer">
                        <span>⚙️ Atau Input Manual (Opsional)</span>
                    </button>
                    
                    <div id="manual-berita-fields" class="mt-3 space-y-3.5 hidden border-t border-dashed border-gray-200 dark:border-[#284c43] pt-3">
                        <div>
                            <label class="mb-1 block text-xs font-bold text-[#0e2f27] dark:text-gray-200">Judul Berita</label>
                            <input name="judul" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b] placeholder:text-gray-400 dark:placeholder:text-gray-500" placeholder="Judul berita">
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-bold text-[#0e2f27] dark:text-gray-200">Isi Berita</label>
                            <textarea name="isi_berita" rows="3" class="w-full resize-none rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b] placeholder:text-gray-400 dark:placeholder:text-gray-500" placeholder="Isi berita"></textarea>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="mb-1 block text-xs font-bold text-[#0e2f27] dark:text-gray-200">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ now()->toDateString() }}" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b]">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-bold text-[#0e2f27] dark:text-gray-200">Sumber</label>
                                <input name="sumber" class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-800 dark:text-white outline-none focus:border-[#35635b] placeholder:text-gray-400 dark:placeholder:text-gray-500" placeholder="Sumber">
                            </div>
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-bold text-[#0e2f27] dark:text-gray-200">Upload Gambar</label>
                            <input type="file" name="gambar" accept="image/*" class="w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3 py-2 text-xs text-gray-800 dark:text-white outline-none file:mr-3 file:rounded-md file:border-0 file:bg-[#35635b] dark:file:bg-[#107050] file:px-3 file:py-1 file:text-xs file:font-bold file:text-white file:cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] p-3 sm:px-6 sm:py-4 bg-gray-50 dark:bg-[#0f1c19] rounded-b-2xl shrink-0">
                <button type="button" onclick="closePublicModal('modal-tambah-berita')" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="w-full sm:w-auto inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#04733f] dark:bg-[#107050] hover:bg-[#035f35] dark:hover:bg-[#0c5940] px-5 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-tambah-galeri" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Tambah Galeri</h3>
            <button type="button" onclick="closePublicModal('modal-tambah-galeri')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal tambah galeri">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.publik.galeri.store') }}" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ now()->toDateString() }}" required class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Foto Galeri</label>
                    <input type="file" name="gambar" accept="image/*" required class="w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition file:mr-3 file:rounded-md file:border-0 file:bg-[#35635b] dark:file:bg-[#107050] file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-white file:cursor-pointer focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
                </div>
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] p-3 sm:px-6 sm:py-4 bg-gray-50 dark:bg-[#0f1c19] rounded-b-2xl shrink-0">
                <button type="button" onclick="closePublicModal('modal-tambah-galeri')" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="w-full sm:w-auto inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#04733f] dark:bg-[#107050] hover:bg-[#035f35] dark:hover:bg-[#0c5940] px-5 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-tambah-video" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Tambah Video</h3>
            <button type="button" onclick="closePublicModal('modal-tambah-video')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal tambah video">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.publik.video.store') }}" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Judul Video</label>
                    <input name="judul" required class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20" placeholder="Judul video">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Link YouTube</label>
                    <input name="youtube_url" type="url" required class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20" placeholder="https://www.youtube.com/watch?v=...">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full resize-none rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20" placeholder="Deskripsi video opsional"></textarea>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] p-3 sm:px-6 sm:py-4 bg-gray-50 dark:bg-[#0f1c19] rounded-b-2xl shrink-0">
                <button type="button" onclick="closePublicModal('modal-tambah-video')" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="w-full sm:w-auto inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#04733f] dark:bg-[#107050] hover:bg-[#035f35] dark:hover:bg-[#0c5940] px-5 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-berita" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Edit Berita</h3>
            <button type="button" onclick="closePublicModal('modal-edit-berita')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal edit berita">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <form id="form-edit-berita" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Judul Berita</label>
                    <input id="edit-berita-judul" name="judul" required class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Isi Berita</label>
                    <textarea id="edit-berita-isi" name="isi_berita" required rows="4" class="w-full resize-none rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20"></textarea>
                </div>
                <div class="grid grid-cols-1 gap-3 sm:gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Tanggal</label>
                        <input id="edit-berita-tanggal" type="date" name="tanggal" required class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Sumber</label>
                        <input id="edit-berita-sumber" name="sumber" required class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
                    </div>
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Ganti Gambar</label>
                    <input type="file" name="gambar" accept="image/*" class="w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 py-2.5 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition file:mr-3 file:rounded-md file:border-0 file:bg-[#35635b] file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-white file:cursor-pointer focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
                </div>
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] p-3 sm:px-6 sm:py-4 bg-gray-50 dark:bg-[#0f1c19] rounded-b-2xl shrink-0">
                <button type="button" onclick="closePublicModal('modal-edit-berita')" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="w-full sm:w-auto inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#04733f] dark:bg-[#107050] hover:bg-[#035f35] dark:hover:bg-[#0c5940] px-5 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-galeri" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Edit Galeri</h3>
            <button type="button" onclick="closePublicModal('modal-edit-galeri')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal edit galeri">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <form id="form-edit-galeri" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
                <input type="hidden" name="jenis_dokumen" value="dokumentasi">
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Unggah Dokumentasi</label>
                    <input type="file" name="dokumen[]" accept=".jpg,.jpeg,.png,.webp" multiple required class="w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition file:mr-3 file:rounded-md file:border-0 file:bg-[#35635b] file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-white file:cursor-pointer focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">Bisa pilih lebih dari satu gambar. Hapus dokumentasi lama satu per satu dari galeri jika tidak diperlukan.</p>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] p-3 sm:px-6 sm:py-4 bg-gray-50 dark:bg-[#0f1c19] rounded-b-2xl shrink-0">
                <button type="button" onclick="closePublicModal('modal-edit-galeri')" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="w-full sm:w-auto inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#04733f] dark:bg-[#107050] hover:bg-[#035f35] dark:hover:bg-[#0c5940] px-5 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-video" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-xs p-2.5 sm:p-4 overflow-y-auto">
    <div class="my-auto flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
        <div class="flex items-center justify-between rounded-t-2xl bg-[#3f8078] px-4 py-3.5 sm:px-6 sm:py-4 text-white shrink-0">
            <h3 class="text-base sm:text-lg font-bold">Edit Video</h3>
            <button type="button" onclick="closePublicModal('modal-edit-video')" class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white cursor-pointer" aria-label="Tutup modal edit video">
                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <form id="form-edit-video" method="POST" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="flex-1 min-h-0 space-y-3.5 sm:space-y-4 overflow-y-auto p-4 sm:p-6">
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Judul Video</label>
                    <input id="edit-video-judul" name="judul" required class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Link YouTube</label>
                    <input id="edit-video-url" name="youtube_url" type="url" required class="h-10 sm:h-11 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
                </div>
                <div>
                    <label class="mb-1.5 block text-xs sm:text-sm font-bold text-[#0e2f27] dark:text-gray-200">Deskripsi</label>
                    <textarea id="edit-video-deskripsi" name="deskripsi" rows="3" class="w-full resize-none rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20"></textarea>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:flex sm:justify-end gap-2.5 sm:gap-3 border-t border-gray-100 dark:border-[#233a34] p-3 sm:px-6 sm:py-4 bg-gray-50 dark:bg-[#0f1c19] rounded-b-2xl shrink-0">
                <button type="button" onclick="closePublicModal('modal-edit-video')" class="w-full sm:w-auto h-10 rounded-xl px-4 text-xs sm:text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-[#152420] border border-gray-300 dark:border-[#284c43] hover:bg-gray-100 dark:hover:bg-white/5 transition cursor-pointer flex items-center justify-center">Batal</button>
                <button type="submit" class="w-full sm:w-auto inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#04733f] dark:bg-[#107050] hover:bg-[#035f35] dark:hover:bg-[#0c5940] px-5 text-xs sm:text-sm font-bold text-white transition cursor-pointer shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openPublicModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.replace('hidden', 'flex');
    }

    function closePublicModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.replace('flex', 'hidden');
    }

    function openDetailBerita(element) {
        const judul = element.dataset.judul || '';
        const isi = element.dataset.isi || '';
        const tanggal = element.dataset.tanggal || '';
        const sumber = element.dataset.sumber || '';
        const gambar = element.dataset.gambar || '';

        const elJudul = document.getElementById('detail-berita-judul');
        const elIsi = document.getElementById('detail-berita-isi');
        const elTanggal = document.getElementById('detail-berita-tanggal');
        const elSumber = document.getElementById('detail-berita-sumber');
        const elGambar = document.getElementById('detail-berita-gambar');

        if (elJudul) elJudul.textContent = judul;
        if (elIsi) elIsi.textContent = isi;
        if (elTanggal) elTanggal.textContent = tanggal;
        if (elSumber) elSumber.textContent = sumber || 'Pemkab Bogor';

        if (elGambar) {
            if (gambar && !gambar.includes('undefined')) {
                elGambar.src = gambar;
                elGambar.classList.remove('hidden');
            } else {
                elGambar.classList.add('hidden');
            }
        }

        openPublicModal('modal-detail-berita');
    }

    function openEditBerita(button) {
        document.getElementById('form-edit-berita').action = button.dataset.action;
        document.getElementById('edit-berita-judul').value = button.dataset.judul || '';
        document.getElementById('edit-berita-isi').value = button.dataset.isi || '';
        document.getElementById('edit-berita-tanggal').value = button.dataset.tanggal || '';
        document.getElementById('edit-berita-sumber').value = button.dataset.sumber || '';
        openPublicModal('modal-edit-berita');
    }

    function openEditGaleri(button) {
        document.getElementById('form-edit-galeri').action = button.dataset.action;
        closePublicModal('modal-semua-galeri');
        openPublicModal('modal-edit-galeri');
    }

    function openEditVideo(button) {
        document.getElementById('form-edit-video').action = button.dataset.action;
        document.getElementById('edit-video-judul').value = button.dataset.judul || '';
        document.getElementById('edit-video-deskripsi').value = button.dataset.deskripsi || '';
        document.getElementById('edit-video-url').value = button.dataset.url || '';
        closePublicModal('modal-semua-video');
        openPublicModal('modal-edit-video');
    }
    function fetchBeritaFromUrl() {
        const urlInput = document.getElementById('fetch-berita-url');
        const url = urlInput ? urlInput.value.trim() : '';
        if (!url) {
            alert('Silakan tempelkan link/URL berita terlebih dahulu.');
            return;
        }

        const btnText = document.getElementById('btn-fetch-text');
        const btnSpinner = document.getElementById('btn-fetch-spinner');
        if (btnText) btnText.textContent = 'Mengambil...';
        if (btnSpinner) btnSpinner.classList.remove('hidden');

        fetch("{{ route('admin.publik.berita.fetch-meta') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ url: url })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                const meta = data.data;
                const modal = document.getElementById('modal-tambah-berita');
                if (modal) {
                    const inputJudul = modal.querySelector('input[name="judul"]');
                    const inputIsi = modal.querySelector('textarea[name="isi_berita"]');
                    const inputTanggal = modal.querySelector('input[name="tanggal"]');
                    const inputSumber = modal.querySelector('input[name="sumber"]');

                    if (inputJudul) inputJudul.value = meta.judul || '';
                    if (inputIsi) inputIsi.value = meta.isi_berita || '';
                    if (inputTanggal && meta.tanggal) inputTanggal.value = meta.tanggal;
                    if (inputSumber) inputSumber.value = meta.sumber || '';

                    if (meta.gambar) {
                        const gambarUrlInput = document.getElementById('tambah-berita-gambar-url');
                        const previewContainer = document.getElementById('tambah-berita-preview-container');
                        const previewImg = document.getElementById('tambah-berita-preview');
                        if (gambarUrlInput) gambarUrlInput.value = meta.gambar;
                        if (previewImg) previewImg.src = meta.gambar;
                        if (previewContainer) previewContainer.classList.remove('hidden');
                    }
                }
            } else {
                alert(data.message || 'Gagal mengambil data dari URL tersebut.');
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan koneksi saat mengambil metadata link.');
        })
        .finally(() => {
            if (btnText) btnText.textContent = 'Ambil Data';
            if (btnSpinner) btnSpinner.classList.add('hidden');
        });
    }
</script>
@endpush
