<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sirapi_md_admin', function (Blueprint $table) {
            if (!Schema::hasColumn('sirapi_md_admin', 'role')) {
                $table->string('role')->default('superadmin')->after('password');
            }
            if (!Schema::hasColumn('sirapi_md_admin', 'id_dinas')) {
                $table->foreignId('id_dinas')->nullable()->after('role')->constrained('sirapi_md_dinas', 'id_dinas')->nullOnDelete();
            }
            if (!Schema::hasColumn('sirapi_md_admin', 'id_kecamatan')) {
                $table->foreignId('id_kecamatan')->nullable()->after('id_dinas')->constrained('sirapi_md_kecamatan', 'id_kecamatan')->nullOnDelete();
            }
            if (!Schema::hasColumn('sirapi_md_admin', 'email')) {
                $table->string('email')->nullable()->after('id_kecamatan');
            }
            if (!Schema::hasColumn('sirapi_md_admin', 'nomor_hp')) {
                $table->string('nomor_hp')->nullable()->after('email');
            }
            if (!Schema::hasColumn('sirapi_md_admin', 'status')) {
                $table->string('status')->default('aktif')->after('nomor_hp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sirapi_md_admin', function (Blueprint $table) {
            $table->dropForeign(['id_dinas']);
            $table->dropForeign(['id_kecamatan']);
            $table->dropColumn(['role', 'id_dinas', 'id_kecamatan', 'email', 'nomor_hp', 'status']);
        });
    }
};
