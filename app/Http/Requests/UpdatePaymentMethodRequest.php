<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DataTransferObject\PaymentMethodData;
use App\DataTransferObject\BillingDetailsData;

class UpdatePaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->account_type === 'CUSTOMER';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $currentYear = date("Y");
        $maxExpirationYear = $currentYear + 120;

        return [
            'payment_method' => 'required|min:1',
            'cardholder_name' => 'required|min:1|max:455',
            'expiration_month' => 'required|integer|min:1|max:12',
            'expiration_year' => "required|integer|min:$currentYear|max:$maxExpirationYear"
        ];
    }

    public function getDto()
    {
        return new PaymentMethodData(
            id: $this->payment_method,
            billingDetailsData: new BillingDetailsData(
                cardholderName: $this->cardholder_name,
                expirationMonth: $this->expiration_month,
                expirationYear: $this->expiration_year
            )
        );
    }
}
