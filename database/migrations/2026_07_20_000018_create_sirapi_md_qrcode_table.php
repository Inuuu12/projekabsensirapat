<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirapi_md_qrcode', function (Blueprint $table) {
            $table->id('id_qrcode');
            $table->string('qr_codepath');
            $table->timestamps();

            $table->foreignId('id_agenda')->constrained('sirapi_md_agenda','id_agenda')->cascadeonDelete('');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_qrcode');
    }
};
