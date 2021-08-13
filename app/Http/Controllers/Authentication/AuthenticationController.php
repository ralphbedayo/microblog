<?php


namespace App\Http\Controllers\Authentication;


use App\Http\Controllers\BaseController;
use App\Http\Requests\Authentication\LoginRequest;
use App\Services\User\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $oUserService;

    protected $oUserTransformer;

    public function __construct(UserService $oUserService, UserTransformer $oUserTransformer)
    {
        $this->oUserService = $oUserService;
        $this->oUserTransformer = $oUserTransformer;
    }


    public function login(LoginRequest $oRequest)
    {
        $aCredentials = $oRequest->all(['username', 'password']);

        if (Auth::attempt($aCredentials) === true) {
            $oRequest->session()->regenerate();

            return $this->oUserTransformer->transform(Auth::user());
        }

        return back()->withErrors([
            'username' => 'Username or password does not match.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function user()
    {
        return Auth::user();
    }

}
