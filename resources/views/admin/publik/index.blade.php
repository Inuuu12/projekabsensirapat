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
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Konten Publik</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Kelola dan publikasikan informasi berita, galeri, ucapan ulang tahun, serta video ke portal publik.</p>
    </div>

    <section class="bg-white rounded-2xl border border-gray-100 shadow-xs p-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-extrabold text-gray-800">Tambah Konten</h2>
                <p class="text-xs text-gray-500 mt-1">Pilih jenis konten publik yang ingin ditambahkan.</p>
            </div>
        </div>
        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">
            <button type="button" onclick="openPublicModal('modal-tambah-berita')" class="flex items-center justify-between gap-4 rounded-xl border border-gray-100 bg-white p-4 text-left shadow-xs transition hover:border-[#35635b] hover:bg-gray-50">
                <span>
                    <span class="block text-sm font-extrabold text-gray-800">Berita</span>
                    <span class="mt-1 block text-xs font-medium text-gray-500">Tambah berita publik</span>
                </span>
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gray-50 p-2">
                    <img src="{{ asset('foto/Beritalogo.png') }}" alt="Berita" class="h-full w-full object-contain">
                </span>
            </button>
            <a href="{{ route('admin.agenda.lihat') }}" class="flex items-center justify-between gap-4 rounded-xl border border-gray-100 bg-white p-4 text-left shadow-xs transition hover:border-[#35635b] hover:bg-gray-50">
                <span>
                    <span class="block text-sm font-extrabold text-gray-800">Galeri</span>
                    <span class="mt-1 block text-xs font-medium text-gray-500">Unggah dokumentasi agenda</span>
                </span>
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gray-50 p-2">
                    <img src="{{ asset('foto/Galerilogo.png') }}" alt="Galeri" class="h-full w-full object-contain">
                </span>
            </a>
            <button type="button" onclick="openPublicModal('modal-tambah-video')" class="flex items-center justify-between gap-4 rounded-xl border border-gray-100 bg-white p-4 text-left shadow-xs transition hover:border-[#35635b] hover:bg-gray-50">
                <span>
                    <span class="block text-sm font-extrabold text-gray-800">Video</span>
                    <span class="mt-1 block text-xs font-medium text-gray-500">Tambah link YouTube</span>
                </span>
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gray-50 p-2">
                    <img src="{{ asset('foto/Videologo.png') }}" alt="Video" class="h-full w-full object-contain">
                </span>
            </button>
        </div>
    </section>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <section class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="flex items-center justify-between gap-3 border-b border-gray-100 px-6 py-4">
                <div>
                    <h2 class="text-base font-extrabold text-gray-800">Berita Publik</h2>
                    <p class="text-xs text-gray-500 mt-1">{{ $berita->count() }} berita di database.</p>
                </div>
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('admin.publik.berita.sync') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-[#35635b] px-3 py-2 text-xs font-bold text-white shadow-xs transition hover:bg-[#284c46]" title="Sinkronkan berita dari Pemkab Bogor & Diskominfo">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Sync Pemkab Bogor</span>
                        </button>
                    </form>
                    @if ($berita->count() > 6)
                        <button type="button" onclick="openPublicModal('modal-semua-berita')" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-bold text-gray-700 transition hover:bg-gray-50">
                            Selengkapnya
                        </button>
                    @endif
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($berita->take(6) as $item)
                    <div class="p-4 flex items-center gap-4">
                        <div class="w-16 h-16 rounded-xl bg-gray-100 bg-cover bg-center shrink-0" style="background-image: url('{{ $imageUrl($item->gambar) }}')"></div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-bold text-gray-900 truncate">{{ $item->judul }}</h3>
                            <p class="text-xs text-gray-500">{{ $item->tanggal?->translatedFormat('d M Y') }} &bull; {{ $item->sumber }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                onclick="openEditBerita(this)"
                                data-action="{{ route('admin.publik.berita.update', $item->id_berita) }}"
                                data-judul="{{ $item->judul }}"
                                data-isi="{{ $item->isi_berita }}"
                                data-tanggal="{{ $item->tanggal?->format('Y-m-d') }}"
                                data-sumber="{{ $item->sumber }}"
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 p-1.5 transition hover:bg-green-100"
                                title="Edit Berita">
                                <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                <span class="sr-only">Edit</span>
                            </button>
                            <form method="POST" action="{{ route('admin.publik.berita.destroy', $item->id_berita) }}">
                                @csrf
                                @method('DELETE')
                                <button class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100" title="Hapus Berita">
                                    <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                    <span class="sr-only">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500">Belum ada berita.</p>
                @endforelse
            </div>
        </section>

        <section class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="flex items-center justify-between gap-3 border-b border-gray-100 px-6 py-4">
                <div>
                    <h2 class="text-base font-extrabold text-gray-800">Galeri Publik</h2>
                    <p class="text-xs text-gray-500 mt-1">{{ $galeri->count() }} dokumentasi agenda.</p>
                </div>
                @if ($galeri->count() > 6)
                    <button type="button" onclick="openPublicModal('modal-semua-galeri')" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-bold text-gray-700 transition hover:bg-gray-50">
                        Selengkapnya
                    </button>
                @endif
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4">
                @forelse ($galeri->take(6) as $item)
                    <div class="rounded-xl border border-gray-100 overflow-hidden">
                        <div class="aspect-[4/3] bg-gray-100 bg-cover bg-center" style="background-image: url('{{ $imageUrl($galleryImagePath($item), 'foto/Agendahariini.png') }}')"></div>
                        <div class="border-b border-gray-100 px-3 py-2">
                            <p class="truncate text-xs font-bold text-gray-800">{{ $galleryTitle($item) }}</p>
                            <p class="mt-0.5 text-[10px] text-gray-500">{{ optional($galleryDate($item))->translatedFormat('d M Y') ?? '-' }}</p>
                        </div>
                        <div class="flex justify-center gap-2 p-2">
                            <button
                                type="button"
                                onclick="openEditGaleri(this)"
                                data-action="{{ route('admin.agenda.dokumen.store', $item->id_agenda) }}"
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 p-1.5 transition hover:bg-green-100"
                                title="Ganti Dokumentasi">
                                <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                <span class="sr-only">Edit</span>
                            </button>
                            <form method="POST" action="{{ route('admin.agenda.dokumen.destroy', [$item->id_agenda, $item->id_dokumen]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100" title="Hapus Dokumentasi">
                                    <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                    <span class="sr-only">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 p-2 text-sm text-gray-500">Belum ada foto galeri.</p>
                @endforelse
            </div>
        </section>

        <section class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="flex items-center justify-between gap-3 border-b border-gray-100 px-6 py-4">
                <div>
                    <h2 class="text-base font-extrabold text-gray-800">Ulang Tahun Publik</h2>
                    <p class="text-xs text-gray-500 mt-1">{{ $ulangTahun->count() }} pegawai memiliki tanggal lahir.</p>
                </div>
                @if ($ulangTahun->count() > 6)
                    <button type="button" onclick="openPublicModal('modal-semua-ulang-tahun')" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-bold text-gray-700 transition hover:bg-gray-50">
                        Selengkapnya
                    </button>
                @endif
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($ulangTahun->take(6) as $item)
                    <div class="p-4 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">{{ $item->nama }}</h3>
                            <p class="text-xs text-gray-500">{{ $item->tanggal?->translatedFormat('d M') }}</p>
                        </div>
                        <a href="{{ route('admin.pegawai.lihat') }}" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-bold text-gray-700 transition hover:bg-gray-50">Data Pegawai</a>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500">Belum ada pegawai yang memiliki tanggal lahir.</p>
                @endforelse
            </div>
        </section>

        <section class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="flex items-center justify-between gap-3 border-b border-gray-100 px-6 py-4">
                <div>
                    <h2 class="text-base font-extrabold text-gray-800">Video Publik</h2>
                    <p class="text-xs text-gray-500 mt-1">{{ $video->count() }} video di database.</p>
                </div>
                @if ($video->count() > 6)
                    <button type="button" onclick="openPublicModal('modal-semua-video')" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-bold text-gray-700 transition hover:bg-gray-50">
                        Selengkapnya
                    </button>
                @endif
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($video->take(6) as $item)
                    <div class="p-4 flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <h3 class="text-sm font-bold text-gray-900 truncate">{{ $item->judul }}</h3>
                            <p class="text-xs text-gray-500">{{ optional($item->created_at)->translatedFormat('d M Y') }} &bull; YouTube</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                onclick="openEditVideo(this)"
                                data-action="{{ route('admin.publik.video.update', $item->id_video) }}"
                                data-judul="{{ $item->judul }}"
                                data-deskripsi="{{ $item->deskripsi }}"
                                data-url="{{ $item->youtube_url }}"
                                class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 p-1.5 transition hover:bg-green-100"
                                title="Edit Video">
                                <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                                <span class="sr-only">Edit</span>
                            </button>
                            <form method="POST" action="{{ route('admin.publik.video.destroy', $item->id_video) }}">
                                @csrf
                                @method('DELETE')
                                <button class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100" title="Hapus Video">
                                    <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                    <span class="sr-only">Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500">Belum ada data video.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>

<div id="modal-semua-galeri" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-xs p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-5xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <div>
                <h3 class="text-lg font-bold">Semua Dokumentasi Agenda</h3>
                <p class="mt-0.5 text-xs text-white/70">{{ $galeri->count() }} foto dari dokumentasi agenda</p>
            </div>
            <button type="button" onclick="closePublicModal('modal-semua-galeri')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal semua galeri">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <div class="grid grid-cols-1 gap-4 overflow-y-auto p-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($galeri as $item)
                <div class="overflow-hidden rounded-xl border border-gray-100">
                    <div class="aspect-[4/3] bg-gray-100 bg-cover bg-center" style="background-image: url('{{ $imageUrl($galleryImagePath($item), 'foto/Agendahariini.png') }}')"></div>
                    <div class="border-b border-gray-100 px-3 py-2">
                        <p class="truncate text-xs font-bold text-gray-800">{{ $galleryTitle($item) }}</p>
                        <p class="mt-0.5 text-[10px] text-gray-500">{{ optional($galleryDate($item))->translatedFormat('d M Y') ?? '-' }}</p>
                    </div>
                    <div class="flex justify-center gap-2 p-2">
                        <button
                            type="button"
                            onclick="openEditGaleri(this)"
                            data-action="{{ route('admin.agenda.dokumen.store', $item->id_agenda) }}"
                            class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 p-1.5 transition hover:bg-green-100"
                            title="Ganti Dokumentasi">
                            <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                            <span class="sr-only">Edit</span>
                        </button>
                        <form method="POST" action="{{ route('admin.agenda.dokumen.destroy', [$item->id_agenda, $item->id_dokumen]) }}">
                            @csrf
                            @method('DELETE')
                            <button class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100" title="Hapus Dokumentasi">
                                <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                <span class="sr-only">Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="p-6 text-sm text-gray-500 sm:col-span-2 lg:col-span-3">Belum ada dokumentasi agenda.</p>
            @endforelse
        </div>
    </div>
</div>

<div id="modal-semua-berita" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-xs p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-5xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <div>
                <h3 class="text-lg font-bold">Semua Berita Publik</h3>
                <p class="mt-0.5 text-xs text-white/70">{{ $berita->count() }} berita di database</p>
            </div>
            <button type="button" onclick="closePublicModal('modal-semua-berita')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal semua berita">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <div class="grid grid-cols-1 gap-4 overflow-y-auto p-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($berita as $item)
                <div class="flex items-center gap-4 overflow-hidden rounded-xl border border-gray-100 p-3">
                    <div class="h-16 w-16 shrink-0 rounded-lg bg-gray-100 bg-cover bg-center" style="background-image: url('{{ $imageUrl($item->gambar) }}')"></div>
                    <div class="min-w-0 flex-1">
                        <h4 class="truncate text-sm font-bold text-gray-900">{{ $item->judul }}</h4>
                        <p class="mt-1 text-[10px] text-gray-500">{{ $item->tanggal?->translatedFormat('d M Y') }} &bull; {{ $item->sumber }}</p>
                    </div>
                    <div class="flex flex-col justify-center gap-1">
                        <button
                            type="button"
                            onclick="openEditBerita(this)"
                            data-action="{{ route('admin.publik.berita.update', $item->id_berita) }}"
                            data-judul="{{ $item->judul }}"
                            data-isi="{{ $item->isi_berita }}"
                            data-tanggal="{{ $item->tanggal?->format('Y-m-d') }}"
                            data-sumber="{{ $item->sumber }}"
                            class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 p-1.5 transition hover:bg-green-100"
                            title="Edit Berita">
                            <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                            <span class="sr-only">Edit</span>
                        </button>
                        <form method="POST" action="{{ route('admin.publik.berita.destroy', $item->id_berita) }}">
                            @csrf
                            @method('DELETE')
                            <button class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100" title="Hapus Berita">
                                <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                <span class="sr-only">Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="p-6 text-sm text-gray-500 sm:col-span-2 lg:col-span-3">Belum ada berita publik.</p>
            @endforelse
        </div>
    </div>
</div>

<div id="modal-semua-ulang-tahun" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-xs p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-5xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <div>
                <h3 class="text-lg font-bold">Semua Ulang Tahun Publik</h3>
                <p class="mt-0.5 text-xs text-white/70">{{ $ulangTahun->count() }} pegawai memiliki tanggal lahir</p>
            </div>
            <button type="button" onclick="closePublicModal('modal-semua-ulang-tahun')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal semua ulang tahun">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <div class="grid grid-cols-1 gap-4 overflow-y-auto p-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($ulangTahun as $item)
                <div class="flex items-center justify-between gap-4 rounded-xl border border-gray-100 p-4">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">{{ $item->nama }}</h3>
                        <p class="text-xs text-gray-500">{{ $item->tanggal?->translatedFormat('d M') }}</p>
                    </div>
                    <a href="{{ route('admin.pegawai.lihat') }}" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-bold text-gray-700 transition hover:bg-gray-50">Data Pegawai</a>
                </div>
            @empty
                <p class="p-6 text-sm text-gray-500 sm:col-span-2 lg:col-span-3">Belum ada pegawai yang memiliki tanggal lahir.</p>
            @endforelse
        </div>
    </div>
</div>

<div id="modal-semua-video" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-xs p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-5xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <div>
                <h3 class="text-lg font-bold">Semua Video Publik</h3>
                <p class="mt-0.5 text-xs text-white/70">{{ $video->count() }} video di database</p>
            </div>
            <button type="button" onclick="closePublicModal('modal-semua-video')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal semua video">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <div class="grid grid-cols-1 gap-4 overflow-y-auto p-5 lg:grid-cols-2">
            @forelse ($video as $item)
                <div class="overflow-hidden rounded-xl border border-gray-100">
                    <div class="aspect-video bg-gray-100">
                        <iframe
                            src="{{ $item->youtube_embed_url }}"
                            title="{{ $item->judul }}"
                            class="h-full w-full"
                            loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                    </div>
                    <div class="border-b border-gray-100 px-4 py-3">
                        <h4 class="truncate text-sm font-bold text-gray-900">{{ $item->judul }}</h4>
                        <p class="mt-1 text-xs text-gray-500">{{ optional($item->created_at)->translatedFormat('d M Y') }} &bull; YouTube</p>
                        @if ($item->deskripsi)
                            <p class="mt-2 line-clamp-2 text-xs text-gray-600">{{ $item->deskripsi }}</p>
                        @endif
                    </div>
                    <div class="flex justify-center gap-2 p-3">
                        <button
                            type="button"
                            onclick="openEditVideo(this)"
                            data-action="{{ route('admin.publik.video.update', $item->id_video) }}"
                            data-judul="{{ $item->judul }}"
                            data-deskripsi="{{ $item->deskripsi }}"
                            data-url="{{ $item->youtube_url }}"
                            class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-50 p-1.5 transition hover:bg-green-100"
                            title="Edit Video">
                            <img src="{{ asset('foto/Editlogo.png') }}" alt="Edit" class="h-full w-full object-contain">
                            <span class="sr-only">Edit</span>
                        </button>
                        <form method="POST" action="{{ route('admin.publik.video.destroy', $item->id_video) }}">
                            @csrf
                            @method('DELETE')
                            <button class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100" title="Hapus Video">
                                <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                <span class="sr-only">Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="p-6 text-sm text-gray-500 lg:col-span-2">Belum ada data video.</p>
            @endforelse
        </div>
    </div>
</div>

<div id="modal-tambah-berita" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-xs p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Tambah Berita</h3>
            <button type="button" onclick="closePublicModal('modal-tambah-berita')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal tambah berita">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.publik.berita.store') }}" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <input type="hidden" name="gambar_url" id="tambah-berita-gambar-url">
            <div class="space-y-5 overflow-y-auto px-5 py-5 sm:px-6">
                <!-- Auto Fetch URL Box -->
                <div class="rounded-xl border border-[#c9ddd4] bg-[#f4faf7] p-4 space-y-2">
                    <label class="block text-xs font-bold text-[#0e2f27] uppercase tracking-wider">🔗 Tempel Link / URL Berita (Opsional)</label>
                    <div class="flex gap-2">
                        <input id="fetch-berita-url" type="url" placeholder="https://bogorkab.go.id/berita/... atau link berita lain" class="h-10 flex-1 rounded-lg border border-[#c9ddd4] bg-white px-3 text-xs text-gray-800 outline-none focus:border-[#35635b]">
                        <button type="button" onclick="fetchBeritaFromUrl()" class="inline-flex h-10 items-center justify-center gap-1.5 rounded-lg bg-[#35635b] px-4 text-xs font-bold text-white transition hover:bg-[#284c46]">
                            <span id="btn-fetch-text">Ambil Data</span>
                            <span id="btn-fetch-spinner" class="hidden animate-spin">⏳</span>
                        </button>
                    </div>
                    <p class="text-[11px] text-gray-500">Judul, Ringkasan, Tanggal, Gambar, dan Sumber akan terisi otomatis dari link di atas.</p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Judul Berita</label>
                    <input name="judul" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10" placeholder="Judul berita">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Isi Berita</label>
                    <textarea name="isi_berita" required rows="4" class="w-full resize-none rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 py-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10" placeholder="Isi berita"></textarea>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ now()->toDateString() }}" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Sumber</label>
                        <input name="sumber" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10" placeholder="Sumber">
                    </div>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Gambar / Thumbnail</label>
                    <input type="file" name="gambar" accept="image/*" class="w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 py-3 text-sm text-gray-800 outline-none transition file:mr-4 file:rounded-lg file:border-0 file:bg-[#35635b] file:px-4 file:py-2 file:text-sm file:font-bold file:text-white focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
                    <div id="tambah-berita-preview-container" class="mt-3 hidden">
                        <p class="text-xs font-semibold text-gray-500 mb-1">Preview Gambar dari Link:</p>
                        <img id="tambah-berita-preview" src="" alt="Preview Gambar" class="h-32 rounded-lg object-cover border border-gray-200">
                    </div>
                </div>
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closePublicModal('modal-tambah-berita')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#04733f] px-5 text-sm font-bold text-white transition hover:bg-[#035f35]">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-tambah-galeri" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-xs p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Tambah Galeri</h3>
            <button type="button" onclick="closePublicModal('modal-tambah-galeri')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal tambah galeri">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.publik.galeri.store') }}" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="space-y-5 overflow-y-auto px-5 py-5 sm:px-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ now()->toDateString() }}" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Foto Galeri</label>
                    <input type="file" name="gambar" accept="image/*" required class="w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 py-3 text-sm text-gray-800 outline-none transition file:mr-4 file:rounded-lg file:border-0 file:bg-[#35635b] file:px-4 file:py-2 file:text-sm file:font-bold file:text-white focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
                </div>
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closePublicModal('modal-tambah-galeri')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#04733f] px-5 text-sm font-bold text-white transition hover:bg-[#035f35]">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-tambah-video" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-xs p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Tambah Video</h3>
            <button type="button" onclick="closePublicModal('modal-tambah-video')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal tambah video">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.publik.video.store') }}" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="space-y-5 overflow-y-auto px-5 py-5 sm:px-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Judul Video</label>
                    <input name="judul" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10" placeholder="Judul video">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Link YouTube</label>
                    <input name="youtube_url" type="url" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10" placeholder="https://www.youtube.com/watch?v=...">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full resize-none rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 py-3 text-sm text-gray-800 outline-none transition placeholder:text-gray-500 focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10" placeholder="Deskripsi video opsional"></textarea>
                </div>
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closePublicModal('modal-tambah-video')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#04733f] px-5 text-sm font-bold text-white transition hover:bg-[#035f35]">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-berita" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-xs p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Edit Berita</h3>
            <button type="button" onclick="closePublicModal('modal-edit-berita')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal edit berita">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <form id="form-edit-berita" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="space-y-5 overflow-y-auto px-5 py-5 sm:px-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Judul Berita</label>
                    <input id="edit-berita-judul" name="judul" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Isi Berita</label>
                    <textarea id="edit-berita-isi" name="isi_berita" required rows="4" class="w-full resize-none rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10"></textarea>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Tanggal</label>
                        <input id="edit-berita-tanggal" type="date" name="tanggal" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Sumber</label>
                        <input id="edit-berita-sumber" name="sumber" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
                    </div>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Ganti Gambar</label>
                    <input type="file" name="gambar" accept="image/*" class="w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 py-3 text-sm text-gray-800 outline-none transition file:mr-4 file:rounded-lg file:border-0 file:bg-[#35635b] file:px-4 file:py-2 file:text-sm file:font-bold file:text-white focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
                </div>
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closePublicModal('modal-edit-berita')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#04733f] px-5 text-sm font-bold text-white transition hover:bg-[#035f35]">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-galeri" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-xs p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Edit Galeri</h3>
            <button type="button" onclick="closePublicModal('modal-edit-galeri')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal edit galeri">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <form id="form-edit-galeri" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
            @csrf
            <div class="space-y-5 overflow-y-auto px-5 py-5 sm:px-6">
                <input type="hidden" name="jenis_dokumen" value="dokumentasi">
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Unggah Dokumentasi</label>
                    <input type="file" name="dokumen[]" accept=".jpg,.jpeg,.png,.webp" multiple required class="w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 py-3 text-sm text-gray-800 outline-none transition file:mr-4 file:rounded-lg file:border-0 file:bg-[#35635b] file:px-4 file:py-2 file:text-sm file:font-bold file:text-white focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
                    <p class="mt-2 text-xs text-gray-500">Bisa pilih lebih dari satu gambar. Hapus dokumentasi lama satu per satu dari galeri jika tidak diperlukan.</p>
                </div>
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closePublicModal('modal-edit-galeri')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#04733f] px-5 text-sm font-bold text-white transition hover:bg-[#035f35]">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit-video" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-xs p-3 sm:p-4">
    <div class="flex max-h-[calc(100vh-1.5rem)] w-full max-w-2xl flex-col overflow-hidden rounded-lg bg-white shadow-2xl sm:max-h-[calc(100vh-2rem)]">
        <div class="flex items-center justify-between bg-[#3f8078] px-5 py-4 text-white sm:px-6">
            <h3 class="text-lg font-bold">Edit Video</h3>
            <button type="button" onclick="closePublicModal('modal-edit-video')" class="flex h-9 w-9 items-center justify-center rounded-full text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Tutup modal edit video">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6L6 18"></path>
                </svg>
            </button>
        </div>
        <form id="form-edit-video" method="POST" class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')
            <div class="space-y-5 overflow-y-auto px-5 py-5 sm:px-6">
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Judul Video</label>
                    <input id="edit-video-judul" name="judul" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Link YouTube</label>
                    <input id="edit-video-url" name="youtube_url" type="url" required class="h-11 w-full rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#0e2f27]">Deskripsi</label>
                    <textarea id="edit-video-deskripsi" name="deskripsi" rows="3" class="w-full resize-none rounded-lg border border-[#c9ddd4] bg-[#f4faf7] px-4 py-3 text-sm text-gray-800 outline-none transition focus:border-[#35635b] focus:bg-white focus:ring-2 focus:ring-[#35635b]/10"></textarea>
                </div>
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <button type="button" onclick="closePublicModal('modal-edit-video')" class="h-10 rounded-lg px-5 text-sm font-bold text-gray-700 transition hover:bg-gray-100">Batal</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#04733f] px-5 text-sm font-bold text-white transition hover:bg-[#035f35]">Simpan</button>
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
