<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreUserPost extends Request
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
            'username' => 'min:5|max:30|required',
            'password' => 'min:10|required',
            'active' => 'size:1'
        ];
    }
}


