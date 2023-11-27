<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => [
                'bail',
                'required',
                'email',
                Rule::unique('users')->ignore($this->route('user')->id, 'id')
            ],
//            'old_password' => 'nullable|valid_old_password:' . $this->route('user')->id,
            'new_password' => 'bail|nullable|confirmed',
            'new_password_confirmation' => 'required_with:new_password',
        ];
    }

    public function messages()
    {
        return [
            'old_password.valid_old_password' => 'Invalid old password!',
            'new_password.required_with' => 'The new password field is required.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
            'new_password_confirmation.required_with' => 'The new password confirmation field is required.',
        ];
    }
}
