<?php


namespace App\Repositories\User;


use App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return User::class;
    }
}
