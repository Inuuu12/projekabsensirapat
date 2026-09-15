<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('sirapi_md_agenda') && Schema::hasColumn('sirapi_md_agenda', 'id_ruangrapat')) {
            DB::statement("ALTER TABLE `sirapi_md_agenda` MODIFY `id_ruangrapat` BIGINT UNSIGNED NULL");
        }

        // Set 3 ruangan bawaan Diskominfo agar memiliki id_dinas = 1 (Dinas Komunikasi dan Informatika)
        if (Schema::hasTable('sirapi_md_ruangrapat')) {
            DB::table('sirapi_md_ruangrapat')
                ->whereNull('id_dinas')
                ->whereNull('id_kecamatan')
                ->whereIn('id_ruangrapat', [1, 2, 3])
                ->update(['id_dinas' => 1]);
        }

        // Sinkronkan akun adminkominfo agar menggunakan id_dinas = 1
        if (Schema::hasTable('sirapi_md_admin')) {
            DB::table('sirapi_md_admin')
                ->where('username', 'adminkominfo')
                ->where('id_dinas', 9)
                ->update(['id_dinas' => 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sirapi_md_agenda') && Schema::hasColumn('sirapi_md_agenda', 'id_ruangrapat')) {
            // Pastikan tidak ada data null sebelum revert ke not null
            DB::table('sirapi_md_agenda')->whereNull('id_ruangrapat')->update(['id_ruangrapat' => 1]);
            DB::statement("ALTER TABLE `sirapi_md_agenda` MODIFY `id_ruangrapat` BIGINT UNSIGNED NOT NULL");
        }
    }
};
