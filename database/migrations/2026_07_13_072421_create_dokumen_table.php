<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id('idDokumen');
            // foreign key relasi ke tabel agendas/agenda bawaan kamu sebelumnya
            $table->foreignId('id_agenda')->nullable()->constrained('agenda', 'id_agenda')->onDelete('cascade');
            $table->string('namaFile');
            $table->string('filePath');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
