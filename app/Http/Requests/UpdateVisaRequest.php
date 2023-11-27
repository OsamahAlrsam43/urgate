<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVisaRequest extends FormRequest
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
            'name.*' => 'required',
            'description.*' => 'required',
            'price' => 'bail|required|integer|min:0',
            'visa_type.*' => 'required',
            'papers.*' => 'required',
            'thumb' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'name.en.required' => 'The english name field is required.',
            'name.ar.required' => 'The arabic name field is required.',
            'description.en.required' => 'The english description field is required.',
            'description.ar.required' => 'The arabic description field is required.',
            'price.required' => 'The price field is required.',
            'price.integer' => 'The price field must be a number.',
            'price.min' => 'The price field must be at least 0.',
            'visa_type.en.required' => 'The english visa type field is required.',
            'visa_type.ar.required' => 'The arabic visa type field is required.',
            'papers.en.required' => 'The english papers field is required.',
            'papers.ar.required' => 'The arabic papers field is required.',
        ];
    }
}
