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
        Schema::create('student_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // References students
            $table->morphs('respondable'); // References the specific model (morphable relation)
            $table->boolean('response')->default(false); // Boolean response
            $table->text('comment')->nullable(); // Optional: Add a comment column for additional details
            $table->timestamp('responded_at')->nullable(); // Optional: Timestamp for when the response was made
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_responses');
    }
};