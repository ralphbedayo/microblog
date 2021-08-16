<?php


namespace App\Constants;


class UserConstants
{
    const ADMIN_USER_TYPE = 'admin';
    const BLOGGER_USER_TYPE = 'blogger';

    const HOME_URL = [
        self::ADMIN_USER_TYPE   => '/admin',
        self::BLOGGER_USER_TYPE => '/'
    ];

    const ALLOWED_WEB_ROUTES = [
        self::ADMIN_USER_TYPE   => [
            'admin',
        ],
        self::BLOGGER_USER_TYPE => [

        ]
    ];

    const USER_TYPES = [
        'admin',
        'blogger'
    ];

    const SAVE_USER_RULES = [
        'name'      => 'required|string|min:5|max:100',
        'username'  => 'required|alpha_num|min:5|max:50|unique:user',
        'user_type' => 'bail|alpha_num|in:admin,blogger',
        'password'  => 'required|alpha_num|min:5|max:100',
    ];

    const UPDATE_USER_RULES = [
        'id'        => 'required|int|exists:user,id,deleted_at,NULL',
        'name'      => 'bail|string|min:5|max:100',
        'username'  => 'bail|alpha_num|min:5|max:50|unique:user',
        'user_type' => 'bail|alpha_num|in:admin,blogger',
        'password'  => 'bail|alpha_num|min:5|max:100',
    ];

    const DELETE_USER_RULES = [
        'id' => 'required|int|exists:user,id,deleted_at,NULL',
    ];

}
