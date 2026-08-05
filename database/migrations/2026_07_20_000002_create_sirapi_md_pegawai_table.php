<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirapi_md_pegawai', function (Blueprint $table) {
            $table->id('id_pegawai');
            $table->string('foto')->nullable();
            $table->string('nama_pegawai');
            $table->string('nip')->unique();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jabatan');
            $table->string('bidang')->nullable();
            $table->string('nomor_hp');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_pegawai');
    }
};
