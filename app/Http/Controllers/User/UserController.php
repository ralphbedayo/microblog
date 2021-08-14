<?php

namespace App\Http\Controllers\User;

use App\Constants\UserConstants;
use App\Exceptions\CreateResourceException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\RegisterRequest;
use App\Services\User\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\ValidationException;

class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $oUserService;

    protected $oUserTransformer;

    public function __construct(UserService $oUserService, UserTransformer $oUserTransformer)
    {
        $this->oUserService = $oUserService;
        $this->oUserTransformer = $oUserTransformer;
    }

    /**
     * @return mixed
     * @throws CreateResourceException
     * @throws ValidationException
     */
    public function store()
    {
        $aFormData = $this->validate(request(), UserConstants::SAVE_USER_RULES);

        $oUserData = $this->oUserService->createUser($aFormData);

        return $this->oUserTransformer->transform($oUserData);
    }
}
