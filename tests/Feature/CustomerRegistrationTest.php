<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Symfony\Component\Process\Process;
use App\Models\User;
use Tests\TestCase;
use Stripe\Customer;
use Stripe\Stripe;
use App\Events\UserCreated;

class CustomerRegistrationTest extends TestCase
{

    protected $user;

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
    public function registers()
    {
        Event::fake();

        $data = \Stripe\Token::create([
            'card' => [
                "number" => "4242424242424242",
                "exp_month" => 11,
                "exp_year" => 2025,
                "cvc" => "314",
                "address_zip" => "30809"
            ]
        ]);

        $token = $data['id'];

        $response = $this->post(route('customer.register.request'), [
            'name' => 'John Smith',
            'email' => 'johnsmith@gmail.com',
            'password' => '1234511',
            'payment_method' => $token,
            'recurring_type' => 'monthly',
            'wordCount' => '4000'
        ]);

        $this->user = User::Where('email', 'johnsmith@gmail.com')->first();

        $response->assertSee('John Smith');
        $response->assertSee('14 Days Remaining');

        Event::assertDispatched(UserCreated::class);
    }

    /** @group failing */
    /** @test */
    public function throws_an_error_on_invalid_payment_data()
    {
        Event::fake();

        // Completely invalid, non-existing payment method.
        $response = $this->post(route('customer.register.request'), [
            'name' => 'John Smith',
            'email' => 'john@gmail.com',
            'password' => 'foobar',
            'payment_method' => 'some_invalid_payment_intent',
            'recurring_type' => 'monthly',
            'wordCount' => 4000
        ]);

        $response->assertSessionHasErrors('invalid_request');

        $this->assertDatabaseMissing('users', [
            'email' => 'john@gmail.com'
        ]);

        // Invalid credit card

        $data = \Stripe\Token::create([
            'card' => [
                "number" => "4000000000000044",
                "exp_month" => 11,
                "exp_year" => 2025,
                "cvc" => "314",
                "address_zip" => "30809"
            ]
        ]);

        $token = $data['id'];

        $response = $this->post(route('customer.register.request'), [
            'name' => 'Jacob Thompson',
            'email' => 'JacobThompson@gmail.com',
            'password' => 'foobar',
            'payment_method' => $token,
            'recurring_type' => 'monthly',
            'wordCount' => 4000
        ]);
        
        $response->assertSessionHasErrors('invalid_request');
        // Actually it has nothing to do with 'invalid_request' type of exception
        // and I was hoping to get 'card_exception' instead since I'm providing a broken credit card
        // and the request by itself is not invalid, but unfortunately this is how Stripe works.
        // $response->assertSessionHasErrors('card_exception');

        $this->assertDatabaseMissing('users', [
            'email' => 'JacobThompson@gmail.com'
        ]);

        // @TODO assert more types of errors
    }

    protected function tearDown(): void
    {
        $this->process->stop();

        parent::tearDown();
    }
}
