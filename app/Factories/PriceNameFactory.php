<?php

namespace App\Factories;

use App\Helpers\StripeConfig;

class PriceNameFactory {
    public static function get(string $recurringType) : string {
        switch($recurringType) {
            case 'monthly':
                return StripeConfig::MONTHLY_PLAN['name'];
                break;
            case 'annual':
                return StripeConfig::ANNUAL_PLAN['name'];
                break;
        }
    }
}