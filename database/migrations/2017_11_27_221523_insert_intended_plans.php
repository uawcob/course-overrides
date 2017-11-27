<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertIntendedPlans extends Migration
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

        $sql = "INSERT INTO intended_plans (name, category) VALUES
            ('Accounting','Majors'),
            ('Economics—Business Economics','Majors'),
            ('Economics—International ECON and Business','Majors'),
            ('Finance—Management/Investments','Majors'),
            ('Finance—Banking','Majors'),
            ('Finance—Insurance','Majors'),
            ('Finance—Real Estate','Majors'),
            ('Finance—Energy Finance','Majors'),
            ('General Business','Majors'),
            ('Information Systems—ERP','Majors'),
            ('Information Systems—Enterprise Systems','Majors'),
            ('Information Systems—Data Analytics','Majors'),
            ('Management—Organizational Leadership','Majors'),
            ('Management—Human Resource Management','Majors'),
            ('Management—Small Business/Entrepreneurship','Majors'),
            ('Marketing','Majors'),
            ('Retail','Majors'),
            ('Supply Chain Management—Transportation & Logistics','Majors'),
            ('Supply Chain Management—Retail Supply Chain','Majors'),
            ('Undeclared—Business','Majors'),
            ('Bumpers College major','Majors'),
            ('Fulbright College major','Majors'),
            ('Jones School of Architecture & Design major','Majors'),
            ('College of Education & Health Professions major','Majors'),
            ('College of Engineering major','Majors'),
            ('Accounting','Minors For Business Majors'),
            ('Behavioral Economics','Minors For Business Majors'),
            ('Business Analytics','Minors For Business Majors'),
            ('Business Economics','Minors For Business Majors'),
            ('Finance—Investments/Banking','Minors For Business Majors'),
            ('Finance—Real Estate/Insurance','Minors For Business Majors'),
            ('Information Systems','Minors For Business Majors'),
            ('Management','Minors For Business Majors'),
            ('Marketing','Minors For Business Majors'),
            ('Retail','Minors For Business Majors'),
            ('Supply Chain Management','Minors For Business Majors'),
            ('Enterprise Resource Planning','Minors For Business Majors'),
            ('Financial Economics','Minors For Business Majors'),
            ('International Business','Minors For Business Majors'),
            ('Nonprofit Studies','Minors For Business Majors'),
            ('Accounting','Minors For Non-Business Majors'),
            ('Business Economics','Minors For Non-Business Majors'),
            ('Enterprise Resource Planning','Minors For Non-Business Majors'),
            ('Enterprise Systems','Minors For Non-Business Majors'),
            ('Finance','Minors For Non-Business Majors'),
            ('General Business','Minors For Non-Business Majors'),
            ('Information Systems','Minors For Non-Business Majors'),
            ('Management','Minors For Non-Business Majors'),
            ('Marketing','Minors For Non-Business Majors'),
            ('Retail','Minors For Non-Business Majors'),
            ('Supply Chain Management','Minors For Non-Business Majors'),
            ('International Business','Minors For Non-Business Majors');
        ";

        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
