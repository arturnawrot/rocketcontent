<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;

class StripeTest extends TestCase
{
    /** @test */
    public function synchronizes_local_updates_to_stripe()
    {
        // Event::fake();

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);
        $user = $customerFactory->create();

        $oldEmail = $user->email;

        $this->assertEquals(\Stripe\Customer::retrieve($user->stripe_id)->email, $oldEmail);

        $user->email = 'anotherEmail2000@gmail.com';
        $user->save();

        // $user->syncStripeCustomerDetails();

        $newEmail = $user->email;

        $this->assertEquals(\Stripe\Customer::retrieve($user->stripe_id)->email, $newEmail);

        $customerFactory->destroy();
    }
}
