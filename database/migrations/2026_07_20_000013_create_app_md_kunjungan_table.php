<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_kunjungan', function (Blueprint $table) {
            $table->bigIncrements('id_kunjungan');
            $table->string('nama_pejabat')->nullable();
            $table->string('nama_pengunjung')->nullable();
            $table->string('asal_instansi')->nullable();
            $table->string('nomorhp_pengunjung')->nullable();
            $table->string('email_pengunjung')->nullable();
            $table->string('keperluan');
            $table->date('tanggal_kunjungan');
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->timestamps();

            $table->foreign('id_admin')->references('id_admin')->on('app_md_admin')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_kunjungan');
    }
};
