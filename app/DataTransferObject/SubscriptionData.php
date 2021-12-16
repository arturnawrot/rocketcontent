<?php

namespace App\DataTransferObject;

use Spatie\DataTransferObject\DataTransferObject;

class SubscriptionData extends DataTransferObject
{
    public string $recurringType;

    public string $wordCount;
}