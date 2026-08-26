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

        // 1. Akun Administrator Default
        DB::table('sirapi_md_admin')->updateOrInsert(
            ['username' => 'admin'],
            [
                'nama' => 'Administrator',
                'password' => Hash::make('admin123'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );

        // 2. Master Status Agenda
        foreach (['Mendatang', 'Berlangsung', 'Selesai'] as $statusAgenda) {
            DB::table('sirapi_md_statusagenda')->updateOrInsert(
                ['nama_status' => $statusAgenda],
                ['created_at' => $now, 'updated_at' => $now],
            );
        }

        // 3. Master Ruang Rapat
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

        // 4. Master Bidang
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

        // 5. Master Jabatan
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
    }
}
