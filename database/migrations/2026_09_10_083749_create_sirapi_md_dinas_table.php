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
        if (!Schema::hasTable('sirapi_md_dinas')) {
            Schema::create('sirapi_md_dinas', function (Blueprint $table) {
                $table->id('id_dinas');
                $table->string('nama_dinas');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_dinas');
    }
};
