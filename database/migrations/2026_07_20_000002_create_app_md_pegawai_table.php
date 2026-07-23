<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_pegawai', function (Blueprint $table) {
            $table->id('id_pegawai');
            $table->string('foto')->nullable();
            $table->string('nama_pegawai');
            $table->string('nip')->unique();
            $table->string('jabatan');
            $table->string('nomor_hp');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_pegawai');
    }
};
