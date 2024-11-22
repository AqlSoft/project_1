<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubmenuRequest extends FormRequest
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

            'main_menu' => 'required|int',
        ];
    }

    /**
    * Set messages for the validation rules that apply to the user specifications.
    *
    * @return array
    */
    public function messages() {
        return [
            'main_menu.required'    => 'حدد القائمة الرئيسية من فضلك',
            'main_menu.int'         => 'اختر القائمة الرئيسية من فضلك',
            ];
    }
}
