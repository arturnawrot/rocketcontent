<?php

namespace App\DataTransferObject;

use Spatie\DataTransferObject\DataTransferObject;

class BillingDetailsData extends DataTransferObject
{
    public string $cardholderName;

    public int $expirationMonth;

    public int $expirationYear;
}