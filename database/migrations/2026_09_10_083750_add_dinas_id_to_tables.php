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
        Schema::table('sirapi_md_admin', function (Blueprint $table) {
            if (!Schema::hasColumn('sirapi_md_admin', 'id_dinas')) {
                $table->foreignId('id_dinas')->nullable()->constrained('sirapi_md_dinas', 'id_dinas')->nullOnDelete();
            }
            if (!Schema::hasColumn('sirapi_md_admin', 'role')) {
                $table->string('role', 20)->default('super_admin');
            }
        });

        Schema::table('sirapi_md_pegawai', function (Blueprint $table) {
            if (!Schema::hasColumn('sirapi_md_pegawai', 'id_dinas')) {
                $table->foreignId('id_dinas')->nullable()->constrained('sirapi_md_dinas', 'id_dinas')->nullOnDelete();
            }
        });

        Schema::table('sirapi_md_agenda', function (Blueprint $table) {
            if (!Schema::hasColumn('sirapi_md_agenda', 'id_dinas')) {
                $table->foreignId('id_dinas')->nullable()->constrained('sirapi_md_dinas', 'id_dinas')->nullOnDelete();
            }
        });

        Schema::table('sirapi_md_ruangrapat', function (Blueprint $table) {
            if (!Schema::hasColumn('sirapi_md_ruangrapat', 'id_dinas')) {
                $table->foreignId('id_dinas')->nullable()->constrained('sirapi_md_dinas', 'id_dinas')->nullOnDelete();
            }
        });

        Schema::table('sirapi_md_kunjungan', function (Blueprint $table) {
            if (!Schema::hasColumn('sirapi_md_kunjungan', 'id_dinas')) {
                $table->foreignId('id_dinas')->nullable()->constrained('sirapi_md_dinas', 'id_dinas')->nullOnDelete();
            }
        });

        Schema::table('sirapi_md_dataaduan', function (Blueprint $table) {
            if (!Schema::hasColumn('sirapi_md_dataaduan', 'id_dinas')) {
                $table->foreignId('id_dinas')->nullable()->constrained('sirapi_md_dinas', 'id_dinas')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sirapi_md_dataaduan', function (Blueprint $table) {
            if (Schema::hasColumn('sirapi_md_dataaduan', 'id_dinas')) {
                $table->dropForeign(['id_dinas']);
                $table->dropColumn('id_dinas');
            }
        });

        Schema::table('sirapi_md_kunjungan', function (Blueprint $table) {
            if (Schema::hasColumn('sirapi_md_kunjungan', 'id_dinas')) {
                $table->dropForeign(['id_dinas']);
                $table->dropColumn('id_dinas');
            }
        });

        Schema::table('sirapi_md_ruangrapat', function (Blueprint $table) {
            if (Schema::hasColumn('sirapi_md_ruangrapat', 'id_dinas')) {
                $table->dropForeign(['id_dinas']);
                $table->dropColumn('id_dinas');
            }
        });

        Schema::table('sirapi_md_agenda', function (Blueprint $table) {
            if (Schema::hasColumn('sirapi_md_agenda', 'id_dinas')) {
                $table->dropForeign(['id_dinas']);
                $table->dropColumn('id_dinas');
            }
        });

        Schema::table('sirapi_md_pegawai', function (Blueprint $table) {
            if (Schema::hasColumn('sirapi_md_pegawai', 'id_dinas')) {
                $table->dropForeign(['id_dinas']);
                $table->dropColumn('id_dinas');
            }
        });

        Schema::table('sirapi_md_admin', function (Blueprint $table) {
            if (Schema::hasColumn('sirapi_md_admin', 'id_dinas')) {
                $table->dropForeign(['id_dinas']);
                $table->dropColumn('id_dinas');
            }
            if (Schema::hasColumn('sirapi_md_admin', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
