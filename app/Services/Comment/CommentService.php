<?php


namespace App\Services\Comment;


use App\Exceptions\CreateResourceException;
use App\Exceptions\UpdateResourceException;
use App\Repositories\Comment\CommentRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class CommentService extends BaseService
{

    public function __construct(protected CommentRepository $commentRepository)
    {
    }

    /**
     * @param array $requestData
     * @return mixed
     * @throws CreateResourceException
     */
    public function createComment(array $requestData)
    {
        try {
            return $this->commentRepository->create($requestData);
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
    public function updateComment($id, array $requestData)
    {
        try {
            return $this->commentRepository->update($requestData, $id);
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
    public function deleteComment($id)
    {
        try {
            return $this->commentRepository->delete($id);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new UpdateResourceException();
        }
    }

}
