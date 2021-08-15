<?php


namespace App\Http\Controllers\Category;


use App\Exceptions\ResourceNotFoundException;
use App\Http\Controllers\BaseController;
use App\Services\Category\CategoryService;
use App\Transformers\CategoryTransformer;

class CategoryController extends BaseController
{
    protected $oCategoryService;

    public function __construct(CategoryService $oCategoryService)
    {
        $this->oCategoryService = $oCategoryService;
    }


    /**
     * @return array
     * @throws ResourceNotFoundException
     */
    public function index()
    {
        $oResponseData = $this->oCategoryService->getAllCategory();

        return $this->transform($oResponseData, CategoryTransformer::class);
    }


    public function store()
    {

    }

    public function find()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

}
