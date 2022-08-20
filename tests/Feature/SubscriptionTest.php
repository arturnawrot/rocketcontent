<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Events\PaymentMethodAdded;
use App\Listeners\UpdatePaymentMethodCache;

class SubscriptionTest extends TestCase
{
    /** @test */
    public function subscription_expires_if_payment_method_does_not_work_anymore()
    {
        Event::fake();

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);
        $user = $customerFactory->create();

        $event = new PaymentMethodAdded($user);
        (new UpdatePaymentMethodCache())->handle($event);

        \Stripe\Customer::update($user->stripe_id, []);

        $customerFactory->destroy();
    }
}
