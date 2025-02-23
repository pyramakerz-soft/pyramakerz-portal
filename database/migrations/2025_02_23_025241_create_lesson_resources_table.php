<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonResourcesTable extends Migration
{
    public function up()
    {
        Schema::create('lesson_resources', function (Blueprint $table) {
            $table->id();
            // Resource is always related to a lesson.
            $table->unsignedBigInteger('lesson_id');
            // Optionally, it may be linked to a specific group.
            $table->unsignedBigInteger('group_id')->nullable();
            // Optionally, it may be linked to a specific group session.
            $table->unsignedBigInteger('group_schedule_id')->nullable();
            // Who uploaded the resource (instructor or supervisor)
            $table->unsignedBigInteger('uploader_id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            // File path or URL for the resource file
            $table->string('file_path');
            // Optionally, a type (e.g. "pdf", "video", "link")
            $table->string('resource_type')->nullable();
            $table->timestamps();

            // Foreign key constraints:
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
            $table->foreign('group_schedule_id')->references('id')->on('group_schedules')->onDelete('set null');
            $table->foreign('uploader_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lesson_resources');
    }
}