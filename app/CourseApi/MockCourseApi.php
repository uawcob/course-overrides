<?php

namespace App\CourseApi;

use App\Semester;
use App\Course;
use App\CourseApi\Exceptions\CourseNotFound;

class MockCourseApi implements CourseApi
{
    public function semester(Semester $semester = null) : Semester
    {
        return new Semester('summer', 2017);
    }

    public function get(int $number) : Course
    {
        $fixtures = realpath(__DIR__.'/../../tests/fixtures/api/courses');
        if (!file_exists("$fixtures/$number.json")) {
            throw new CourseNotFound("Course number: $number not found in semester: {$this->semester()}.");
        }

        $data = json_decode(file_get_contents("$fixtures/$number.json"), $array = true);

        $course = new Course([
            'number' => $number,
            'code' => $data[0]['CourseID'],
            'section' => $data[0]['Section'],
            'title' => $data[0]['Title'],
            'time' => $data[0]['Day/Time'],
        ]);
        $course->semester($this->semester());

        return $course;
    }
}
