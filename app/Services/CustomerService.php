<?php

namespace App\Services;

use App\Models\User;
use App\DataTransferObject\CustomerData;
use App\Helpers\StripeConfig;
use App\Factories\PriceNameFactory;

class CustomerService {

    protected $userService;

    protected $subscriptionService;

    public function __construct(UserService $userService, SubscriptionService $subscriptionService) {
        $this->userService = $userService;

        $this->subscriptionService = $subscriptionService;
    }

    public function register(CustomerData $customerData, int $trialDays = 0) : User {
        $user = $this->userService->create($customerData->userData, 'CUSTOMER');
        $user->createAsStripeCustomer();

        $this->subscriptionService->updatePaymentMethod($user, $customerData->paymentIntent);

        $priceName = PriceNameFactory::get($customerData->subscriptionData->recurringType);

        $this->subscriptionService->subscribe(
            $user, 
            StripeConfig::PRODUCT_NAME, 
            $priceName, 
            $customerData->paymentIntent, 
            $customerData->subscriptionData->wordCount
        );

        $this->expandTrialTime($user, $trialDays);

        return $user;
    }
    
    public function expandTrialTime(User $user, int $days) : void {
        if($days <= 0) {
            return;
        }

        $user->trial_ends_at = now()->addDays($days + (int) $user->daysBeforeTrialEnds());
        $user->save();
    }
}