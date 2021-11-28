<?php


namespace App\Services\Category;


use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Category\CategoryRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class CategoryService extends BaseService
{

    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }


    /**
     * Get all registered categories
     *
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function getAllCategory()
    {
        try {
            return $this->categoryRepository->all();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ResourceNotFoundException();
        }
    }

}
