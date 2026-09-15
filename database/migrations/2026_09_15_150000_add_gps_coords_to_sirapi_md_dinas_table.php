<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sirapi_md_dinas', function (Blueprint $table) {
            if (!Schema::hasColumn('sirapi_md_dinas', 'gps_lat')) {
                $table->string('gps_lat')->nullable()->after('kepala_dinas');
            }
            if (!Schema::hasColumn('sirapi_md_dinas', 'gps_long')) {
                $table->string('gps_long')->nullable()->after('gps_lat');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sirapi_md_dinas', function (Blueprint $table) {
            if (Schema::hasColumn('sirapi_md_dinas', 'gps_lat') && Schema::hasColumn('sirapi_md_dinas', 'gps_long')) {
                $table->dropColumn(['gps_lat', 'gps_long']);
            }
        });
    }
};
