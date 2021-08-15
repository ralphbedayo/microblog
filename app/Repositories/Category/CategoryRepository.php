<?php


namespace App\Repositories\Category;


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
