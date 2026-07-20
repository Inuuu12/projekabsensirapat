<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_masukan', function (Blueprint $table) {
            $table->bigIncrements('id_masukan');
            $table->string('email');
            $table->string('no_hp');
            $table->text('isi_masukan');
            $table->string('lampiran');
            $table->unsignedBigInteger('status_id');
            $table->text('reply_admin');
            $table->dateTime('waktu_proses');
            $table->dateTime('waktu_selesai');
            $table->timestamps();

            $table->foreign('status_id')->references('id_statusmasukan')->on('app_md_statusmasukan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_masukan');
    }
};
