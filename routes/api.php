<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('users', UserController::class);
Route::get('/login', [UserController::class, 'login']);

Route::resource('blogs', BlogController::class);
Route::resource('comments', CommentController::class);
