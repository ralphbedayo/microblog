<?php


namespace App\Constants;


class AuthenticationConstants
{
    const LOGIN_PARAMS = [
        'username' => 'required|max:100|alpha_num',
        'password' => 'required|max:100|alpha_num'
    ];

}
