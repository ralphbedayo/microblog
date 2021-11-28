<?php

namespace App\Transformers;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 *
 * @package App\Transformers
 */
class UserTransformer extends TransformerAbstract
{

    /**
     * @param User|Authenticatable $userModel
     * @return array
     */
    public function transform($userModel)
    {
        return [
            'id'         => $userModel->id,
            'username'   => $userModel->username,
            'user_type'  => $userModel->user_type,
            'name'       => $userModel->name,
            'created_at' => $userModel->created_at,
            'updated_at' => $userModel->updated_at
        ];
    }
}
