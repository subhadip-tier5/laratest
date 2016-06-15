<?php


/*
 * TODO: need to move these routes to Api package
 */

Route::group(['prefix' => 'api1'], function () {

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::resource('AmazonProduct', 'Ecomtracker\Amazon\Http\Controllers\AmazonProductController', ['only' => [
            'show', 'store', 'update', 'destroy'
        ]]);

        Route::resource('AmazonKeyword', 'Ecomtracker\Amazon\Http\Controllers\AmazonKeywordController', ['only' => [
            'show', 'store', 'update', 'destroy'
        ]]);
        
    });

});
