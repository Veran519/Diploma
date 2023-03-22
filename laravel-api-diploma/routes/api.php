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

Route::get('/category/get', [CategoryController::class, 'getCategoryInfo']);
Route::get('/reviews/get', [ReviewController::class, 'getAllReviews']);
Route::get('/products/get', [ProductController::class, 'getProducts']);
Route::get('/products/get/{id}', [ProductController::class, 'getProductsById']);
Route::get('/products/getactual', [ProductController::class, 'getActualandAvailableProducts']);
Route::get('/category/getcategories', [CategoryController::class, 'getCategories']);
Route::post('/products/getproductsinfo', [ProductController::class, 'getProductInfoByArrayIds']);
Route::post('/feedback/post', [FeedbackController::class, 'askCallBack']);
Route::post('/order/make', [OrderController::class, 'makeOrder']);
Route::get('/order/getOrder', [OrderController::class, 'getOrder'])->middleware('auth:sanctum');

Route::post('/registration', [UserController::class, 'registerUser']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/login', [UserController::class, 'login']);
Route::post('/updateUsersData', [UserController::class, 'updateUsersData'])->middleware('auth:sanctum');
Route::post('/order/makeOrderByUser', [OrderController::class, 'makeOrderByUser'])->middleware('auth:sanctum');