<?php


namespace App\Repositories\User;


use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{

    protected $fieldSearchable = [
        'id'        => '=',
        'name'      => 'like',
        'username'  => 'like',
        'user_type' => '=',
    ];

    /**
     * @inheritDoc
     */
    public function model()
    {
        return User::class;
    }
}
