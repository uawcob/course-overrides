<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisabledColumnToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->boolean('enabled')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop column doesn't work so smoothly on SQL Server
        // https://github.com/laravel/framework/issues/4402
        if ('sqlsrv' == DB::connection()->getDriverName()) {
            $defaultContraint = DB::selectOne("SELECT OBJECT_NAME([default_object_id]) AS name FROM SYS.COLUMNS WHERE [object_id] = OBJECT_ID('[dbo].[courses]') AND [name] = 'enabled'");
            DB::statement("ALTER TABLE [dbo].[courses] DROP CONSTRAINT {$defaultContraint->name}");
        }

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('enabled');
        });
    }
}
