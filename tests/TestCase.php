<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Services\Traits\StripeAPI;
use Tests\Traits\ClearsCache;
use Stripe\Stripe;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, ClearsCache, StripeAPI;

    protected $secret;

    protected $stripeClient;

    protected function setUp() : void {
        parent::setUp();

        $this->stripeClient = $this->getStripeClient();

        $this->secret = env('STRIPE_SECRET');

        Stripe::setApiKey($this->secret);
    }
}
