<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

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

Route::controller(CategoryController::class)->group(function () {
    Route::get('/category/get', 'getCategoryInfo');
    Route::get('/category/getcategories', 'getCategories');
});

Route::post('/feedback/post', [FeedbackController::class, 'askCallBack']);

Route::controller(OrderController::class)->group(function () {
    Route::get('/order/getOrders', 'getOrders')->middleware('auth:sanctum');
    Route::post('/order/make', 'makeOrder');
    Route::post('/order/makeOrderByUser', 'makeOrderByUser')->middleware('auth:sanctum');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products/get', 'getProducts');
    Route::get('/products/get/{id}', 'getProductsById');
    Route::get('/products/getactual', 'getActualandAvailableProducts');
    Route::post('/products/getproductsinfo', 'getProductInfoByArrayIds');
});

Route::get('/reviews/get', [ReviewController::class, 'getAllReviews']);

Route::controller(UserController::class)->group(function () {
    Route::post('/registration', 'registerUser');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
    Route::post('/login', 'login');
    Route::post('/updateUsersData', 'updateUsersData')->middleware('auth:sanctum');
});