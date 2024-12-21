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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the test
            $table->text('description')->nullable(); // Description of the test
            $table->enum('type', ['quiz', 'exam', 'practice'])->default('quiz'); // Type of test
            $table->integer('duration')->nullable(); // Duration of the test in minutes
            $table->boolean('is_active')->default(true); // Status of the test
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};