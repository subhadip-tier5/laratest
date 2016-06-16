<?php
Route::group(['prefix' => 'semrush'], function () {
    Route::get('usage', ['as' => 'semrush.usage', 'uses' => 'Ecomtracker\Semrush\Http\Controllers\UsageController@index']);
});

