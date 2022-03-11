<?php

namespace App\Services;

use App\Models\User;
use App\DataTransferObject\PaymentMethodData;
use App\Events\PaymentMethodAdded;
use App\Events\PaymentMethodDeleted;
use App\Events\PaymentMethodUpdated;
use App\Events\DefaultPaymentMethodUpdated;
use App\Exceptions\PaymentMethodAlreadyExistsException;
use App\Exceptions\CannotDeleteDefaultPaymentMethodException;
use Stripe\StripeClient;

class PaymentService
{
    private $stripeClient;

    public function __construct(StripeClient $stripeClient)
    {
        $this->stripeClient = $stripeClient;
    }

    public function setDefaultPaymentMethod(User $user, PaymentMethodData $paymentMethodData) {
        $user->updateDefaultPaymentMethod($paymentMethodData->id);

        DefaultPaymentMethodUpdated::dispatch($user);
    }

    public function addPaymentMethod(User $user, PaymentMethodData $paymentMethodData) {
        if($this->doesPaymentMethodAlreadyExists($user, $paymentMethodData->id))
            throw new PaymentMethodAlreadyExistsException();

        $user->addPaymentMethod($paymentMethodData->id);

        PaymentMethodAdded::dispatch($user);
    }

    public function updatePaymentMethod(User $user, PaymentMethodData $paymentMethodData)
    {
        $billingDetailsData = $paymentMethodData->billingDetailsData;

        $this->stripeClient->paymentMethods->update(
            $paymentMethodData->id,
            [
                'billing_details' => [
                    'name' =>   $billingDetailsData->cardholderName
                ],
                'card' => [
                    'exp_month' => $billingDetailsData->expirationMonth,
                    'exp_year' => $billingDetailsData->expirationYear
                ]
            ]
        );

        PaymentMethodUpdated::dispatch($user);
    }

    public function deletePaymentMethod(User $user, PaymentMethodData $paymentMethodData)
    {
        if($this->isPaymentMethodDefault($user, $paymentMethodData->id))
            throw new CannotDeleteDefaultPaymentMethodException();
        
        $user->deletePaymentMethod($paymentMethodData->id);

        PaymentMethodDeleted::dispatch($user);
    }

    private function isPaymentMethodDefault(User $user, string $id)
    {
        return $user->getPaymentMethods()->firstWhere('id', $id)['default'];
    }

    private function getCardInfoFrompaymentMethodId(string $paymentMethodId)
    {
        return $this->stripeClient->paymentMethods->retrieve($paymentMethodId)->card;
    }

    public function doesPaymentMethodAlreadyExists(User $user, string $paymentMethodId)
    {
        $card = $this->getCardInfoFrompaymentMethodId($paymentMethodId);
        
        return $user->getPaymentMethods()->contains('fingerprint', $card->fingerprint);
    }
}