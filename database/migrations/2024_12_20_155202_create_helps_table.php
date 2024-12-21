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
        Schema::create('helps', function (Blueprint $table) {
            $table->id();
            $table->string('contact_method'); // Type of contact (e.g., WhatsApp, Email, Phone)
            $table->string('contact_detail'); // The contact detail (e.g., phone number, email address)
            $table->text('description')->nullable(); // Optional description or instructions for the support
            $table->string('availability')->nullable(); // Support availability times (e.g., "9 AM - 5 PM")
            $table->string('category')->nullable(); // Optional category of support (e.g., Technical, Billing)
            $table->boolean('is_active')->default(true); // Status of the support method
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helps');
    }
};