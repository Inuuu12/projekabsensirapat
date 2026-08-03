<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('app_md_dokumen_notulen') || ! Schema::hasColumn('app_md_dokumen_notulen', 'id_kehadiran')) {
            return;
        }

        Schema::table('app_md_dokumen_notulen', function (Blueprint $table) {
            $table->dropColumn('id_kehadiran');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('app_md_dokumen_notulen') || Schema::hasColumn('app_md_dokumen_notulen', 'id_kehadiran')) {
            return;
        }

        Schema::table('app_md_dokumen_notulen', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kehadiran')->nullable()->after('updated_at');
        });
    }
};
