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
     * @param Comment $oCommentModel
     * @return array
     */
    public function transform($oCommentModel)
    {

        return [
            'id'         => $oCommentModel->id,
            'content'    => $oCommentModel->content,
            'created_at' => $oCommentModel->created_at,
            'updated_at' => $oCommentModel->updated_at
        ];
    }

    public function includeCommentAuthor(Comment $oCommentModel)
    {
        return new Primitive($oCommentModel->commentAuthor);
    }

    public function includeBlog(Comment $oCommentModel)
    {
        return new Primitive($oCommentModel->blog);
    }
}
