<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use Illuminate\Support\Facades\Request;

class CourseTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_cannot_view_create_course_page()
    {
        $this->withExceptionHandling();

        openSchedule();

        $response = $this
            ->signIn()
            ->get('/courses/create');

        $response->assertStatus(403);
    }

    public function test_admin_can_view_create_course_page()
    {
        $response = $this
            ->withServerVariables(['entitlement' => 'admin'])
            ->signIn()
            ->get('/courses/create');

        $response->assertStatus(200);
    }

    public function test_creates_course()
    {
        $course = make('App\Course');
        $data = array_merge(
            $course->toArray(),
            ['strm' => $course->semester->string()]
        );

        $response = $this
            ->withServerVariables(['entitlement' => 'admin'])
            ->signIn()
            ->post('/courses', $data);

        $response->assertStatus(302);

        $this->get($response->headers->get('Location'))
            ->assertJson($course->toArray());
//             ->assertSee($course->number)
//             ->assertSee($course->title)
//             ->assertSee($course->code);
    }

    public function test_view_courses_only_when_authenticated()
    {
        $this
            ->withExceptionHandling()
            ->get('/courses')
            ->assertRedirect('/shibboleth-login')
        ;
    }
}
