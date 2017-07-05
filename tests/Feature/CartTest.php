<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Course;
use App\Semester;
use App\Schedule;
use Carbon\Carbon;

class CartTest extends TestCase
{
    use DatabaseMigrations;

    public function test_adds_and_removes_course_from_cart()
    {
        openSchedule();

        $course = make(Course::class);
        $course->semester(Semester::createFromStrm('1179'));
        $course->save();

        $this
            ->signIn()
            ->post("/cart/add/{$course->id}")
            ->assertStatus(204)
        ;

        $this
            ->get("/cart/data")
            ->assertJson(['data' =>
                [$course->toArray()],
            ])
        ;

        $this
            ->post("/cart/remove/{$course->id}")
            ->assertStatus(204)
        ;

        $this
            ->get("/cart/data")
            ->assertJsonMissing(['data' =>
                [$course->toArray()],
            ])
        ;
    }
}
