@extends('admin.layout.app')

@section('title', 'Konten Publik')

@section('content')
@php
    $imageUrl = function ($path, $fallback = 'assets/foto/Suratlogo.png') {
        if (! $path) {
            return asset($fallback);
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (str_starts_with($path, 'assets/foto/') || str_starts_with($path, 'foto/') || str_starts_with($path, 'uploads/')) {
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

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <section class="bg-white dark:bg-[#152420] rounded-2xl border border-gray-100 dark:border-[#233a34] shadow-xs overflow-hidden transition-colors">
            <div class="flex items-center justify-between gap-3 border-b border-gray-100 dark:border-[#233a34] px-6 py-4">
                <div>
                    <h2 class="text-base font-extrabold text-gray-800 dark:text-white flex items-center gap-2">
                        <span>Berita Indonesia</span>
                        <span class="inline-flex items-center rounded-full bg-emerald-100 dark:bg-emerald-950/60 px-2 py-0.5 text-[10px] font-bold text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800/40">Live API</span>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">{{ $berita->count() }} feed aktif (LKBN Antara, CNN Indonesia, Tempo)</p>
                </div>
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('admin.publik.berita.refresh') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-[#35635b] hover:bg-[#284c46] dark:bg-[#107050] dark:hover:bg-[#0c5940] px-3 py-2 text-xs font-bold text-white shadow-xs transition cursor-pointer" title="Perbarui cache feed berita terkini">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Refresh API</span>
                        </button>
                    </form>
                    <a href="{{ route('publik.berita') }}" target="_blank" class="rounded-lg border border-gray-200 dark:border-[#284c43] px-3 py-2 text-xs font-bold text-gray-700 dark:text-gray-300 transition hover:bg-gray-50 dark:hover:bg-white/5 cursor-pointer inline-flex items-center gap-1">
                        <span>Portal Publik</span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-[#233a34] max-h-[500px] overflow-y-auto">
                @forelse ($berita->take(15) as $item)
                    <div class="p-4 flex items-center gap-4 hover:bg-gray-50/50 dark:hover:bg-[#1b332d] transition group">
                        <div onclick="openDetailBerita(this)"
                             data-judul="{{ $item->judul }}"
                             data-isi="{{ $item->isi_berita }}"
                             data-tanggal="{{ $item->tanggal?->translatedFormat('d F Y') }}"
                             data-sumber="{{ $item->sumber }}"
                             data-gambar="{{ $imageUrl($item->gambar) }}"
                             class="w-16 h-16 rounded-xl bg-gray-100 dark:bg-[#0f1c19] bg-cover bg-center shrink-0 border border-transparent dark:border-[#284c43] cursor-pointer transition-transform duration-200 group-hover:scale-105" 
                             title="Klik untuk membaca ringkasan"
                             style="background-image: url('{{ $imageUrl($item->gambar) }}')"></div>
                        <div class="min-w-0 flex-1 cursor-pointer"
                             onclick="openDetailBerita(this)"
                             data-judul="{{ $item->judul }}"
                             data-isi="{{ $item->isi_berita }}"
                             data-tanggal="{{ $item->tanggal?->translatedFormat('d F Y') }}"
                             data-sumber="{{ $item->sumber }}"
                             data-gambar="{{ $imageUrl($item->gambar) }}">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ $item->judul }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-300 mt-0.5 flex items-center gap-2">
                                <span>{{ $item->tanggal?->translatedFormat('d M Y') }}</span>
                                <span>&bull;</span>
                                <span class="font-bold text-[#35635b] dark:text-emerald-400">{{ $item->sumber }}</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            @if (!empty($item->url))
                                <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer" class="flex h-8 px-2.5 items-center justify-center gap-1 rounded-lg bg-gray-100 dark:bg-[#0f1c19] hover:bg-gray-200 dark:hover:bg-[#1f3b33] border border-gray-200 dark:border-[#284c43] text-[11px] font-bold text-gray-700 dark:text-gray-300 transition" title="Buka di portal berita resmi">
                                    <span>Sumber</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500 dark:text-gray-400">Belum ada feed berita.</p>
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
                        <div onclick="openDocumentPreview('{{ $imageUrl($galleryImagePath($item), 'assets/foto/Agendahariini.png') }}', 'Dokumentasi - {{ addslashes($galleryTitle($item)) }}', '{{ addslashes(basename($galleryImagePath($item))) }}')" 
                             class="aspect-[4/3] bg-gray-100 dark:bg-[#152420] bg-cover bg-center cursor-pointer transition-transform duration-200 group-hover:scale-105" 
                             title="Klik untuk melihat foto"
                             style="background-image: url('{{ $imageUrl($galleryImagePath($item), 'assets/foto/Agendahariini.png') }}')"></div>
                        <div class="border-b border-gray-100 dark:border-[#233a34] px-3 py-2">
                            <p class="truncate text-xs font-bold text-gray-800 dark:text-white">{{ $galleryTitle($item) }}</p>
                            <p class="mt-0.5 text-[10px] text-gray-500 dark:text-gray-400">{{ optional($galleryDate($item))->translatedFormat('d M Y') ?? '-' }}</p>
                        </div>
                        @php
                            $hasAgenda = !empty($item->id_agenda);
                            $editAction = $hasAgenda
                                ? route('admin.agenda.dokumen.store', $item->id_agenda)
                                : ($item->id_galeri ? route('admin.publik.galeri.update', $item->id_galeri) : '#');
                            $deleteAction = $hasAgenda
                                ? route('admin.agenda.dokumen.destroy', [$item->id_agenda, $item->id_dokumen])
                                : ($item->id_galeri ? route('admin.publik.galeri.destroy', $item->id_galeri) : '#');
                        @endphp
                        <div class="flex justify-center gap-2 p-2">
                            <button
                                type="button"
                                onclick="openEditGaleri(this)"
                                data-action="{{ $editAction }}"
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-green-100 dark:hover:bg-[#23423b] cursor-pointer"
                                title="Ganti Dokumentasi">
                                <img src="{{ asset('assets/foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                <span class="sr-only">Edit</span>
                            </button>
                            <form method="POST" action="{{ $deleteAction }}">
                                @csrf
                                @method('DELETE')
                                <button class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer" title="Hapus Dokumentasi">
                                    <img src="{{ asset('assets/foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
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
                    <h2 class="text-base font-extrabold text-gray-800 dark:text-white">Pengaturan Channel YouTube Publik</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-300 mt-1">Video di Beranda dan Halaman Video otomatis memutar unggahan terbaru dari channel ini.</p>
                </div>
            </div>
            <form action="{{ route('admin.publik.youtube.update') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 mb-1.5">Link / URL Channel YouTube</label>
                        <input type="url" name="youtube_channel_url" required value="{{ old('youtube_channel_url', $youtubeChannelUrl) }}"
                            placeholder="https://youtube.com/@kabupatenbogor"
                            class="h-10 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
                        <p class="mt-1 text-[11px] text-gray-500 dark:text-gray-400">Tautan channel untuk tombol di Footer dan halaman Video Publik.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-200 mb-1.5">ID Playlist / Channel YouTube</label>
                        <input type="text" name="youtube_playlist_id" required value="{{ old('youtube_playlist_id', $youtubePlaylistId) }}"
                            placeholder="Contoh: UUJlX_73GqPvJlerJFN4cRgA atau UC..."
                            class="h-10 w-full rounded-xl border border-[#c9ddd4] dark:border-[#284c43] bg-[#f4faf7] dark:bg-[#0f1c19] px-3.5 text-xs sm:text-sm text-gray-800 dark:text-white outline-none transition focus:border-[#35635b] dark:focus:border-emerald-500 focus:bg-white dark:focus:bg-[#0f1c19] focus:ring-2 focus:ring-[#35635b]/10 dark:focus:ring-emerald-500/20">
                        <p class="mt-1 text-[11px] text-gray-500 dark:text-gray-400">Gunakan ID playlist unggahan channel (awalan <strong>UU</strong>) atau ID Channel (awalan <strong>UC</strong>).</p>
                    </div>
                </div>

                <div class="rounded-xl bg-[#f4faf7] dark:bg-[#0f1c19] p-4 border border-[#c9ddd4]/60 dark:border-[#284c43] flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-800 dark:text-white flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Preview Video yang Sedang Aktif
                        </p>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 font-mono break-all">{{ $youtubeEmbedUrl }}</p>
                    </div>
                    <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-[#35635b] hover:bg-[#2b4f49] dark:bg-[#107050] dark:hover:bg-[#0c5940] px-5 text-xs font-bold text-white transition cursor-pointer shadow-xs shrink-0">
                        Simpan Pengaturan Channel
                    </button>
                </div>

                <div class="aspect-video max-h-60 rounded-xl overflow-hidden bg-black shadow-inner border border-gray-200 dark:border-[#284c43]">
                    <iframe class="w-full h-full" src="{{ $youtubeEmbedUrl }}" title="Preview YouTube Video" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </form>
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
                        <div onclick="openDocumentPreview('{{ $imageUrl($galleryImagePath($item), 'assets/foto/Agendahariini.png') }}', 'Dokumentasi - {{ addslashes($galleryTitle($item)) }}', '{{ addslashes(basename($galleryImagePath($item))) }}')" 
                             class="aspect-[4/3] bg-gray-100 dark:bg-[#152420] bg-cover bg-center cursor-pointer transition-transform duration-200 group-hover:scale-105" 
                             title="Klik untuk melihat foto"
                             style="background-image: url('{{ $imageUrl($galleryImagePath($item), 'assets/foto/Agendahariini.png') }}')"></div>
                        <div class="border-b border-gray-100 dark:border-[#233a34] px-3.5 py-2.5">
                            <p class="truncate text-xs font-bold text-gray-800 dark:text-white">{{ $galleryTitle($item) }}</p>
                            <p class="mt-0.5 text-[10px] text-gray-500 dark:text-gray-400">{{ optional($galleryDate($item))->translatedFormat('d M Y') ?? '-' }}</p>
                        </div>
                        @php
                            $hasAgenda = !empty($item->id_agenda);
                            $editAction = $hasAgenda
                                ? route('admin.agenda.dokumen.store', $item->id_agenda)
                                : ($item->id_galeri ? route('admin.publik.galeri.update', $item->id_galeri) : '#');
                            $deleteAction = $hasAgenda
                                ? route('admin.agenda.dokumen.destroy', [$item->id_agenda, $item->id_dokumen])
                                : ($item->id_galeri ? route('admin.publik.galeri.destroy', $item->id_galeri) : '#');
                        @endphp
                        <div class="flex justify-end gap-2 p-2 bg-gray-50/50 dark:bg-[#152420]/50">
                            <button
                                type="button"
                                onclick="openEditGaleri(this)"
                                data-action="{{ $editAction }}"
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 dark:bg-[#1a332d] border border-transparent dark:border-[#284c43] p-1.5 transition hover:bg-green-100 dark:hover:bg-[#23423b] cursor-pointer"
                                title="Ganti Dokumentasi">
                                <img src="{{ asset('assets/foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                <span class="sr-only">Edit</span>
                            </button>
                            <form method="POST" action="{{ $deleteAction }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 dark:bg-red-950/40 border border-transparent dark:border-red-900/40 p-1.5 transition hover:bg-red-100 dark:hover:bg-red-900/60 cursor-pointer" title="Hapus Dokumentasi">
                                    <img src="{{ asset('assets/foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
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
                <h3 class="text-base sm:text-lg font-bold">Semua Berita Indonesia (Live API)</h3>
                <p class="mt-0.5 text-xs text-white/70">{{ $berita->count() }} feed berita aktif (LKBN Antara, CNN Indonesia, Tempo)</p>
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
                             title="Klik untuk membaca ringkasan"
                             style="background-image: url('{{ $imageUrl($item->gambar) }}')"></div>
                        <div class="min-w-0 flex-1 cursor-pointer"
                             onclick="openDetailBerita(this)"
                             data-judul="{{ $item->judul }}"
                             data-isi="{{ $item->isi_berita }}"
                             data-tanggal="{{ $item->tanggal?->translatedFormat('d F Y') }}"
                             data-sumber="{{ $item->sumber }}"
                             data-gambar="{{ $imageUrl($item->gambar) }}">
                             <h4 class="line-clamp-2 text-xs sm:text-sm font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors leading-snug">{{ $item->judul }}</h4>
                            <p class="mt-1 text-[10px] text-gray-500 dark:text-gray-300">{{ $item->tanggal?->translatedFormat('d M Y') }} &bull; <span class="font-bold text-[#35635b] dark:text-emerald-400">{{ $item->sumber }}</span></p>
                        </div>
                        <div class="flex flex-col justify-center gap-1.5 shrink-0">
                            @if (!empty($item->url))
                                <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer" class="flex h-7 px-2 items-center justify-center gap-1 rounded-lg bg-gray-100 dark:bg-[#152420] hover:bg-gray-200 dark:hover:bg-[#23423b] border border-gray-200 dark:border-[#284c43] text-[10px] font-bold text-gray-700 dark:text-gray-300 transition" title="Buka artikel di sumber resmi">
                                    <span>Buka</span>
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500 dark:text-gray-400 sm:col-span-2 lg:col-span-3">Belum ada feed berita.</p>
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



<div id="modal-edit-galeri" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-xs p-3 sm:p-4">
    <div class="relative flex max-h-[calc(100dvh-1.5rem)] sm:max-h-[calc(100vh-2rem)] w-full max-w-2xl flex-col overflow-hidden rounded-2xl bg-white dark:bg-[#152420] shadow-2xl dark:border dark:border-[#284c43]">
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

@endsection

@push('scripts')
<script>
    function openPublicModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            if (modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closePublicModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
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

    function openEditGaleri(button) {
        document.getElementById('form-edit-galeri').action = button.dataset.action;
        closePublicModal('modal-semua-galeri');
        openPublicModal('modal-edit-galeri');
    }
</script>
@endpush
