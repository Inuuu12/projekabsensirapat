<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirapi_md_facerecog', function (Blueprint $table) {
            $table->id('id_facerecog');
            $table->string('nama');
            $table->timestamps();

            $table->foreignId('id_peserta')->constrained('sirapi_md_peserta', 'id_peserta')->cascadeonDelete('');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_facerecog');
    }
};
