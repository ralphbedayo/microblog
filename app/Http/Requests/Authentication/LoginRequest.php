<?php

namespace App\Http\Requests\Authentication;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|max:100|alpha_num',
            'password' => 'required|max:100|alpha_num'
        ];
    }
}
