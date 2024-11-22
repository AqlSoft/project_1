<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
        if (request()->routeIs('room.store')) {
            return [
                //
    
                'a_name'        => 'required|unique:rooms',
                'e_name'        => 'required|unique:rooms',
                'serial'        => 'required|unique:rooms',
                'code'          => 'required|unique:rooms',
    
            ];
        } elseif (request()->routeIs('room.update')) {
            return [
                //
                'a_name'        => 'required|unique:rooms,a_name,'.$this->id,
                'e_name'        => 'required|unique:rooms,e_name,'.$this->id,
                'serial'        => 'required|unique:rooms,serial,'.$this->id,
                'code'          => 'required|unique:rooms,code,'.$this->id,
            ];
        }
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages() {
        return [
            //
            'a_name.required'           => 'الاسم العربى لا بمكن أن يكون فارغا',
            'a_name.unique'             => 'الاسم العربى مستخدم من قبل',
            'e_name.required'           => 'الاسم باللغة الأخرى لا بمكن أن يكون فارغا',
            'e_name.unique'             => 'الاسم باللغة الأخرى مستخدم من قبل',
            'serial.required'           => 'الرقم المسلسل للغرفة لا بمكن أن يكون فارغا',
            'serial.unique'             => 'الرقم المسلسل للغرفة مستخدم من قبل',
            'code.required'             => 'كود الغرفة لا بمكن أن يكون فارغا',
            'code.unique'               => 'كود الغرفة مستخدم من قبل',
        ];
    }
}
