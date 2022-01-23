<?php

namespace App\Services;

use App\Models\User;

class PaymentService
{
    protected $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function setDefaultPaymentMethod(User $user, string $paymentIntent) : void {
        $user->updateDefaultPaymentMethod($paymentIntent);
    }

    // $deleteUserOnFail should be true only during the customer's registration process.
    // Laravel Cashier module is made that way that a user must be first created and saved before 
    // adding the payment method and charging them. In case if for some reason the payment fails
    // the user record must be removed from database, so the customer can fill out the same data
    // in the reigstration form during another attempt. Otherwise they will receive a duplicate entry error.
    public function addPaymentMethod(User $user, string $paymentIntent, bool $deleteUserOnFail = false) {
        try {
            $user->addPaymentMethod($paymentIntent);
        } catch (\Stripe\Exception\ApiErrorException | \Stripe\Exception\InvalidRequestException $e) {
            
            if($deleteUserOnFail) {
                $this->userService->delete($user);
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
}