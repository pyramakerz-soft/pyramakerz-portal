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
        Schema::create('student_to_insts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('meeting_id')->constrained('meetings')->onDelete('cascade');
            $table->tinyInteger('content_quality')->comment('1 to 5 rating for content quality');
            $table->tinyInteger('instructor_clarity')->comment('1 to 5 rating for instructor’s clarity');
            $table->tinyInteger('engagement')->comment('1 to 5 rating for engagement');
            $table->tinyInteger('pace')->comment('1 to 5 rating for session pace');
            $table->tinyInteger('technology_usage')->comment('1 to 5 rating for technology and tools usage');
            $table->tinyInteger('overall_experience')->comment('1 to 5 overall experience rating');
            $table->text('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_to_insts');
    }
};
