<?php


namespace App\Services\User;


use App\Exceptions\CreateResourceException;
use App\Repositories\User\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserService extends BaseService
{
    protected $oRepository;

    public function __construct(UserRepository $oRepository)
    {
        $this->oRepository = $oRepository;
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
            return $this->oRepository->create($aData);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw new CreateResourceException();
        }
    }
}
