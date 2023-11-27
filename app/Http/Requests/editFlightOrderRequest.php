<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class editFlightOrderRequest extends FormRequest
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
            'pdf' => 'mimes:pdf',
            'first_name' => 'required',
            'last_name' => 'required',
            'passport_expire_date' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'pdf.mimes' => 'Visa must be a file of type: pdf.'
        ];
    }
}
