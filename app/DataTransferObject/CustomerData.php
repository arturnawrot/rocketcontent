<?php

namespace App\DataTransferObject;

use Spatie\DataTransferObject\DataTransferObject;

class CustomerData extends DataTransferObject
{
    public UserData $userData;

    public string $paymentIntent;

    public SubscriptionData $subscriptionData;
}