<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountsCategoryCreateRequest extends FormRequest
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
            'a_name'    => 'required',
            'e_name'    => 'required',
            'brief'   => 'required',
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

            'a_name.required'       => 'Category Arabic Name Can\'t be empty',
            'e_name.required'       => 'Category Latin Name Can\'t be empty',
            'brief.required'        => 'Category Description Can\'t be empty',

        ];
    }
}
