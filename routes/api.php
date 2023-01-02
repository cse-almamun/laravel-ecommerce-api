<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



/**
 * Public routes
 * Which is access by all user
 * */

//user login route
Route::post('/login', [AuthController::class, 'login']);
//user resgister route
Route::post('/register', [AuthController::class, 'register']);
//Products Resource Routes
Route::resource('/products', ProductController::class);

//Coupons Resouce Routes
Route::resource('/coupon', CouponController::class);


/**
 * Protected Routes
 * which is protecte by sanctum auth
 * */
Route::group(['middleware' => ['auth:sanctum']], function () {
    //get logged in user details
    Route::get('/user', [AuthController::class, 'user']);

    //user order
    Route::resource("/order", OrderController::class);

    //log out user route
    Route::post('/logout', [AuthController::class, 'logout']);
});
