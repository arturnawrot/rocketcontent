<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DataTransferObject\CustomerData;
use App\DataTransferObject\UserData;
use App\DataTransferObject\SubscriptionData;

class CustomerRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:255',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:4|max:255',
            'payment_method' => 'required|min:1',
            'recurring_type' => 'required|in:monthly,annual',
            'wordCount' => 'required|integer|min:4000|max:30000'
        ];
    }

    public function getDto() : CustomerData {
        return new CustomerData(
            userData: new UserData(name: $this->name, email: $this->email, password: $this->password),
            paymentIntent: $this->payment_method,
            subscriptionData: new SubscriptionData(recurringType: $this->recurring_type, wordCount: $this->wordCount)
        );
    }
}
