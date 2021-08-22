<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\User\ForgotPasswordController;
use App\Http\Controllers\Api\User\RegisterController;
use App\Http\Controllers\Api\User\UserAuthController;
use App\Http\Controllers\Api\User\UserController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['middleware' => ['api', 'checkLanguage'], 'namespace' => 'Api'], function () {

    Route::get('/hello', function () {
        return response()->json('Hello word');

    });

    /*******************  Route auth admin *******************/
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth.guard:admin_api');

        Route::post('me', [AuthController::class, 'me'])->middleware('auth.guard:admin_api');

    });

    /*******************  Route auth user *******************/

    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::post('login', [UserAuthController::class, 'login']);
        Route::post('logout', [UserAuthController::class, 'logout'])->middleware('auth.guard:user_api');
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('password/forgot', [ForgotPasswordController::class, 'forgot']);

    });

    /*******************  Route user *******************/

    Route::group(['prefix' => 'user', 'middleware' => 'auth.guard:user_api'], function () {
        Route::post('profile', [UserController::class, 'profile']);
        Route::post('update/profile', [UserController::class, 'updateProfile']);

    });


    /*******************  Route category *******************/
    Route::group(['prefix' => 'category', /*'middleware' => 'auth.guard:admin_api'*/], function () {
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/store', [CategoryController::class, 'store']);
        Route::post('/show', [CategoryController::class, 'show']);
        Route::put('/update', [CategoryController::class, 'update']);
        Route::delete('/delete', [CategoryController::class, 'destroy']);
        Route::post('/change-status', [CategoryController::class, 'changeStatus']);

    });

    Route::group(['prefix' => 'product', /*'middleware' => 'auth.guard:admin_api'*/], function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/reviews/{id}', [ProductController::class, 'showReviewProduct'])->name('product.reviews');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::put('/update', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/delete', [ProductController::class, 'destroy'])->name('product.delete');

    });

    Route::group(['prefix' => 'review', /*'middleware' => 'auth.guard:admin_api'*/], function () {
        Route::get('/', [ReviewController::class, 'index']);
        Route::post('/store', [ReviewController::class, 'store']);
        Route::get('/show', [ReviewController::class, 'show']);
        Route::put('/update', [ReviewController::class, 'update']);
        Route::delete('/delete', [ReviewController::class, 'destroy']);

    });


});
