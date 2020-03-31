<?php

use Illuminate\Support\Facades\Route;

/*
test
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('/', function(){
        return view('auth.login');
        });


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/ajax/users/search', 'UserController@ajaxSearch2');
Route::resource("users", "UserController");


Route::get('/ajax/categories/search', 'CategoryController@ajaxSearch');
Route::get('/categories/trash', 'CategoryController@trash')->name('categories.trash');
Route::get('/categories/{id}/restore', 'CategoryController@restore')->name('categories.restore');
Route::delete('/categories/{category}/delete-permanent','CategoryController@deletePermanent')->name('categories.deletepermanent');
Route::resource('categories', 'CategoryController');


Route::get('/ajax/books/search', 'BookController@ajaxSearch1');
Route::delete('/books/{id}/delete-permanent','BookController@deletePermanent')->name('books.delete-permanent');
Route::get('/books/trash', 'BookController@trash')->name('books.trash');
Route::post('/books/{book}/restore', 'BookController@restore')->name('books.restore'); 
Route::resource("books", "BookController");
 


Route::get('/order/create', 'OrderController@create')->name('order.create');
Route::resource('orders', 'OrderController'); 
 
Route::get('/transaksi', 'Order1Controller@addOrder')->name('order.transaksi');
