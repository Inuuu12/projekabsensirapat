<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_agenda', function (Blueprint $table) {
            $table->bigIncrements('id_agenda');
            $table->string('nama_agenda');
            $table->date('tanggal');
            $table->time('waktu');
            $table->integer('kuota')->nullable();
            $table->string('lokasi');
            $table->boolean('status_fr')->nullable();
            $table->string('status_qr')->nullable();
            $table->unsignedBigInteger('id_ruangrapat')->nullable();
            $table->unsignedBigInteger('id_statusagenda')->nullable();
            $table->timestamps();

            $table->foreign('id_ruangrapat')->references('id_ruangrapat')->on('app_md_ruangrapat')->onDelete('cascade');
            $table->foreign('id_statusagenda')->references('id_statusagenda')->on('app_md_statusagenda')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_agenda');
    }
};
