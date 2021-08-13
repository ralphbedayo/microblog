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
use Illuminate\Support\Facades\Auth;

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
     * @param RegisterRequest $oRequest
     * @return mixed
     * @throws CreateResourceException
     */
    public function store(RegisterRequest $oRequest)
    {
        $aFormData = $oRequest->all(UserConstants::SAVE_USER_PARAMS);

        $oUserData = $this->oUserService->createUser($aFormData);

        Auth::login($oUserData);

        return $this->oUserTransformer->transform($oUserData);
    }
}
