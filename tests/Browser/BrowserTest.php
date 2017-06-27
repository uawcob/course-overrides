<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Course;

class BrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_anonymous_welcome()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Override')
                    ->assertSee('Login')
                    ->assertDontSee('Classes')
                    ->assertDontSee('Cart')
                    ->assertDontSee('Admin')
            ;
        });
    }

    public function test_user_adds_and_removes_course_from_cart()
    {
        $this->browse(function (Browser $browser) {

            $user = create(User::class);
            $course = create(Course::class);

            $browser->loginAs($user)
                    ->visit('/')
                    ->assertSee('Logout '.$user->name)
                    ->assertSee('Classes')
                    ->assertSee('Cart')
                    ->assertDontSee('Admin')
                    ->clickLink('Cart')
                    ->whenAvailable('#courses-table_wrapper', function($datatable){
                        $datatable->assertSee('No data available in table');
                    })
                    ->clickLink('Classes')
                    ->whenAvailable('#courses-table_wrapper', function($datatable)use($course){
                        $datatable
                            ->assertSee($course->code)
                            ->press('Add')
                            ->waitUntilMissing('.btn-cart', 1)
                            ->assertDontSee($course->code)
                        ;
                    })
                    ->clickLink('Cart')
                    ->whenAvailable('#courses-table_wrapper', function($datatable)use($course){
                        $datatable
                            ->assertSee($course->code)
                            ->press('Remove')
                            ->waitUntilMissing('.btn-cart', 1)
                            ->assertDontSee($course->code)
                        ;
                    })
                    ->clickLink('Cart')
                    ->whenAvailable('#courses-table_wrapper', function($datatable){
                        $datatable->assertSee('No data available in table');
                    })
            ;
        });
    }

    public function test_user_can_see_plans()
    {
        $this->browse(function (Browser $browser) {

            $user = make(User::class);
            $user->student_id = '900000005';
            $user->save();

            $browser->loginAs($user)
                    ->visit('/requests')
                    ->assertSee("Accounting")
                    ->assertSee("Minor in Finance-Bank/Fin")
                    ->assertSee("Political Science")
            ;
        });
    }
}
