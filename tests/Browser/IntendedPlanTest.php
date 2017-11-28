<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Course;
use App\IntendedPlan;
use Cache;
use Tests\Browser\Pages\Courses;

class IntendedPlanTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_can_add_and_remove_intended_plans()
    {
        create(IntendedPlan::class, [], 10);
        $iplan = create(IntendedPlan::class);

        openSchedule();
        $this->browse(function (Browser $browser) use ($iplan) {
            $course = create(Course::class);
            $browser->loginAs(create(User::class))
                    ->visit('/courses')
                    ->whenAvailable('#courses-table_wrapper', function ($datatable) use ($course) {
                        $datatable
                            ->press("#btn-cart-add-{$course->id}")
                            ->waitFor("#btn-cart-add-$course->id.btn-cart-remove")
                        ;
                    })
                    ->visit('/requests/create')
                    ->assertPathIs('/requests/create')
                    ->assertVisible('#sel-intended-plans')
                    ->select('sel-intended-plans', $iplan->id)
                    ->press('#btn-add-intended-plan')
                    ->waitFor('#ul-intended-plans li')
                    ->assertSeeIn('#ul-intended-plans', $iplan->name)
                    ->press("#btn-del-iplan-{$iplan->id}")
                    ->waitUntilMissing("#btn-del-iplan-{$iplan->id}")
                    ->assertDontSeeIn('#ul-intended-plans', $iplan->name)
            ;
        });
    }
}
