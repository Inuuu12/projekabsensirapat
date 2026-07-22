<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('app_md_agenda', function (Blueprint $table) {
            if (! Schema::hasColumn('app_md_agenda', 'kategori_surat')) {
                $table->string('kategori_surat', 20)->default('internal')->after('nama_agenda');
            }

            if (! Schema::hasColumn('app_md_agenda', 'asal_surat')) {
                $table->string('asal_surat')->nullable()->after('kategori_surat');
            }

            if (! Schema::hasColumn('app_md_agenda', 'ditugaskan')) {
                $table->string('ditugaskan')->nullable()->after('asal_surat');
            }

            if (! Schema::hasColumn('app_md_agenda', 'lampiran')) {
                $table->string('lampiran')->nullable()->after('ditugaskan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('app_md_agenda', function (Blueprint $table) {
            foreach (['lampiran', 'ditugaskan', 'asal_surat', 'kategori_surat'] as $column) {
                if (Schema::hasColumn('app_md_agenda', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
