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
    protected $oUserRepository;

    public function __construct(UserRepository $oRepository)
    {
        $this->oUserRepository = $oRepository;
    }


    /**
     * @param array $aData
     * @return mixed
     * @throws CreateResourceException
     */
    public function createUser(array $aData)
    {
        $aData['password'] = Hash::make($aData['password']);
        $aData['api_token'] = Str::random(32);

        try {
            return $this->oUserRepository->create($aData);
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
            return $this->oUserRepository->paginate();
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ResourceNotFoundException();
        }
    }

    /**
     * @param $iId
     * @return mixed
     * @throws ResourceNotFoundException
     */
    public function findUser($iId)
    {
        try {
            return $this->oUserRepository->find($iId);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new ResourceNotFoundException();
        }
    }

    /**
     * @param $iId
     * @param $aData
     * @return mixed
     * @throws UpdateResourceException
     */
    public function updateUser($iId, $aData)
    {
        try {
            return $this->oUserRepository->update($aData, $iId);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new UpdateResourceException();
        }
    }

    /**
     * @param $iId
     * @return int
     * @throws UpdateResourceException
     */
    public function deleteUser($iId)
    {
        try {
            return $this->oUserRepository->delete($iId);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new UpdateResourceException();
        }
    }
}
