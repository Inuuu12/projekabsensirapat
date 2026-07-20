<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_kehadiran', function (Blueprint $table) {
            $table->bigIncrements('id_kehadiran');
            $table->unsignedBigInteger('id_peserta');
            $table->unsignedBigInteger('id_agenda');
            $table->unsignedBigInteger('id_log');
            $table->timestamps();

            $table->foreign('id_peserta')->references('id_peserta')->on('app_md_peserta')->onDelete('cascade');
            $table->foreign('id_agenda')->references('id_agenda')->on('app_md_agenda')->onDelete('cascade');
            $table->foreign('id_log')->references('id_log')->on('app_md_logbook')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_kehadiran');
    }
};
