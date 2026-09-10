<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirapi_md_kecamatan', function (Blueprint $table) {
            $table->id('id_kecamatan');
            $table->string('kode_kecamatan')->unique()->nullable();
            $table->string('nama_kecamatan');
            $table->text('alamat_kantor')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('camat')->nullable();
            $table->string('gps_lat')->nullable();
            $table->string('gps_long')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_kecamatan');
    }
};
