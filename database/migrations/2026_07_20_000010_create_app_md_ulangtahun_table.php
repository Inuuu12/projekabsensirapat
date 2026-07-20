<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_ulangtahun', function (Blueprint $table) {
            $table->bigIncrements('id_ulangtahun');
            $table->string('nama');
            $table->date('tanggal');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_ulangtahun');
    }
};
