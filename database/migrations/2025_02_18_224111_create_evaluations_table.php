<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->integer('sessions_per_week')->default(0);
            $table->integer('students_count')->default(0);
            $table->integer('attended')->default(0);
            $table->integer('absent')->default(0);
            $table->decimal('percentage', 5, 2)->default(0.00);
            $table->decimal('evaluation', 5, 2)->default(0.00);
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluations');
    }
};
