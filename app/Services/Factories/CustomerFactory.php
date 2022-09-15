<?php

namespace App\Services\Factories;

use App\DataTransferObject\CustomerData;
use App\DataTransferObject\UserData;
use App\DataTransferObject\PaymentMethodData;
use App\DataTransferObject\SubscriptionData;
use App\Services\Factories\DtoFactory;
use App\Services\CustomerService;
use App\Services\PaymentService;
use App\Models\User;
use Stripe\StripeClient;

class CustomerFactory extends DtoFactory {

    protected $serviceDestination = [
        'class' => CustomerService::class,
        'method' => 'register'
    ];

    protected function setProperties()
    {
        $this->properties = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
            'id' => $this->getPaymentMethodIdToken(),
            'recurringType' => 'monthly',
            'wordCount' => 4000
        ];
    }

    protected function define() {
        return new CustomerData(
            userData: new UserData(name: $this->properties['name'], email: $this->properties['email'], password: $this->properties['password']),
            paymentMethodData: new PaymentMethodData(id: $this->properties['id']),
            subscriptionData: new SubscriptionData(recurringType: $this->properties['recurringType'], wordCount: $this->properties['wordCount'])
        );
    }

    public function attachTestPaymentMethod(string $type = 'backup') : void
    {
        // @App\Models\User
        $customer = $this->result;

        if(!$customer instanceof User) {
            throw new \Exception('$customer is not an instance of App\Models\User');
        }

        $paymentService = app()->make(PaymentService::class);

        switch ($type) {
            case 'backup':
                $paymentId = self::getBackuppaymentMethodIdToken();
                break;
            case 'broken':
                $paymentId = self::getBrokenPaymentMethodIdToken();
                break;
            default:
                throw new \Exception('Invalid payment ID type');
        }

        $dto = new PaymentMethodData(id: $paymentId);

        $paymentService->addPaymentMethod($customer, $dto);
    }

    private function createPaymentMethod(array $data)
    {
        $stripeClient = app()->make(\Stripe\StripeClient::class);

        return $stripeClient->paymentMethods->create($data);
    }

    public function getPaymentMethodIdToken() : string {
        return $this->createPaymentMethod([
            'type' => 'card',
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 2,
                'exp_year' => 2025,
                'cvc' => '314',
            ],
        ])['id'];
    }

    public function getBackupPaymentMethodIdToken() : string {
        return $this->createPaymentMethod([
            'type' => 'card',
            'card' => [
                'number' => '5555555555554444',
                'exp_month' => 2,
                'exp_year' => 2025,
                'cvc' => '314',
            ],
        ])['id'];
    }

    // This payment method will be sucesfully recognized and saved, however it will fail whenever it's used for actual payments.
    public function getBrokenPaymentMethodIdToken() : string {
        return $this->createPaymentMethod([
            'type' => 'card',
            'card' => [
                'number' => '4000000000000341',
                'exp_month' => 2,
                'exp_year' => 2025,
                'cvc' => '314',
            ],
        ])['id'];
    }

    public function destroy() {
        return app()->make(CustomerService::class)->deleteCustomer($this->result);
    }
}