<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreCompanyPost extends Request
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
            'name' => 'min:3|max:30|required',
            'adress' => 'min:10|required',
            'bulstat' => 'max:10|required',
            'email' => 'min:8|max:100',
            'phone' => 'size:10|required',
            'note' => 'max: 250'
        ];
    }
}
