<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_tamu', function (Blueprint $table) {
            $table->bigIncrements('id_tamu');
            $table->string('nik')->nullable();
            $table->string('nama');
            $table->string('jabatan')->nullable();
            $table->string('no_hp');
            $table->string('asal_instansi');
            $table->string('foto_selfie')->nullable();
            $table->unsignedBigInteger('id_agenda');
            $table->timestamps();

            $table->foreign('id_agenda')->references('id_agenda')->on('app_md_agenda')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_tamu');
    }
};
