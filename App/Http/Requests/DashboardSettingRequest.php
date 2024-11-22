<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashboardSettingRequest extends FormRequest
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
            'name'          => 'required',
            'address'       => 'required',
            'phone'         => 'required',
            

        ];
    }

    public function messages () {
        return [
            'name.required'             => 'Company Name is required',
            'address.required'          => 'Company Address is required',
            'phone.required'            => 'Phone is required'
            
        ];
    }
}
