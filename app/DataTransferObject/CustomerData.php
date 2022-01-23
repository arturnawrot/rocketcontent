<?php

namespace App\DataTransferObject;

use Spatie\DataTransferObject\DataTransferObject;

class CustomerData extends DataTransferObject
{
    public UserData $userData;

    public PaymentMethodData $paymentMethodData;

    public SubscriptionData $subscriptionData;
}