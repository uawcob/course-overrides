<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;
use App\Course;

class Courses extends BasePage
{
    protected $course;

    public function __construct()
    {
        $this->course = create(Course::class);
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/courses';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Add an item to the cart.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function addToCart(Browser $browser)
    {
        $browser->whenAvailable('#courses-table_wrapper', function ($datatable) {
                $datatable
                    ->assertSee($this->course->code)
                    ->press("#btn-cart-add-{$this->course->id}")
                    ->waitFor("#btn-cart-add-{$this->course->id}.btn-cart-remove")
                ;
            })
        ;
    }
}
