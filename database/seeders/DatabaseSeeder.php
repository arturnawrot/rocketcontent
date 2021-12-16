<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Stripe\StripeClient;
use App\Helpers\StripeConfig;

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
            'id' => StripeConfig::PRODUCT_NAME,
            'name' => 'rocketcontent.io - Contnet Writing Service.',
        ]);

        $this->stripe->plans->create([
            'id' => StripeConfig::ANNUAL_PLAN['name'],
            'amount' => StripeConfig::ANNUAL_PLAN['price'],
            'currency' => 'usd',
            'interval' => 'month',
            'product' => StripeConfig::PRODUCT_NAME,
            'billing_scheme' => 'per_unit'
          ]);

          $this->stripe->plans->create([
            'id' => StripeConfig::MONTHLY_PLAN['name'],
            'amount' => StripeConfig::MONTHLY_PLAN['price'],
            'currency' => 'usd',
            'interval' => 'month',
            'product' => StripeConfig::PRODUCT_NAME,
            'billing_scheme' => 'per_unit'
          ]);
    }
}
