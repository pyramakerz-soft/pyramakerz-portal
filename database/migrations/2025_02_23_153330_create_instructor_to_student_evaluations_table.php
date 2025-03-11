<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorToStudentEvaluationsTable extends Migration
{
    public function up()
    {
        Schema::create('instructor_to_student_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable(); // e.g. "pyra-00884"
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('course_path_id')->nullable();
            $table->unsignedBigInteger('path_of_path_id')->nullable();
            // Date the student joined the group (from group_students.created_at)
            $table->date('joined_at')->nullable();
            // Evaluation period (start and end dates)
            $table->date('evaluation_period_start')->nullable();
            $table->date('evaluation_period_end')->nullable();
            // Store dynamic session evaluation details as JSON.
            // Each element may contain keys: interaction, performance, homework, and evaluated_at.
            $table->json('evaluation_details')->nullable();
            // Optionally store computed scores.
            $table->decimal('total_score', 8, 2)->nullable();
            $table->decimal('evaluation_score', 8, 2)->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('instructor_to_student_evaluations');
    }
}
