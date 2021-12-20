<?php

namespace App\Services;

use App\Models\User;

class SubscriptionService {

    public function updatePaymentMethod(User $user, string $paymentIntent) : void {
        $user->addPaymentMethod($paymentIntent);
        $user->updateDefaultPaymentMethod($paymentIntent);
    }

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