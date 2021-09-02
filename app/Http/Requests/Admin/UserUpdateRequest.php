<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required',
            'role' => 'required',
        ];
        if ($this->phone) {
            $rule['phone'] = 'numeric|phone_number';
        }
        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => __('The name field can not empty'),
            'role.required' => __('The Role field can not empty'),
            'phone.phone_number' => __('Invalid phone number'),
        ];
    }
}
