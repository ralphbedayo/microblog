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

    public function __construct(protected BlogRepository $blogRepository)
    {
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
            return $this->blogRepository->paginate();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ResourceNotFoundException();
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function findBlogById($id)
    {
        try {
            return $this->blogRepository->find($id);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ResourceNotFoundException();
        }
    }

    /**
     * @param array $requestData
     * @return mixed
     * @throws CreateResourceException
     */
    public function createBlog(array $requestData)
    {
        try {
            return $this->blogRepository->create($requestData);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new CreateResourceException();
        }
    }

    /**
     * @param $id
     * @param array $requestData
     * @return mixed
     * @throws UpdateResourceException
     */
    public function updateBlog($id, array $requestData)
    {
        try {
            return $this->blogRepository->update($requestData, $id);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new UpdateResourceException();
        }
    }

    /**
     * @param $id
     * @return int
     * @throws UpdateResourceException
     */
    public function deleteBlog($id)
    {
        try {
            return $this->blogRepository->delete($id);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new UpdateResourceException();
        }

    }

}
