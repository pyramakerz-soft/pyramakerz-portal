<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworksTable extends Migration
{
    public function up()
    {
        Schema::create('homeworks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instructor_id');
            $table->unsignedBigInteger('student_id');
            // Homework is given according to a specific lesson
            $table->unsignedBigInteger('lesson_id');
            // Optionally, homework may be tied to a specific group schedule session
            $table->unsignedBigInteger('group_schedule_id')->nullable();
            $table->string('file_path'); // Path or URL to the uploaded homework file
            $table->decimal('grade', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('instructor_id')->references('id')->nullable()->on('users')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
            $table->foreign('group_schedule_id')->references('id')->on('group_schedules')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('homeworks');
    }
}
