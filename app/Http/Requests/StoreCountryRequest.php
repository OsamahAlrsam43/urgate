<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
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
            'name.*' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.en.required' => 'The english name field is required.',
            'name.ar.required' => 'The arabic name field is required.',
        ];
    }
}
