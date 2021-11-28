<?php


namespace App\Services\User;


use App\Exceptions\CreateResourceException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\UpdateResourceException;
use App\Repositories\User\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserService extends BaseService
{

    public function __construct(protected UserRepository $userRepository)
    {
    }


    /**
     * @param array $requestData
     * @return mixed
     * @throws CreateResourceException
     */
    public function createUser(array $requestData)
    {
        $requestData['password'] = Hash::make($requestData['password']);
        $requestData['api_token'] = Str::random(32);

        try {
            return $this->userRepository->create($requestData);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new CreateResourceException();
        }
    }

    /**
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function getAllUsers()
    {
        try {
            return $this->userRepository->paginate();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ResourceNotFoundException();
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function findUser($id)
    {
        try {
            return $this->userRepository->find($id);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ResourceNotFoundException();
        }
    }

    /**
     * @param $id
     * @param $requestData
     * @return mixed
     * @throws UpdateResourceException
     */
    public function updateUser($id, $requestData)
    {
        try {
            return $this->userRepository->update($requestData, $id);
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
    public function deleteUser($id)
    {
        try {
            return $this->userRepository->delete($id);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new UpdateResourceException();
        }
    }
}
