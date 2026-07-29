<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_md_video', function (Blueprint $table) {
            $table->id('id_video');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('youtube_url');
            $table->string('youtube_embed_url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_md_video');
    }
};
