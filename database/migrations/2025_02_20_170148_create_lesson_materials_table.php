<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('lesson_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade'); // Links to lessons table
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('set null'); // Instructor who uploaded the material
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('cascade'); // Links material to a specific group
            $table->string('title'); // Material title
            $table->enum('type', ['video', 'quiz', 'assignment', 'document']); // Type of material
            $table->string('url'); // URL or file path
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lesson_materials');
    }
}

