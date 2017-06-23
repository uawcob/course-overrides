<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BrowserTest extends DuskTestCase
{
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
}
