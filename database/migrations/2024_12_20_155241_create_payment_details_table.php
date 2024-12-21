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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_parent_id')->constrained()->onDelete('cascade'); // Link to the user making the payment
            $table->string('payment_method'); // Payment method (e.g., Credit Card, PayPal)
            $table->string('transaction_id')->unique(); // Unique transaction identifier
            $table->decimal('amount', 10, 2); // Payment amount
            $table->string('currency')->default('USD'); // Currency code (e.g., USD, EUR)
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending'); // Payment status
            $table->text('description')->nullable(); // Optional payment description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};