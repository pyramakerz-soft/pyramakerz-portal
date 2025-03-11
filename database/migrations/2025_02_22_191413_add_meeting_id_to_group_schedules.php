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
        Schema::table('group_schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('meeting_id')->nullable()->after('id');
            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_schedules', function (Blueprint $table) {
            //
        });
    }
};
