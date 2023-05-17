<?php

use App\Http\Controllers\API\V1\Auth\AuthBaseController;
use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\CategoriesController;
use App\Http\Controllers\API\V1\DenouncementsController;
use App\Http\Controllers\API\V1\HomeController;
use App\Http\Controllers\API\V1\ImagesController;
use App\Http\Controllers\API\V1\NotificationsController;
use App\Http\Controllers\API\V1\ProductsController;
use App\Http\Controllers\API\V1\ProfilesController;
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

Route::middleware('setLocale')->prefix('V1')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('submitcode', [AuthController::class, 'submitCode']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('home', HomeController::class);
        Route::resource('category', CategoriesController::class);
        Route::resource('product', ProductsController::class);
        Route::put('product/view/{id}', [ProductsController::class , 'view']);
        Route::delete('product/delete/images', ImagesController::class);
        Route::resource('profile', ProfilesController::class);
        Route::resource('denouncement', DenouncementsController::class);
        Route::resource('notification', NotificationsController::class);
        Route::delete('delete/profile', [AuthController::class , 'deleteAcount']);
        Route::get('logout', [AuthBaseController::class , 'logout']);
    });
});
