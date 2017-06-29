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

            $user = create(User::class, ['student_id' => '900000005']);

            $browser->loginAs($user)
                    ->visit('/requests')
                    ->assertSee("Accounting")
                    ->assertSee("Minor in Finance-Bank/Fin")
                    ->assertSee("Political Science")
            ;
        });
    }

    public function test_drag_drop_course_priority()
    {
        $this->browse(function (Browser $browser) {

            $class = 'ECON2013';
            $course1 = create(Course::class, [
                'code' => $class,
                'section' => '001',
            ]);
            $course2 = create(Course::class, [
                'code' => $class,
                'section' => '002',
            ]);

            $browser->loginAs(create(User::class))
                    ->visit('/courses')
                    ->whenAvailable('#courses-table_wrapper', function ($datatable) use ($course1, $course2) {
                        $datatable
                            ->assertSee($course1->section)
                            ->press("#btn-cart-add-{$course1->id}")
                            ->waitUntilMissing("#btn-cart-add-{$course1->id}", 1)
                            ->assertDontSee($course1->section)

                            ->assertSee($course2->section)
                            ->press("#btn-cart-add-{$course2->id}")
                            ->waitUntilMissing("#btn-cart-add-{$course2->id}", 1)
                            ->assertDontSee($course2->section)
                        ;
                    })
                    ->visit('/requests/create')
                    ->assertInputValue('id[1]', $course1->id)
                    ->assertInputValue('id[2]', $course2->id)
                    ->drag("#btn-priority-course-{$course1->id}", "#btn-priority-course-{$course2->id}")
                    ->assertInputValue('id[1]', $course2->id)
                    ->assertInputValue('id[2]', $course1->id)
            ;
        });
    }
}
