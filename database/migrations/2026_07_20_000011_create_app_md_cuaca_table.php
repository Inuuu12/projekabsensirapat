<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_cuaca', function (Blueprint $table) {
            $table->id('id_cuaca');
            $table->string('lokasi');
            $table->text('isi_berita');
            $table->string('suhu');
            $table->string('kondisi');
            $table->string('kelembapan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_cuaca');
    }
};
