<?php

namespace App\Exceptions;

use Exception;

class CannotDeleteDefaultPaymentMethodException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return redirect()->back()->withErrors(['cannot_delete_default_payment_method' => 'Cannot delete a default payment method.']);
    }
}
