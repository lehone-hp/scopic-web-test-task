<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'API'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::get('products/categories', 'ProductCategoryController@fetchAll');

    Route::get('products', 'ProductController@fetchAll');
    Route::get('products/{slug}', 'ProductController@fetchBySlug');

    Route::post('products/bid/create', 'BidController@placeBid');
    Route::post('products/bid/auto-bid', 'BidController@toggleAutoBid');

    Route::get('bids', 'BidController@fetchBid');

    Route::get('/user/settings/{user_id}', 'UserController@fetchSettings');
    Route::post('/user/settings', 'UserController@updateSettings');
});
