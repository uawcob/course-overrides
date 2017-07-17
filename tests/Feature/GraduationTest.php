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

        $response = $this
            ->signIn($user)
            ->get('/graduation')
            ->assertSee('1179')
            ->assertSee('Fall 2017')
        ;
    }
}