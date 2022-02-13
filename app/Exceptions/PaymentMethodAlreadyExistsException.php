<?php

namespace App\Exceptions;

use Exception;

class PaymentMethodAlreadyExistsException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        // return response(...);

        return redirect()->back()->withErrors(['payment_method_already_exists_exception' => 'This payment method already exists in your account']);
    }
}
