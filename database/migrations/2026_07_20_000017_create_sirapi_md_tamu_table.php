<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirapi_md_tamu', function (Blueprint $table) {
            $table->id('id_tamu');
            $table->string('nama');
            $table->string('nik')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('no_hp');
            $table->string('asal_instansi');
            $table->string('foto_selfie')->nullable();
            $table->timestamps();

            $table->foreignId('id_agenda')->constraide('sirapi_md_agenda', 'id_agenda')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_tamu');
    }
};
