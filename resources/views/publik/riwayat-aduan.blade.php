<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aduan - SIRAPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ijo-tua': '#14524E',
                        'ijo-semitua': '#1F7A6F',
                        'ijo-sangatmuda': '#DCF1E6',
                        'oren-muda': '#FBEBD1',
                        'oren-tua': '#B87A1E',
                        'biru-muda': '#DCEEF5',
                        'biru-tua': '#1E6E8C',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F8F7F4] font-sans antialiased text-gray-800 flex flex-col min-h-screen">
    @include('publik.layout_publik.navbarpublik')

    <main class="flex-grow w-full max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-10 py-8 space-y-6">
        @php
            $masukanItems = ($masukan ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator
                ? $masukan->getCollection()
                : collect($masukan ?? []);
            $statusClass = fn ($status) => match (strtolower((string) $status)) {
                'selesai' => 'bg-ijo-sangatmuda text-ijo-tua',
                'diproses', 'proses' => 'bg-biru-muda text-biru-tua',
                default => 'bg-oren-muda text-oren-tua',
            };
            $maskEmail = function ($email) {
                if (! $email || ! str_contains($email, '@')) {
                    return '-';
                }

                [$local, $domain] = explode('@', $email, 2);
                $visible = substr($local, 0, min(2, strlen($local)));

                return $visible . '***@' . $domain;
            };
            $aduanDetailItems = $masukanItems->mapWithKeys(fn ($aduan) => [
                $aduan->id_datamasukan => [
                    'nama_pengadu' => $aduan->nama_pengadu,
                    'email' => $maskEmail($aduan->email),
                    'isi_aduan' => $aduan->isi_aduan,
                    'balasan_admin' => $aduan->balasan_admin ?: 'Belum ada balasan dari admin.',
                    'status' => $aduan->status ?? 'Pending',
                    'tanggal' => $aduan->created_at ? \Carbon\Carbon::parse($aduan->created_at)->translatedFormat('d F Y, H:i') : '-',
                    'foto_url' => (!empty($aduan->foto) && $aduan->foto !== 'aduan/default.jpg' && file_exists(public_path('storage/' . $aduan->foto))) ? asset('storage/' . $aduan->foto) : null,
                ],
            ])->all();
        @endphp

        <div class="space-y-3">
            <nav class="text-xs text-gray-500 flex items-center space-x-2">
                <a href="{{ route('publik.beranda') }}" class="hover:underline">Beranda</a>
                <span>/</span>
                <span class="text-gray-800 font-semibold">Daftar Aduan</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Daftar Aduan</h1>
                    <p class="text-xs text-gray-500 mt-1">Melihat seluruh laporan aduan yang telah dikirimkan.</p>
                </div>
                <a href="{{ route('publik.masukan') }}" class="bg-ijo-tua hover:bg-ijo-semitua text-white text-xs font-bold px-5 py-2.5 rounded-full self-start md:self-auto">
                    Buat Aduan Baru
                </a>
            </div>
        </div>

        <section class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-gray-100 text-gray-500 uppercase text-[10px] tracking-wider">
                            <th class="p-3 rounded-l-xl">Nama Pengadu</th>
                            <th class="p-3">Isi Aduan</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Balasan Admin</th>
                            <th class="p-3 text-center">Status</th>
                            <th class="p-3 text-right rounded-r-xl">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium text-gray-700">
                        @forelse ($masukanItems as $aduan)
                            <tr class="aduan-row cursor-pointer hover:bg-gray-50/80 transition" data-aduan-id="{{ $aduan->id_datamasukan }}" title="Klik untuk melihat detail aduan">
                                <td class="p-3 font-bold text-gray-900 whitespace-nowrap">{{ $aduan->nama_pengadu }}</td>
                                <td class="p-3 text-gray-500 min-w-[260px]">{{ $aduan->isi_aduan }}</td>
                                <td class="p-3 text-gray-500 min-w-[180px]">{{ $maskEmail($aduan->email) }}</td>
                                <td class="p-3 text-gray-500 min-w-[220px]">
                                    {{ $aduan->balasan_admin ? \Illuminate\Support\Str::limit($aduan->balasan_admin, 90) : 'Belum ada balasan' }}
                                </td>
                                <td class="p-3 text-center">
                                    <span class="{{ $statusClass($aduan->status) }} font-bold px-3 py-1 rounded-full text-[10px]">{{ $aduan->status ?? 'Pending' }}</span>
                                </td>
                                <td class="p-3 text-right text-gray-400 whitespace-nowrap">{{ $aduan->created_at ? \Carbon\Carbon::parse($aduan->created_at)->translatedFormat('d M Y') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-500">Belum ada aduan di database.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (($masukan ?? null) instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="pt-4">
                    {{ $masukan->links() }}
                </div>
            @endif
        </section>
    </main>

    <div id="aduan-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="w-full max-w-2xl rounded-3xl bg-white shadow-xl overflow-hidden">
            <div class="bg-ijo-tua text-white p-6 flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-wider text-white/70 font-bold">Detail Aduan</p>
                    <h2 id="aduan-modal-title" class="text-xl font-extrabold mt-1">-</h2>
                    <p id="aduan-modal-date" class="text-xs text-white/70 mt-1">-</p>
                </div>
                <button type="button" id="aduan-modal-close" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-lg font-bold">x</button>
            </div>

            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                    <div class="rounded-2xl bg-gray-50 p-4">
                        <p class="text-[10px] uppercase font-bold text-gray-400">Nama</p>
                        <p id="aduan-modal-name" class="mt-1 font-bold text-gray-900">-</p>
                    </div>
                    <div class="rounded-2xl bg-gray-50 p-4">
                        <p class="text-[10px] uppercase font-bold text-gray-400">Email</p>
                        <p id="aduan-modal-email" class="mt-1 font-bold text-gray-900">-</p>
                    </div>
                    <div class="rounded-2xl bg-gray-50 p-4">
                        <p class="text-[10px] uppercase font-bold text-gray-400">Status</p>
                        <p id="aduan-modal-status" class="mt-1 font-bold text-gray-900">-</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 p-5">
                    <p class="text-[10px] uppercase font-bold text-gray-400">Isi Aduan</p>
                    <p id="aduan-modal-body" class="mt-2 text-sm leading-relaxed text-gray-700 whitespace-pre-line">-</p>
                </div>

                <div id="aduan-modal-photo-container" class="hidden rounded-2xl border border-gray-100 p-5">
                    <p class="text-[10px] uppercase font-bold text-gray-400">Lampiran Foto</p>
                    <div class="mt-2">
                        <a id="aduan-modal-photo-link" href="#" target="_blank" rel="noopener noreferrer">
                            <img id="aduan-modal-photo-img" src="" alt="Lampiran Foto" class="max-h-60 rounded-xl border border-gray-200 object-contain hover:opacity-90 transition">
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl bg-ijo-sangatmuda p-5">
                    <p class="text-[10px] uppercase font-bold text-ijo-tua/70">Balasan Admin</p>
                    <p id="aduan-modal-reply" class="mt-2 text-sm leading-relaxed text-gray-800 whitespace-pre-line">-</p>
                </div>
            </div>
        </div>
    </div>

    @include('publik.layout_publik.footer')
    <script>
        const aduanDetails = @json($aduanDetailItems);
        const aduanModal = document.getElementById('aduan-modal');
        const aduanModalClose = document.getElementById('aduan-modal-close');
        const aduanModalPhotoContainer = document.getElementById('aduan-modal-photo-container');
        const aduanModalPhotoLink = document.getElementById('aduan-modal-photo-link');
        const aduanModalPhotoImg = document.getElementById('aduan-modal-photo-img');

        function setAduanText(id, value) {
            const element = document.getElementById(id);
            if (element) {
                element.textContent = value || '-';
            }
        }

        document.querySelectorAll('.aduan-row').forEach((row) => {
            row.addEventListener('click', () => {
                const detail = aduanDetails[row.dataset.aduanId];

                if (!detail) {
                    return;
                }

                setAduanText('aduan-modal-title', detail.isi_aduan.length > 70 ? detail.isi_aduan.slice(0, 70) + '...' : detail.isi_aduan);
                setAduanText('aduan-modal-date', detail.tanggal);
                setAduanText('aduan-modal-name', detail.nama_pengadu);
                setAduanText('aduan-modal-email', detail.email);
                setAduanText('aduan-modal-status', detail.status);
                setAduanText('aduan-modal-body', detail.isi_aduan);
                setAduanText('aduan-modal-reply', detail.balasan_admin);

                if (detail.foto_url) {
                    aduanModalPhotoLink.href = detail.foto_url;
                    aduanModalPhotoImg.src = detail.foto_url;
                    aduanModalPhotoContainer.classList.remove('hidden');
                } else {
                    aduanModalPhotoContainer.classList.add('hidden');
                    aduanModalPhotoLink.href = '#';
                    aduanModalPhotoImg.src = '';
                }

                aduanModal.classList.remove('hidden');
                aduanModal.classList.add('flex');
            });
        });

        aduanModalClose?.addEventListener('click', () => {
            aduanModal.classList.add('hidden');
            aduanModal.classList.remove('flex');
        });

        aduanModal?.addEventListener('click', (event) => {
            if (event.target === aduanModal) {
                aduanModal.classList.add('hidden');
                aduanModal.classList.remove('flex');
            }
        });
    </script>
</body>
</html>
