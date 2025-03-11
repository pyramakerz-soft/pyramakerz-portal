<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('course_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->string('branch');
            $table->string('age_group');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['Online', 'Offline', 'Delayed', 'Finished', 'Canceled']);
            $table->integer('total_sessions');
            $table->integer('completed_sessions')->default(0);
            $table->integer('delayed_sessions')->default(0);
            $table->integer('canceled_sessions')->default(0);
            $table->json('progress')->nullable(); // JSON field for storing weekly progress
            $table->json('materials')->nullable(); // JSON field for storing handouts and summaries
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_progress');
    }
};
