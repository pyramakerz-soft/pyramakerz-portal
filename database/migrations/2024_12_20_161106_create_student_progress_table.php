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
        Schema::create('student_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Link to the student
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('cascade'); // Link to the lesson
            $table->foreignId('course_path_id')->nullable()->constrained()->onDelete('cascade'); // Link to the course path
            $table->foreignId('path_of_path_id')->nullable()->constrained()->onDelete('cascade'); // Link to the path of path
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started'); // Progress status
            $table->integer('progress_percentage')->default(0); // Percentage progress (e.g., 50% completed)
            $table->timestamp('started_at')->nullable(); // Timestamp for when the student started
            $table->timestamp('completed_at')->nullable(); // Timestamp for when the student completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_progress');
    }
};