<?php

use Illuminate\Support\Facades\Route;
// use Krishn\AuthApi\Providers\AuthApi;

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

Route::get('/', function () {
    
    return redirect('/home');
});

Route::resource('/user','UserController');

Auth::routes();

Route::get('/logout','Auth\LoginController@logoutApi');

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/products', 'ProductController');

Route::resource('inventories', 'InventoryController')->middleware('apiToken');
Route::resource('invoices', 'InvoiceController')->middleware('apiToken');
Route::get('invoices/products', 'InvoiceController@products')->middleware('apiToken');
