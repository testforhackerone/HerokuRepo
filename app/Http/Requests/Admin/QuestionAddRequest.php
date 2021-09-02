<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QuestionAddRequest extends FormRequest
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
        $url = '/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/';
        $rules = [
//            'title' => ['required', Rule::unique('questions')->ignore($request->edit_id, 'id')],
            'category_id' => 'required',
            'skip_coin' => 'required|integer|numeric|between:0,100',
//            'hints' => 'required',
            'type' => 'required',
            'status' => 'required',
            'point' => 'required|integer|numeric|between:0,100',

        ];
        if (!empty($this->video_link)) {
            $rules['video_link'] = ['max:150','regex:'.$url];
        }
        if (!empty($this->coin)) {
            $rules['coin'] = 'numeric|integer|between:1,1000';
        }
        if (!empty($this->time_limit)) {
            $rules['time_limit'] = 'numeric|integer|between:1,10';
        }
        if (!empty($this->image)) {
            $rules['image'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:2000';
        }
        if (!empty($this->option_image1)) {
            $rules['option_image1'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:2000';
        }
        if (!empty($this->option_image2)) {
            $rules['option_image2'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:2000';
        }
        if (!empty($this->option_image3)) {
            $rules['option_image3'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:2000';
        }
        if (!empty($this->option_image4)) {
            $rules['option_image4'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:2000';
        }
        if (!empty($this->option_image5)) {
            $rules['option_image5'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:2000';
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
//            'title.required' => __('Question Title field can not be empty'),
            'point.required' => __('Question point field can not be empty'),
            'status.required' => __('Status field can not be empty'),
            'options.required' => __('Option field can not be empty'),
            'category_id.required' => __('Must be select a category'),
            'type.required' => __('Must be select a question type'),
            'skip_coin.required' => __('Skip coin field is required'),
            'hints.required' => __('Hints field is required'),
        ];

        return $messages;
    }
}
