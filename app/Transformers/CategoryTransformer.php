<?php


namespace App\Transformers;


use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

    /**
     * @param Category $categoryModel
     * @return array
     */
    public function transform($categoryModel)
    {

        return [
            'id'    => $categoryModel->id,
            'title' => $categoryModel->title,
        ];
    }

}
