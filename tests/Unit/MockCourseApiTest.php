<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\CourseApi\MockCourseApi;
use App\Course;

class MockCourseApiTest extends TestCase
{
    public function test_returns_course()
    {
        $api = new MockCourseApi;
        $course = $api->get(6631);
        $this->assertInstanceOf(Course::class, $course);
    }
}
