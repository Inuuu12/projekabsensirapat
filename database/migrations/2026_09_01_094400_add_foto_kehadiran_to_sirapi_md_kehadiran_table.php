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
        Schema::table('sirapi_md_kehadiran', function (Blueprint $table) {
            if (!Schema::hasColumn('sirapi_md_kehadiran', 'lokasi_presensi')) {
                $table->text('lokasi_presensi')->nullable();
            }
            if (!Schema::hasColumn('sirapi_md_kehadiran', 'foto_kehadiran')) {
                $table->string('foto_kehadiran')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sirapi_md_kehadiran', function (Blueprint $table) {
            $table->dropColumn(['lokasi_presensi', 'foto_kehadiran']);
        });
    }
};
