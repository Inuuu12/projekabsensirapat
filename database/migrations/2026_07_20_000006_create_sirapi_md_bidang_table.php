<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sirapi_md_bidang')) {
            return;
        }

        Schema::create('sirapi_md_bidang', function (Blueprint $table) {
            $table->id('id_bidang');
            $table->string('nama_bidang')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirapi_md_bidang');
    }
};
