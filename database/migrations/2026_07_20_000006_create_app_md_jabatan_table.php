<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('app_md_jabatan')) {
            return;
        }

        Schema::create('app_md_jabatan', function (Blueprint $table) {
            $table->id('id_jabatan');
            $table->string('nama_jabatan')->unique();
            $table->string('kategori')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_jabatan');
    }
};
