<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\ClearsCache;
use Stripe\Stripe;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, ClearsCache;

    protected $secret;

    protected $stripeClient;

    protected function setUp() : void {
        parent::setUp();

        // \Log::channel('single')->info('Something happened!');

        $this->stripeClient = app()->make(\Stripe\StripeClient::class);

        $this->secret = env('STRIPE_SECRET');

        Stripe::setApiKey($this->secret);
    }
}
