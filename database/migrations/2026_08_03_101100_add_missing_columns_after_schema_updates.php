<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('app_md_pegawai')) {
            Schema::table('app_md_pegawai', function (Blueprint $table) {
                if (! Schema::hasColumn('app_md_pegawai', 'foto')) {
                    $table->string('foto')->nullable()->after('id_pegawai');
                }

                if (! Schema::hasColumn('app_md_pegawai', 'tanggal_lahir')) {
                    $table->date('tanggal_lahir')->nullable()->after('nip');
                }
            });
        }

        if (Schema::hasTable('app_md_kunjungan')) {
            Schema::table('app_md_kunjungan', function (Blueprint $table) {
                if (! Schema::hasColumn('app_md_kunjungan', 'nama_pegawai')) {
                    $table->string('nama_pegawai')->nullable()->after('id_kunjungan');
                }

                if (! Schema::hasColumn('app_md_kunjungan', 'waktu')) {
                    $table->time('waktu')->nullable()->after('keperluan');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('app_md_kunjungan')) {
            Schema::table('app_md_kunjungan', function (Blueprint $table) {
                if (Schema::hasColumn('app_md_kunjungan', 'waktu')) {
                    $table->dropColumn('waktu');
                }

                if (Schema::hasColumn('app_md_kunjungan', 'nama_pegawai')) {
                    $table->dropColumn('nama_pegawai');
                }
            });
        }

        if (Schema::hasTable('app_md_pegawai')) {
            Schema::table('app_md_pegawai', function (Blueprint $table) {
                if (Schema::hasColumn('app_md_pegawai', 'tanggal_lahir')) {
                    $table->dropColumn('tanggal_lahir');
                }

                if (Schema::hasColumn('app_md_pegawai', 'foto')) {
                    $table->dropColumn('foto');
                }
            });
        }
    }
};
