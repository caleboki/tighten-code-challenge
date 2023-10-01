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
        Schema::create('observations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('capybara_id');
            $table->date('date');
            $table->string('city');
            $table->boolean('hat')->default(false);
            $table->timestamps();

            $table->foreign('capybara_id')->references('id')->on('capybaras')->onDelete('cascade');

            // Unique constraint to ensure only one observation per capybara/city/date
            $table->unique(['capybara_id', 'date', 'city']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observations');
    }
};
