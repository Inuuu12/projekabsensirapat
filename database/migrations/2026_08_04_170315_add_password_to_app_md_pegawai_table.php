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
        Schema::table('app_md_pegawai', function (Blueprint $table) {
            if (!Schema::hasColumn('app_md_pegawai', 'password')) {
                $table->string('password')->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_md_pegawai', function (Blueprint $table) {
            if (Schema::hasColumn('app_md_pegawai', 'password')) {
                $table->dropColumn('password');
            }
        });
    }
};
