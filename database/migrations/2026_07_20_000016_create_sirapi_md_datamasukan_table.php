<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirapi_md_datamasukan', function (Blueprint $table) {
            $table->bigIncrements('id_datamasukan');
            $table->string('nama_pengadu');
            $table->string('nomor_pengadu');
            $table->string('email');
            $table->string('foto');
            $table->text('isi_aduan');
            $table->text('balasan_admin')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreignid('id_admin')->nullable()->constraide('sirapi_md_admin','id_admin')->cascadeondelete('');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_datamasukan');
    }
};
