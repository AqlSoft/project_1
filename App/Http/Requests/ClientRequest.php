<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name'              => 'required|unique:App\Models\Client,name',
            'person'            => 'required',
            'phone'             => 'required',
            'iqama'             => 'required|unique:App\Models\Client,iqama',
            's_number'          => 'required|unique:App\Models\Client,s_number'
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

            'name.required'                 => 'لا يمكنك ترك اسم العميل فارغا',
            'name.unique'                   => 'هذا الاسم موجود بالفعل',
            's_number.required'             => 'لا يمكنك ترك الرقم المسلسل فارغا',
            's_number.unique'               => 'هذا الرقم مرنبط بعميل آخر بالفعل',
            'person.required'               => 'اسم المفوض بالتوقيع مهم، لا تتركه فارغا',
            'phone.required'                => 'رقم الهاتف مهم، لا تتركه فارغا',
            'iqama.required'                => 'الإقامة/الهوية الوطنية ركن مهم من أركان العقد، لا تتركها فارغة',
            'iqama.unique'                  => 'رقم الإقامة / الهوية مستخدم بالفعل مع عميل آخر',
        ];
    }
}
