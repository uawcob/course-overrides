<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class GraduationTest extends TestCase
{
    use DatabaseMigrations;

    public function test_shows_graduation_strm()
    {
        openSchedule();

        $user = create(User::class, ['graduation_strm' => '1179']);

        $this
            ->signIn($user)
            ->get('/graduation')
            ->assertSee('1179')
            ->assertSee('Fall 2017')
        ;
    }

    public function test_updates_graduation_strm()
    {
        openSchedule();

        $this
            ->signIn()
            ->get('/graduation')
            ->assertDontSee('1179')
            ->assertDontSee('Fall 2017')
        ;

        $this
            ->post('/graduation', ['year' => '2017', 'term' => 'fall'])
            ->assertStatus(200)
            ->assertSee('1179')
            ->assertSee('Fall 2017')
        ;

        $this
            ->get('/graduation')
            ->assertSee('1179')
            ->assertSee('Fall 2017')
        ;
    }
}
