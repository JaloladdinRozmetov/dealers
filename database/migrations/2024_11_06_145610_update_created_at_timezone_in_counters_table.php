<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('counters', function (Blueprint $table) {
            Schema::table('counters', function (Blueprint $table) {
                DB::statement("UPDATE counters SET created_at = DATE_ADD(created_at, INTERVAL 5 HOUR)");
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counters', function (Blueprint $table) {
            Schema::table('counters', function (Blueprint $table) {
                DB::statement("UPDATE counters SET created_at = DATE_SUB(created_at, INTERVAL 5 HOUR)");
            });
        });
    }
};
