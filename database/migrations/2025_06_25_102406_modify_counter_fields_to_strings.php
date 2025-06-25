<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('counters', function (Blueprint $table) {
            // Change column types to string
            $table->string('serial_number', 20)->change();
            $table->string('imei', 20)->change();
            $table->string('iccid', 25)->change();
            $table->string('phone_number', 15)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('counters', function (Blueprint $table) {
            // Revert changes (WARNING: may lose data if overflow occurs)
            $table->bigInteger('serial_number')->change();
            $table->bigInteger('imei')->change();
            $table->bigInteger('iccid')->change();
            $table->integer('phone_number')->nullable()->change();
        });
    }
};
