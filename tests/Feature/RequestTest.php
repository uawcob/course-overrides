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
}
