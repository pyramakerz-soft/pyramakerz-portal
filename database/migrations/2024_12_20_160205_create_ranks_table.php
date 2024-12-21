<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Rank name (e.g., Bronze, Silver, Gold)
            $table->integer('min_points')->default(0); // Minimum points required for this rank
            $table->integer('max_points')->nullable(); // Maximum points for this rank (nullable for highest rank)
            $table->string('shield_image'); // Path to the shield image representing the rank
            $table->text('description')->nullable(); // Description of the rank
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranks');
    }
};