<?php

namespace Database\Seeders;

use App\Models\QRCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class PublicFullDemoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $today = $now->copy();

        $this->ensureDemoImages();

        $ruangId = $this->ensureRuangRapat('Ruang Command Center', 80, 'Ruang rapat publik dan koordinasi layanan digital.');
        $statusId = $this->ensureStatusAgenda('Mendatang');
        $adminId = DB::table('app_md_admin')->where('username', 'admin')->value('id_admin');

        $agendaRows = [
            [
                'nama_agenda' => 'Koordinasi Layanan Digital Publik',
                'tanggal' => $today->toDateString(),
                'waktu' => $now->copy()->subMinutes(10)->format('H:i:s'),
                'waktu_selesai' => $now->copy()->addMinutes(50)->format('H:i:s'),
                'kuota' => 80,
                'lokasi' => 'Ruang Command Center',
                'status_fr' => true,
                'status_qr' => 'aktif',
                'kategori_surat' => 'internal',
                'asal_surat' => 'Sekretariat Diskominfo Kabupaten Bogor',
                'ditugaskan' => 'Bidang Aplikasi Informatika',
            ],
            [
                'nama_agenda' => 'Sosialisasi Keamanan Informasi OPD',
                'tanggal' => $today->toDateString(),
                'waktu' => '09:00:00',
                'waktu_selesai' => '10:30:00',
                'kuota' => 120,
                'lokasi' => 'Aula Diskominfo',
                'status_fr' => true,
                'status_qr' => 'aktif',
                'kategori_surat' => 'eksternal',
                'asal_surat' => 'Bidang Persandian dan Statistik',
                'ditugaskan' => 'Tim Keamanan Informasi',
            ],
            [
                'nama_agenda' => 'Evaluasi Kanal Aduan Masyarakat',
                'tanggal' => $today->toDateString(),
                'waktu' => '13:30:00',
                'waktu_selesai' => '15:00:00',
                'kuota' => 45,
                'lokasi' => 'Ruang Rapat Bidang',
                'status_fr' => true,
                'status_qr' => 'nonaktif',
                'kategori_surat' => 'internal',
                'asal_surat' => 'PPID Kabupaten Bogor',
                'ditugaskan' => 'Tim Pengelola Aduan',
            ],
            [
                'nama_agenda' => 'Pelatihan Pengelolaan Website Desa',
                'tanggal' => $today->copy()->addDay()->toDateString(),
                'waktu' => '08:30:00',
                'waktu_selesai' => '11:30:00',
                'kuota' => 100,
                'lokasi' => 'Aula Serbaguna',
                'status_fr' => true,
                'status_qr' => 'aktif',
                'kategori_surat' => 'eksternal',
                'asal_surat' => 'Kecamatan Cibinong',
                'ditugaskan' => 'Bidang Informasi dan Komunikasi Publik',
            ],
            [
                'nama_agenda' => 'Monitoring Jaringan Perangkat Daerah',
                'tanggal' => $today->copy()->addDays(2)->toDateString(),
                'waktu' => '10:00:00',
                'waktu_selesai' => '12:00:00',
                'kuota' => 30,
                'lokasi' => 'Ruang Network Operation Center',
                'status_fr' => false,
                'status_qr' => 'nonaktif',
                'kategori_surat' => 'internal',
                'asal_surat' => 'Bidang Infrastruktur TIK',
                'ditugaskan' => 'Tim Infrastruktur',
            ],
        ];

        foreach ($agendaRows as $row) {
            $payload = $this->agendaPayload($row, $ruangId, $statusId, $now);

            DB::table('app_md_agenda')->updateOrInsert(
                ['nama_agenda' => $row['nama_agenda']],
                $payload
            );

            if ($row['status_qr'] === 'aktif') {
                $agendaId = DB::table('app_md_agenda')->where('nama_agenda', $row['nama_agenda'])->value('id_agenda');
                QRCode::generateQR((int) $agendaId);
            }
        }

        $beritaRows = [
            ['Diskominfo Perkuat Layanan Informasi Publik', 'Tim Diskominfo Kabupaten Bogor memperbarui kanal informasi agar jadwal kegiatan, pengumuman, dan layanan aduan lebih mudah dipantau masyarakat.', 'uploads/demo/berita-layanan-digital.svg'],
            ['Pelatihan Website Desa Dorong Transparansi Informasi', 'Operator desa mengikuti pendampingan pengelolaan konten digital untuk meningkatkan kualitas informasi publik di wilayah Kabupaten Bogor.', 'uploads/demo/berita-website-desa.svg'],
            ['Keamanan Informasi Jadi Fokus Koordinasi OPD', 'Koordinasi lintas perangkat daerah membahas perlindungan data, tata kelola akun, dan kesiapan respons insiden keamanan informasi.', 'uploads/demo/berita-keamanan-informasi.svg'],
            ['Integrasi Aduan Publik Dipantau Berkala', 'Riwayat aduan masyarakat kini dipantau melalui dashboard agar tindak lanjut setiap laporan lebih mudah dilihat dan dievaluasi.', 'uploads/demo/berita-aduan-publik.svg'],
            ['Jaringan Komunikasi Pemerintah Daerah Dimonitor', 'Tim infrastruktur TIK melakukan monitoring layanan jaringan untuk memastikan dukungan konektivitas kegiatan pemerintahan tetap berjalan.', 'uploads/demo/berita-monitoring-jaringan.svg'],
            ['Publikasi Agenda Rapat Dibuka untuk Masyarakat', 'Agenda kegiatan yang bersifat publik ditampilkan pada portal agar masyarakat mengetahui informasi kegiatan secara lebih cepat.', 'uploads/demo/berita-agenda-publik.svg'],
        ];

        foreach ($beritaRows as $index => [$judul, $isi, $gambar]) {
            DB::table('app_md_berita')->updateOrInsert(
                ['judul' => $judul],
                [
                    'isi_berita' => $isi,
                    'tanggal' => $today->copy()->subDays($index)->toDateString(),
                    'gambar' => $gambar,
                    'sumber' => 'Diskominfo Kabupaten Bogor',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $galeriRows = [
            ['uploads/demo/galeri-command-center.svg', 0],
            ['uploads/demo/galeri-sosialisasi-opd.svg', 0],
            ['uploads/demo/galeri-pelatihan-desa.svg', 1],
            ['uploads/demo/galeri-monitoring-jaringan.svg', 2],
            ['uploads/demo/galeri-aduan-publik.svg', 3],
            ['uploads/demo/galeri-ppid.svg', 4],
            ['uploads/demo/galeri-keamanan-informasi.svg', 5],
            ['uploads/demo/galeri-rapat-koordinasi.svg', 6],
            ['uploads/demo/galeri-layanan-data.svg', 7],
        ];

        foreach ($galeriRows as [$gambar, $daysAgo]) {
            DB::table('app_md_galeri')->updateOrInsert(
                ['gambar' => $gambar],
                [
                    'tanggal' => $today->copy()->subDays($daysAgo)->toDateString(),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        $ulangTahunRows = [
            ['Raka Pratama', $today->copy()->toDateString(), 'uploads/demo/pegawai-raka.svg'],
            ['Nadia Permata', $today->copy()->addDays(3)->toDateString(), 'uploads/demo/pegawai-nadia.svg'],
            ['Dimas Arya', $today->copy()->addDays(9)->toDateString(), 'uploads/demo/pegawai-dimas.svg'],
            ['Salsa Fitri', $today->copy()->addDays(15)->toDateString(), 'uploads/demo/pegawai-salsa.svg'],
            ['Bayu Nugroho', $today->copy()->addDays(22)->toDateString(), 'uploads/demo/pegawai-bayu.svg'],
            ['Laras Wulandari', $today->copy()->addMonth()->toDateString(), 'uploads/demo/pegawai-laras.svg'],
        ];

        foreach ($ulangTahunRows as [$nama, $tanggal, $gambar]) {
            DB::table('app_md_ulangtahun')->updateOrInsert(
                ['nama' => $nama],
                [
                    'tanggal' => $tanggal,
                    'gambar' => $gambar,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        DB::table('app_md_cuaca')->updateOrInsert(
            ['lokasi' => 'Cibinong, Kabupaten Bogor'],
            [
                'isi_berita' => 'Data contoh cuaca untuk fallback ketika API cuaca tidak dapat diakses.',
                'suhu' => '28',
                'kondisi' => 'Cerah Berawan',
                'kelembapan' => '76%',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        $masukanRows = [
            ['Agus Saputra', 'agus.saputra@example.test', '081311110001', 'Mohon jadwal sosialisasi literasi digital ditampilkan lebih awal agar warga bisa mendaftar.', 'Menunggu', null],
            ['Maya Lestari', 'maya.lestari@example.test', '081311110002', 'Website kecamatan beberapa kali lambat saat membuka halaman informasi pelayanan.', 'Diproses', 'Terima kasih, laporan sudah diteruskan ke tim infrastruktur TIK untuk pengecekan.'],
            ['Rizky Ramadhan', 'rizky.ramadhan@example.test', '081311110003', 'Informasi kontak layanan publik perlu dibuat lebih mudah ditemukan pada halaman utama.', 'Selesai', 'Kontak layanan sudah ditambahkan pada area informasi publik dan akan dipantau kembali.'],
            ['Putri Amelia', 'putri.amelia@example.test', '081311110004', 'Galeri kegiatan Diskominfo bisa dibuat lebih sering diperbarui setelah acara selesai.', 'Diproses', 'Masukan sudah diterima oleh admin konten dan akan masuk jadwal pembaruan rutin.'],
            ['Fajar Hidayat', 'fajar.hidayat@example.test', '081311110005', 'Mohon dibuatkan pengumuman singkat jika ada gangguan jaringan layanan pemerintah daerah.', 'Menunggu', null],
            ['Dewi Anggraini', 'dewi.anggraini@example.test', '081311110006', 'Riwayat aduan sebaiknya menampilkan status tindak lanjut agar pelapor mudah memantau.', 'Selesai', 'Fitur riwayat aduan sudah menampilkan status dan balasan admin secara ringkas.'],
            ['Teguh Santoso', 'teguh.santoso@example.test', '081311110007', 'Video dokumentasi kegiatan literasi digital perlu ditampilkan pada portal publik.', 'Diproses', 'Konten video publik sedang dikurasi dan diarahkan ke kanal YouTube Diskominfo.'],
            ['Indah Kurnia', 'indah.kurnia@example.test', '081311110008', 'Tampilan agenda hari ini sudah membantu, tapi jumlah kegiatan bisa dibuat lebih lengkap.', 'Menunggu', null],
        ];

        foreach ($masukanRows as $index => [$nama, $email, $nomor, $aduan, $status, $balasan]) {
            $payload = [
                'nama_pengadu' => $nama,
                'nomor_pengadu' => $nomor,
                'foto' => 'uploads/demo/aduan-' . (($index % 4) + 1) . '.svg',
                'isi_aduan' => $aduan,
                'status' => $status,
                'id_admin' => $adminId,
                'created_at' => $now->copy()->subHours($index),
                'updated_at' => $now,
            ];

            if (Schema::hasColumn('app_md_datamasukan', 'balasan_admin')) {
                $payload['balasan_admin'] = $balasan;
            }

            DB::table('app_md_datamasukan')->updateOrInsert(
                ['email' => $email],
                $payload
            );
        }
    }

    private function ensureRuangRapat(string $nama, int $kapasitas, string $keterangan): int
    {
        DB::table('app_md_ruangrapat')->updateOrInsert(
            ['nama_ruang' => $nama],
            [
                'kapasitas' => $kapasitas,
                'keterangan' => $keterangan,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return (int) DB::table('app_md_ruangrapat')->where('nama_ruang', $nama)->value('id_ruangrapat');
    }

    private function ensureStatusAgenda(string $nama): int
    {
        DB::table('app_md_statusagenda')->updateOrInsert(
            ['nama_status' => $nama],
            ['created_at' => now(), 'updated_at' => now()]
        );

        return (int) DB::table('app_md_statusagenda')->where('nama_status', $nama)->value('id_statusagenda');
    }

    private function agendaPayload(array $row, int $ruangId, int $statusId, mixed $now): array
    {
        $payload = [
            'nama_agenda' => $row['nama_agenda'],
            'tanggal' => $row['tanggal'],
            'waktu' => $row['waktu'],
            'kuota' => $row['kuota'],
            'lokasi' => $row['lokasi'],
            'status_fr' => $row['status_fr'],
            'status_qr' => $row['status_qr'],
            'id_ruangrapat' => $ruangId,
            'id_statusagenda' => $statusId,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        foreach (['waktu_selesai', 'kategori_surat', 'asal_surat', 'ditugaskan'] as $column) {
            if (Schema::hasColumn('app_md_agenda', $column)) {
                $payload[$column] = $row[$column] ?? null;
            }
        }

        if (Schema::hasColumn('app_md_agenda', 'lampiran')) {
            $payload['lampiran'] = null;
        }

        return $payload;
    }

    private function ensureDemoImages(): void
    {
        $directory = public_path('uploads/demo');
        File::ensureDirectoryExists($directory);

        $images = [
            'berita-layanan-digital.svg' => ['Layanan Digital', '#0f766e', '#e0f2fe'],
            'berita-website-desa.svg' => ['Website Desa', '#2563eb', '#ecfccb'],
            'berita-keamanan-informasi.svg' => ['Keamanan Informasi', '#7c3aed', '#fef3c7'],
            'berita-aduan-publik.svg' => ['Aduan Publik', '#b45309', '#dbeafe'],
            'berita-monitoring-jaringan.svg' => ['Monitoring Jaringan', '#15803d', '#fce7f3'],
            'berita-agenda-publik.svg' => ['Agenda Publik', '#be123c', '#dcfce7'],
            'galeri-command-center.svg' => ['Command Center', '#155e75', '#f8fafc'],
            'galeri-sosialisasi-opd.svg' => ['Sosialisasi OPD', '#047857', '#fefce8'],
            'galeri-pelatihan-desa.svg' => ['Pelatihan Desa', '#1d4ed8', '#f0fdf4'],
            'galeri-monitoring-jaringan.svg' => ['Monitoring TIK', '#9333ea', '#eff6ff'],
            'galeri-aduan-publik.svg' => ['Aduan Publik', '#c2410c', '#f7fee7'],
            'galeri-ppid.svg' => ['Layanan PPID', '#0e7490', '#fff7ed'],
            'galeri-keamanan-informasi.svg' => ['Keamanan Data', '#4338ca', '#ecfeff'],
            'galeri-rapat-koordinasi.svg' => ['Rapat Koordinasi', '#0369a1', '#fef2f2'],
            'galeri-layanan-data.svg' => ['Layanan Data', '#166534', '#eef2ff'],
            'pegawai-raka.svg' => ['RP', '#0f766e', '#ffffff'],
            'pegawai-nadia.svg' => ['NP', '#be123c', '#ffffff'],
            'pegawai-dimas.svg' => ['DA', '#1d4ed8', '#ffffff'],
            'pegawai-salsa.svg' => ['SF', '#7c2d12', '#ffffff'],
            'pegawai-bayu.svg' => ['BN', '#6d28d9', '#ffffff'],
            'pegawai-laras.svg' => ['LW', '#047857', '#ffffff'],
            'aduan-1.svg' => ['Aduan', '#64748b', '#ffffff'],
            'aduan-2.svg' => ['Aduan', '#0f766e', '#ffffff'],
            'aduan-3.svg' => ['Aduan', '#2563eb', '#ffffff'],
            'aduan-4.svg' => ['Aduan', '#b45309', '#ffffff'],
        ];

        foreach ($images as $file => [$label, $primary, $secondary]) {
            File::put($directory . DIRECTORY_SEPARATOR . $file, $this->svg($label, $primary, $secondary));
        }
    }

    private function svg(string $label, string $primary, string $secondary): string
    {
        $safeLabel = e($label);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="960" height="640" viewBox="0 0 960 640">
  <rect width="960" height="640" fill="{$secondary}"/>
  <rect x="64" y="64" width="832" height="512" rx="28" fill="{$primary}" opacity="0.95"/>
  <circle cx="770" cy="164" r="70" fill="{$secondary}" opacity="0.22"/>
  <circle cx="178" cy="494" r="96" fill="{$secondary}" opacity="0.18"/>
  <path d="M132 430h696v54H132zM132 348h456v34H132zM132 292h588v34H132z" fill="{$secondary}" opacity="0.86"/>
  <text x="132" y="230" fill="{$secondary}" font-family="Arial, Helvetica, sans-serif" font-size="58" font-weight="700">{$safeLabel}</text>
  <text x="132" y="274" fill="{$secondary}" font-family="Arial, Helvetica, sans-serif" font-size="24">Diskominfo Kabupaten Bogor</text>
</svg>
SVG;
    }
}
