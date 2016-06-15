<?php

Route::get('test', ['as' => 'test', 'uses' => 'Ecomtracker\Api\Http\Controllers\TestController@index']);


Route::get('testeror', function () {
    abort('400', 'Aborting');
});



Route::group(['prefix' => 'api1'], function () {
    Route::post('auth', ['as' => 'api1.auth', 'uses' => 'Ecomtracker\Api\Http\Controllers\User\AuthController@post']);
    Route::get('logout', ['as' => 'api1.logout', 'uses' => 'Ecomtracker\Api\Http\Controllers\User\AuthController@logout']);

    //NON JWT
    Route::group(['prefix' => 'user'], function () {
        Route::post('register', ['as' => 'api1.user.register.post', 'uses' => 'Ecomtracker\Api\Http\Controllers\User\RegisterController@post']);

        Route::group(['prefix' => 'password'], function () {
            Route::post('forgot', ['as' => 'api1.user.password.forgot', 'uses' => 'Ecomtracker\Api\Http\Controllers\User\PasswordController@forgot']);
            Route::get('reset/{token}', ['as' => 'api1.user.password.reset', 'uses' => 'Ecomtracker\Api\Http\Controllers\User\PasswordController@getReset']);
            Route::post('reset', ['as' => 'api1.user.password.reset.post', 'uses' => 'Ecomtracker\Api\Http\Controllers\User\PasswordController@postReset']);
        });

    });
    
    
    //JWT
    Route::group(['middleware' => ['jwt.auth']], function () {
        
        //Source
        Route::group(['prefix' => 'source'], function () {
            Route::get('', ['as' => 'api1.source.index', 'uses' => 'Ecomtracker\Api\Http\Controllers\SourceController@index']);
        });
        
        //User
        Route::group(['prefix' => 'user'], function () {
            Route::get('{id?}',['as' => 'api1.user.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\UserController@show']);
            Route::put('',['as' => 'api1.user.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\UserController@update']);
            Route::get('{id}/venues', ['as' => 'api1.user.venue.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\User\VenueController@show']);
        });

        //Venue
        Route::resource('venue', 'Ecomtracker\Api\Http\Controllers\VenueController', ['only' => [
            'show', 'store', 'update', 'destroy'
        ]]);

        Route::group(['prefix' => 'venue'], function () {
            Route::get('{venue}/config', ['as' => 'api1.venue.config.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Venue\ConfigController@show']);
            Route::put('{venue}/config', ['as' => 'api1.venue.config.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\Venue\ConfigController@update']);
        });
        

        //Search
        Route::group(['prefix' => 'search'], function () {
            Route::get('keyword', ['as' => 'api1.keyword.search.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\SearchController@show']);
        });
        
        //Keyword
        Route::resource('keyword', 'Ecomtracker\Api\Http\Controllers\KeywordController', ['only' => [
            'show', 'store', 'update', 'destroy'
        ]]);
        Route::group(['prefix' => 'keyword'], function () {
            Route::get('{id}/history', ['as' => 'api1.keyword.history.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\HistoryController@show']);
            Route::get('{id}/related', ['as' => 'api1.keyword.related.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\RelatedController@show']);
            Route::get('{id}/related/update', ['as' => 'api1.keyword.related.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\RelatedController@update']);
            
            Route::get('{id}/organic/update', ['as' => 'api1.keyword.organic.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\OrganicController@update']);
            Route::get('{id}/organic', ['as' => 'api1.keyword.organic.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\OrganicController@show']);
            Route::get('{id}/organic/distribution', ['as' => 'api1.keyword.organic.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Organic\DistributionController@show']);
            Route::get('{id}/organic/distribution/update', ['as' => 'api1.keyword.organic.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Organic\DistributionController@update']);
            Route::get('{id}/organic/distribution', ['as' => 'api1.keyword.organic.distribution.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Organic\DistributionController@show']);
            Route::get('{id}/organic/distribution/update', ['as' => 'api1.keyword.organic.distribution.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Organic\DistributionController@update']);
            Route::get('{id}/organic/results', ['as' => 'api1.keyword.organic.results.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Organic\ResultController@show']);
            Route::get('{id}/organic/results/update', ['as' => 'api1.keyword.organic.results.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Organic\ResultController@update']);
            Route::get('{id}/organic/trend', ['as' => 'api1.keyword.organic.trend.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Organic\TrendController@show']);
            Route::get('{id}/organic/trend/update', ['as' => 'api1.keyword.organic.trend.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Organic\TrendController@update']);
            Route::get('{id}/related/phrase', ['as' => 'api1.keyword.related.phrase.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Related\PhraseMatchedController@show']);
            Route::get('{id}/related/phrase/update', ['as' => 'api1.keyword.related.phrase.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Related\PhraseMatchedController@update']);




            Route::get('{id}/paid/update', ['as' => 'api1.keyword.paid.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\PaidController@update']);
            Route::get('{id}/paid', ['as' => 'api1.keyword.paid.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\OrganicController@show']);
            Route::get('{id}/paid/distribution/update', ['as' => 'api1.keyword.paid.distribution.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Paid\DistributionController@update']);
            Route::get('{id}/paid/distribution', ['as' => 'api1.keyword.paid.distribution.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Paid\DistributionController@show']);
            Route::get('{id}/paid/results', ['as' => 'api1.keyword.paid.results.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Paid\ResultController@show']);
            Route::get('{id}/paid/results/update', ['as' => 'api1.keyword.paid.results.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Paid\ResultController@update']);
            Route::get('{id}/paid/trend', ['as' => 'api1.keyword.paid.trend.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Paid\TrendController@update']);
            Route::get('{id}/paid/trend/update', ['as' => 'api1.keyword.paid.trend.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\Paid\TrendController@update']);

            Route::get('{id}/competitors', ['as' => 'api1.keyword.competitors.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\Keyword\CompetitorController@show']);
        });

        //Product
        Route::resource('product', 'Ecomtracker\Api\Http\Controllers\ProductController', ['only' => [
            'show', 'store', 'update', 'destroy'
        ]]);

        Route::group(['prefix' => 'product'], function () {
            Route::get('{product}/keywords',['as' => 'api1.product.keywords', 'uses' => 'Ecomtracker\Api\Http\Controllers\Product\KeywordsController@show']);
            Route::get('{product}/keywords/results',['as' => 'api1.product.keywords.results', 'uses' => 'Ecomtracker\Api\Http\Controllers\Product\Keywords\ResultsController@show']);
            Route::get('{product}/keywords/competitors',['as' => 'api1.product.keywords.competitors', 'uses' => 'Ecomtracker\Api\Http\Controllers\Product\Keywords\CompetitorsController@show']);

//            Route::get('{product}/keyword/{keyword}/positions',['as' => 'api1.product.keyword.positions', 'uses' => 'Ecomtracker\Api\Http\Controllers\Product\Keyword\PositionsController@show']);
//            Route::get('{product}/keywords/competitors',['as' => 'api1.product.keyword.competition', 'uses' => 'Ecomtracker\Api\Http\Controllers\Product\Keyword\CompetitorsController@show']);




//            Route::get('{id?}/keywords/organic/volumes',['as' => 'api1.product.keywords.', 'uses' => 'Ecomtracker\Api\Http\Controllers\Product\KeywordController@show']);
//            Route::put('',['as' => 'api1.user.update', 'uses' => 'Ecomtracker\Api\Http\Controllers\UserController@update']);
//            Route::get('{id}/venues', ['as' => 'api1.user.venue.show', 'uses' => 'Ecomtracker\Api\Http\Controllers\User\VenueController@show']);
        });




        Route::post('AmazonProducts', ['as' => 'api1.AmazonProducts', 'uses' => 'Ecomtracker\Api\Http\Controllers\AmazonProductController@AmazonProducts']  );

        //AmazonProduct (can replace the /Product route then)
        Route::resource('AmazonProduct', 'Ecomtracker\Api\Http\Controllers\AmazonProductController', ['only' => [
            'show', 'store', 'update', 'destroy'
        ]]);

        Route::group(['prefix' => 'AmazonProduct'], function () {
            Route::get('{id}/AmazonKeywords', ['as' => 'api1.AmazonProduct.AmazonKeywords', 'uses' => 'Ecomtracker\Api\Http\Controllers\AmazonProductController@AmazonKeywords']);
            Route::get('{id}/history', ['as' => 'api1.AmazonProduct.history', 'uses' => 'Ecomtracker\Api\Http\Controllers\AmazonProductController@history']);
            Route::get('{id}/LastTrackedStats', ['as' => 'api1.AmazonProduct.LastTrackedStats', 'uses' => 'Ecomtracker\Api\Http\Controllers\AmazonProductController@LastTrackedStats']);
            Route::get('{id}/reviews', ['as' => 'api1.AmazonProduct.reviews', 'uses' => 'Ecomtracker\Api\Http\Controllers\AmazonProductController@reviews']);
            Route::post('{id}/OnPageInfo', ['as' => 'api1.AmazonProduct.reviews', 'uses' => 'Ecomtracker\Api\Http\Controllers\AmazonProductController@OnPageInfo']);
            Route::get('{id}/TopKeyword', ['as' => 'api1.AmazonProduct.TopKeyword', 'uses' => 'Ecomtracker\Api\Http\Controllers\AmazonProductController@TopKeyword']);

        });


        //AmazonKeyword (can replace the /Keyword route then)
        Route::resource('AmazonKeyword', 'Ecomtracker\Api\Http\Controllers\AmazonKeywordController', ['only' => [
            'show', 'store', 'update', 'destroy'
        ]]);

        Route::post('AddAmazonKeywords',  ['as' => 'api1.AddAmazonKeywords', 'uses' => 'Ecomtracker\Api\Http\Controllers\AmazonKeywordController@AddAmazonKeywords']);

        Route::group(['prefix' => 'AmazonKeyword'], function () {
            Route::get('{id}/history', ['as' => 'api1.AmazonKeyword.history', 'uses' => 'Ecomtracker\Api\Http\Controllers\AmazonKeywordController@history']);

        });

    });
});

