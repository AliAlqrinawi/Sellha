<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ControlPanelUsersController;
use App\Http\Controllers\DenouncementsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
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

Route::get('test' , function(){
    return view('dashboard.test');
});

Route::prefix(LaravelLocalization::setLocale())->middleware(['auth' , 'localization'])->get('/', function (User $user) {
    return view('dashboard.dashboard');
})->name('home');
Auth::routes();

Route::group([
    'prefix' => LaravelLocalization::setLocale().'/admin',
    'middleware' => ['auth' , 'localization']
],function () {
    Route::resource('ad' , AdsController::class);
    Route::put('status/ad/{id}', [AdsController::class , 'status']);
    Route::resource('category' , CategoriesController::class);
    Route::put('status/category/{id}', [CategoriesController::class , 'status']);
    Route::resource('subCategory' , SubCategoriesController::class);
    Route::put('status/subCategory/{id}', [SubCategoriesController::class , 'status']);
    Route::resource('user' , UsersController::class);
    Route::put('status/user/{id}', [UsersController::class , 'status']);
    Route::get('profile/{id}', [ProfileController::class , 'show'])->name('profile.show1');
    Route::put('profile/{id}', [ProfileController::class , 'update'])->name('profile.update1');
    Route::resource('setting', SettingsController::class)->only(['index' , 'update']);
    Route::get('setting/social', [SettingsController::class , 'social'])->name('setting.social');
    Route::resource('denouncement', DenouncementsController::class)->only(['index' , 'destroy']);
    Route::resource('role' , RoleController::class);
    Route::resource('admin' , ControlPanelUsersController::class);
    Route::put('status/admin/{id}', [ControlPanelUsersController::class , 'status']);
    Route::resource('product' , ProductsController::class);
    Route::put('status/product/{id}', [ProductsController::class , 'status']);
});
