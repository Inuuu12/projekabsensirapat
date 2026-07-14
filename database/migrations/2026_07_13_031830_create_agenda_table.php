<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id('id_agenda'); // primary key sesuai diagram
            $table->string('judul'); // di diagram field-nya namanya 'judul'
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('lokasi');
            $table->boolean('status_FaceRecognition')->default(false); // sesuai tipe data boolean di diagram
            $table->string('status_qr')->default('nonaktif'); // tambahan status untuk switch on/off QR scanner
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda');
    }
};
