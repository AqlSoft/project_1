<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArrangReceiptCreateRequest extends FormRequest
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
            'contract'          => 'required',
            'contact'           => 'required',
            's_number'          => 'required|unique:App\Models\Receipt,s_number'
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

            'contract.required'                 => 'انت لم تختار العقد، فضلا اختر أحد العقود',
            'contact.required'                  => 'انت لم تختر المندوب، فضلا اختر المندوب',
            's_number.required'                 => 'انت لم تقدم رقم مسلسل للسند، من فضلك أضف الرقم المسلسل',
            's_number.unique'                   => 'الرقم المسلسل هذا مستخدم بالفعل، جرب رقما آخر',
        ];
    }
}
