<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Instructor
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // Student
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Course
            $table->string('day');
            $table->time('time');
            $table->enum('status', ['Online', 'Offline']);
            $table->foreignId('course_path_id')->constrained('course_paths')->onDelete('cascade'); // Level
            $table->foreignId('path_of_path_id')->nullable()->constrained('path_of_paths')->onDelete('cascade'); // Sub-Level
            $table->json('sessions'); // Store attendance per session
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('attendance_records');
    }
};
