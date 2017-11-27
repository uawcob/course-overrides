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

class DragDropTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        Cache::flush();
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
                            ->waitFor("#btn-cart-add-$course1->id.btn-cart-remove")

                            ->assertSee($course2->section)
                            ->press("#btn-cart-add-{$course2->id}")
                            ->waitFor("#btn-cart-add-$course2->id.btn-cart-remove")
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
