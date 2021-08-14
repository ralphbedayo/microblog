<?php


namespace App\Http\Controllers\Authentication;


use App\Constants\AuthenticationConstants;
use App\Constants\UserConstants;
use App\Exceptions\CreateResourceException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Authentication\LoginRequest;
use App\Services\User\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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

    public function view()
    {
        if (Auth::check() === true) {
            return redirect('/');
        }

        return view('login');
    }

    public function viewRegister()
    {
        if (Auth::check() === true) {
            return redirect('/');
        }

        return view('register');
    }

    /**
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     * @throws CreateResourceException
     */
    public function register()
    {
        $aFormData = $this->validate(request(), UserConstants::SAVE_USER_RULES);

        $oUserData = $this->oUserService->createUser($aFormData);

        if (empty($oUserData) === false) {
            Auth::login($oUserData);

            request()->session()->regenerate();

            return redirect('/');
        }

        return back()->withErrors([
            'system_error' => 'Something happened with the server. Please come back later.',
        ]);
    }

    /**
     * @return array|RedirectResponse
     * @throws ValidationException
     */
    public function login()
    {
        $aCredentials = $this->validate(request(), AuthenticationConstants::LOGIN_PARAMS);

        if (Auth::attempt($aCredentials) === true) {
            request()->session()->regenerate();

            return redirect('/');
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

        return redirect('/login');
    }

    public function user()
    {
        return Auth::user();
    }

}
