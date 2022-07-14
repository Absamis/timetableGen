<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('department', 20);
            $table->string('level', 5);
            $table->text('course_title');
            $table->string('course_code', 7);
            $table->string("course_type", 10);
            $table->string('course_id', 20);
            $table->string('lecturer', 40);
            $table->string('lecture_room', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_courses');
    }
}
