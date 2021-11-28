<?php


namespace App\Http\Controllers\Category;


use App\Exceptions\ResourceNotFoundException;
use App\Http\Controllers\BaseController;
use App\Services\Category\CategoryService;
use App\Transformers\CategoryTransformer;

class CategoryController extends BaseController
{

    public function __construct(protected CategoryService $categoryService)
    {
    }


    /**
     * @return array
     * @throws ResourceNotFoundException
     */
    public function index()
    {
        $response = $this->categoryService->getAllCategory();

        return $this->transform($response, CategoryTransformer::class);
    }


    public function store()
    {

    }

    public function show()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

}
