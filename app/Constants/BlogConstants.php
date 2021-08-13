<?php


namespace App\Constants;


class BlogConstants
{
    const CATEGORIES = [
        1  => 'fashion',
        2  => 'food',
        3  => 'travel',
        4  => 'music',
        5  => 'lifestyle',
        6  => 'fitness',
        7  => 'sports',
        8  => 'technology',
        9  => 'science',
        10 => 'finance',
    ];

    const SAVE_BLOG_RULES = [
        'title'       => 'required|string|min:5|max:100',
        'content'     => 'required|string|min:5|max:50000',
        'category_id' => 'required|int|exists:category,id',
        'author_id'   => 'required|int|exists:user,id',
    ];

    const UPDATE_BLOG_RULES = [
        'id'          => 'required|int|exists:blog,id,deleted_at,NULL',
        'title'       => 'bail|string|min:5|max:100',
        'content'     => 'bail|string|min:5|max:50000',
        'category_id' => 'bail|int|exists:category,id',
    ];

    const DELETE_BLOG_RULES = [
        'id' => 'required|int|exists:blog,id,deleted_at,NULL',
    ];

}
