<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('app_md_pegawai') || Schema::hasColumn('app_md_pegawai', 'bidang')) {
            return;
        }

        Schema::table('app_md_pegawai', function (Blueprint $table) {
            $table->string('bidang')->nullable()->after('jabatan');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('app_md_pegawai') || ! Schema::hasColumn('app_md_pegawai', 'bidang')) {
            return;
        }

        Schema::table('app_md_pegawai', function (Blueprint $table) {
            $table->dropColumn('bidang');
        });
    }
};
