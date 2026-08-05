<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirapi_md_agenda', function (Blueprint $table) {
            $table->id('id_agenda');
            $table->string('nama_agenda');
            $table->string('kategori_surat', 20)->default('internal');
            $table->string('asal_surat')->nullable();
            $table->string('ditugaskan')->nullable();
            $table->string('lampiran')->nullable();
            $table->date('tanggal');
            $table->time('waktu');
            $table->time('waktu_selesai')->nullable();
            $table->integer('kuota')->nullable();
            $table->string('lokasi');
            $table->boolean('status_fr')->nullable();
            $table->string('status_qr')->nullable();
            $table->timestamps();

            $table->foreignId('id_ruangrapat')->constrained('sirapi_md_ruangrapat','id_ruangrapat')->cascadeonDelete('');
            $table->foreignId('id_statusagenda')->constrained('sirapi_md_statusagenda','id_statusagenda')->cascadeonDelete('');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_agenda');
    }
};
