<?php

namespace App\Services;

use App\Models\User;
use App\Services\Traits\HasStripeRequestHook;
use App\DataTransferObject\PaymentMethodData;

class SubscriptionService {

    public function subscribe(
        User $user, 
        string $productName, 
        string $priceName,
        PaymentMethodData $paymentMethodData,
        int $quantity = null
    ) : void {
        $user->newSubscription($productName, $priceName)
            ->quantity($quantity)
            ->create($paymentMethodData->paymentIntent);
    }
}