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

    public function test_can_view_intended_plans_index()
    {
        $iplans = create(IntendedPlan::class, [], 10);

        openSchedule();

        $response = $this
            ->signIn()
            ->get('/intended-plans')
        ;

        foreach ($iplans as $iplan) {
            $response->assertSee($iplan->name);
        }
    }

    public function test_can_generate_select_options()
    {
        IntendedPlan::create([
            'name' => 'Economics—Business Economics',
            'category' => 'Majors',
        ]);
        IntendedPlan::create([
            'name' => 'Finance—Investments/Banking',
            'category' => 'Minors for Business Majors',
        ]);
        IntendedPlan::create([
            'name' => 'Information Systems',
            'category' => 'Minors for Non-Business Majors',
        ]);
        IntendedPlan::create([
            'name' => 'Economics—International ECON and Business',
            'category' => 'Majors',
        ]);
        IntendedPlan::create([
            'name' => 'Finance—Real Estate/Insurance',
            'category' => 'Minors for Business Majors',
        ]);
        IntendedPlan::create([
            'name' => 'Enterprise Systems',
            'category' => 'Minors for Non-Business Majors',
        ]);

        $options = <<<OPTIONS
<optgroup label="Majors">
        <option value="1">Economics—Business Economics</option>
        <option value="4">Economics—International ECON and Business</option>
    </optgroup>
<optgroup label="Minors for Business Majors">
        <option value="2">Finance—Investments/Banking</option>
        <option value="5">Finance—Real Estate/Insurance</option>
    </optgroup>
<optgroup label="Minors for Non-Business Majors">
        <option value="3">Information Systems</option>
        <option value="6">Enterprise Systems</option>
    </optgroup>

OPTIONS;

        openSchedule();
        $this->signIn();

        $this
            ->get('/intended-plans/options')
            ->assertSee($options)
        ;
    }
}
