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
        $semester = new Semester('Fall', random_int( 2010, 2022 ));
        $data = [
            'term' => $semester->term(),
            'year' => $semester->year(),
            'start' => (string)(new Carbon)->subMonth(),
            'finish' => (string)(new Carbon)->addMonth(),
        ];

        $response = $this
            ->withServerVariables(['entitlement' => 'admin'])
            ->signIn()
            ->post('/schedules', $data);

        $response->assertStatus(302);

        $this->assertDatabaseHas('schedules', [
            'strm' => (string)$semester,
            'start' => $data['start'],
            'finish' => $data['finish'],
        ]);

        $this->get($response->headers->get('Location'))
            ->assertSee((string)$semester)
            ->assertSee($data['start'])
            ->assertSee($data['finish']);
    }
}
