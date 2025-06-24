<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hotel_reviews', function (Blueprint $table) {
            $table->string('foto', 255)->nullable()->after('review');
        });
    }

    public function down(): void
    {
        Schema::table('hotel_reviews', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
