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
        Schema::create('path_of_paths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_path_id')->constrained()->onDelete('cascade'); // Link to the course path
            $table->foreignId('parent_id')->nullable()->constrained('path_of_paths')->onDelete('cascade'); // Self-referencing parent path
            $table->string('name'); // Name of the nested path
            $table->text('description')->nullable(); // Description of the nested path
            $table->integer('order')->nullable(); // Order of the path within its parent
            $table->string('duration')->nullable(); // Duration of the nested path
            $table->decimal('price', 10, 2)->nullable(); // Price for this specific nested path
            $table->boolean('is_active')->default(true); // Status of the path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('path_of_paths');
    }
};