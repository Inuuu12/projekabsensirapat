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
            $table->string('status_verifikasi', 20)->default('aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sirapi_md_pegawai', function (Blueprint $table) {
            $table->dropColumn('status_verifikasi');
        });
    }
};
