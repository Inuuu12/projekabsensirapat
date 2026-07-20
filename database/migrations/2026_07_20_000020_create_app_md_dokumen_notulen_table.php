<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_dokumen_notulen', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->string('nama_file');
            $table->string('file_path');
            $table->timestamps();
            
            $table->foreignId('id_kehadiran')->contstraide('id_kehadiran')->on('app_md_kehadiran')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_dokumen_notulen');
    }
};
