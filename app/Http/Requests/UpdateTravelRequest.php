<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTravelRequest extends FormRequest
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
            'from_date' => 'required',
            'to_date' => 'required',
            'period.*' => 'required',
            'from_country.*' => 'required',
            'to_country.*' => 'required',
            'thumb' => 'nullable|image',
            'images.*' => 'nullable|image',
            'description.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.en.required' => 'The english name field is required.',
            'name.ar.required' => 'The arabic name field is required.',
            'from_date.required' => 'The start date field is required.',
            'to_date.required' => 'The end date field is required.',
            'period.en.required' => 'The english period field is required.',
            'period.ar.required' => 'The arabic period field is required.',
            'from_country.en.required' => 'The english from country field is required.',
            'from_country.ar.required' => 'The arabic from country field is required.',
            'to_country.en.required' => 'The english to country field is required.',
            'to_country.ar.required' => 'The arabic to country field is required.',
            'description.en.required' => 'The english program field is required.',
            'description.ar.required' => 'The arabic program is required.',
        ];
    }
}
