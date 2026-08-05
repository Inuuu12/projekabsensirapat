<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirapi_md_dokumen_notulen', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->foreignId('id_agenda')->constrained('sirapi_md_agenda', 'id_agenda')->cascadeOnDelete();
            $table->string('jenis_dokumen', 30)->default('notulen');
            $table->string('nama_file');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_dokumen_notulen');
    }
};
