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
     * @param User|Authenticatable $oUserModel
     * @return array
     */
    public function transform($oUserModel)
    {
        return [
            'id'         => $oUserModel->id,
            'username'   => $oUserModel->username,
            'name'       => $oUserModel->name,
            'created_at' => $oUserModel->created_at,
            'updated_at' => $oUserModel->updated_at
        ];
    }
}
