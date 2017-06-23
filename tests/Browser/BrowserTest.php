<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

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

    public function test_user_cannot_see_admin()
    {
        $this->browse(function (Browser $browser) {
            $user = create(User::class);
            $browser->loginAs($user)
                    ->visit('/')
                    ->assertSee('Logout '.$user->name)
                    ->assertSee('Classes')
                    ->assertSee('Cart')
                    ->assertDontSee('Admin')
            ;
        });
    }
}
