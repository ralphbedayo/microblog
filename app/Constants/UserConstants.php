<?php


namespace App\Constants;


class UserConstants
{
    const USER_TYPES = [
        'blogger',
        'admin'
    ];

    const SAVE_USER_RULES = [
        'name'     => 'required|string|min:5|max:100',
        'username' => 'required|alpha_num|min:5|max:50|unique:user',
        'password' => 'required|alpha_num|min:5|max:100',
    ];

}
