<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Course;

class CartTest extends TestCase
{
    use DatabaseMigrations;

    public function test_adds_and_removes_course_from_cart()
    {
        $course = create(Course::class);

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
