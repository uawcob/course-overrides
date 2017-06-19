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
}
