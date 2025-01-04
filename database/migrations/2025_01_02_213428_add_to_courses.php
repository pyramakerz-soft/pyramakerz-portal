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
        Schema::table('courses', function (Blueprint $table) {
            // Ensure the columns are only added if they do not already exist
            if (!Schema::hasColumn('courses', 'slug')) {
                $table->string('slug')->nullable();
            }

            if (!Schema::hasColumn('courses', 'discounted_price')) {
                $table->decimal('discounted_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('courses', 'language')) {
                $table->string('language')->nullable();
            }
            if (!Schema::hasColumn('courses', 'skill_level')) {
                $table->string('skill_level')->nullable();
            }

            if (!Schema::hasColumn('courses', 'course_path')) {
                $table->string('course_path')->nullable();
            }

            if (!Schema::hasColumn('courses', 'prereq')) {
                $table->json('prereq')->nullable();
            }

            if (!Schema::hasColumn('courses', 'course_tags')) {
                $table->json('course_tags')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Optionally remove the columns if necessary
            if (Schema::hasColumn('courses', 'slug')) {
                $table->dropColumn('slug');
            }

            if (Schema::hasColumn('courses', 'discounted_price')) {
                $table->dropColumn('discounted_price');
            }

            if (Schema::hasColumn('courses', 'course_path')) {
                $table->dropColumn('course_path');
            }

            if (Schema::hasColumn('courses', 'prereq')) {
                $table->dropColumn('prereq');
            }

            if (Schema::hasColumn('courses', 'course_tags')) {
                $table->dropColumn('course_tags');
            }
        });
    }
};
