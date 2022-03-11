<?php

namespace App\Repositories\Cache;

use Illuminate\Support\Collection;
use App\Models\User;
use \Cache;

class PaymentMethodRepository
{
    private const EXPIRY_SECONDS = 3600;

    public static function getPaymentMethods(User $user)
    {
        return Cache::remember("payment_methods.{$user->id}", self::EXPIRY_SECONDS, function() use ($user) {
            $paymentMethods = $user->paymentMethods();

            if($paymentMethods->isEmpty()) 
                return collect([]);
            
            $paymentMethods = $paymentMethods->merge([$user->defaultPaymentMethod()]);
            $paymentMethods = self::transformPaymentMethods($paymentMethods);

            return $paymentMethods->sortByDesc('default');
        });
    }

    public static function updatePaymentMethods(User $user)
    {
        Cache::forget("payment_methods.{$user->id}");

        self::getPaymentMethods($user);
    }

    private static function transformPaymentMethods(Collection $paymentMethods)
    {
        // @TODO There's a better way to do it like array_map() or creating a seperate class.
        $newPaymentMethods = array();

        $uniquePaymentMethod = $paymentMethods->duplicates()->first();
        $paymentMethods = $paymentMethods->unique();

        foreach($paymentMethods as $paymentMethod) {
            if($paymentMethod === null)
                continue;
            
            $newPaymentMethod = array();

            $paymentMethod = $paymentMethod->toArray();

            $newPaymentMethod['default'] = false;
            
            if($uniquePaymentMethod !== null) {
                if($uniquePaymentMethod->toArray() === $paymentMethod
                    || $paymentMethods->count() === 1) {
                    $newPaymentMethod['default'] = true;
                }
            }

            $newPaymentMethod['id'] = $paymentMethod['id'];
            $newPaymentMethod['brand'] = $paymentMethod['card']['brand'];
            $newPaymentMethod['country'] = $paymentMethod['card']['country'];
            $newPaymentMethod['last4'] = $paymentMethod['card']['last4'];
            $newPaymentMethod['exp_month'] = $paymentMethod['card']['exp_month'];
            $newPaymentMethod['exp_year'] = $paymentMethod['card']['exp_year'];
            $newPaymentMethod['fingerprint'] = $paymentMethod['card']['fingerprint'];
            $newPaymentMethod['created_at'] = $paymentMethod['created'];
            $newPaymentMethod['name'] = $paymentMethod['billing_details']['name'];


            $newPaymentMethods[] = $newPaymentMethod;
        }

        return collect($newPaymentMethods);
    }
}