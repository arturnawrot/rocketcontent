<?php

namespace App\Listeners;

use App\Events\PaymentMethodAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\Cache\PaymentMethodRepository;
use \Cache;

class UpdatePaymentMethodCache
{


    /**
     * Handle the event.
     *
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(PaymentMethodAdded $event)
    {
        $customer = $event->customer;
        
        PaymentMethodRepository::updatePaymentMethods($customer);
    }
}
