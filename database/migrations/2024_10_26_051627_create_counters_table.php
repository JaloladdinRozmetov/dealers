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
        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('serial_number')->length(14);
            $table->string('caliber');
            $table->bigInteger('imei')->length(15);
            $table->bigInteger('iccid')->length(19);
            $table->integer('phone_number')->length(9)->nullable();
            $table->foreignId('dealer_id')->nullable()->constrained('dealers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counters');
    }
};
