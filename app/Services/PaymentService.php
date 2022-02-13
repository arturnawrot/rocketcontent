<?php

namespace App\Services;

use App\Models\User;
use App\DataTransferObject\PaymentMethodData;
use App\Services\Traits\HasStripeRequestHook;
use App\Events\PaymentMethodAdded;
use App\Events\PaymentMethodAdding;
use App\Exceptions\PaymentMethodAlreadyExistsException;
use Stripe\StripeClient;

class PaymentService
{
    private $stripeClient;

    public function __construct(StripeClient $stripeClient)
    {
        $this->stripeClient = $stripeClient;
    }

    public function setDefaultPaymentMethod(User $user, PaymentMethodData $paymentMethodData) {
        $user->updateDefaultPaymentMethod($paymentMethodData->paymentIntent);
    }

    public function addPaymentMethod(User $user, PaymentMethodData $paymentMethodData) {
        if($this->doesPaymentMethodAlreadyExists($user, $paymentMethodData->paymentIntent))
            throw new PaymentMethodAlreadyExistsException();

        $user->addPaymentMethod($paymentMethodData->paymentIntent);

        PaymentMethodAdded::dispatch($user);
    }

    private function getCardInfoFromPaymentIntent(string $paymentIntent)
    {
        return $this->stripeClient->paymentMethods->retrieve($paymentIntent)->card;
    }

    public function doesPaymentMethodAlreadyExists(User $user, string $paymentIntent)
    {
        $card = $this->getCardInfoFromPaymentIntent($paymentIntent);
        
        $paymentMethods = $user->getPaymentMethods();

        foreach($paymentMethods as $paymentMethod) {
            if($paymentMethod['fingerprint'] === $card->fingerprint) {
                return true;
            }
        }

        return false;
    }
}