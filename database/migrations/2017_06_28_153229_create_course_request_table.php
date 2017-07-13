<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_request', function (Blueprint $table) {
            $table->integer('request_id')->unsigned();
            $table->foreign('request_id')
                ->references('id')
                ->on('requests')
                ->onDelete('cascade');

            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')
                ->references('id')
                ->on('courses');

            $table->primary(['request_id', 'course_id']);

            $table->tinyInteger('priority');
            $table->unique(['request_id', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_request');
    }
}
