<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserPermissions extends Migration
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

        $group = config('admin.group');

        DB::statement("CREATE USER [$group]");
        DB::statement("ALTER ROLE db_datareader ADD MEMBER [$group]");
        DB::statement("GRANT UPDATE ON dbo.vwRequests (inclass) TO [$group]");
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

        $group = config('admin.group');

        DB::statement("DROP USER [$group]");
    }
}
