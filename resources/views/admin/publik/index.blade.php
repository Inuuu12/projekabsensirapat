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
@endphp

<div class="max-w-[1400px] mx-auto space-y-6">
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F2937] tracking-tight">Konten Publik</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">Data di halaman ini langsung tampil di folder publik karena memakai tabel database yang sama.</p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <section class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 space-y-4">
            <div>
                <h2 class="text-base font-extrabold text-gray-800">Tambah Berita</h2>
                <p class="text-xs text-gray-500 mt-1">Masuk ke halaman Berita Terkini publik.</p>
            </div>
            <form method="POST" action="{{ route('admin.publik.berita.store') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <input name="judul" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-[#35635b]" placeholder="Judul berita">
                <textarea name="isi_berita" required rows="4" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-[#35635b]" placeholder="Isi berita"></textarea>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <input type="date" name="tanggal" value="{{ now()->toDateString() }}" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-[#35635b]">
                    <input name="sumber" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-[#35635b]" placeholder="Sumber">
                </div>
                <input type="file" name="gambar" accept="image/*" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm">
                <button class="rounded-xl bg-[#22C55E] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#16A34A]">Simpan Berita</button>
            </form>
        </section>

        <section class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 space-y-4">
            <div>
                <h2 class="text-base font-extrabold text-gray-800">Tambah Galeri</h2>
                <p class="text-xs text-gray-500 mt-1">Masuk ke grid Galeri di beranda publik dan halaman galeri.</p>
            </div>
            <form method="POST" action="{{ route('admin.publik.galeri.store') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <input type="date" name="tanggal" value="{{ now()->toDateString() }}" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-[#35635b]">
                <input type="file" name="gambar" accept="image/*" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm">
                <button class="rounded-xl bg-[#22C55E] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#16A34A]">Simpan Foto</button>
            </form>
        </section>

        <section class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 space-y-4">
            <div>
                <h2 class="text-base font-extrabold text-gray-800">Tambah Ulang Tahun</h2>
                <p class="text-xs text-gray-500 mt-1">Masuk ke widget ulang tahun publik.</p>
            </div>
            <form method="POST" action="{{ route('admin.publik.ulang-tahun.store') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <input name="nama" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-[#35635b]" placeholder="Nama pegawai">
                <input type="date" name="tanggal" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-[#35635b]">
                <input type="file" name="gambar" accept="image/*" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm">
                <button class="rounded-xl bg-[#22C55E] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#16A34A]">Simpan Ulang Tahun</button>
            </form>
        </section>

        <section class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 space-y-4">
            <div>
                <h2 class="text-base font-extrabold text-gray-800">Tambah Cuaca</h2>
                <p class="text-xs text-gray-500 mt-1">Data terbaru akan dipakai widget cuaca publik.</p>
            </div>
            <form method="POST" action="{{ route('admin.publik.cuaca.store') }}" class="space-y-3">
                @csrf
                <input name="lokasi" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-[#35635b]" placeholder="Lokasi">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <input name="suhu" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-[#35635b]" placeholder="27">
                    <input name="kondisi" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-[#35635b]" placeholder="Cerah Berawan">
                    <input name="kelembapan" required class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-[#35635b]" placeholder="78%">
                </div>
                <textarea name="isi_berita" rows="2" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none focus:border-[#35635b]" placeholder="Catatan cuaca opsional"></textarea>
                <button class="rounded-xl bg-[#22C55E] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#16A34A]">Simpan Cuaca</button>
            </form>
        </section>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <section class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-extrabold text-gray-800">Berita Publik</h2>
                <p class="text-xs text-gray-500 mt-1">{{ $berita->count() }} berita di database.</p>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($berita->take(6) as $item)
                    <div class="p-4 flex items-center gap-4">
                        <div class="w-16 h-16 rounded-xl bg-gray-100 bg-cover bg-center shrink-0" style="background-image: url('{{ $imageUrl($item->gambar) }}')"></div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-bold text-gray-900 truncate">{{ $item->judul }}</h3>
                            <p class="text-xs text-gray-500">{{ $item->tanggal?->format('d M Y') }} &bull; {{ $item->sumber }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.publik.berita.destroy', $item->id_berita) }}">
                            @csrf
                            @method('DELETE')
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100" title="Hapus Berita">
                                <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                <span class="sr-only">Hapus</span>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500">Belum ada berita.</p>
                @endforelse
            </div>
        </section>

        <section class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-extrabold text-gray-800">Galeri Publik</h2>
                <p class="text-xs text-gray-500 mt-1">{{ $galeri->count() }} foto di database.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4">
                @forelse ($galeri->take(6) as $item)
                    <div class="rounded-xl border border-gray-100 overflow-hidden">
                        <div class="aspect-[4/3] bg-gray-100 bg-cover bg-center" style="background-image: url('{{ $imageUrl($item->gambar, 'foto/Agendahariini.png') }}')"></div>
                        <form method="POST" action="{{ route('admin.publik.galeri.destroy', $item->id_galeri) }}" class="p-2">
                            @csrf
                            @method('DELETE')
                            <button class="mx-auto flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100" title="Hapus Foto">
                                <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                <span class="sr-only">Hapus</span>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="col-span-3 p-2 text-sm text-gray-500">Belum ada foto galeri.</p>
                @endforelse
            </div>
        </section>

        <section class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-extrabold text-gray-800">Ulang Tahun Publik</h2>
                <p class="text-xs text-gray-500 mt-1">{{ $ulangTahun->count() }} data di database.</p>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($ulangTahun->take(6) as $item)
                    <div class="p-4 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">{{ $item->nama }}</h3>
                            <p class="text-xs text-gray-500">{{ $item->tanggal?->format('d M') }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.publik.ulang-tahun.destroy', $item->id_ulangtahun) }}">
                            @csrf
                            @method('DELETE')
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100" title="Hapus Ulang Tahun">
                                <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                <span class="sr-only">Hapus</span>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500">Belum ada data ulang tahun.</p>
                @endforelse
            </div>
        </section>

        <section class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-extrabold text-gray-800">Cuaca Publik</h2>
                <p class="text-xs text-gray-500 mt-1">{{ $cuaca->count() }} data di database.</p>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse ($cuaca->take(6) as $item)
                    <div class="p-4 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">{{ $item->lokasi }} &bull; {{ $item->suhu }}°C</h3>
                            <p class="text-xs text-gray-500">{{ $item->kondisi }} &bull; Kelembapan {{ $item->kelembapan }}</p>
                        </div>
                        <form method="POST" action="{{ route('admin.publik.cuaca.destroy', $item->id_cuaca) }}">
                            @csrf
                            @method('DELETE')
                            <button class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 p-1.5 transition hover:bg-red-100" title="Hapus Cuaca">
                                <img src="{{ asset('foto/Deletelogo.png') }}" alt="Hapus" class="h-full w-full object-contain">
                                <span class="sr-only">Hapus</span>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="p-6 text-sm text-gray-500">Belum ada data cuaca.</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection
