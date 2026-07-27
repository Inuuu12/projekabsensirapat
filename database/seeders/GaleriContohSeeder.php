<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GaleriContohSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach ([
            ['gambar' => 'foto/Agendahariini.png', 'tanggal' => $now->toDateString()],
            ['gambar' => 'foto/Kunjunganlogo.png', 'tanggal' => $now->copy()->subDay()->toDateString()],
            ['gambar' => 'foto/Ruanganlogo.png', 'tanggal' => $now->copy()->subDays(2)->toDateString()],
        ] as $item) {
            DB::table('app_md_galeri')->updateOrInsert(
                ['gambar' => $item['gambar']],
                [
                    'tanggal' => $item['tanggal'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }
    }
}
