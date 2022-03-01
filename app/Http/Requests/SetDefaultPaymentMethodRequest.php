<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DataTransferObject\PaymentMethodData;

class SetDefaultPaymentMethodRequest extends FormRequest
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
        return [
            'payment_method' => 'required|min:1'
        ];
    }

    public function getDto()
    {
        return new PaymentMethodData(paymentIntent: $this->payment_method);
    }
}
