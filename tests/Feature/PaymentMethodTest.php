<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    /** @test */
    public function throws_an_error_on_adding_duplicate_payment_method()
    {
        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);
        $user = $customerFactory->create();

        // The first payment method was already created through the customer factory
        // Now we will create the same 2nd time. It shall fail and return an error.

        $response = $this->actingAs($user)->post(route('customer.payment-method.add'), [
            'payment_method' => $customerFactory::getPaymentIntentToken()
        ]);

        $response->assertSessionHasErrors('payment_method_already_exists_exception');
    }
}
