<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePasswordRequest extends FormRequest
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
            'password' => 'required|valid_old_password:' . Auth::user()->id,
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'password.valid_old_password' => 'Please, enter valid old password.'
        ];
    }
}
