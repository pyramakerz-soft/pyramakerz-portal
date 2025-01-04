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
        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_assessment_id')->constrained()->onDelete('cascade'); 
            $table->text('question'); 
            $table->enum('type', ['multiple_choice', 'true_false', 'short_answer'])->default('multiple_choice'); 
            $table->json('options')->nullable(); 
            $table->string('correct_answer')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_questions');
    }
};
