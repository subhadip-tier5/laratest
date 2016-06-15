<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/lists', 'ListsController@index');
Route::get('/lists/{slug}', 'ListsController@show');
Route::put('/lists/{slug}', 'ListsController@update');

//Route::model('customer', 'App\Customer');
Route::get('/customers', 'CustomersController@index');
Route::get('/customer/{id}', 'CustomersController@show');