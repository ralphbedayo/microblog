<?php


namespace App\Services\Blog;


use App\Exceptions\CreateResourceException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UpdateResourceException;
use App\Repositories\Blog\BlogRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class BlogService extends BaseService
{
    protected $oBlogRepository;

    public function __construct(BlogRepository $oBlogRepository)
    {
        $this->oBlogRepository = $oBlogRepository;
    }


    /**
     * Paginate through all blog
     *
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function getAllBlog()
    {
        try {
            return $this->oBlogRepository->paginate();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ResourceNotFoundException();
        }
    }

    /**
     * @param $iId
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function findBlogById($iId)
    {
        try {
            return $this->oBlogRepository->find($iId);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ResourceNotFoundException();
        }
    }

    /**
     * @param array $aData
     * @return mixed
     * @throws CreateResourceException
     */
    public function createBlog(array $aData)
    {
        try {
            return $this->oBlogRepository->create($aData);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new CreateResourceException();
        }
    }

    /**
     * @param $iId
     * @param $aData
     * @return mixed
     * @throws UpdateResourceException
     */
    public function updateBlog($iId, array $aData)
    {
        try {
            return $this->oBlogRepository->update($aData, $iId);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new UpdateResourceException();
        }
    }

    public function deleteBlog($iId)
    {
        try {
            return $this->oBlogRepository->delete($iId);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new UpdateResourceException();
        }

    }

}
