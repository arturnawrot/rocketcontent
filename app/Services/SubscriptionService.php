<?php

namespace App\Services;

use App\Models\User;
use App\Services\Traits\HasStripeRequestHook;

class SubscriptionService {

    public function subscribe(
        User $user, 
        string $productName, 
        string $priceName,
        string $paymentIntent,
        int $quantity = null
    ) : void {
        $user->newSubscription($productName, $priceName)
            ->quantity($quantity)
            ->create($paymentIntent);
    }
}