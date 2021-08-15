<?php


namespace App\Constants;


class UserConstants
{
    const ADMIN_USER_TYPE = 'admin';
    const BLOGGER_USER_TYPE = 'blogger';

    const HOME_URL = [
        self::ADMIN_USER_TYPE => '/admin',
        self::BLOGGER_USER_TYPE  => '/'
    ];

    const ALLOWED_WEB_ROUTES = [
        self::ADMIN_USER_TYPE => [
            'admin',
        ],
        self::BLOGGER_USER_TYPE => [

        ]
    ];

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
