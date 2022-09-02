<?php

namespace App\Services;

use App\Models\User;
use App\Services\Traits\HasStripeRequestHook;
use App\DataTransferObject\PaymentMethodData;
use App\Events\SubscriptionCanceled;

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
            ->create($paymentMethodData->id);
    }

    public function cancel(User $user, string $subscriptionName = 'default', bool $cancelNow = False) : void {
        $subscription = $user->subscription($subscriptionName);

        if($user->isOnTrial() || $cancelNow) {
            $subscription->cancelNow();
        } else {
            // It will actually cancel at the end of the billing cycle.
            $subscription->cancel();
        }

        SubscriptionCanceled::dispatch($user);
    }
}