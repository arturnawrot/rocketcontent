<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Stripe\Exception\InvalidRequestException;
use Stripe\Customer;
use Stripe\Stripe;
use App\Models\User;
use Symfony\Component\Process\Process;
use Tests\Browser\Pages\RegistrationForm;
use Illuminate\Support\Facades\Event;
use App\Events\UserCreated;

class CustomerRegistrationTest extends DuskTestCase
{
    /**
     * @var Process
     */
    private $process;

    /**
     * @var User
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $secret = env('STRIPE_SECRET');

        $this->process = new Process(['stripe', 'listen', '--api-key', $secret, '--forward-to', sprintf('%s/stripe/webhook', env('APP_URL'))]);
        $this->process->start();

        Stripe::setApiKey($secret);
    }

    public function testCustomerRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegistrationForm)->pause(5000)
                    ->assertSee('Register')
                    ->enterName('John Smith')
                    ->enterEmail('johnsmith@gmail.com')
                    ->enterPassword('1234511')
                    ->enterNameOnCreditCard('John Smith')
                    ->enterValidCreditCard()
                    ->submit()
                    ->assertSee('14 Days Remaining');

            $this->user = User::Where('email', 'johnsmith@gmail.com')->first();
        });
    }

    protected function tearDown(): void
    {
        $this->process->stop();

        if ($this->user instanceof User) {
            try {
                (new Customer($this->user->stripe_id))->delete();
                $this->app->make(\App\Services\UserService::class)->delete($this->user);
            } catch (InvalidRequestException $exception) {
            }
        }

        $this->user = null;

        parent::tearDown();
    }
}
