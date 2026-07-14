<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('logbook', function (Blueprint $table) {
            $table->id('idLog');
            $table->foreignId('id_agenda')->constrained('agenda', 'id_agenda')->onDelete('cascade');
            $table->text('catatan');
            $table->dateTime('waktu_isi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook');
    }
};

