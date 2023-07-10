<?php

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\API\V1\OrdersController as V1OrdersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ControllersService;
use App\Http\Controllers\ControlPanelUsersController;
use App\Http\Controllers\DenouncementsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
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

Route::get('test', [HomeController::class, 'index']);


Route::get('test12', function(){
	$url = "https://test.oppwa.com/v1/checkouts";
	$data = "entityId=8a8294174d0595bb014d05d82e5b01d2" .
                "&amount=92.00" .
                "&currency=SAR" .
                "&paymentType=DB" .
                // "&registrations[0].id=8ac7a4a2892b3dc301892c29a18f0a59" .
                // "&registrations[1].id=8ac7a4a0892b3dc201892c29a27d0cb6" .
                "&standingInstruction.source=CIT" .
                "&standingInstruction.mode=REPEATED" .
                "&standingInstruction.type=UNSCHEDULED";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$responseData = curl_exec($ch);
	if(curl_errno($ch)) {
		return curl_error($ch);
	}
	curl_close($ch);
    $responseData = json_decode($responseData);
    return view('pay' , compact('responseData'));
});

Route::get('resourcePath/{id}', function($id){
    $url = "https://test.oppwa.com/v1/checkouts/$id/payment";
    $url .= "?entityId=8a8294174d0595bb014d05d82e5b01d2";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseData = curl_exec($ch);
    if(curl_errno($ch)) {
        return curl_error($ch);
    }
    curl_close($ch);
    return $responseData;
})->name("dsdsa");


Route::prefix(LaravelLocalization::setLocale())->middleware(['auth', 'localization'])->get('/',  [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group([
    'prefix' => LaravelLocalization::setLocale() . '/admin',
    'middleware' => ['auth', 'localization']
], function () {
    Route::resource('ad', AdsController::class);
    Route::put('status/ad/{id}', [AdsController::class, 'status']);
    Route::resource('category', CategoriesController::class);
    Route::put('status/category/{id}', [CategoriesController::class, 'status']);
    Route::resource('subCategory', SubCategoriesController::class);
    Route::put('status/subCategory/{id}', [SubCategoriesController::class, 'status']);
    Route::resource('user', UsersController::class);
    Route::put('status/user/{id}', [UsersController::class, 'status']);
    Route::get('profile/{id}', [ProfileController::class, 'show'])->name('profile.show1');
    Route::put('profile/{id}', [ProfileController::class, 'update'])->name('profile.update1');
    Route::resource('setting', SettingsController::class)->only(['index', 'update']);
    Route::get('setting/social', [SettingsController::class, 'social'])->name('setting.social');
    Route::resource('denouncement', DenouncementsController::class)->only(['index', 'destroy']);
    Route::resource('role', RoleController::class);
    Route::resource('admin', ControlPanelUsersController::class);
    Route::put('status/admin/{id}', [ControlPanelUsersController::class, 'status']);
    Route::resource('product', ProductsController::class);
    Route::put('status/product/{id}', [ProductsController::class, 'status']);
    Route::resource('order', OrdersController::class);
    Route::put('status/order/{id}', [OrdersController::class, 'status']);
    Route::get('edit', [AdminsController::class, 'edit_admin'])->name('admin.edit1');
    Route::post('update', [AdminsController::class, 'update_admin'])->name('admin.updat');
    Route::get('resetPassword', [AdminsController::class, 'reset_Password'])->name('admin.resetPassword1');;
    Route::post('reset-Password', [AdminsController::class, 'resetPassword'])->name('admin.resetPassword');
});

Route::get('createPaymentLink/{id}', [V1OrdersController::class , 'createPaymentLink'])->name('createPaymentLink');
Route::get('sendIdForPayment/{id}/{idOrder}', [V1OrdersController::class , 'sendIdForPayment'])->name('sendIdForPayment');
Route::get('statusPayment/{id}/{status}', function($id , $status){
    if($status == "PAID"){
        return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS', 200);
    }else{
        return ControllersService::generateProcessResponse(false, 'CREATE_FAILED', 200);
    }
})->name("statusPayment");

