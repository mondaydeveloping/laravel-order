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
    
    Route::get('/books/{id}', 'Order1Controller@getBook');
    Route::post('/cart', 'Order1Controller@addToCart');
    Route::get('/cart', 'Order1Controller@getCart');
    Route::get('/cart', 'Order1Controller@Checkout');
    Route::delete('/cart/{id}', 'Order1Controller@removeCart');
    Route::post('/costumer/search', 'CustomerController@search');

});
