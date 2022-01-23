<?php

namespace App\Services;

use App\Models\User;
use App\DataTransferObject\CustomerData;
use App\Helpers\StripeConfig;
use App\Factories\PriceNameFactory;
use App\Expections\BusinessExpection;
use Stripe\StripeClient;

class CustomerService {

    protected $userService;

    protected $subscriptionService;

    protected $paymentService;

    protected $stripe;

    public function __construct(UserService $userService, 
        SubscriptionService $subscriptionService,
        PaymentService $paymentService,
        StripeClient $stripeClient
    ) {
        $this->userService = $userService;

        $this->subscriptionService = $subscriptionService;

        $this->paymentService = $paymentService;

        $this->stripe = $stripeClient;
    }

    public function register(CustomerData $customerData, int $trialDays = 0) : User {
        $user = $this->userService->create($customerData->userData, 'CUSTOMER');
        $user->createAsStripeCustomer();

        $this->paymentService->addPaymentMethod($user, $customerData->paymentMethodData->paymentIntent, true);
        $this->paymentService->setDefaultPaymentMethod($user, $customerData->paymentMethodData->paymentIntent);

        $priceName = PriceNameFactory::get($customerData->subscriptionData->recurringType);

        $this->subscriptionService->subscribe(
            $user, 
            StripeConfig::PRODUCT_NAME, 
            $priceName, 
            $customerData->paymentMethodData->paymentIntent, 
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

    public function deleteCustomer(User $user) {
        $this->stripe->customers->delete( $user->stripe_id );
        $this->userService->delete($user);
    }
}