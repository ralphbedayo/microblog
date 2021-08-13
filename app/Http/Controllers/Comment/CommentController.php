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
    protected $oCommentService;

    public function __construct(CommentService $oCommentService)
    {
        $this->oCommentService = $oCommentService;
    }

    /**
     * @return array
     * @throws CreateResourceException
     * @throws ResourceNotFoundException
     * @throws ValidationException
     */
    public function store()
    {
        $aCommentData = $this->validate(request(), CommentConstants::SAVE_COMMENT_RULES);

        $oResponseData = $this->oCommentService->createComment($aCommentData);

        return $this->transform($oResponseData, CommentTransformer::class);
    }

    /**
     * @param $iId
     * @return array
     * @throws ResourceNotFoundException
     * @throws ValidationException
     * @throws UpdateResourceException
     */
    public function update($iId)
    {
        $aCommentData = $this->validate(request()->merge(['id' => $iId]), CommentConstants::UPDATE_COMMENT_RULES);

        $oResponseData = $this->oCommentService->updateComment($iId, $aCommentData);

        return $this->transform($oResponseData, CommentTransformer::class);

    }


    /**
     * @param $iId
     * @return JsonResponse
     * @throws UpdateResourceException
     * @throws ValidationException
     */
    public function destroy($iId)
    {
        $this->validate(request()->merge(['id' => $iId]), CommentConstants::DELETE_COMMENT_RULES);

        $this->oCommentService->deleteComment($iId);

        return $this->accepted([
            'Deleted Comment successfully.'
        ]);
    }

    public function index($iId)
    {

    }

    public function show($iId)
    {

    }

}
