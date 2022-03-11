<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Collection;
use App\Events\PaymentMethodAdded;
use App\Events\PaymentMethodUpdated;
use App\Events\PaymentMethodDeleted;
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
            'payment_method' => $customerFactory->getpaymentMethodIdToken()
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

        $this->assertSame($user->getPaymentMethods()->count(), 2);

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

    /** @test */
    public function deletes_backup_payment_method()
    {
        Event::fake();

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);

        $user = $customerFactory->create();

        $event = new PaymentMethodAdded($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $customerFactory->attachTestPaymentMethod();

        $event = new PaymentMethodAdded($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $backupPm = $this->findNewestPaymentMethod($user->getPaymentMethods());

        $response = $this->actingAs($user)->post(route('customer.payment-method.delete'), [
            'payment_method' => $backupPm['id']
        ]);

        $event = new PaymentMethodDeleted($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $this->assertNotContains($backupPm, $user->getPaymentMethods());

        $customerFactory->destroy();
    }

    /** @test */
    public function throws_an_error_on_an_attempt_to_delete_a_default_payment_method()
    {
        Event::fake();

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);

        $user = $customerFactory->create();

        $event = new PaymentMethodAdded($user);
        (new UpdatePaymentMethodCache())->handle($event);
        
        $paymentMethodsBeforeTheAttempt = $user->getPaymentMethods();
        $pm = $user->getPaymentMethods()[0];

        $response = $this->actingAs($user)->post(route('customer.payment-method.delete'), [
            'payment_method' => $pm['id']
        ]);

        $response->assertSessionHasErrors('cannot_delete_default_payment_method');
        
        // This event will not be actually trigerred if everything works properly
        // But we want to make sure that the payment method was not actually deleted
        // so we update the cache to later check user's payment methods.
        $event = new PaymentMethodDeleted($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $this->assertEquals($paymentMethodsBeforeTheAttempt, $user->getPaymentMethods());

        $customerFactory->destroy();
    }

    /** @test */
    public function updates_backup_payment_method()
    {
        Event::fake();

        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);

        $user = $customerFactory->create();

        $event = new PaymentMethodAdded($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $customerFactory->attachTestPaymentMethod();

        $event = new PaymentMethodAdded($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $backupPm = $this->findNewestPaymentMethod($user->getPaymentMethods());

        $dataToBeUpdated = [
            'payment_method' => $backupPm['id'],
            'cardholder_name' => 'Dr. Jackson Smith The Second',
            'expiration_month' => 12,
            'expiration_year' => 2026
        ];

        $response = $this->actingAs($user)->patch(route('customer.payment-method.update'), $dataToBeUpdated);

        $response = $this->followRedirects($response);
        
        $response->assertStatus(200);

        $event = new PaymentMethodUpdated($user);
        (new UpdatePaymentMethodCache())->handle($event);

        $updatedPm = collect($this->findNewestPaymentMethod($user->getPaymentMethods()))
                        ->only( ['id', 'name', 'exp_month', 'exp_year'] )
                        ->toArray();

        $this->assertEquals([
            'id' => $dataToBeUpdated['payment_method'],
            'exp_month' => $dataToBeUpdated['expiration_month'],
            'exp_year' => $dataToBeUpdated['expiration_year'],
            'name' => $dataToBeUpdated['cardholder_name']
        ], $updatedPm);

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
