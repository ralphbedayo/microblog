<?php


namespace App\Constants;


class CommentConstants
{
    const SAVE_COMMENT_RULES = [
        'content'           => 'required|string|min:5|max:50000',
        'blog_id'           => 'required|int|exists:blog,id,deleted_at,NULL',
        'comment_author_id' => 'required|int|exists:user,id',
    ];

    const UPDATE_COMMENT_RULES = [
        'id'      => 'required|int|exists:comment,id,deleted_at,NULL',
        'content' => 'required|string|min:5|max:50000',
    ];

    const DELETE_COMMENT_RULES = [
        'id' => 'required|int|exists:comment,id,deleted_at,NULL',
    ];

}
