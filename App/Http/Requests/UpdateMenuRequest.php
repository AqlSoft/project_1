<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
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
           'name'              => 'required|unique:main_menues,name,'.$this->menuId,
        ];
    }


    /**
     * Get the validation messeges that has been genrated to the view.
     *
     * @return array
     */
    public function messages() {
        return [
            //
            'name.required'                 => 'لا يمكنك ترك اسم القائمة فارغا',
            'name.unique'                   => 'هذا الاسم موجود بالفعل',
        ];
    }
}
