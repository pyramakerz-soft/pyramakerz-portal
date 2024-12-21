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
        Schema::create('student_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Link to the student
            $table->foreignId('payment_detail_id')->nullable()->constrained('payment_details')->onDelete('cascade'); // Link to payment details
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade'); // Link to a specific course (if applicable)
            $table->decimal('amount', 10, 2); // Payment amount
            $table->string('currency')->default('USD'); // Currency of the payment
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending'); // Payment status
            $table->text('notes')->nullable(); // Optional notes for the payment
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_payments');
    }
};