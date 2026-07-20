<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_peserta', function (Blueprint $table) {
            $table->id('id_peserta');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('instansi');
            $table->string('jenis_peserta');
            $table->string('nomor_hp');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_peserta');
    }
};
