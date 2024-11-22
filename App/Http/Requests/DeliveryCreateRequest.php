<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryCreateRequest extends FormRequest
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
            
            
            'contract'          => 'required|int',
            'driver'           => 'required|int',
            'contact'          => 'required|int',
            's_number'            => 'required|int',
        ];
    }
    
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            
            
            'table_id.required'          => 'Select Table',
            'table_id.int'          => 'Select Table',
            
            'item_id.required'           => 'Select items',
            'item_id.int'           => 'Select items',
            
            'box_size.required'          => 'Select box',
            'box_size.int'          => 'Select box',
            
            'inputs.required'            => 'specify inputs',
            'inputs.int'            => 'specify inputs',
        ];
    }
}
