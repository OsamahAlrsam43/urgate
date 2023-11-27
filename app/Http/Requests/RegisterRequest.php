<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'register_email' => 'bail|required|email|unique:users,email',
            'register_password' => 'bail|required|confirmed',
            'register_password_confirmation' => 'required',
         //   'g-recaptcha-response' => 'required|captcha'
        ];
    }
}
