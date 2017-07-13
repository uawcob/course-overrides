<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultGetdate extends Migration
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

        DB::statement("ALTER TABLE courses ADD CONSTRAINT DF_courses_created DEFAULT GETDATE() FOR created_at");
        DB::statement("ALTER TABLE courses ADD CONSTRAINT DF_courses_updated DEFAULT GETDATE() FOR updated_at");
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

        DB::statement("ALTER TABLE courses DROP CONSTRAINT DF_courses_created");
        DB::statement("ALTER TABLE courses DROP CONSTRAINT DF_courses_updated");
    }
}
