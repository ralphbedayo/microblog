<?php


namespace App\Http\Controllers\Blog;


use App\Constants\BlogConstants;
use App\Exceptions\CreateResourceException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UpdateResourceException;
use App\Http\Controllers\BaseController;
use App\Services\Blog\BlogService;
use App\Transformers\BlogTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BlogController extends BaseController
{

    public function __construct(protected BlogService $blogService)
    {
    }

    /**
     * Display a listing of resource
     *
     * @return array
     * @throws ResourceNotFoundException
     */
    public function index()
    {
        $response = $this->blogService->getAllBlog();

        return $this->transform($response, BlogTransformer::class);
    }

    /**
     * Display specified resource
     *
     * @param string $id
     * @return array
     * @throws ResourceNotFoundException
     */
    public function show($id)
    {
        $response = $this->blogService->findBlogById($id);

        return $this->transform($response, BlogTransformer::class);
    }


    /**
     * Create new resource
     *
     * @param
     * @return array
     * @throws CreateResourceException
     * @throws ValidationException
     * @throws ResourceNotFoundException
     */
    public function store()
    {
        $blogData = $this->validate(request(), BlogConstants::SAVE_BLOG_RULES);

        $response = $this->blogService->createBlog($blogData);

        return $this->transform($response, BlogTransformer::class);
    }

    /**
     * Update Resource
     *
     * @param $id
     * @return array
     * @throws ValidationException
     * @throws UpdateResourceException
     * @throws ResourceNotFoundException
     */
    public function update($id)
    {
        $blogData = $this->validate(request()->merge(['id' => $id]), BlogConstants::UPDATE_BLOG_RULES);

        $response = $this->blogService->updateBlog($id, $blogData);

        return $this->transform($response, BlogTransformer::class);
    }


    /**
     * Delete Resource
     *
     * @param $id
     * @return JsonResponse
     * @throws UpdateResourceException
     * @throws ValidationException
     */
    public function destroy($id)
    {
        $this->validate(request()->merge(['id' => $id]), BlogConstants::DELETE_BLOG_RULES);

        $this->blogService->deleteBlog($id);

        return $this->accepted([
            'Deleted Blog successfully.'
        ], 200);
    }
}
