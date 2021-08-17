<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|max:100|string',
            'username' => 'required|max:100|alpha_num',
            'password' => 'required|max:100|alpha_num',
        ];
    }
}
