<?php


namespace App\Services\Category;


use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Category\CategoryRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class CategoryService extends BaseService
{
    protected $oCategoryRepository;

    public function __construct(CategoryRepository $oCategoryRepository)
    {
        $this->oCategoryRepository = $oCategoryRepository;
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
            return $this->oCategoryRepository->all();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ResourceNotFoundException();
        }
    }

}
