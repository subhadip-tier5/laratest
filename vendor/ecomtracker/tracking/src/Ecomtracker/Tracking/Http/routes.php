<?php


/*
 * TODO: need to move these routes to Api package
 */

Route::group(['prefix' => 'api1'], function () {

    Route::group(['middleware' => 'jwt.auth'], function () {
        //User
        Route::post('GetAmazonProductInfo', ['as' => 'api1.GetAmazonProductInfo', 'uses' => 'Ecomtracker\Tracking\Http\Controllers\TrackingController@GetAmazonProductInfo'] );

        /* use AmazonProduct/{id}/history instead
        Route::post('GetAmazonProductHistory/{id}', 'Ecomtracker\Tracking\Http\Controllers\TrackingController@GetAmazonProductHistory');
        */

        Route::get('GetAmazonKeywordInfo/{id}', ['as' => 'api1.GetAmazonKeywordInfo', 'uses' => 'Ecomtracker\Tracking\Http\Controllers\TrackingController@GetAmazonKeywordInfo']);

        Route::post('GetAmazonKeywordSuggestions', ['as' => 'api1.GetAmazonKeywordSuggestions', 'uses' => 'Ecomtracker\Tracking\Http\Controllers\TrackingController@GetAmazonKeywordSuggestions']);


        Route::post('GetAmazonProductSimilarItems', ['as' => 'api1.GetAmazonProductSimilarItems', 'uses' => 'Ecomtracker\Tracking\Http\Controllers\TrackingController@GetAmazonProductSimilarItems']);
        Route::get('GetAmazonCountries', ['as' => 'api1.GetAmazonCountries', 'uses' => 'Ecomtracker\Tracking\Http\Controllers\TrackingController@GetAmazonCountries']);




        Route::resource('EmailReport', 'Ecomtracker\Tracking\Http\Controllers\EmailReportController', ['only' => [
            'index','show', 'store', 'update', 'destroy'
        ]]);
        Route::post('PreviewEmailReport', ['as' => 'api1.PreviewEmailReport', 'uses' => 'Ecomtracker\Tracking\Http\Controllers\EmailReportController@PreviewEmailReport']);

        Route::get('EmailReports', ['as' => 'api1.EmailReports', 'uses' => 'Ecomtracker\Tracking\Http\Controllers\EmailReportController@index']);

    });

});
