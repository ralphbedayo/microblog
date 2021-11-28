<?php


namespace App\Transformers;


use App\Models\Comment;
use League\Fractal\Resource\Primitive;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'comment_author', 'blog'
    ];

    protected $defaultIncludes = [
        'comment_author'
    ];

    /**
     * @param Comment $commentModel
     * @return array
     */
    public function transform($commentModel)
    {

        return [
            'id'         => $commentModel->id,
            'content'    => $commentModel->content,
            'created_at' => $commentModel->created_at,
            'updated_at' => $commentModel->updated_at
        ];
    }

    public function includeCommentAuthor(Comment $commentModel)
    {
        return new Primitive($commentModel->commentAuthor);
    }

    public function includeBlog(Comment $commentModel)
    {
        return new Primitive($commentModel->blog);
    }
}
