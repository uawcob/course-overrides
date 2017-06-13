<?php

namespace App\CoursesApi;

use App\Semester;
use App\Course;
use App\CoursesApi\Exceptions\{CourseNotFound,BadStatusCode};

class CoursesApiClient
{
    protected $semester;

    public function __construct(Semester $semester = null)
    {
        if (isset($semester)) {
            $this->semester($semester);
        }
    }

    public function semester(Semester $semester = null) : Semester
    {
        if (isset($semester)) {
            $this->semester = $semester;
        }

        return $this->semester;
    }

    public function get(int $number) : Course
    {
        $query = http_build_query([
            '1' => $this->semester()->string(),
            '2' => $number,
        ]);

        $endpoint = config('coursesapi.endpoint')."?$query";

        $response = (new \GuzzleHttp\Client)->request('GET', $endpoint);

        if (($code = $response->getStatusCode()) != 200) {
            throw new BadStatusCode("Courses API returned HTTP $code");
        }

        $data = json_decode($response->getBody(), $array = true);

        if (empty($data)) {
            throw new CourseNotFound("Course number: $number not found in semester: {$this->semester()}.");
        }

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
