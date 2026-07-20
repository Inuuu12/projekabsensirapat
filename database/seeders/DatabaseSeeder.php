<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('app_md_admin')->updateOrInsert(
            ['username' => 'admin'],
            [
                'nama' => 'Administrator',
                'password' => Hash::make('admin123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        DB::table('app_md_statusagenda')->updateOrInsert(
            ['nama_status' => 'Aktif'],
            ['created_at' => $now, 'updated_at' => $now],
        );

        DB::table('app_md_statusagenda')->updateOrInsert(
            ['nama_status' => 'Selesai'],
            ['created_at' => $now, 'updated_at' => $now],
        );

        DB::table('app_md_statusmasukan')->updateOrInsert(
            ['nama_status' => 'Menunggu'],
            ['created_at' => $now, 'updated_at' => $now],
        );

        DB::table('app_md_statusmasukan')->updateOrInsert(
            ['nama_status' => 'Diproses'],
            ['created_at' => $now, 'updated_at' => $now],
        );

        DB::table('app_md_statusmasukan')->updateOrInsert(
            ['nama_status' => 'Selesai'],
            ['created_at' => $now, 'updated_at' => $now],
        );

        $ruangan = [
            ['nama_ruang' => 'Ruang Rapat Utama', 'kapasitas' => 40, 'keterangan' => 'Ruang rapat utama lantai 2.'],
            ['nama_ruang' => 'Aula Serbaguna', 'kapasitas' => 120, 'keterangan' => 'Aula untuk rapat besar dan sosialisasi.'],
            ['nama_ruang' => 'Ruang Rapat Bidang', 'kapasitas' => 20, 'keterangan' => 'Ruang rapat internal bidang.'],
        ];

        foreach ($ruangan as $item) {
            DB::table('app_md_ruangrapat')->updateOrInsert(
                ['nama_ruang' => $item['nama_ruang']],
                $item + ['created_at' => $now, 'updated_at' => $now],
            );
        }

        $pegawai = [
            [
                'nip' => '198801012010011001',
                'nama_pegawai' => 'Andi Saputra',
                'jabatan' => 'Kepala Sub Bagian Umum',
                'nomor_hp' => '081234567890',
                'email' => 'andi.saputra@bappenda.test',
            ],
            [
                'nip' => '199002022015032002',
                'nama_pegawai' => 'Siti Aminah',
                'jabatan' => 'Analis Pajak Daerah',
                'nomor_hp' => '081234567891',
                'email' => 'siti.aminah@bappenda.test',
            ],
            [
                'nip' => '199503032020121003',
                'nama_pegawai' => 'Budi Santoso',
                'jabatan' => 'Pranata Komputer',
                'nomor_hp' => '081234567892',
                'email' => 'budi.santoso@bappenda.test',
            ],
        ];

        foreach ($pegawai as $item) {
            DB::table('app_md_pegawai')->updateOrInsert(
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
            DB::table('app_md_peserta')->updateOrInsert(
                ['email' => $item['email']],
                $item + ['created_at' => $now, 'updated_at' => $now],
            );
        }

        $idAdmin = DB::table('app_md_admin')->where('username', 'admin')->value('id_admin');
        $idRuangUtama = DB::table('app_md_ruangrapat')->where('nama_ruang', 'Ruang Rapat Utama')->value('id_ruangrapat');
        $idStatusAktif = DB::table('app_md_statusagenda')->where('nama_status', 'Aktif')->value('id_statusagenda');
        $idPesertaPegawai = DB::table('app_md_peserta')->where('email', 'andi.saputra@bappenda.test')->value('id_peserta');

        DB::table('app_md_agenda')->updateOrInsert(
            ['nama_agenda' => 'Rapat Koordinasi Evaluasi PAD'],
            [
                'tanggal' => now()->toDateString(),
                'waktu' => '09:00:00',
                'kuota' => 40,
                'lokasi' => 'Ruang Rapat Utama',
                'status_fr' => true,
                'status_qr' => 'aktif',
                'id_ruangrapat' => $idRuangUtama,
                'id_statusagenda' => $idStatusAktif,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        $idAgenda = DB::table('app_md_agenda')->where('nama_agenda', 'Rapat Koordinasi Evaluasi PAD')->value('id_agenda');

        DB::table('app_md_tamu')->updateOrInsert(
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

        DB::table('app_md_kunjungan')->updateOrInsert(
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

        DB::table('app_md_datamasukan')->updateOrInsert(
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

        DB::table('app_md_qrcode')->updateOrInsert(
            ['id_agenda' => $idAgenda],
            [
                'qr_codepath' => "qrcodes/agenda-{$idAgenda}.png",
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        DB::table('app_md_logbook')->updateOrInsert(
            ['catatan' => 'Seeder: agenda awal dibuat.'],
            [
                'Id_agenda' => $idAgenda,
                'waktu_isi' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        $idLog = DB::table('app_md_logbook')->where('catatan', 'Seeder: agenda awal dibuat.')->value('id_log');

        DB::table('app_md_kehadiran')->updateOrInsert(
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

        DB::table('app_md_berita')->updateOrInsert(
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

        DB::table('app_md_galeri')->updateOrInsert(
            ['gambar' => 'galeri/rapat-koordinasi.jpg'],
            [
                'tanggal' => now()->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        DB::table('app_md_ulangtahun')->updateOrInsert(
            ['nama' => 'Andi Saputra'],
            [
                'tanggal' => now()->startOfYear()->addMonths(2)->addDays(14)->toDateString(),
                'gambar' => 'ulangtahun/default.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        DB::table('app_md_cuaca')->updateOrInsert(
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
