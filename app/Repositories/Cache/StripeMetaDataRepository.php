<?php

namespace App\Repositories\Cache;

use Illuminate\Support\Collection;
use App\Models\User;
use \Cache;

class StripeMetaDataRepository
{
    private const EXPIRY_SECONDS = 3600;

    public static function getStripeSubscriptionObject(User $user) : \Stripe\Subscription {
        return Cache::remember("stripe_meta.subscription_id.{$user->id}", self::EXPIRY_SECONDS, function() use ($user) {
            return $user->subscription( $user->getSubscriptionStripeId() )->asStripeSubscription();
        });
    }

    public static function updatePaymentMethods(User $user) : void
    {
        Cache::forget("stripe_meta.subscription_id.{$user->id}");

        self::getStripeSubscriptionObject($user);
    }
}