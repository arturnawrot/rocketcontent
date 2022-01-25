<?php

namespace App\Services;

use App\Models\User;
use App\Services\Traits\HasStripeRequestHook;

class PaymentService
{
    public function setDefaultPaymentMethod(User $user, string $paymentIntent) {
        $user->updateDefaultPaymentMethod($paymentIntent);
    }

    // $deleteUserOnFail should be true only during the customer's registration process.
    // Laravel Cashier module is made that way that a user must be first created and saved before 
    // adding the payment method and charging them. In case if for some reason the payment fails
    // the user record must be removed from database, so the customer can fill out the same data
    // in the reigstration form during another attempt. Otherwise they will receive a duplicate entry error.
    public function addPaymentMethod(User $user, string $paymentIntent) {
        $user->addPaymentMethod($paymentIntent);
    }
}