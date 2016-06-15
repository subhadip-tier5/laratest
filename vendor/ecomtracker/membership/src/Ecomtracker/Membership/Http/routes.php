<?php


/*
 * TODO: need to move these routes to Api package
 */

Route::group(['prefix' => 'api1'], function () {

    Route::group(['middleware' => 'jwt.auth'], function () {
        //User
        Route::get('AvailableMembershipPlans', ['as' => 'api1.AvailableMembershipPlans', 'uses' => 'Ecomtracker\Membership\Http\Controllers\MembershipController@getAvailableMembershipPlans'] );
        Route::get('GetCurrentMembershipPlan', ['as' => 'api1.GetCurrentMembershipPlan', 'uses' => 'Ecomtracker\Membership\Http\Controllers\MembershipController@GetCurrentMembershipPlan'] );
        Route::resource('MembershipPlan',  'Ecomtracker\Membership\Http\Controllers\MembershipController',['as' => 'api1.MembershipPlan','only' => [
            'show'
        ]]);
        Route::post('ChangePlan', ['as' => 'api1.ChangePlan', 'uses' => 'Ecomtracker\Membership\Http\Controllers\MembershipController@ChangePlan'] );
        Route::get('CancelCurrentMembershipPlan', ['as' => 'api1.CancelCurrentMembershipPlan', 'uses' => 'Ecomtracker\Membership\Http\Controllers\MembershipController@CancelCurrentMembershipPlan'] );
        Route::post('ChangeCCData', ['as' => 'api1.ChangeCCData', 'uses' => 'Ecomtracker\Membership\Http\Controllers\MembershipController@ChangeCCData'] );
        Route::post('NMITransactions', ['as' => 'api1.NMITransactions', 'uses' => 'Ecomtracker\Membership\Http\Controllers\MembershipController@NMITransactions'] );



        /*&
        Route::group(['prefix' => 'admin'], function () {
            Route::resource('MembershipPlan',  'Ecomtracker\Membership\Http\Controllers\AdminMembershipController',['as' => 'AdminMembershipPlan','only' => [
               'index', 'show', 'store', 'update', 'destroy'
            ]]);

        });
        */


    });

});
