<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTravelRequest extends FormRequest
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
            'price.*' => 'bail|required|integer|min:0',
            'from_date' => 'required',
            'to_date' => 'required',
            'period.*' => 'required',
            'from_country.*' => 'required',
            'to_country.*' => 'required',
            'thumb' => 'required|image',
            'images' => 'required',
            'images.*' => 'image',
            'description.*' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.en.required' => 'The english name field is required.',
            'name.ar.required' => 'The arabic name field is required.',
            'price.adult.required' => 'The price for adult field is required.',
            'price.children.required' => 'The price for children field is required.',
            'price.baby.required' => 'The price for baby field is required.',
            'price.adult.integer' => 'The price for adult field must be a number.',
            'price.children.integer' => 'The price for children field must be a number.',
            'price.baby.integer' => 'The price for baby field must be a number.',
            'price.adult.min' => 'The price for adult field must be at least 0.',
            'price.children.min' => 'The price for children field must be at least 0.',
            'price.baby.min' => 'The price for baby field must be at least 0.',
            'from_date.required' => 'The start date field is required.',
            'to_date.required' => 'The end date field is required.',
            'period.en.required' => 'The english period field is required.',
            'period.ar.required' => 'The arabic period field is required.',
            'from_country.en.required' => 'The english from country field is required.',
            'from_country.ar.required' => 'The arabic from country field is required.',
            'to_country.en.required' => 'The english to country field is required.',
            'to_country.ar.required' => 'The arabic to country field is required.',
            'thumb.required' => 'The thumb field is required.',
            'images.required' => 'The images field is required.',
            'description.en.required' => 'The english program field is required.',
            'description.ar.required' => 'The arabic program is required.',
        ];
    }
}
