<?php

namespace App\Http\Controllers\User;

use App\Constants\UserConstants;
use App\Exceptions\CreateResourceException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UpdateResourceException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\RegisterRequest;
use App\Services\User\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UserController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

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

    /**
     * @return array
     * @throws ResourceNotFoundException
     */
     public function index()
     {
         $oResponseData = $this->oUserService->getAllUsers();

         return $this->transform($oResponseData, UserTransformer::class);
     }

    /**
     * @param $iId
     * @return array
     * @throws ResourceNotFoundException
     */
    public function show($iId)
    {
        $oResponseData = $this->oUserService->findUser($iId);

        return $this->transform($oResponseData, UserTransformer::class);
    }

    /**
     * @param $iId
     * @return array
     * @throws ValidationException
     * @throws UpdateResourceException
     */
    public function update($iId)
    {
        $aFormData = $this->validate(request()->merge(['id' => $iId]), UserConstants::UPDATE_USER_RULES);

        $oUserData = $this->oUserService->updateUser($iId, $aFormData);

        return $this->oUserTransformer->transform($oUserData);
    }

    /**
     * @param $iId
     * @return JsonResponse
     * @throws UpdateResourceException
     * @throws ValidationException
     */
    public function destroy($iId)
    {
        $this->validate(request()->merge(['id' => $iId]), UserConstants::DELETE_USER_RULES);

        $this->oUserService->deleteUser($iId);

        return $this->accepted([
            'Deleted User successfully.'
        ], 200);
    }
}
