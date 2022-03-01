<?php

namespace App\Listeners;

use App\Events\PaymentMethodAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\Cache\PaymentMethodRepository;
use \Cache;

class UpdatePaymentMethodCache
{
    public function handle($event)
    {
        $customer = $event->customer;
        
        PaymentMethodRepository::updatePaymentMethods($customer);
    }
}
