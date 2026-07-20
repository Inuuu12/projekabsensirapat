<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_qrcode', function (Blueprint $table) {
            $table->id('id_qrcode');
            $table->string('qr_codepath');
            $table->timestamps();

            $table->foreignId('id_agenda')->constrained('app_md_agenda','id_agenda')->cascadeonDelete('');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_qrcode');
    }
};
