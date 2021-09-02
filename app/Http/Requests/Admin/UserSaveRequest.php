<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserSaveRequest extends FormRequest
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
//            'country' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|strong_pass|confirmed',
            'password_confirmation' => 'required',
        ];
        if ($this->phone) {
            $rule['phone'] = 'numeric|phone_number';
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => __('Name field can not be empty'),
            'role.required' => __('Role field can not be empty'),
            'country.required' => __('Country field can not be empty'),
            'password.required' => __('Password field can not be empty'),
            'password_confirmation.required' => __('Password confirmed field can not be empty'),
            'password.min' => __('Password length must be minimum 8 characters.'),
            'password.strong_pass' => __('Password must be consist of one uppercase, one lowercase and one number!'),
            'email.required' => __('Email field can not be empty'),
            'email.unique' => __('Email address already exists'),
            'email.email' => __('Invalid email address'),
            'phone.phone_number' => __('Invalid phone number'),
        ];
    }
}
