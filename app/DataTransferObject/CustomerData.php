<?php

namespace App\DataTransferObject;

use Spatie\DataTransferObject\DataTransferObject;

class CustomerData extends DataTransferObject
{
    public string $firstName;

    public string $lastName;

    public string $email;

    public string $companyName;
    
    public string $password;

    public SubscriptionData $subscriptionData;
}