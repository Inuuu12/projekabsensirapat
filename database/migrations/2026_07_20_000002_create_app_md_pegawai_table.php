<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_pegawai', function (Blueprint $table) {
            $table->bigIncrements('id_pegawai');
            $table->string('nip');
            $table->string('nama_pegawai');
            $table->string('jabatan');
            $table->string('nomor_hp');
            $table->string('email');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_pegawai');
    }
};
