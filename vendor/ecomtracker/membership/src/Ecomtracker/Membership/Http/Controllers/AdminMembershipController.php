<?php

namespace Ecomtracker\Membership\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Ecomtracker\Membership\Models\MembershipPlan;
use Ecomtracker\User\Models\User;
use Tymon\JWTAuth\JWTAuth;
use Ecomtracker\Membership\Exceptions\Membershipexception ;
use Ecomtracker\Membership\BillingManager as BillingManager;

use Ecomtracker\Amazon\Models\Keyword as AmazonKeyword;
use Ecomtracker\Amazon\Models\Product as AmazonProduct;


class AdminMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $MembershipPlans = MembershipPlan::all();
        return $MembershipPlans;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $MembershipPlan = MembershipPlan::getModel()->fill($request->all());
        $MembershipPlan->save();
        return $MembershipPlan;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $MembershipPlan = MembershipPlan::where('id','=',$id)->firstOrFail();
        return $MembershipPlan;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $MembershipPlan = MembershipPlan::where('id', '=', $id)->firstOrFail();
        $result = ['status' => 'success', 'code' => '200'];
        $MembershipPlan->fill($request->all());
        $MembershipPlan->save();
        return response()->json(compact('result'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MembershipPlan::destroy($id);
        $result = ['status' => 'success', 'code' => '200', 'action' => 'destroy', 'id' => $id];
        return response()->json(compact('result'));
    }




}

