<?php

namespace Tests\Feature;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function login()
    {
        Event::fake();

        $userFactory = $this->app->make('App\Services\Factories\UserFactory');
        $userFactory->override(array('password' => '1234511'));
        $userFactory->setParameters(accountType: 'CUSTOMER');

        $user = $userFactory->create();

        $response = $this->from(route('login'))
            ->post(route('auth.login.request'), ['email' => $user->email, 'password' => '1234511'])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('customer.dashboard.view'));
        
        $this->followRedirects($response)->assertSee($user->name);

        $this->assertAuthenticatedAs($user);
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
