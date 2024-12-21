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
        Schema::create('lesson_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade'); // Link to the lesson
            $table->string('type'); // Type of detail (e.g., "video", "resource", "quiz")
            $table->string('content'); // URL or path to the content
            $table->text('description')->nullable(); // Description of the detail
            $table->integer('order')->default(0); // Order of the detail within the lesson
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_details');
    }
};