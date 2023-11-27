<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class CharterPreCheckoutRequest extends FormRequest
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
//            'age.*' => 'required|in:adult,children,baby',
            'first_name.*' => 'required',
            'last_name.*' => 'required',
//            'birth_place.*' => 'required',
            // 'birth_date.*' => 'bail|date|date_format:m/d/Y',
//            'nationality.*' => 'required',
            'passport_number.*' => 'required',
            // 'passport_issuance_date.*' => 'bail|date|date_format:m/d/Y',
            'passport_expire_date.*' => 'bail|required',
//            'father_name.*' => 'required',
//            'mother_name.*' => 'required',
//            'passport_image' => 'required',
//            'personal_image' => 'required',
//            'passport_image.*' => 'bail|required|image',
//            'personal_image.*' => 'bail|required|image',
//            'g-recaptcha-response' => 'required|captcha'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        $date = App::getLocale() == 'ar' ? 'من فضلك ادخل تاريخ صحيح' : 'invalid date format';
        $first_name = App::getLocale() == 'ar' ? 'هذا الحقل مطلوب!' : 'first name field is required';
        $last_name = App::getLocale() == 'ar' ? 'هذا الحقل مطلوب!' : 'last name field is required';
        $passport_number = App::getLocale() == 'ar' ? 'هذا الحقل مطلوب!' : 'passport number field is required';
        $passport_expire_date = App::getLocale() == 'ar' ? 'هذا الحقل مطلوب!' : 'expire date field is required';
        $passport_image = App::getLocale() == 'ar' ? 'هذا الحقل مطلوب!' : 'passport image field is required';
        $personal_image = App::getLocale() == 'ar' ? 'هذا الحقل مطلوب!' : 'personal image field is required';
        $captcha = App::getLocale() == 'ar' ? 'هذا الحقل مطلوب!' : 'captcha field is required';

        return [
            'first_name.*.required' => $first_name,
            'last_name.*.required' => $last_name,
            'passport_number.*.required' => $passport_number,
            'passport_expire_date.*.required' => $passport_expire_date,
            'passport_image.*.required' => $passport_image,
            'personal_image.*.required' => $personal_image,
            'g-recaptcha-response.required' => $captcha,
            'birth_date.*.date' => $date,
            'birth_date.*.date_format' => $date,
            'passport_issuance_date.*.date' => $date,
            'passport_issuance_date.*.date_format' => $date,
            'passport_expire_date.*.date' => $date,
            'passport_expire_date.*.date_format' => $date
        ];
    }
}
