<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Stripe\StripeClient;

class DatabaseSeeder extends Seeder
{
    private $stripe;

    public function __construct(StripeClient $stripeClient) {
        $this->stripe = $stripeClient;
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {        
        $products = [];

        $this->stripe->products->create([
            'id' => 'product_writing_service',
            'name' => 'rocketcontent.io - Contnet Writing Service.',
        ]);

        $this->stripe->plans->create([
            'id' => 'price_writing_service_annual',
            'amount' => 10,
            'currency' => 'usd',
            'interval' => 'month',
            'product' => 'product_writing_service',
            'billing_scheme' => 'per_unit'
          ]);

          $this->stripe->plans->create([
            'id' => 'price_writing_service_monthly',
            'amount' => 11,
            'currency' => 'usd',
            'interval' => 'month',
            'product' => 'product_writing_service',
            'billing_scheme' => 'per_unit'
          ]);
    }
}
