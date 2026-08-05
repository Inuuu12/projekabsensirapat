<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirapi_md_logbook', function (Blueprint $table) {
            $table->id('id_log');
            $table->text('catatan');
            $table->dateTime('waktu_isi');
            $table->timestamps();

            $table->foreignId('Id_agenda')->constrained('sirapi_md_agenda','id_agenda')->cascadeonDelete('');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_logbook');
    }
};
