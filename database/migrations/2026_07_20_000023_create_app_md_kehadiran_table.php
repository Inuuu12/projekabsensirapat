<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_kehadiran', function (Blueprint $table) {
            $table->id('id_kehadiran');
            $table->timestamps();

            $table->foreignId('id_peserta')->constrained('app_md_peserta', 'id_peserta')->cascadeOnDelete('');
            $table->foreignId('id_agenda')->constrained('app_md_agenda', 'id_agenda')->cascadeonDelete('');
            $table->foreignId('id_log')->constrained('app_md_logbook', 'id_log')->cascadeonDelete('');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_kehadiran');
    }
};
