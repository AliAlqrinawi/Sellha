<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DenouncementsController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

Route::get('otp', [OtpController::class , 'sendOtp']);

Route::middleware('auth')->get('/', function (User $user) {
    return view('dashboard.dashboard');
});
Auth::routes();

Route::group([
    'prefix' => '/admin',
    'middleware' => ['auth']
],function () {
    Route::resource('ad' , AdsController::class);
    Route::put('status/ad/{id}', [AdsController::class , 'status']);
    Route::resource('category' , CategoriesController::class);
    Route::put('status/category/{id}', [CategoriesController::class , 'status']);
    Route::resource('subCategory' , SubCategoriesController::class);
    Route::put('status/subCategory/{id}', [SubCategoriesController::class , 'status']);
    Route::resource('user' , UsersController::class);
    Route::put('status/user/{id}', [UsersController::class , 'status']);
    Route::get('profile/{id}', [ProfileController::class , 'show']);
    Route::put('profile/{id}', [ProfileController::class , 'update'])->name('profile.update1');
    Route::resource('setting', SettingsController::class)->only(['index' , 'update']);
    Route::resource('denouncement', DenouncementsController::class)->only(['index' , 'destroy']);
});
