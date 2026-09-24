<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('sirapi_md_dinas')) {
            if (!Schema::hasColumn('sirapi_md_dinas', 'singkatan')) {
                Schema::table('sirapi_md_dinas', function (Blueprint $table) {
                    $table->string('singkatan', 50)->nullable()->after('nama_dinas');
                });
            }

            // Mapping singkatan resmi untuk 38 dinas
            $mapping = [
                'DISKOMINFO'   => 'Diskominfo',
                'DISDIK'       => 'Disdik',
                'DINKES'       => 'Dinkes',
                'DISHUB'       => 'Dishub',
                'PUPR'         => 'PUPR',
                'BAPPERIDA'    => 'Bappedalitbang',
                'BAPPENDA'     => 'Bappenda',
                'SATPOL PP'    => 'Satpol PP',
                'BAKESBANGPOL' => 'Bakesbangpol',
                'BKPSDM'       => 'BKPSDM',
                'BPBD'         => 'BPBD',
                'BPKAD'        => 'BPKAD',
                'DAMKAR'       => 'Damkar',
                'DAPD'         => 'DAPD',
                'DINSOS'       => 'Dinsos',
                'DISBUD'       => 'Disbudpar',
                'DISDAGIN'     => 'Disdagin',
                'DISDUKCAPIL'  => 'Disdukcapil',
                'DISKANAK'     => 'Diskanak',
                'DISKOPUKM'    => 'Diskopukm',
                'DISNAKER'     => 'Disnaker',
                'DISPAREKRAF'  => 'Disparekraf',
                'DISPORA'      => 'Dispora',
                'DISTANHORBUN' => 'Distanhorbun',
                'DKP'          => 'DKP',
                'DLH'          => 'DLH',
                'DP3AP2KB'     => 'DP3AP2KB',
                'DPKP'         => 'DPKP',
                'DPMD'         => 'DPMD',
                'DPMPTSP'      => 'DPMPTSP',
                'DPTR'         => 'DPTR',
                'INSPEKTORAT'  => 'Inspektorat',
                'RSUD Ciawi'   => 'RSUD Ciawi',
                'RSUD Cibinong'=> 'RSUD Cibinong',
                'RSUD Cileungsi'=> 'RSUD Cileungsi',
                'RSUD Leuwiliang'=> 'RSUD Leuwiliang',
                'SETDA'        => 'Setda',
                'SETWAN'       => 'Setwan',
            ];

            foreach ($mapping as $kode => $singkatan) {
                DB::table('sirapi_md_dinas')
                    ->where('kode_dinas', $kode)
                    ->update(['singkatan' => $singkatan]);
            }

            // Fallback jika ada yang belum terisi
            DB::table('sirapi_md_dinas')
                ->whereNull('singkatan')
                ->orWhere('singkatan', '')
                ->update(['singkatan' => DB::raw('COALESCE(kode_dinas, nama_dinas)')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sirapi_md_dinas') && Schema::hasColumn('sirapi_md_dinas', 'singkatan')) {
            Schema::table('sirapi_md_dinas', function (Blueprint $table) {
                $table->dropColumn('singkatan');
            });
        }
    }
};
