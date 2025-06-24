<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotel_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->tinyInteger('rating')->unsigned(); // rating 1–5
            $table->text('review')->nullable();
            $table->timestamps();

            // Foreign key ke ogc_fid (karena itu PK tabel hotels)
            $table->foreign('hotel_id')->references('ogc_fid')->on('hotels')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_reviews');
    }
};
