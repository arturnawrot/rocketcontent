<?php

namespace App\Services;

use App\Models\User;
use App\DataTransferObject\CustomerData;
use App\Helpers\StripeConfig;
use App\Factories\PriceNameFactory;
use App\Expections\BusinessExpection;

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

        try {
            $this->subscriptionService->updatePaymentMethod($user, $customerData->paymentIntent);
        } catch (\Stripe\Error\Base $e) {
            
        }

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
    
    public function expandTrialTime(User $user, int $days) : User {
        if($days <= 0) {
            throw new BusinessExpection("The 'days' parameter cannot be zero or lower.");
        }

        $user->trial_ends_at = now()->addDays($days + (int) $user->daysBeforeTrialEnds());
        $user->save();

        return $user;
    }
}