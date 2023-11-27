<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
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
            'about_title' => 'required',
            'about_title.en' => 'required',
            'about_title.ar' => 'required',
            'about_content' => 'required',
            'about_content.en' => 'required',
            'about_content.ar' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'about_title.en.required' => 'About us page title is required in english.',
            'about_title.ar.required' => 'About us page title is required in arabic.',
            'about_content.en.required' => 'About us page content is required in english.',
            'about_content.ar.required' => 'About us page content is required in arabic.',
        ];
    }
}
