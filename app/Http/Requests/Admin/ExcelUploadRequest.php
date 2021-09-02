<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExcelUploadRequest extends FormRequest
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
            'excelfile'=>'required'
//            'excelfile'=>'required|mimes:xlsx,xls,csv'
//            'excelfile'=>'required|mimeTypes:'.
//                'text/csv,'.
//                'application/csv,'.
//                'application/vnd.ms-office,'.
//                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,'.
//                'application/vnd.ms-excel',
//            'excelfile'=>'required|max:50000|mimes:xlsx,xls,csv'
        ];
    }

    public function messages()
    {
        return [
            'excelfile.required' => 'Must be select a file'
        ];
    }
}
