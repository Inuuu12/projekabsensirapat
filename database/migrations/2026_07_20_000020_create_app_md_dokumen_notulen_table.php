<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_dokumen_notulen', function (Blueprint $table) {
            $table->bigIncrements('id_dokumen');
            $table->string('nama_file');
            $table->string('file_path');
            $table->unsignedBigInteger('id_kehadiran');
            $table->timestamps();

            $table->foreign('id_kehadiran')->references('id_kehadiran')->on('app_md_kehadiran')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_dokumen_notulen');
    }
};
