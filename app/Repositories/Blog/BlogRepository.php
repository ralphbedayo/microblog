<?php


namespace App\Repositories\Blog;


use App\Models\Blog;
use App\Repositories\BaseRepository;

class BlogRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id'             => '=',
        'author_id'      => '=',
        'author.name'    => 'like',
        'title'          => 'like',
        'category_id'    => 'in',
        'category.title' => 'in',
    ];

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Blog::class;
    }
}
