<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        $rules['app_title'] = 'required|max:255';
        if (isset($this->logo)) {
            $rules['logo']='required|image|mimes:jpg,jpeg,png|max:3000';
        }
        if (isset($this->favicon)) {
            $rules['favicon']='required|image|mimes:jpg,jpeg,png|max:3000';
        }
        if (isset($this->login_logo)) {
            $rules['login_logo']='required|image|mimes:jpg,jpeg,png|max:3000';
        }

        return $rules;
    }
}
