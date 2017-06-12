<?php

namespace App\CourseApi;

use App\Semester;
use App\Course;

class MockCourseApi implements CourseApi
{
    public function semester(Semester $semester = null) : Semester
    {
        return new Semester('summer', 2017);
    }

    public function get(int $number) : Course
    {
        $course = new Course;
        $course->semester($this->semester());
        return $course;
    }
}
