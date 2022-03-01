<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Collection;
use App\Events\PaymentMethodAdded;
use App\Events\DefaultPaymentMethodUpdated;
use App\Listeners\UpdatePaymentMethodCache;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    /** @test */
    public function throws_an_error_on_adding_duplicate_payment_method()
    {
        Event::fake();

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);
        $user = $customerFactory->create();

        $event = new PaymentMethodAdded($user);
        (new UpdatePaymentMethodCache())->handle($event);

        // The first payment method was already created through the customer factory
        // Now we will create the same 2nd time. It shall fail and return an error.

        $response = $this->actingAs($user)->post(route('customer.payment-method.add'), [
            'payment_method' => $customerFactory->getPaymentIntentToken()
        ]);

        $response->assertSessionHasErrors('payment_method_already_exists_exception');

        $customerFactory->destroy();
    }

    /** @test */
    public function sets_a_different_card_as_the_default_payment_method()
    {
        Event::fake();

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);

        $user = $customerFactory->create();

        $event = new PaymentMethodAdded($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $customerFactory->attachTestPaymentMethod();

        $event = new PaymentMethodAdded($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $this->assertSame(count($user->getPaymentMethods()), 2);

        $oldestPaymentMethod = $this->findOldestPaymentMethod($user->getPaymentMethods());
        $newestPaymentMethod = $this->findNewestPaymentMethod($user->getPaymentMethods());

        $this->assertSame($oldestPaymentMethod['default'], true);
        $this->assertSame($newestPaymentMethod['default'], false);

        $response = $this->actingAs($user)->post(route('customer.payment-method.set-default'), [
            'payment_method' => $newestPaymentMethod['id']
        ]);

        $event = new DefaultPaymentMethodUpdated($user);
        (new UpdatePaymentMethodCache())->handle($event);


        $this->assertSame($this->findOldestPaymentMethod($user->getPaymentMethods())['default'], false);
        $this->assertSame($this->findNewestPaymentMethod($user->getPaymentMethods())['default'], true);

        $customerFactory->destroy();
    }

    private function findOldestPaymentMethod($paymentMethods)
    {
        $counts = array_column($paymentMethods, 'created_at');
        $index = array_search(min($counts), $counts, true);

        return $paymentMethods[$index];
    }

    private function findNewestPaymentMethod($paymentMethods)
    {
        $counts = array_column($paymentMethods, 'created_at');
        $index = array_search(max($counts), $counts, true);

        return $paymentMethods[$index];
    }
}
