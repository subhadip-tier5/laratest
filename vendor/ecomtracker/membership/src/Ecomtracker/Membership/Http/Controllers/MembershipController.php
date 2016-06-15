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


class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Return the User Model Data
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @SWG\Get(
     *     path="/api1/membership/{id}",
     *     description="Returns a user object",
     *     operationId="api1.membeship.show",
     *     produces={"application/json"},
     *     tags={"user"},
     *      @SWG\Parameter(
     *          name="token",
     *          in="query",
     *          type="string",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          in="path",
     *          type="number",
     *          required=true,
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Get available Membership Plans UI action.
     *
     * @return Collection
     */
    public function getAvailableMembershipPlans()
    {

        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();

        $current_membership_plan=$logined_user->membership_plan_id;
        $AvailableMembershipPlans=MembershipPlan::where('is_selectable','1')
            ->where('id','!=',$current_membership_plan)
            ->get();
        return $AvailableMembershipPlans;

    }




    /**
     * Change Membership Plan UI action.
     *
     * @param Request $request
     * @return bool  changed or not
     * @throws MembershipException If the Membership Plan is not available for user
     */
    public function ChangePlan(Request $request)
    {

        $new_id=$request->input('id');
        $method=$request->input('method');

        $User=\Ecomtracker\User\Models\User::Logined()->first();

        if( MembershipPlan::isAllowedForMember($User) )
        {

            try
            {
                $newPlan=MembershipPlan::find($new_id);

                // changing plan
                switch($method)
                {
                    case "immediatelly":
                        BillingManager::ChargeAndSave($User,$newPlan);
                        break;

                    case "at_the_end":
                        BillingManager::ScheduleChargeAndSave($User,$newPlan);
                        break;

                    default:
                        throw new Membershipexception("Method not selected");
                }
            }
            catch( \Ecxeption $e)
            {
                throw new Membershipexception("Error changing the plan");
            }



        }
        else
        {
            throw new Membershipexception("Not allowed to change");


        }

        //return response()->json(false);
    }


    /**
     * Change Membership Plan UI action.
     *
     * @param Request $request
     * @return bool  changed or not
     * @throws MembershipException If the Membership Plan is not available for user
     */
    public function GetCurrentMembershipPlan(Request $request)
    {
        $User=\Ecomtracker\User\Models\User::Logined()->first();
        $MembershipPlan = $User->membershipplan;

        if (!$MembershipPlan)
        {
            $return=['status'=>'no_membership_assigned'];
            abort(404,'No Membership Plan Assigned');
        }
        else
        {
            $return=$MembershipPlan->toArray();

            $return['current_counts']=[];
            $return['current_counts']['total_products']=\Ecomtracker\Membership\MembershipService::countProducts($User);
            $return['current_counts']['tracking_products']=\Ecomtracker\Membership\MembershipService::countTrackingProducts($User);
            $return['current_counts']['total_keywords']=\Ecomtracker\Membership\MembershipService::countKeywords($User);
            $return['current_counts']['total_negative_reviews']=\Ecomtracker\Membership\MembershipService::countNegativeReviews($User);
            $return['current_counts']['total_email_reports']=\Ecomtracker\Membership\MembershipService::countEmailReports($User);

        }

        return response()->json($return);

    }




    /**
     * Cancel Membership Plan UI action.
     *
     * @param Request $request
     * @return bool  canceled or not
     * @throws MembershipException If the Membership Plan is not available for user
     */
    public function CancelCurrentMembershipPlan(Request $request)
    {
        $User=\Ecomtracker\User\Models\User::Logined()->first();
        $res=BillingManager::CancelAndSave($User);
        return $res;

    }


    public function ChangeCCData(Request $request)
    {
        $User=\Ecomtracker\User\Models\User::Logined()->first();
        $res=BillingManager::UpdateCC($User,\Input::all());
        if ($res)
        {return response()->json(['status'=>'success']);}
        else
        {abort(500,'Error changing CC data');}



    }



    public function NMITransactions(Request $request)
    {

        $date_from=$request->input('date_from');
        $date_to=$request->input('date_to');
        $limit=$request->input('limit');


        $User=\Ecomtracker\User\Models\User::Logined()->first();
        $transactions=$User->NMITransactions();

        if ( $date_from)
        {
            $transactions->where('created_at','>=',$date_from);
        }
        if ( $date_to)
        {
            $transactions->where('created_at','<=',$date_to);
        }
        if ( $limit)
        {
            $transactions->take($limit);
        }
        $transactions->orderBy('id', 'desc');

        $transactions_col=$transactions->get();


        return response()->json($transactions_col);




    }

}

