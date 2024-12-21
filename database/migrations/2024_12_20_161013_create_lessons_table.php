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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_path_id')->nullable()->constrained()->onDelete('cascade'); // Link to a course path
            $table->foreignId('path_of_path_id')->nullable()->constrained()->onDelete('cascade'); // Link to a path of path
            $table->string('title'); // Lesson title
            $table->text('description')->nullable(); // Lesson description
            $table->string('video_url')->nullable(); // URL to the lesson video
            $table->string('resource_file')->nullable(); // Path to additional lesson resources
            $table->integer('order')->default(0); // Order of the lesson within the course path or path of path
            $table->boolean('is_active')->default(true); // Status of the lesson
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};