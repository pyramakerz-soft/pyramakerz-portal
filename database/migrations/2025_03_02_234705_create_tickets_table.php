<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            // Assuming the student users are stored in a "students" table
            $table->unsignedBigInteger('user_id');
            $table->string('category'); // Technical, Academic, Other
            $table->text('message');
            $table->string('attachment')->nullable();
            $table->timestamps();

            // Adjust foreign key as needed (if using students table)
            $table->foreign('user_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
