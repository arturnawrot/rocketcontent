<?php

namespace App\Services;

use App\Models\User;
use App\Services\Traits\HasStripeRequestHook;
use App\DataTransferObject\PaymentMethodData;
use App\Events\SubscriptionCanceled;
use App\Exceptions\BusinessException;
use App\Services\Traits\StripeAPI;

class SubscriptionService {

    use StripeAPI;

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

    public static function getMinimumSubscriptionWordCount() : int {
        return (int) config('subscriptions.minimum_word_count');
    }

    public static function getMonthlySubscriptionCostPerWord() : float
    {
        return (float) config('subscriptions.monthly_plan.price');
    }

    public function changeWordCount(User $user, string $subscriptionName = 'default', int $wordCount) : void
    {
        if($wordCount < self::getMinimumSubscriptionWordCount()) {
            throw new BusinessException("Minimum word count requirement is not satisfied.");
        }

        $subscription = $user->subscription($subscriptionName);

        if($subscription->quantity < $wordCount) {
            $this->upgradeSubscription($user, $subscription, $newWordCount);
        } elseif ($subscription->quantity > $wordCount) {
            $this->downgradeSubscription();
        } else {
            throw new BusinessException("Word count must be smaller or bigger");
        }
    }

    public function upgradeSubscription(User $user, Cashier\Subscription $subscription, int $newWordCount)
    {
        if($user->remainingWordCount() > 0) {
            // create a discount object to deduct the upgrade cost since we already have some word count remaining from the old subscription
            $amount_off = ($newWordCount - $user->remainingWordCount()) * self::getMonthlySubscriptionCostPerWord();
            
            $coupon = $this->getStripeClient()->coupons->create(
                ['duration' => 'once', 'amount_off' => $amount_off * 100] // $amount_off needs to be in cents
            );
        }

        $this->getStripeClient()->subscriptions->update(
            'sub_1LfA22GAA2s7aUvA0kPa3wPy',
            ['metadata' => ['order_id' => '6735']]
        );
    }

    public function downgradeSubscription(User $user, Cashier\Subscription $subscription, int $newWordCount)
    {

    }
}