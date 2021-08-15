<?php


namespace App\Transformers;


use App\Models\Blog;
use League\Fractal\Resource\Primitive;
use League\Fractal\TransformerAbstract;
use Spatie\Fractal\Fractal;

/**
 * Class BlogTransformer
 *
 * @package App\Transformers
 */
class BlogTransformer extends TransformerAbstract
{
    /** @var UserTransformer */
    protected $oUserTransformer;

    /** @var CommentTransformer */
    protected $oCommentTransformer;


    protected $availableIncludes = [
        'author', 'comments'
    ];

    protected $defaultIncludes = [
        'author'
    ];


    /**
     * @param Blog $oBlogModel
     * @return array
     */
    public function transform($oBlogModel)
    {
        $this->oUserTransformer = new UserTransformer();
        $this->oCommentTransformer = new CommentTransformer();

        return [
            'id'          => $oBlogModel->id,
            'title'       => $oBlogModel->title,
            'content'     => $oBlogModel->content,
            'category'    => $oBlogModel->category->title,
            'author_name' => $oBlogModel->author->name,
            'created_at'  => $oBlogModel->created_at,
            'updated_at'  => $oBlogModel->updated_at
        ];
    }


    public function includeAuthor(Blog $oBlogModel)
    {
        return new Primitive($oBlogModel->author);
    }

    public function includeComments(Blog $oBlogModel)
    {
        $comments = Fractal::create($oBlogModel->comments, CommentTransformer::class);

        return new Primitive($comments->toArray()['data']);
    }

}
