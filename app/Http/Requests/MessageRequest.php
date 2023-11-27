<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'title_en' => 'required|max:225',
            'title_ar' => 'required|max:225',
            'details_en' => 'required',
            'details_ar' => 'required',
            'users' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'title_en.required' => 'The english Title field is required.',
            'title_ar.required' => 'The arabic title field is required.',
            'details_en.required' => 'The english description field is required.',
            'details_ar.required' => 'The arabic description field is required.',
            'users.required' =>  'Please Select one User at least.',

        ];
    }
}
