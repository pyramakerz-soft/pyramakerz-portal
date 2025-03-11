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
        Schema::table('instructor_to_student_evaluations', function (Blueprint $table) {
            $table->unsignedBigInteger('group_schedule_id')->nullable();
            $table->foreign('group_schedule_id')->references('id')->on('group_schedules');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instructor_to_student_evaluations', function (Blueprint $table) {
            //
        });
    }
};
