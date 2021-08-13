<?php


namespace App\Services\Comment;


use App\Exceptions\CreateResourceException;
use App\Exceptions\UpdateResourceException;
use App\Repositories\Comment\CommentRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class CommentService extends BaseService
{
    protected $oCommentRepository;

    public function __construct(CommentRepository $oCommentRepository)
    {
        $this->oCommentRepository = $oCommentRepository;
    }

    /**
     * @param array $aData
     * @return mixed
     * @throws CreateResourceException
     */
    public function createComment(array $aData)
    {
        try {
            return $this->oCommentRepository->create($aData);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new CreateResourceException();
        }
    }

    /**
     * @param $iId
     * @param array $aData
     * @return mixed
     * @throws UpdateResourceException
     */
    public function updateComment($iId, array $aData)
    {
        try {
            return $this->oCommentRepository->update($aData, $iId);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new UpdateResourceException();
        }
    }

    public function deleteComment($iId)
    {
        try {
            return $this->oCommentRepository->delete($iId);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new UpdateResourceException();
        }
    }

}
