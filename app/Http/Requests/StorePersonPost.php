<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StorePersonPost extends Request
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
            'p_name' => 'min:5|max:30|required',
            'p_adress' => 'min:10|required',
            'p_phone' => 'size: 10|required',
            'p_email' => 'min:8|max:100|required'
        ];
    }
    public function attributes()
{
    return[
        'p_name' => "person's name", 
        'p_adress' => "person's address",
        'p_phone' => "person's phone",
        'p_email' => "person's email"
    ];

}
}
