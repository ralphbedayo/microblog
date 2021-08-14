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
use Illuminate\Validation\ValidationException;

class BlogController extends BaseController
{
    protected $oBlogService;

    public function __construct(BlogService $oBlogService)
    {
        $this->oBlogService = $oBlogService;
    }

    /**
     * Display a listing of resource
     *
     * @return array
     * @throws ResourceNotFoundException
     */
    public function index()
    {
        $oResponseData = $this->oBlogService->getAllBlog();

        return $this->transform($oResponseData, BlogTransformer::class);
    }

    /**
     * Display specified resource
     *
     * @param string $iId
     * @return array
     * @throws ResourceNotFoundException
     */
    public function show($iId)
    {
        $oResponseData = $this->oBlogService->findBlogById($iId);

        return $this->transform($oResponseData, BlogTransformer::class);
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
        $aBlogData = $this->validate(request(), BlogConstants::SAVE_BLOG_RULES);

        $oResponseData = $this->oBlogService->createBlog($aBlogData);

        return $this->transform($oResponseData, BlogTransformer::class);
    }

    /**
     * Update Resource
     *
     * @param $iId
     * @return array
     * @throws ValidationException
     * @throws UpdateResourceException
     * @throws ResourceNotFoundException
     */
    public function update($iId)
    {
        $aBlogUpdateData = $this->validate(request()->merge(['id' => $iId]), BlogConstants::UPDATE_BLOG_RULES);

        $oResponseData = $this->oBlogService->updateBlog($iId, $aBlogUpdateData);

        return $this->transform($oResponseData, BlogTransformer::class);
    }


    /**
     * Delete Resource
     *
     * @param $iId
     * @return JsonResponse
     * @throws UpdateResourceException
     * @throws ValidationException
     */
    public function destroy($iId)
    {
        $this->validate(request()->merge(['id' => $iId]), BlogConstants::DELETE_BLOG_RULES);

        $this->oBlogService->deleteBlog($iId);

        return $this->accepted([
            'Deleted Blog successfully.'
        ]);
    }
}
