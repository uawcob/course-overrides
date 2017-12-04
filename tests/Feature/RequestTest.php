<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Course;
use App\CourseRequest;

class RequestTest extends TestCase
{
    use DatabaseMigrations;

    public function test_request_requires_graduation_date()
    {
        openSchedule();

        $course = create(Course::class);

        $this
            ->signIn()
            ->withSession([
                "cart.{$course->id}" => $course,
            ])
            ->post('/requests', [
                'id' => [
                    '1' => $course->id,
                ],
                'required' => '1',
                'enrolled' => '0',
                'comment' => 'my justification',
            ])
            ->assertRedirect('/requests/create')
            ->assertSessionHasErrors(['graduation_strm'])
        ;
    }

    public function test_makes_request_for_course()
    {
        openSchedule();

        $user = create(User::class, ['graduation_strm' => '1179']);
        $course = create(Course::class);

        $response = $this
            ->signIn($user)
            ->withSession([
                "cart.{$course->id}" => $course,
            ])
            ->post('/requests', [
                'id' => [
                    '1' => $course->id,
                ],
                'required' => '1',
                'enrolled' => '0',
                'comment' => 'my justification',
            ])
            ->assertRedirect()
            ->assertSessionMissing("cart.{$course->id}")
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
        openSchedule();

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

    public function test_user_can_view_request()
    {
        openSchedule();

        $cr = create(CourseRequest::class);

        $this
            ->signIn($cr->request->user)
            ->get("/requests/{$cr->request->id}")
            ->assertSee($cr->course->title)
        ;
    }

    public function test_user_cannot_delete_request()
    {
        $this->withExceptionHandling();

        openSchedule();

        $cr = create(CourseRequest::class);

        $this
            ->signIn($cr->request->user)
            ->delete("/requests/{$cr->request->id}")
            ->assertStatus(403)
        ;
    }
}
