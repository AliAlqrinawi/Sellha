<?php

use App\Http\Controllers\API\V1\Auth\AuthBaseController;
use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\NotificationsController;
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

Route::middleware('auth:sanctum')->get('V1/user', function (Request $request) {
    return $request->user();
});

Route::prefix('V1')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('submitcode', [AuthController::class, 'submitCode']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resource('notification', NotificationsController::class);
        Route::delete('delete/profile', [AuthController::class , 'deleteAcount']);
        Route::get('logout', [AuthBaseController::class , 'logout']);
    });
});
