<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlansTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_gets_plans()
    {
        $user = create('App\User');
        $user->student_id = '900000001';
        $user->save();

        $this
            ->signIn($user)
            ->get('/plans')
            ->assertStatus(200)
            ->assertJson([
                ['Major' => 'Marketing'],
                ['Minor' => 'Minor in Finance-Ins/Re'],
            ])
        ;
    }

    public function test_saves_to_session()
    {
        $user = create('App\User');
        $user->student_id = '900000001';
        $user->save();

        $this
            ->signIn($user)
            ->get('/requests')
            ->assertStatus(200)
            ->assertSessionHas('plans', [
                ['Major' => 'Marketing'],
                ['Minor' => 'Minor in Finance-Ins/Re'],
            ])
        ;
    }
}
