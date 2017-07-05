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
        openSchedule();

        $user = make('App\User');
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
        openSchedule();

        $user = make('App\User');
        $user->student_id = '900000001';
        $user->save();

        $this
            ->signIn($user)
            ->get('/requests/create')
            ->assertStatus(200)
            ->assertSessionHas('plans', [
                ['Major' => 'Marketing'],
                ['Minor' => 'Minor in Finance-Ins/Re'],
            ])
        ;
    }

    public function test_saves_to_database()
    {
        openSchedule();

        $user = make('App\User');
        $user->student_id = '900000001';
        $user->save();

        $this->assertEmpty($user->plans()->get());

        $this
            ->signIn($user)
            ->get('/requests/create')
            ->assertStatus(200)
        ;

        $this->assertDatabaseHas('plans', [
            'user_id' => $user->id,
            'type' => 'Major',
            'name' => 'Marketing',
        ]);

        $this->assertDatabaseHas('plans', [
            'user_id' => $user->id,
            'type' => 'Minor',
            'name' => 'Minor in Finance-Ins/Re',
        ]);

        $this->assertNotEmpty($user->plans()->get());

        // empty session to make sure it pulls from db
        session()->forget('plans');
        $this
            ->get('/')
            ->assertSessionMissing('plans')
        ;

        $this
            ->get('/requests/create')
            ->assertStatus(200)
            ->assertSessionHas('plans', [
                ['Major' => 'Marketing'],
                ['Minor' => 'Minor in Finance-Ins/Re'],
            ])
        ;
    }
}
