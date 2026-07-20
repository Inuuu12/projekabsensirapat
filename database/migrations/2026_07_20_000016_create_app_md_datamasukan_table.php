<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_datamasukan', function (Blueprint $table) {
            $table->bigIncrements('id_datamasukan');
            $table->string('nama_pengadu');
            $table->string('nomor_pengadu');
            $table->string('email');
            $table->string('foto');
            $table->text('isi_aduan');
            $table->string('status');
            $table->unsignedBigInteger('id_admin');
            $table->timestamps();

            $table->foreign('id_admin')->references('id_admin')->on('app_md_admin')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_datamasukan');
    }
};
