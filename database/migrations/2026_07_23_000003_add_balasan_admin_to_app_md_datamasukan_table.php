<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('app_md_datamasukan', function (Blueprint $table) {
            if (! Schema::hasColumn('app_md_datamasukan', 'balasan_admin')) {
                $table->text('balasan_admin')->nullable()->after('isi_aduan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('app_md_datamasukan', function (Blueprint $table) {
            if (Schema::hasColumn('app_md_datamasukan', 'balasan_admin')) {
                $table->dropColumn('balasan_admin');
            }
        });
    }
};
