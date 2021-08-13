<?php


namespace App\Repositories\Blog;


use App\Models\Blog;
use App\Repositories\BaseRepository;

class BlogRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id'             => '=',
        'author_id'      => '=',
        'title'          => 'like',
        'category_id'    => '=',
        'category.title' => '=',
    ];

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Blog::class;
    }
}
