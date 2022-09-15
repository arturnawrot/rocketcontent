<?php

namespace App\Services\Traits;

trait StripeAPI {
    public function getStripeClient() {
        return app()->make(\Stripe\StripeClient::class);
    }
}