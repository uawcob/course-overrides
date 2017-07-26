<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Course;
use App\Semester;
use Cache;
use Tests\Browser\Pages\Courses;

class BrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_anonymous_welcome()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Override')
                    ->assertSee('Login')
                    ->assertDontSee('Search')
                    ->assertDontSee('Cart')
                    ->assertDontSee('Admin')
            ;
        });
    }

    public function test_user_only_sees_this_term_courses()
    {
        openSchedule();

        $this->browse(function (Browser $browser) {

            $course1 = make(Course::class);
            $course1->semester(new Semester('Spring', 2017));
            $course1->save();

            $course2 = create(Course::class);

            $user = create(User::class);

            $browser
                ->loginAs($user)
                ->visit('/courses')
                ->whenAvailable('#courses-table_wrapper', function ($datatable) use ($course1, $course2) {
                    $datatable->assertDontSee($course1->title);
                    $datatable->assertSee($course2->title);
                })
            ;
        });
    }

    public function test_user_adds_and_removes_course_from_cart()
    {
        openSchedule();

        $this->browse(function (Browser $browser) {

            $user = create(User::class);
            $course = create(Course::class);

            $browser->loginAs($user)
                    ->visit('/')
                    ->assertSee('Logout '.$user->name)
                    ->assertSee('Search')
                    ->assertSee('Cart')
                    ->assertDontSee('Admin')
                    ->clickLink('Cart')
                    ->whenAvailable('#courses-table_wrapper', function($datatable){
                        $datatable->assertSee('No data available in table');
                    })
                    ->clickLink('Search')
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
        openSchedule();

        $this->browse(function (Browser $browser) {

            $user = create(User::class, ['student_id' => '900000005']);

            $browser->loginAs($user)
                    ->visit(new Courses)
                    ->addToCart()
                    ->visit('/requests/create')
                    ->assertSee("Accounting")
                    ->assertSee("Minor in Finance-Bank/Fin")
                    ->assertSee("Political Science")
            ;
        });
    }

    public function test_drag_drop_course_priority()
    {
        openSchedule();

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

    public function test_disabled_courses_are_hidden()
    {
        openSchedule();

        $this->browse(function (Browser $browser) {

            $enabled = create(Course::class);
            $disabled = create(Course::class, ['enabled' => false]);

            $user = create(User::class);

            $browser
                ->loginAs($user)
                ->visit('/courses')
                ->whenAvailable('#courses-table_wrapper', function ($datatable) use ($enabled, $disabled) {
                    $datatable->assertSee($enabled->title);
                    $datatable->assertDontSee($disabled->title);
                })
            ;
        });
    }
}
