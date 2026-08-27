<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirapi_md_kehadiran', function (Blueprint $table) {
            $table->id('id_kehadiran');
            $table->text('lokasi_presensi')->nullable();
            $table->string('foto_kehadiran')->nullable();
            $table->timestamps();

            $table->foreignId('id_peserta')->constrained('sirapi_md_peserta', 'id_peserta')->cascadeOnDelete();
            $table->foreignId('id_agenda')->constrained('sirapi_md_agenda', 'id_agenda')->cascadeOnDelete();
            $table->foreignId('id_log')->constrained('sirapi_md_logbook', 'id_log')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_kehadiran');
    }
};
