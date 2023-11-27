<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePageRequest extends FormRequest
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
            'title' => 'required',
            'title.en' => 'required',
            'title.ar' => 'required',
            'page_content' => 'required',
            'page_content.en' => 'required',
            'page_content.ar' => 'required',
            'name' => 'required',
            'name.en' => 'required',
            'name.ar' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.en' => 'english title is required field',
            'title.ar' => 'arabic title is required field',
            'page_content.en' => 'english content is required field',
            'page_content.ar' => 'arabic content is required field',
            'name.en' => 'english name is required field',
            'name.ar' => 'arabic name is required field',
        ];
    }
}
