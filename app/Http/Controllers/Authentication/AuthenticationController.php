<?php


namespace App\Http\Controllers\Authentication;


use App\Constants\AuthenticationConstants;
use App\Constants\UserConstants;
use App\Exceptions\CreateResourceException;
use App\Exceptions\ResourceNotFoundException;
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

    public function __construct(protected UserService $userService, protected UserTransformer $userTransformer)
    {
    }

    public function view()
    {
        if (Auth::check() === true) {

            return redirect(UserConstants::HOME_URL[Auth::user()->user_type]);
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
        $requestData = $this->validate(request(), UserConstants::SAVE_USER_RULES);
        $requestData['user_type'] = UserConstants::BLOGGER_USER_TYPE;

        $userData = $this->userService->createUser($requestData);

        if (empty($userData) === false) {
            Auth::login($userData);

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
        $credentials = $this->validate(request(), AuthenticationConstants::LOGIN_PARAMS);

        if (Auth::attempt($credentials) === true) {
            request()->session()->regenerate();

            return redirect(UserConstants::HOME_URL[Auth::user()->user_type]);
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

    /**
     * @return array
     * @throws ResourceNotFoundException
     */
    public function user()
    {
        return $this->transform(Auth::user(), UserTransformer::class);
    }

}
