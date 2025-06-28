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
        Schema::create('offline_counters', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number');
            $table->string('caliber');
            $table->timestamp('production_time')->nullable(); // Use datetime() if you prefer
            $table->string('producer_country');
            $table->string('supplier');
            $table->string('phone_number');
            $table->timestamps(); // adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offline_counters');
    }
};
