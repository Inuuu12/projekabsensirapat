<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirapi_md_aduan', function (Blueprint $table) {
            $table->id('id_aduan');
            $table->string('email')->unique();
            $table->string('no_hp');
            $table->text('isi_aduan');
            $table->string('lampiran');
            $table->integer('status_id');
            $table->text('reply_admin');
            $table->dateTime('waktu_proses');
            $table->dateTime('waktu_selesai');
            $table->timestamps();

            $table->foreignId('id_statusaduan')->constrained('sirapi_md_statusaduan', 'id_statusaduan')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_aduan');
    }
};
