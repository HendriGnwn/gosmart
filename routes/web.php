<?php

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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
	Route::get('/', 'Admin\\DashboardController@index');
	
	Route::get('/payment/data', ['as' => 'payment.data', 'uses' => 'Admin\\PaymentController@anyData']);
	Route::resource('/payment', 'Admin\\PaymentController');
});
