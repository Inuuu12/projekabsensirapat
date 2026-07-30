<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('app_md_datamasukan', function (Blueprint $table) {
            $table->dropUnique('app_md_datamasukan_email_unique');
        });
    }

    public function down(): void
    {
        Schema::table('app_md_datamasukan', function (Blueprint $table) {
            $table->unique('email', 'app_md_datamasukan_email_unique');
        });
    }
};
