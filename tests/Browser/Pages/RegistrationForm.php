<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class RegistrationForm extends Page
{
    public function url()
    {
        return '/register';
    }

    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    public function enterName(Browser $browser, string $name)
    {
        $browser->type('name', $name);
    }

    public function enterEmail(Browser $browser, string $email)
    {
        $browser->type('email', $email);
    }

    public function enterPassword(Browser $browser, string $password)
    {
        $browser->type('password', $password);
    }

    public function enterNameOnCreditCard(Browser $browser, string $name)
    {
        $browser->type('#card-holder-name', $name);
    }

    public function enterValidCreditCard(Browser $browser)
    {
        $browser->withinFrame('.__PrivateStripeElement iframe', function ($browser) {
                $browser
                    ->type('[placeholder="Card number"]', '4242424242424242')
                    ->type('[placeholder="CVC"]', '123')
                    ->type('[placeholder="MM / YY"]', '1224')
                    ->type('[placeholder="ZIP"]', '10006');
        });
    }

    public function submit(Browser $browser)
    {
        $browser->press('#loginButton')
                ->pause(10000);
    }
}