<?php

namespace App\CourseApi;

use App\Semester;
use App\Course;

interface CourseApi
{
    public function semester(Semester $semester = null) : Semester;
    public function get(int $number) : Course;
}
