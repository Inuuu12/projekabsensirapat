<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('app_md_dokumen_notulen', function (Blueprint $table) {
            if (! Schema::hasColumn('app_md_dokumen_notulen', 'id_agenda')) {
                $table->unsignedBigInteger('id_agenda')->nullable()->after('id_dokumen');
            }
        });

        Schema::table('app_md_dokumen_notulen', function (Blueprint $table) {
            if (! Schema::hasColumn('app_md_dokumen_notulen', 'jenis_dokumen')) {
                $table->string('jenis_dokumen', 30)->default('notulen')->after('id_agenda');
            }
        });

        if (
            Schema::hasColumn('app_md_dokumen_notulen', 'id_kehadiran')
            && Schema::hasColumn('app_md_kehadiran', 'id_kehadiran')
            && Schema::hasColumn('app_md_kehadiran', 'id_agenda')
        ) {
            DB::statement('
                UPDATE app_md_dokumen_notulen dokumen
                JOIN app_md_kehadiran kehadiran ON kehadiran.id_kehadiran = dokumen.id_kehadiran
                SET dokumen.id_agenda = kehadiran.id_agenda
                WHERE dokumen.id_agenda IS NULL
            ');
        }
    }

    public function down(): void
    {
        Schema::table('app_md_dokumen_notulen', function (Blueprint $table) {
            if (Schema::hasColumn('app_md_dokumen_notulen', 'jenis_dokumen')) {
                $table->dropColumn('jenis_dokumen');
            }

            if (Schema::hasColumn('app_md_dokumen_notulen', 'id_agenda')) {
                $table->dropColumn('id_agenda');
            }
        });
    }
};
