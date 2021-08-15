<?php


namespace App\Http\Controllers\View;


use App\Constants\UserConstants;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;

class ViewController extends BaseController
{

    public function view()
    {
        if (Auth::check() === false) {
            return redirect('/login');
        }

        if (Auth::user()->user_type !== UserConstants::ADMIN_USER_TYPE && in_array(request()->path(), UserConstants::ALLOWED_WEB_ROUTES)) {
            return redirect('/');
        }

        return view('index', ['token' => Auth::user()->api_token]);
    }
}
