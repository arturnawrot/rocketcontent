<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DataTransferObject\ContentListingData;

class ContentListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->account_type == 'CUSTOMER';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:5|max:255|string',
            'description' => 'required|string|min:100|max:20000',
            'deadline' => 'required|string'
        ];
    }

    public function getDto()
    {
        return new ContentListingData(
            title: $this->title,
            description: $this->description,
            deadline: $this->deadline
        );
    }
}
