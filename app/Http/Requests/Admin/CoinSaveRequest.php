<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CoinSaveRequest extends FormRequest
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
        $rule = [
            'name' => 'required|max:255',
            'amount' => 'required|numeric|min:1|max:99999999',
            'price' => 'required|numeric|min:1|max:99999999',
        ];

        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => __('Name field can not be empty'),
            'amount.required' => __('Amount field can not be empty'),
            'price.required' => __('Price field can not be empty'),
        ];
    }
}
