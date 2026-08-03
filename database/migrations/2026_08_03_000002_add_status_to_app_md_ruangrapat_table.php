<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('app_md_ruangrapat') || Schema::hasColumn('app_md_ruangrapat', 'status')) {
            return;
        }

        Schema::table('app_md_ruangrapat', function (Blueprint $table) {
            $table->string('status', 20)->default('tersedia')->after('kapasitas');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('app_md_ruangrapat') || ! Schema::hasColumn('app_md_ruangrapat', 'status')) {
            return;
        }

        Schema::table('app_md_ruangrapat', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
