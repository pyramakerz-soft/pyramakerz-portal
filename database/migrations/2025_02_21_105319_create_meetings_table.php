<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('zoom_meeting_id')->unique();
            $table->string('topic');
            $table->string('start_time');
            $table->integer('duration');
            $table->string('join_url');
            $table->string('status')->default('scheduled'); // scheduled, live, ended
            
            // Relationships
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->foreignId('group_schedule_id')->constrained('group_schedules')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meetings');
    }
};
