<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TreasuriesCreateRequest extends FormRequest
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
            'name'      => 'required|min:5|max:50|unique:treasuries,name',
            'type'      => 'required|int',
            'cashier'   => 'required|int'
        ];
    }

    /**
     * Return the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'         => 'Treasury name is required',
            'name.min'              => 'At least 5 chars is accepted for treasury name',
            'name.max'              => 'Maximum 50 chars for treasury name',
            'type.required'         => 'Specify the type of traesury?',
            'cashier.required'      => 'Please Select Cashier',
        ];
    }
}
