<?php


namespace App\Repositories;


use App\Models\Category;
use Prettus\Repository\Eloquent\BaseRepository;

class CategoryRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Category::class;
    }
}
