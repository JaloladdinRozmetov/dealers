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
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('INN');
            $table->string('director_name');
            $table->string('ofice_adres'); // Consider correcting to 'office_address'
            $table->string('store_adres'); // Consider correcting to 'store_address'
            $table->string('phone_number');
            $table->unsignedBigInteger('user_id'); // Add user_id column
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealers');
    }
};
