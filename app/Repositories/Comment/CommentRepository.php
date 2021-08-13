<?php


namespace App\Repositories\Comment;


use App\Models\Comment;
use Prettus\Repository\Eloquent\BaseRepository;

class CommentRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Comment::class;
    }
}
