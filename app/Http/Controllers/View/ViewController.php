<?php


namespace App\Http\Controllers\View;


use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;

class ViewController extends BaseController
{

    public function view()
    {
        if (Auth::check() === false) {
            return redirect('/login');
        }

        return view('index', ['token' => Auth::user()->api_token]);
    }
}
