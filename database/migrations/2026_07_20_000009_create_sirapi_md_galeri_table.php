<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirapi_md_galeri', function (Blueprint $table) {
            $table->id('id_galeri');
            $table->date('tanggal');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_galeri');
    }
};
