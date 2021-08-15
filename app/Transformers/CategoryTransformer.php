<?php


namespace App\Transformers;


use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

    /**
     * @param Category $oCategoryModel
     * @return array
     */
    public function transform($oCategoryModel)
    {

        return [
            'id'    => $oCategoryModel->id,
            'title' => $oCategoryModel->title,
        ];
    }

}
