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
        Schema::table('sirapi_md_pegawai', function (Blueprint $table) {
            if (!Schema::hasColumn('sirapi_md_pegawai', 'status_verifikasi')) {
                $table->string('status_verifikasi', 20)->default('aktif');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sirapi_md_pegawai', function (Blueprint $table) {
            if (Schema::hasColumn('sirapi_md_pegawai', 'status_verifikasi')) {
                $table->dropColumn('status_verifikasi');
            }
        });
    }
};
