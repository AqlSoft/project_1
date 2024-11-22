<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
    **/
    public function rules()
    {
        return [
            //

            'username'          => 'required',
            'email'             => 'required',
            'password'          => 'required',
            'firstName'         => 'required',
            'lastName'          => 'required',
            'profession'        => 'required',
            'dob'               => 'required',
            'natId'             => 'required',
            
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
    **/

    public function messages() {
        return [
            //
            
            'username.required'                 => 'اسم المستخدم حقل مطلوب',
            'email.required'                    => 'البريد الالكترونى حقل مطلوب',
            'password.required'                 => 'لم تقم بتعيين كلمة مرور',
            'firstName.required'                => 'الاسم الأول مطلوب',
            'lastName.required'                 => 'لم يتم تقديم اسم العائلة',
            'profession.required'               => 'لم تحدد الوظيفة',
            'dob.required'                      => 'لم يتم تقديم تاريخ الميلاد للمستخدم',
            'natId.required'                    => 'الرقم القومى مطلوب',
        ];
    }
}
