<?php

namespace App\Services;

use App\Models\User;
use App\DataTransferObject\CustomerData;
use App\Helpers\StripeConfig;
use App\Factories\PriceNameFactory;

class CustomerService {

    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function register(CustomerData $customerData, int $trialDays = 0) : User {
        $user = $this->userService->create($customerData->userData, 'CUSTOMER');
        $user->createAsStripeCustomer();

        $this->updatePaymentMethod($user, $customerData->paymentIntent);

        $priceName = PriceNameFactory::get($customerData->subscriptionData->recurringType);

        $this->subscribe(
            $user, 
            StripeConfig::PRODUCT_NAME, 
            $priceName, 
            $customerData->paymentIntent, 
            $customerData->subscriptionData->wordCount
        );

        $this->expandTrialTime($user, $trialDays);

        return $user;
    }

    public function updatePaymentMethod(User $user, string $paymentIntent) : void {
        $user->addPaymentMethod($paymentIntent);
        $user->updateDefaultPaymentMethod($paymentIntent);
    }

    public function subscribe(
        User $user, 
        string $productName, 
        string $priceName,
        string $paymentIntent,
        int $quantity = null
    ) : void {
        $user->newSubscription($productName, $priceName)
            ->quantity($quantity)
            ->create($paymentIntent);
    }

    public function expandTrialTime(User $user, int $days) : void {
        if($days <= 0) {
            return;
        }

        $user->trial_ends_at = now()->addDays($days + (int) $user->daysBeforeTrialEnds());
        $user->save();
    }
}