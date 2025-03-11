<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('manual_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade'); // Trainer
            $table->date('date');
            $table->string('program'); // AI, Robotics, etc.
            $table->enum('rank', ['S', 'A', 'B', 'C', 'D', 'F'])->default('A');

            // Evaluation Criteria (Scores)
            $table->tinyInteger('setup')->default(10);
            $table->tinyInteger('preparation')->default(10);
            $table->tinyInteger('objectives')->default(10);
            $table->tinyInteger('delivery_capacity')->default(10);
            $table->tinyInteger('controlling_session')->default(10);
            $table->tinyInteger('communication_students')->default(10);
            $table->tinyInteger('attendance_evaluation_sheets')->default(10);
            $table->tinyInteger('personal_impact')->default(10);
            $table->tinyInteger('training_techniques')->default(10);

            $table->decimal('evaluation_percentage', 5, 2)->default(100.00);
            $table->foreignId('supervisor_id')->constrained('users')->onDelete('cascade'); // Supervisor

            $table->text('comments')->nullable(); // Additional comments
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
};
