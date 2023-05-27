<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SubCategoriesController;
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

Route::middleware('auth')->get('/', function (User $user) {
    return view('dashboard.dashboard');
});
Auth::routes();

Route::group([
    'prefix' => '/admin',
    'middleware' => ['auth']
],function () {
    Route::resource('category' , CategoriesController::class);
    Route::put('status/category/{id}', [CategoriesController::class , 'status']);
    Route::resource('subCategory' , SubCategoriesController::class);
    Route::put('status/subCategory/{id}', [SubCategoriesController::class , 'status']);
});
