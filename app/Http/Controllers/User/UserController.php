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

    public function __construct(
        protected UserService     $userService,
        protected UserTransformer $userTransformer)
    {
    }

    /**
     * @return mixed
     * @throws CreateResourceException
     * @throws ValidationException
     */
    public function store()
    {
        $requestData = $this->validate(request(), UserConstants::SAVE_USER_RULES);

        $userData = $this->userService->createUser($requestData);

        return $this->userTransformer->transform($userData);
    }

    /**
     * @return array
     * @throws ResourceNotFoundException
     */
    public function index()
    {
        $response = $this->userService->getAllUsers();

        return $this->transform($response, UserTransformer::class);
    }

    /**
     * @param $id
     * @return array
     * @throws ResourceNotFoundException
     */
    public function show($id)
    {
        $response = $this->userService->findUser($id);

        return $this->transform($response, UserTransformer::class);
    }

    /**
     * @param $id
     * @return array
     * @throws ValidationException
     * @throws UpdateResourceException
     */
    public function update($id)
    {
        $requestData = $this->validate(request()->merge(['id' => $id]), UserConstants::UPDATE_USER_RULES);

        $userData = $this->userService->updateUser($id, $requestData);

        return $this->userTransformer->transform($userData);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws UpdateResourceException
     * @throws ValidationException
     */
    public function destroy($id)
    {
        $this->validate(request()->merge(['id' => $id]), UserConstants::DELETE_USER_RULES);

        $this->userService->deleteUser($id);

        return $this->accepted([
            'Deleted User successfully.'
        ], 200);
    }
}
