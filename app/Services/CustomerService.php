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

    protected $stripe;

    public function __construct(UserService $userService, 
        SubscriptionService $subscriptionService, 
        StripeClient $stripeClient
    ) {
        $this->userService = $userService;

        $this->subscriptionService = $subscriptionService;

        $this->stripe = $stripeClient;
    }

    public function register(CustomerData $customerData, int $trialDays = 0) : User {
        $user = $this->userService->create($customerData->userData, 'CUSTOMER');
        $user->createAsStripeCustomer();

        $this->updatePaymentMethod($user, $customerData->paymentIntent, true);

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

    // $deleteUserOnFail should be true only during the customer's registration process.
    // Laravel Cashier module is made that way that a user must be first created and saved before 
    // adding the payment method and charging them. In case if for some reason the payment fails
    // the user record must be removed from database, so the customer can fill out the same data
    // in the reigstration form during another attempt. Otherwise they will receive a duplicate entry error.
    public function updatePaymentMethod(User $user, string $paymentIntent, bool $deleteUserOnFail = false) {
        try {
            $this->subscriptionService->updatePaymentMethod($user, $paymentIntent);
        } catch (\Stripe\Exception\ApiErrorException | \Stripe\Exception\InvalidRequestException $e) {
            
            if($deleteUserOnFail) {
                $this->deleteCustomer($user);
            }

            return redirect()->back()->withErrors(['invalid_request' => 'There were some issues with processing your request to the payment processor. Please, try again later, or contact the customer service.']);
        } 
        
        catch(\Stripe\Exception\CardException $e) {
            return redirect()->back()->withErrors(['card_exception' => 'Your card was declined. Please, contact customer service.']);
        } 
        
        // catch (\Stripe\Exception\RateLimitException $e) {
        //     Too many requests made to the API too quickly
        // } catch (\Stripe\Exception\AuthenticationException $e) {
        //     Authentication with Stripe's API failed
        //     (maybe you changed API keys recently)
        // } 
        
        catch (\Stripe\Exception\ApiConnectionException $e) {
            return redirect()->back()->withErrors(['api_connection' => 'There were some issues with processing your request to the payment processor. Please, try again later, or contact the customer service.']);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['exception' => 'There were some issues with processing your request to the payment processor. Please, try again later, or contact the customer service.']);
        }
    }

    public function deleteCustomer(User $user) {
        $this->stripe->customers->delete( $user->stripe_id );
        $this->userService->delete($user);
    }
}