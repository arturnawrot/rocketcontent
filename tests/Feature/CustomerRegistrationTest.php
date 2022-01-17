<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Process\Process;
use App\Model\User;
use Tests\TestCase;
use Stripe\Customer;
use Stripe\Stripe;

class CustomerRegistrationTest extends TestCase
{

    /**
     * @var Process
     */
    private $process;

    protected function setUp(): void
    {
        parent::setUp();

        $secret = env('STRIPE_SECRET');

        $this->process = new Process(['stripe', 'listen', '--api-key', $secret, '--forward-to', sprintf('%s/stripe/webhook', env('APP_URL'))]);
        $this->process->start();

        Stripe::setApiKey($secret);
    }

    /** @test */
    // public function throws_an_error_on_invalid_payment()
    // {
    //     $response = $this->post(route('customer.register.request'), [
    //         'name' => 'John Smith',
    //         'email' => 'john@gmail.com',
    //         'password' => 'foobar',
    //         'payment_method' => 'some_invalid_payment_intent',
    //         'recurring_type' => 'monthly',
    //         'wordCount' => 4000
    //     ]);

    //     $response->assertStatus(200);
    // }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->process->stop();
    }
}
