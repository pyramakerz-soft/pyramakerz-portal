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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('age_group_id')->constrained()->onDelete('cascade');
            $table->text('description');
            $table->string('image');
            $table->decimal('price', 10, 2); // Price with decimal support
            $table->string('duration'); // Duration in text format, e.g., "3 weeks"
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active'); // Status with predefined options
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};