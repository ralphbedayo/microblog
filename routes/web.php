<?php

use App\Http\Controllers\Authentication\AuthenticationController;
use App\Http\Controllers\View\ViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthenticationController::class, 'view']);
Route::get('/register', [AuthenticationController::class, 'viewRegister']);

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);


Route::get('/logout', [AuthenticationController::class, 'logout']);
Route::get('/me', [AuthenticationController::class, 'user']);


Route::get('/admin', [ViewController::class, 'view']);
Route::get('/{all}', [ViewController::class, 'view'])->where('all', '.*');
