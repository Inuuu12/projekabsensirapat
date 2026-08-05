<?php

namespace Database\Seeders;

use App\Models\QRCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('sirapi_md_admin')->updateOrInsert(
            ['username' => 'admin'],
            [
                'nama' => 'Administrator',
                'password' => Hash::make('admin123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        foreach (['Mendatang', 'Berlangsung', 'Selesai'] as $statusAgenda) {
            DB::table('sirapi_md_statusagenda')->updateOrInsert(
                ['nama_status' => $statusAgenda],
                ['created_at' => $now, 'updated_at' => $now],
            );
        }

        $ruangan = [
            ['nama_ruang' => 'Ruang Rapat Utama', 'kapasitas' => 40, 'keterangan' => 'Ruang rapat utama lantai 2.'],
            ['nama_ruang' => 'Aula Serbaguna', 'kapasitas' => 120, 'keterangan' => 'Aula untuk rapat besar dan sosialisasi.'],
            ['nama_ruang' => 'Ruang Rapat Bidang', 'kapasitas' => 20, 'keterangan' => 'Ruang rapat internal bidang.'],
        ];

        foreach ($ruangan as $item) {
            DB::table('sirapi_md_ruangrapat')->updateOrInsert(
                ['nama_ruang' => $item['nama_ruang']],
                $item + ['created_at' => $now, 'updated_at' => $now],
            );
        }

        foreach ([
            'Sekretariat',
            'Bidang Pengelolaan Informasi dan Komunikasi Publik',
            'Bidang Aplikasi Informatika',
            'Bidang Infrastruktur Teknologi',
            'Bidang Persandian dan Statistik',
            'UPT Radio dan Televisi',
        ] as $bidang) {
            DB::table('sirapi_md_bidang')->updateOrInsert(
                ['nama_bidang' => $bidang],
                ['created_at' => $now, 'updated_at' => $now],
            );
        }

        foreach ([
            ['nama_jabatan' => 'Kepala Dinas', 'kategori' => 'Struktural'],
            ['nama_jabatan' => 'Sekretaris Dinas', 'kategori' => 'Struktural'],
            ['nama_jabatan' => 'Kepala Bidang', 'kategori' => 'Struktural'],
            ['nama_jabatan' => 'Kepala Subag/Seksi', 'kategori' => 'Struktural'],
            ['nama_jabatan' => 'Kepala UPT', 'kategori' => 'Struktural'],
            ['nama_jabatan' => 'Kepala TU UPT', 'kategori' => 'Struktural'],
            ['nama_jabatan' => 'Sub Koordinator', 'kategori' => 'Jabatan Fungsional'],
            ['nama_jabatan' => 'Pranata Komputer Ahli Muda', 'kategori' => 'Jabatan Fungsional'],
            ['nama_jabatan' => 'Pranata Komputer Pertama', 'kategori' => 'Jabatan Fungsional'],
            ['nama_jabatan' => 'Pelaksana', 'kategori' => 'Jabatan Fungsional'],
        ] as $jabatan) {
            DB::table('sirapi_md_jabatan')->updateOrInsert(
                ['nama_jabatan' => $jabatan['nama_jabatan']],
                $jabatan + ['created_at' => $now, 'updated_at' => $now],
            );
        }

        $pegawai = [
            [
                'nip' => '198801012010011001',
                'nama_pegawai' => 'Andi Saputra',
                'tanggal_lahir' => '1988-03-15',
                'jabatan' => 'Kepala Subag/Seksi',
                'bidang' => 'Sekretariat',
                'nomor_hp' => '081234567890',
                'email' => 'andi.saputra@bappenda.test',
                'password' => Hash::make('pegawai123'),
            ],
            [
                'nip' => '199002022015032002',
                'nama_pegawai' => 'Siti Aminah',
                'tanggal_lahir' => '1990-08-07',
                'jabatan' => 'Pelaksana',
                'bidang' => 'Bidang Pengelolaan Informasi dan Komunikasi Publik',
                'nomor_hp' => '081234567891',
                'email' => 'siti.aminah@bappenda.test',
                'password' => Hash::make('pegawai123'),
            ],
            [
                'nip' => '199503032020121003',
                'nama_pegawai' => 'Budi Santoso',
                'tanggal_lahir' => '1995-01-10',
                'jabatan' => 'Pranata Komputer Pertama',
                'bidang' => 'Bidang Aplikasi Informatika',
                'nomor_hp' => '081234567892',
                'email' => 'budi.santoso@bappenda.test',
                'password' => Hash::make('pegawai123'),
            ],
        ];

        foreach ($pegawai as $item) {
            DB::table('sirapi_md_pegawai')->updateOrInsert(
                ['nip' => $item['nip']],
                $item + ['created_at' => $now, 'updated_at' => $now],
            );
        }

        $peserta = [
            [
                'nama' => 'Andi Saputra',
                'jabatan' => 'Kepala Sub Bagian Umum',
                'instansi' => 'BAPPENDA Kabupaten Bogor',
                'jenis_peserta' => 'pegawai',
                'nomor_hp' => '081234567890',
                'email' => 'andi.saputra@bappenda.test',
            ],
            [
                'nama' => 'Rina Lestari',
                'jabatan' => 'Staf Administrasi',
                'instansi' => 'Dinas Komunikasi dan Informatika',
                'jenis_peserta' => 'tamu',
                'nomor_hp' => '081298765432',
                'email' => 'rina.lestari@example.test',
            ],
        ];

        foreach ($peserta as $item) {
            DB::table('sirapi_md_peserta')->updateOrInsert(
                ['email' => $item['email']],
                $item + ['created_at' => $now, 'updated_at' => $now],
            );
        }

        $idAdmin = DB::table('sirapi_md_admin')->where('username', 'admin')->value('id_admin');
        $idRuangUtama = DB::table('sirapi_md_ruangrapat')->where('nama_ruang', 'Ruang Rapat Utama')->value('id_ruangrapat');
        $idStatusMendatang = DB::table('sirapi_md_statusagenda')->where('nama_status', 'Mendatang')->value('id_statusagenda');
        $idPesertaPegawai = DB::table('sirapi_md_peserta')->where('email', 'andi.saputra@bappenda.test')->value('id_peserta');

        DB::table('sirapi_md_agenda')->updateOrInsert(
            ['nama_agenda' => 'Rapat Koordinasi Evaluasi PAD'],
            [
                'tanggal' => now()->toDateString(),
                'waktu' => '09:00:00',
                'kuota' => 40,
                'lokasi' => 'Ruang Rapat Utama',
                'status_fr' => true,
                'status_qr' => 'aktif',
                'id_ruangrapat' => $idRuangUtama,
                'id_statusagenda' => $idStatusMendatang,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        $idAgenda = DB::table('sirapi_md_agenda')->where('nama_agenda', 'Rapat Koordinasi Evaluasi PAD')->value('id_agenda');

        DB::table('sirapi_md_tamu')->updateOrInsert(
            ['nik' => '3201010101010001'],
            [
                'nama' => 'Rina Lestari',
                'jabatan' => 'Staf Administrasi',
                'no_hp' => '081298765432',
                'asal_instansi' => 'Dinas Komunikasi dan Informatika',
                'foto_selfie' => null,
                'id_agenda' => $idAgenda,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        DB::table('sirapi_md_kunjungan')->updateOrInsert(
            ['email_pengunjung' => 'rina.lestari@example.test'],
            [
                'nama_pejabat' => 'Administrator',
                'nama_pengunjung' => 'Rina Lestari',
                'asal_instansi' => 'Dinas Komunikasi dan Informatika',
                'nomorhp_pengunjung' => '081298765432',
                'keperluan' => 'Koordinasi agenda rapat lintas dinas',
                'tanggal_kunjungan' => now()->toDateString(),
                'id_admin' => $idAdmin,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        DB::table('sirapi_md_datamasukan')->updateOrInsert(
            ['email' => 'warga@example.test'],
            [
                'nama_pengadu' => 'Warga Bogor',
                'nomor_pengadu' => '081200001111',
                'foto' => 'aduan/default.jpg',
                'isi_aduan' => 'Mohon informasi jadwal rapat publik dipublikasikan lebih awal.',
                'status' => 'Menunggu',
                'id_admin' => $idAdmin,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        QRCode::generateQR((int) $idAgenda);

        DB::table('sirapi_md_logbook')->updateOrInsert(
            ['catatan' => 'Seeder: agenda awal dibuat.'],
            [
                'Id_agenda' => $idAgenda,
                'waktu_isi' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        $idLog = DB::table('sirapi_md_logbook')->where('catatan', 'Seeder: agenda awal dibuat.')->value('id_log');

        DB::table('sirapi_md_kehadiran')->updateOrInsert(
            [
                'id_peserta' => $idPesertaPegawai,
                'id_agenda' => $idAgenda,
            ],
            [
                'id_log' => $idLog,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        DB::table('sirapi_md_berita')->updateOrInsert(
            ['judul' => 'Informasi Agenda BAPPENDA'],
            [
                'isi_berita' => 'Agenda rapat BAPPENDA dapat dipantau melalui sistem e-Agenda.',
                'tanggal' => now()->toDateString(),
                'gambar' => 'berita/default.jpg',
                'sumber' => 'BAPPENDA Kabupaten Bogor',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        DB::table('sirapi_md_galeri')->updateOrInsert(
            ['gambar' => 'galeri/rapat-koordinasi.jpg'],
            [
                'tanggal' => now()->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        DB::table('sirapi_md_ulangtahun')->updateOrInsert(
            ['nama' => 'Andi Saputra'],
            [
                'tanggal' => now()->startOfYear()->addMonths(2)->addDays(14)->toDateString(),
                'gambar' => 'ulangtahun/default.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        DB::table('sirapi_md_cuaca')->updateOrInsert(
            ['lokasi' => 'Kabupaten Bogor'],
            [
                'isi_berita' => 'Cuaca cerah berawan di sekitar pusat pemerintahan.',
                'suhu' => '27 C',
                'kondisi' => 'Cerah Berawan',
                'kelembapan' => '78%',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );
    }
}
