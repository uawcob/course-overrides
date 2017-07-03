<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\{
    User,
    Semester
};
use Carbon\Carbon;

class ScheduleTest extends TestCase
{
    use DatabaseMigrations;

    public function test_creates_schedule()
    {
        $start = (new Carbon)->subMonth();
        $finish = (new Carbon)->addMonth();
        $semester = new Semester('Fall', random_int( 2010, 2022 ));

        $data = [
            'term' => $semester->term(),
            'year' => $semester->year(),
            'start' => (string) $start->timezone('America/Chicago'),
            'finish' => (string) $finish->timezone('America/Chicago'),
        ];

        $response = $this
            ->withServerVariables(['entitlement' => 'admin'])
            ->signIn()
            ->post('/schedules', $data);

        $response->assertStatus(302);

        $this->assertDatabaseHas('schedules', [
            'strm' => (string)$semester,
            'start' => (string) $start->timezone('UTC'),
            'finish' => (string) $finish->timezone('UTC'),
        ]);

        $this->get($response->headers->get('Location'))
            ->assertSee($semester->canonical())
            ->assertSee($start->timezone('America/Chicago')->format('l, F jS Y, h:i:s A'))
            ->assertSee($finish->timezone('America/Chicago')->format('l, F jS Y, h:i:s A'));
    }
}
