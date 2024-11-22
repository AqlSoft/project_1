<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TreasuriesUpdateRequest extends FormRequest
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
            'name'      => 'required|min:5',
            'type'      => 'required|int',
            'cashier'   => 'required|int',
            'status'    => 'required|int'
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
            'cashier.required'      => 'Specify treasury cashier',
            'cashier.int'           => 'Treasury Cahier is invalid',
            'status.required'       => 'Specify Treasury status',
            'status.int'            => 'Treasury Status is invalid'
        ];
    }
}