<?php

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
|use App\Http\Controllers\UserController;

Route::get('/user', [UserController::class, 'index']);
*/


use App\Http\Controllers\api\ProfileController;
use App\Http\Controllers\api\RouteController;
use App\Http\Controllers\api\TransactionController;

Route::post('/save_user_profile', [ProfileController::class, 'save_user_profile']);
Route::post('/save_route', [RouteController::class, 'save_route']);
Route::post('/save_transaction', [TransactionController::class, 'save_transaction']);
Route::get('/get_transaction', [TransactionController::class, 'get_transaction']);




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
