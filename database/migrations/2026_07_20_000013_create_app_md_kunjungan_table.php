<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_kunjungan', function (Blueprint $table) {
            $table->id('id_kunjungan');
            $table->string('nama_pejabat')->nullable();
            $table->string('nama_pengunjung')->nullable();
            $table->string('asal_instansi')->nullable();
            $table->string('nomorhp_pengunjung')->nullable();
            $table->string('email_pengunjung')->unique()->nullable();
            $table->string('keperluan');
            $table->time('waktu')->nullable();
            $table->date('tanggal_kunjungan');
            $table->timestamps();

            $table->foreignId('id_admin')->constraide('app_md_admin', 'id_admin')->cascadeonDelete('');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_kunjungan');
    }
};
