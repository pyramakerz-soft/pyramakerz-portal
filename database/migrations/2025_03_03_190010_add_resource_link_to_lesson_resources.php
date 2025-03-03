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
        Schema::table('lesson_resources', function (Blueprint $table) {
            $table->string('resource_link')->nullable()->after('file_path'); // Store external links
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lesson_resources', function (Blueprint $table) {
            //
        });
    }
};
