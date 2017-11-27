<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\IntendedPlan;

class IntendedPlanTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_cannot_create_intended_plan()
    {
        $this->withExceptionHandling();

        openSchedule();

        $iplan = make(IntendedPlan::class);

        $this
            ->signIn()
            ->post('/intended-plans', $iplan->toArray())
            ->assertStatus(403)
        ;
    }

    public function test_admin_can_create_intended_plan()
    {
        $iplan = make(IntendedPlan::class);

        $response = $this
            ->signInAdmin()
            ->post('/intended-plans', $iplan->toArray())
        ;

        $response->assertStatus(302);

        $this->get($response->headers->get('Location'))
            ->assertSee($iplan->name)
        ;
    }
}
