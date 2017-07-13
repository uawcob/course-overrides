<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (App::Environment() === 'testing') {
            return;
        }

        $sql = database_path('sql/view-courses.sql');
        $sql = file_get_contents($sql);
        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (App::Environment() === 'testing') {
            return;
        }

        DB::statement('DROP VIEW vwCourses');
    }
}
