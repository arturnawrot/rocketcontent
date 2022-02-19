<?php

namespace App\Services\Factories;

use App\DataTransferObject\CustomerData;
use App\DataTransferObject\UserData;
use App\DataTransferObject\PaymentMethodData;
use App\DataTransferObject\SubscriptionData;
use App\Services\Factories\DtoFactory;
use App\Services\CustomerService;
use Stripe\StripeClient;

class CustomerFactory extends DtoFactory {


    protected $serviceDestination = [
        'class' => CustomerService::class,
        'method' => 'register'
    ];

    protected function getProperties()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
            'paymentIntent' => self::getPaymentIntentToken(),
            'recurringType' => 'monthly',
            'wordCount' => 4000
        ];
    }

    protected function define() {
        return new CustomerData(
            userData: new UserData(name: $this->properties['name'], email: $this->properties['email'], password: $this->properties['password']),
            paymentMethodData: new PaymentMethodData(paymentIntent: $this->properties['paymentIntent']),
            subscriptionData: new SubscriptionData(recurringType: $this->properties['recurringType'], wordCount: $this->properties['wordCount'])
        );
    }

    public static function getPaymentIntentToken() {
        return 'pm_card_visa';
    }

    public function destroy() {
        return app()->make(CustomerService::class)->deleteCustomer($this->result);
    }
}