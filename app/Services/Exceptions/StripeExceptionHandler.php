<?php

namespace App\Services\Exceptions;

class StripeExceptionHandler {
    public static function handleException(\Exception $e)
    {
        $exceptions = config('stripe.exceptions');
        $errorMessages = config('stripe.error_messages');

        foreach($exceptions as $exception) {
            if($e instanceof $exception['exception']) {
                return redirect()->back()->withErrors([$exception['type'] => $errorMessages[$exception['type']]]);
            }
        }

        return redirect()->back()->withErrors(['exception' => $errorMessages['exception']]);
    }
}