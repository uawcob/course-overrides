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
            ('Accounting','Major'),
            ('Economics—Business Economics','Major'),
            ('Economics—International ECON and Business','Major'),
            ('Finance—Management/Investments','Major'),
            ('Finance—Banking','Major'),
            ('Finance—Insurance','Major'),
            ('Finance—Real Estate','Major'),
            ('Finance—Energy Finance','Major'),
            ('General Business','Major'),
            ('Information Systems—ERP','Major'),
            ('Information Systems—Enterprise Systems','Major'),
            ('Information Systems—Data Analytics','Major'),
            ('Management—Organizational Leadership','Major'),
            ('Management—Human Resource Management','Major'),
            ('Management—Small Business/Entrepreneurship','Major'),
            ('Marketing','Major'),
            ('Retail','Major'),
            ('Supply Chain Management—Transportation & Logistics','Major'),
            ('Supply Chain Management—Retail Supply Chain','Major'),
            ('Undeclared—Business','Major'),
            ('Bumpers College major','Major'),
            ('Fulbright College major','Major'),
            ('Jones School of Architecture & Design major','Major'),
            ('College of Education & Health Professions major','Major'),
            ('College of Engineering major','Major'),
            ('Accounting','Minor for Business Majors'),
            ('Behavioral Economics','Minor for Business Majors'),
            ('Business Analytics','Minor for Business Majors'),
            ('Business Economics','Minor for Business Majors'),
            ('Finance—Investments/Banking','Minor for Business Majors'),
            ('Finance—Real Estate/Insurance','Minor for Business Majors'),
            ('Information Systems','Minor for Business Majors'),
            ('Management','Minor for Business Majors'),
            ('Marketing','Minor for Business Majors'),
            ('Retail','Minor for Business Majors'),
            ('Supply Chain Management','Minor for Business Majors'),
            ('Enterprise Resource Planning','Minor for Business Majors'),
            ('Financial Economics','Minor for Business Majors'),
            ('International Business','Minor for Business Majors'),
            ('Nonprofit Studies','Minor for Business Majors'),
            ('Accounting','Minor for Non-Business Majors'),
            ('Business Economics','Minor for Non-Business Majors'),
            ('Enterprise Resource Planning','Minor for Non-Business Majors'),
            ('Enterprise Systems','Minor for Non-Business Majors'),
            ('Finance','Minor for Non-Business Majors'),
            ('General Business','Minor for Non-Business Majors'),
            ('Information Systems','Minor for Non-Business Majors'),
            ('Management','Minor for Non-Business Majors'),
            ('Marketing','Minor for Non-Business Majors'),
            ('Retail','Minor for Non-Business Majors'),
            ('Supply Chain Management','Minor for Non-Business Majors'),
            ('International Business','Minor for Non-Business Majors');
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
