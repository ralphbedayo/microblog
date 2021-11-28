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
    protected $userTransformer;

    /** @var CommentTransformer */
    protected $commentTransformer;


    protected $availableIncludes = [
        'author', 'comments'
    ];

    protected $defaultIncludes = [
        'author'
    ];


    /**
     * @param Blog $blog
     * @return array
     */
    public function transform($blog)
    {
        $this->userTransformer = new UserTransformer();
        $this->commentTransformer = new CommentTransformer();

        return [
            'id'          => $blog->id,
            'title'       => $blog->title,
            'content'     => $blog->content,
            'category_id' => $blog->category_id,
            'category'    => $blog->category->title,
            'author_id'   => $blog->author_id,
            'author_name' => $blog->author->name,
            'created_at'  => $blog->created_at,
            'updated_at'  => $blog->updated_at
        ];
    }


    public function includeAuthor(Blog $blog)
    {
        return new Primitive($blog->author);
    }

    public function includeComments(Blog $blog)
    {
        $comments = Fractal::create($blog->comments, CommentTransformer::class);

        return new Primitive($comments->toArray()['data']);
    }

}
