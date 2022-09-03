<?php

namespace Tests\Feature;

use App\Events\PaymentMethodAdded;
use App\Events\PaymentMethodUpdated;
use App\Events\PaymentMethodDeleted;
use App\Events\DefaultPaymentMethodUpdated;
use App\Listeners\UpdatePaymentMethodCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    /** @test */
    public function subscription_cancels()
    {
        Event::fake();

        $testClock = \Stripe\TestHelpers\TestClock::create(['frozen_time' => strtotime('+1 month'), 'name' => 'Monthly renewal']);

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);
        $customerFactory->addParameters(stripeOptions: ['test_clock' => $testClock['id']]);
        $user = $customerFactory->create();

        $response = $this->actingAs($user)
            ->post(route('customer.subscription.cancel'))
            ->assertSessionHasNoErrors();
        
        sleep(10);
        
        $subscriptions = $this->stripeClient->subscriptions->all(['limit' => 3, 'customer' => $user->stripe_id, 'status' => 'active']);

        $this->assertSame($user->isSubscribing(), True);

        $this->assertEquals(count($subscriptions), 1);

        $this->stripeClient->testHelpers->testClocks->advance($testClock['id'], ['frozen_time' => strtotime('+2 month +1 hour')]);

        // Stripe needs a few seconds before they fully process new invoices.
        sleep(10);

        $this->stripeClient->testHelpers->testClocks->advance($testClock['id'], ['frozen_time' => strtotime('+2 month +2 hour')]);

        sleep(20);

        $subscriptions = $this->stripeClient->subscriptions->all(['limit' => 3, 'customer' => $user->stripe_id, 'status' => 'canceled']);

        $this->assertEquals(count($subscriptions), 1);
        
        $user->refresh();
        $this->assertSame($user->isSubscribing(), False);

        $customerFactory->destroy();
    }


    /** @test */
    public function subscription_renews_upon_next_billing_cycle()
    {
        Event::fake();

        $testClock = \Stripe\TestHelpers\TestClock::create(['frozen_time' => strtotime('+1 month'), 'name' => 'Monthly renewal']);

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);
        $customerFactory->addParameters(stripeOptions: ['test_clock' => $testClock['id']]);
        $user = $customerFactory->create();

        $event = new PaymentMethodAdded($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $this->stripeClient->testHelpers->testClocks->advance($testClock['id'], ['frozen_time' => strtotime('+2 month +1 hour')]);

        // Stripe needs a few seconds before they fully process new invoices.
        sleep(10);

        $this->stripeClient->testHelpers->testClocks->advance($testClock['id'], ['frozen_time' => strtotime('+2 month +2 hour')]);

        sleep(20);
        
        $invoices = $this->stripeClient->invoices->all([
            'customer' => $user->stripe_id,
            'limit' => 3
        ])['data'];


        $this->assertEquals(count($invoices), 2);

        foreach($invoices as $invoice) {
            $this->assertEquals($invoice['paid'], True);
        }

        $this->assertSame($user->isSubscribing(), True);

        $customerFactory->destroy();
    }

    /** @test */
    public function subscription_is_canceled_if_payment_method_does_not_work_anymore_upon_next_billing_cycle()
    {
        Event::fake();

        $testClock = \Stripe\TestHelpers\TestClock::create(['frozen_time' => strtotime('+1 month'), 'name' => 'Monthly renewal']);

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);
        $customerFactory->addParameters(stripeOptions: ['test_clock' => $testClock['id']]);
        $user = $customerFactory->create();

        $event = new PaymentMethodAdded($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $customerFactory->attachTestPaymentMethod('broken');

        $event = new PaymentMethodAdded($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $newestPaymentMethod = $this->findNewestPaymentMethod($user->getPaymentMethods());

        $response = $this->actingAs($user)->post(route('customer.payment-method.set-default'), [
            'payment_method' => $newestPaymentMethod['id']
        ]);

        $event = new DefaultPaymentMethodUpdated($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $backupPm = $this->findOldestPaymentMethod($user->getPaymentMethods());

        $response = $this->actingAs($user)->post(route('customer.payment-method.delete'), [
            'payment_method' => $backupPm['id']
        ]);

        $event = new PaymentMethodDeleted($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $this->stripeClient->testHelpers->testClocks->advance($testClock['id'], ['frozen_time' => strtotime('+2 month +1 hour')]);

        // Stripe needs a few seconds before they fully process new invoices.
        sleep(10);

        // For some reason the test clock needs to be advanced for 2nd time to allow Stripe process everything correctly
        $this->stripeClient->testHelpers->testClocks->advance($testClock['id'], ['frozen_time' => strtotime('+2 month +2 hour')]);

        sleep(20);

        $invoices = $this->stripeClient->invoices->all([
            'customer' => $user->stripe_id,
            'limit' => 3
        ])['data'];

        $this->assertEquals(count($invoices), 2);

        // 1st month invoice
        $this->assertEquals($invoices[1]['paid'], True);

        // 2nd month invoice
        $this->assertEquals($invoices[0]['paid'], False);

        $this->assertSame($user->isSubscribing(), False);

        $subscriptions = $this->stripeClient->subscriptions->all(['limit' => 3, 'customer' => $user->stripe_id, 'status' => 'canceled'])['data'];

        $this->assertEquals(count($subscriptions), 1);

        $customerFactory->destroy();
    }

    private function findOldestPaymentMethod(Collection $paymentMethods)
    {
        return $paymentMethods->firstWhere('created_at', $paymentMethods->min('created_at'));
    }

    private function findNewestPaymentMethod(Collection $paymentMethods)
    {
        return $paymentMethods->firstWhere('created_at', $paymentMethods->max('created_at'));
    }
}
