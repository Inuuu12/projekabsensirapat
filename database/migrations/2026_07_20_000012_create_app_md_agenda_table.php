<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_agenda', function (Blueprint $table) {
            $table->id('id_agenda');
            $table->string('nama_agenda');
            $table->date('tanggal');
            $table->time('waktu');
            $table->integer('kuota')->nullable();
            $table->string('lokasi');
            $table->boolean('status_fr')->nullable();
            $table->string('status_qr')->nullable();
            $table->timestamps();

            $table->foreignId('id_ruangrapat')->constrained('app_md_ruangrapat','id_ruangrapat')->cascadeonDelete('');
            $table->foreignId('id_statusagenda')->constrained('app_md_statusagenda','id_statusagenda')->cascadeonDelete('');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_agenda');
    }
};
