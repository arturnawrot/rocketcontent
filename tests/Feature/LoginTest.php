<?php

namespace Tests\Feature;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function customer_login()
    {
        Event::fake();

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);
        $customerFactory->override(array('password' => '1234511'));

        $customer = $customerFactory->create();

        $response = $this->from(route('login'))
            ->post(route('auth.login.request'), ['email' => $customer->email, 'password' => '1234511'])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('customer.dashboard.view'));
        
        $this->followRedirects($response)->assertSee($customer->name);

        $this->assertAuthenticatedAs($customer);

        $customerFactory->destroy();
    }

    /** @test */
    public function shows_error_message_on_invalid_login_credentials()
    {
        Event::fake();

        $response = $this->post(route('auth.login.request'), ['email' => '', 'password' => 'fakepassword']);

        $response->assertSessionHasErrors([
            'email' => 'The provided data is incomplete.'
        ]);

        $response = $this->post(route('auth.login.request'), ['email' => 'fakeemail@gmail.com', 'password' => 'fakepassword']);

        $response->assertSessionHasErrors([
            'email' => 'Incorrect email or password.'
        ]);
    }
}
