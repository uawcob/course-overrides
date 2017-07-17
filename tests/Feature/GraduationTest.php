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

        $user = create(User::class, ['graduation_strm' => 'Fall 2017']);

        $response = $this
            ->signIn($user)
            ->get('/graduation')
            ->assertSee('Fall 2017')
        ;
    }
}
