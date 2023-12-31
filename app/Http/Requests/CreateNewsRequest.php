<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewsRequest extends FormRequest
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
            'news' => 'required',
            'news.en' => 'required',
            'news.ar' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'news.en.required' => 'english content is required field',
            'news.ar.required' => 'arabic content is required field',
        ];
    }
}
