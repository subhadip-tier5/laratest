<?php

Route::get('test', ['as' => 'test', 'uses' => 'Ecomtracker\Api\Http\Controllers\TestController@index']);


Route::group(['prefix' => 'admin'], function () {

    Route::group(['prefix' => 'login'], function () {
        Route::get('', ['as' => 'admin.login', 'uses' => 'Ecomtracker\Admin\Http\Controllers\LoginController@get']);
        Route::post('', ['as' => 'admin.login.post', 'uses' => 'Ecomtracker\Admin\Http\Controllers\LoginController@post']);
    });

    Route::group(['prefix' => 'logout'], function () {
        Route::get('', ['as' => 'admin.logout', 'uses' => 'Ecomtracker\Admin\Http\Controllers\LogoutController@get']);
    });

    Route::group([], function () { //@todo AJW! add admin middleware

        Route::resource('user', 'Ecomtracker\Admin\Http\Controllers\UserController', ['only' => [
            'index', 'show', 'store', 'update', 'destroy'
        ]]);

        Route::get('user/{id}/loginas', ['as' => 'admin.user.loginas', 'uses' => 'Ecomtracker\Admin\Http\Controllers\UserController@loginAs']);
        Route::put('user/{id}/update/password', ['as' => 'admin.user.update.password', 'uses' => 'Ecomtracker\Admin\Http\Controllers\UserController@updatePassword']);
        Route::put('user/{id}/update/card', ['as' => 'admin.user.update.card', 'uses' => 'Ecomtracker\Admin\Http\Controllers\UserController@updateCard']);


        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('', ['as' => 'admin.dashboard', 'uses' => 'Ecomtracker\Admin\Http\Controllers\DashboardController@show']);
        });


        Route::group(['prefix' => 'report'], function () {
            Route::get('/', ['as' => 'admin.report.index', 'uses' => 'Ecomtracker\Admin\Http\Controllers\ReportController@index']);
            Route::get('sales', ['as' => 'admin.report.sales', 'uses' => 'Ecomtracker\Admin\Http\Controllers\Report\SalesController@show']);
            Route::get('sales/export', ['as' => 'admin.report.sales.export', 'uses' => 'Ecomtracker\Admin\Http\Controllers\Report\SalesController@export']);
        });
    });
});



