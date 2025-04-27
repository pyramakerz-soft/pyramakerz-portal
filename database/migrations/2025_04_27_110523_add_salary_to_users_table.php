<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('salary_type', ['Full-Time', 'Part-Time', 'Per-Session'])->nullable()->after('password');
            $table->decimal('salary', 10, 2)->nullable()->after('salary_type');
            $table->string('level')->nullable()->after('salary');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['salary_type', 'salary', 'level']);
        });
    }
};
