<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('sirapi_md_kunjungan') && !Schema::hasColumn('sirapi_md_kunjungan', 'id_kecamatan')) {
            Schema::table('sirapi_md_kunjungan', function (Blueprint $table) {
                $table->foreignId('id_kecamatan')
                    ->nullable()
                    ->after('id_dinas')
                    ->constrained('sirapi_md_kecamatan', 'id_kecamatan')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sirapi_md_kunjungan') && Schema::hasColumn('sirapi_md_kunjungan', 'id_kecamatan')) {
            Schema::table('sirapi_md_kunjungan', function (Blueprint $table) {
                $table->dropForeign(['id_kecamatan']);
                $table->dropColumn('id_kecamatan');
            });
        }
    }
};
