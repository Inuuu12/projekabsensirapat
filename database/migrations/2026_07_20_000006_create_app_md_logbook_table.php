<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_logbook', function (Blueprint $table) {
            $table->bigIncrements('id_log');
            $table->unsignedBigInteger('id_agenda')->nullable();
            $table->text('catatan');
            $table->dateTime('waktu_isi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_logbook');
    }
};
