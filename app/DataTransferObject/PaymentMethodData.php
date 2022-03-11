<?php

namespace App\DataTransferObject;

use Spatie\DataTransferObject\DataTransferObject;

class PaymentMethodData extends DataTransferObject
{
    public string $id;

    public ?BillingDetailsData $billingDetailsData;
}