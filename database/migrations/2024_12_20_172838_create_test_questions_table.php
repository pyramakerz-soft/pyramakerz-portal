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
        Schema::create('test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained()->onDelete('cascade'); // Link to the test
            $table->text('question'); // The question text
            $table->enum('type', ['multiple_choice', 'true_false', 'short_answer'])->default('multiple_choice'); // Question type
            $table->json('options')->nullable(); // Options for multiple-choice questions
            $table->string('correct_answer')->nullable(); // Correct answer for the question
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_questions');
    }
};