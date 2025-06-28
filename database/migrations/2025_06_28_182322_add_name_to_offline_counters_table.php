<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('offline_counters', function (Blueprint $table) {
            $table->string('name')->nullable()->after('phone_number');
        });

        // Set 'ZENPRO' for existing rows
        DB::table('offline_counters')->update(['name' => 'ZENPRO']);
    }

    public function down()
    {
        Schema::table('offline_counters', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};
