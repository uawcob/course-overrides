<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Course;

class RequestTest extends TestCase
{
    use DatabaseMigrations;

    public function test_makes_request_for_course()
    {
        $course = create(Course::class);

        $response = $this
            ->signIn()
            ->post('/requests', [
                'id' => [
                    '1' => $course->id,
                ],
                'required' => '1',
                'enrolled' => '0',
                'comment' => 'my justification',
            ])
            ->assertRedirect()
        ;

        $redirect = $response->headers->get('Location');
        $this->assertRegExp('~/requests/\d$~', $redirect);

        $this
            ->get($redirect)
            ->assertSee((string)$course->number)
        ;
    }

    public function test_views_course_request_form()
    {
        $course1 = create(Course::class, ['code' => 'WCOB2013']);
        $course2 = create(Course::class, ['code' => 'WCOB2013']);
        $course3 = create(Course::class, ['code' => 'FINN2013']);

        $this
            ->signIn()
            ->withSession([
                "cart.{$course1->id}" => $course1,
                "cart.{$course2->id}" => $course2,
                "cart.{$course3->id}" => $course3,
            ])
            ->get('/requests/create')
            ->assertSee((string)$course1->number)
            ->assertSee((string)$course2->number)
            ->assertDontSee((string)$course3->number)
        ;
    }
}
