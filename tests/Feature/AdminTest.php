<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_cannot_view_create_admin_page()
    {
        $this->withExceptionHandling();

        $this
            ->signIn()
            ->get('/admin')
            ->assertStatus(403)
        ;
    }

    public function test_admin_can_view_create_admin_page()
    {
        $this
            ->withServerVariables(['entitlement' => 'admin'])
            ->signIn()
            ->get('/admin')
            ->assertStatus(200)
        ;
    }
}
