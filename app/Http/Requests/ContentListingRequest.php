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
            'title' => 'required|min:5|max:255|string',
            'description' => 'required|string|min:100|max:20000',
            'word_count' => 'required|integer|min:50|max:30000',
            'deadline' => 'required|string',
            'options.*.name' => 'string|min:1|max:255|required_with:options.*.value',
            'options.*.value' => 'string|min:1|max:3000|required_with:options.*.name'
        ];
    }

    public function getDto()
    {
        return new ContentListingData(
            title: $this->title,
            description: $this->description,
            wordCount: $this->word_count,
            deadline: $this->deadline,
            options: $this->options
        );
    }
}
