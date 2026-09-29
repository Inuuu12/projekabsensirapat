<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('sirapi_md_dinas')) {
            return;
        }

        // 1. Update atau Insert data Polisi
        $polisiExists = DB::table('sirapi_md_dinas')
            ->where(function ($q) {
                $q->where('nama_dinas', 'like', '%polisi%')
                  ->where('nama_dinas', 'not like', '%satuan polisi%')
                  ->orWhere('kode_dinas', 'like', 'pol%');
            })
            ->exists();

        if ($polisiExists) {
            DB::table('sirapi_md_dinas')
                ->where(function ($q) {
                    $q->where('nama_dinas', 'like', '%polisi%')
                      ->where('nama_dinas', 'not like', '%satuan polisi%')
                      ->orWhere('kode_dinas', 'like', 'pol%');
                })
                ->update([
                    'nama_dinas' => 'Polisi',
                    'kode_dinas' => 'Pol',
                    'singkatan'  => 'Pol',
                ]);
        } else {
            DB::table('sirapi_md_dinas')->insert([
                'nama_dinas' => 'Polisi',
                'kode_dinas' => 'Pol',
                'singkatan'  => 'Pol',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Update data RSUD dengan nama resmi lengkap (termasuk nama tokoh RSUD Kab. Bogor)
        $rsudMapping = [
            'Ciawi' => [
                'nama_dinas' => 'Rumah Sakit Umum Daerah Idham Chalid Ciawi',
                'kode_dinas' => 'RSUD Ciawi',
                'singkatan'  => 'RSUD Ciawi',
            ],
            'Cibinong' => [
                'nama_dinas' => 'Rumah Sakit Umum Daerah Bakti Pajajaran Cibinong',
                'kode_dinas' => 'RSUD Cibinong',
                'singkatan'  => 'RSUD Cibinong',
            ],
            'Cileungsi' => [
                'nama_dinas' => 'Rumah Sakit Umum Daerah RH. Satibi Cileungsi',
                'kode_dinas' => 'RSUD Cileungsi',
                'singkatan'  => 'RSUD Cileungsi',
            ],
            'Leuwiliang' => [
                'nama_dinas' => 'Rumah Sakit Umum Daerah R. Moh. Noh Nur Leuwiliang',
                'kode_dinas' => 'RSUD Leuwiliang',
                'singkatan'  => 'RSUD Leuwiliang',
            ],
        ];

        foreach ($rsudMapping as $wilayah => $data) {
            DB::table('sirapi_md_dinas')
                ->where(function ($q) use ($wilayah) {
                    $q->where('nama_dinas', 'like', "%{$wilayah}%")
                      ->orWhere('kode_dinas', 'like', "%{$wilayah}%");
                })
                ->update($data);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
