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

        $sql = "INSERT INTO intended_plans (name, category, abbr) VALUES
            ('Accounting','Major', '(M)'),
            ('Economics—Business Economics','Major', '(M)'),
            ('Economics—International ECON and Business','Major', '(M)'),
            ('Finance—Management/Investments','Major', '(M)'),
            ('Finance—Banking','Major', '(M)'),
            ('Finance—Insurance','Major', '(M)'),
            ('Finance—Real Estate','Major', '(M)'),
            ('Finance—Energy Finance','Major', '(M)'),
            ('General Business','Major', '(M)'),
            ('Information Systems—ERP','Major', '(M)'),
            ('Information Systems—Enterprise Systems','Major', '(M)'),
            ('Information Systems—Data Analytics','Major', '(M)'),
            ('Management—Organizational Leadership','Major', '(M)'),
            ('Management—Human Resource Management','Major', '(M)'),
            ('Management—Small Business/Entrepreneurship','Major', '(M)'),
            ('Marketing','Major', '(M)'),
            ('Retail','Major', '(M)'),
            ('Supply Chain Management—Transportation & Logistics','Major', '(M)'),
            ('Supply Chain Management—Retail Supply Chain','Major', '(M)'),
            ('Undeclared—Business','Major', '(M)'),
            ('Bumpers College major','Major', '(M)'),
            ('Fulbright College major','Major', '(M)'),
            ('Jones School of Architecture & Design major','Major', '(M)'),
            ('College of Education & Health Professions major','Major', '(M)'),
            ('College of Engineering major','Major', '(M)'),
            ('Accounting','Minor for Business Majors','(mB)'),
            ('Behavioral Economics','Minor for Business Majors','(mB)'),
            ('Business Analytics','Minor for Business Majors','(mB)'),
            ('Business Economics','Minor for Business Majors','(mB)'),
            ('Finance—Investments/Banking','Minor for Business Majors','(mB)'),
            ('Finance—Real Estate/Insurance','Minor for Business Majors','(mB)'),
            ('Information Systems','Minor for Business Majors','(mB)'),
            ('Management','Minor for Business Majors','(mB)'),
            ('Marketing','Minor for Business Majors','(mB)'),
            ('Retail','Minor for Business Majors','(mB)'),
            ('Supply Chain Management','Minor for Business Majors','(mB)'),
            ('Enterprise Resource Planning','Minor for Business Majors','(mB)'),
            ('Financial Economics','Minor for Business Majors','(mB)'),
            ('International Business','Minor for Business Majors','(mB)'),
            ('Nonprofit Studies','Minor for Business Majors','(mB)'),
            ('Accounting','Minor for Non-Business Majors','(mN)'),
            ('Business Economics','Minor for Non-Business Majors','(mN)'),
            ('Enterprise Resource Planning','Minor for Non-Business Majors','(mN)'),
            ('Enterprise Systems','Minor for Non-Business Majors','(mN)'),
            ('Finance','Minor for Non-Business Majors','(mN)'),
            ('General Business','Minor for Non-Business Majors','(mN)'),
            ('Information Systems','Minor for Non-Business Majors','(mN)'),
            ('Management','Minor for Non-Business Majors','(mN)'),
            ('Marketing','Minor for Non-Business Majors','(mN)'),
            ('Retail','Minor for Non-Business Majors','(mN)'),
            ('Supply Chain Management','Minor for Non-Business Majors','(mN)'),
            ('International Business','Minor for Non-Business Majors','(mN)');
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
