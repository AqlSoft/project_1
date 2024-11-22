<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            //

            'a_name'      => 'required',
            'parent_cat'    => 'required',
            'unit'        => 'required',
            
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages() {
        return [
            //
            'name.required'             => 'نسيت كتابة الاسم',
            'parent_cat.required'       => 'نسيت اختيار التصنيف الأب',
            'unit.required'             => 'لم تختر وحدة القياس',
        ];
    }
}
