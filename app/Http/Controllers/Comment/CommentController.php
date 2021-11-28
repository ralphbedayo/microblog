<?php


namespace App\Http\Controllers\Comment;


use App\Constants\CommentConstants;
use App\Exceptions\CreateResourceException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UpdateResourceException;
use App\Http\Controllers\BaseController;
use App\Services\Comment\CommentService;
use App\Transformers\CommentTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CommentController extends BaseController
{
    public function __construct(protected CommentService $commentService)
    {
    }

    /**
     * @return array
     * @throws CreateResourceException
     * @throws ResourceNotFoundException
     * @throws ValidationException
     */
    public function store()
    {
        $requestData = $this->validate(request(), CommentConstants::SAVE_COMMENT_RULES);

        $response = $this->commentService->createComment($requestData);

        return $this->transform($response, CommentTransformer::class);
    }

    /**
     * @param $id
     * @return array
     * @throws ResourceNotFoundException
     * @throws ValidationException
     * @throws UpdateResourceException
     */
    public function update($id)
    {
        $requestData = $this->validate(request()->merge(['id' => $id]), CommentConstants::UPDATE_COMMENT_RULES);

        $response = $this->commentService->updateComment($id, $requestData);

        return $this->transform($response, CommentTransformer::class);

    }


    /**
     * @param $id
     * @return JsonResponse
     * @throws UpdateResourceException
     * @throws ValidationException
     */
    public function destroy($id)
    {
        $this->validate(request()->merge(['id' => $id]), CommentConstants::DELETE_COMMENT_RULES);

        $this->commentService->deleteComment($id);

        return $this->accepted([
            'Deleted Comment successfully.'
        ], 200);
    }

    public function index()
    {

    }

    public function show($id)
    {

    }

}
