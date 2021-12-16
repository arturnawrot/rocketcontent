<?php

namespace App\Helpers;

class StripeConfig {

    public const PRODUCT_NAME = 'product_writing_service';

    public const ANNUAL_PLAN = [
        'name' => 'price_writing_service_annual',
        'price' => 10 
    ];

    public const MONTHLY_PLAN = [
        'name' => 'price_writing_service_monthly',
        'price' => 11
    ];

}