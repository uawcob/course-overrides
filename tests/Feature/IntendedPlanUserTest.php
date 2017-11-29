<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\IntendedPlan;
use App\User;

class IntendedPlanUserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_can_add_and_delete_intended_plan()
    {
        openSchedule();
        $this->signIn();

        $iplan = create(IntendedPlan::class);

        $this
            ->get('/my/intended-plans')
            ->assertJsonMissing([['id' => $iplan->id]])
        ;

        $this
            ->post("/my/intended-plans/{$iplan->id}")
            ->assertStatus(201)
        ;

        $this
            ->get('/my/intended-plans')
            ->assertJson([['id' => $iplan->id]])
        ;

        $this
            ->delete("/my/intended-plans/{$iplan->id}")
            ->assertStatus(204)
        ;

        $this
            ->get('/my/intended-plans')
            ->assertJsonMissing([['id' => $iplan->id]])
        ;
    }

    public function test_user_cannot_add_duplicate_intended_plan()
    {
        $iplan = create(IntendedPlan::class);
        openSchedule();
        $this->signIn();

        $this
            ->get('/my/intended-plans')
            ->assertExactJson([])
        ;

        $this
            ->post("/my/intended-plans/{$iplan->id}")
            ->assertStatus(201)
        ;

        $this
            ->post("/my/intended-plans/{$iplan->id}")
            ->assertStatus(201)
        ;

        $result = $this
            ->get('/my/intended-plans')
            ->decodeResponseJson()
        ;

        $this->assertCount(1, $result);
    }
}
