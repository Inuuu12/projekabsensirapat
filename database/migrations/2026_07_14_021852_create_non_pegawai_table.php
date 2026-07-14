<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('non_pegawai', function (Blueprint $table) {
            $table->id('id_non_pegawai'); // Sesuai diagram
            $table->string('nama');
            $table->string('no_hp');
            $table->string('asal_instansi');
            $table->string('foto_selfie')->nullable();
            $table->text('tanda_tangan')->nullable(); // Disimpan sebagai string base64 / path berkas
            // Berelasi dengan tabel agenda tunggal yang kita pisah sebelumnya
            $table->foreignId('id_agenda')->constrained('agenda', 'id_agenda')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('non_pegawai');
    }
};
