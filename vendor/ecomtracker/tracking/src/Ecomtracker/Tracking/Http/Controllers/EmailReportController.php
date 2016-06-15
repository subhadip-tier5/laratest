<?php namespace Ecomtracker\Tracking\Http\Controllers;


use Ecomtracker\Amazon\Http\Requests\ShowRequest;
use Ecomtracker\Amazon\Http\Requests\DestroyRequest;
use Ecomtracker\Amazon\Http\Requests\StoreRequest;
use Ecomtracker\Amazon\Http\Requests\UpdateRequest;

use Ecomtracker\Amazon\Models\Keyword as AmazonKeyword;
use Ecomtracker\Amazon\Models\Product as AmazonProduct;
use Ecomtracker\Tracking\Models\EmailReport;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Ecomtracker\Tracking\Exceptions\TrackingException as TrackingException;
class EmailReportController extends Controller
{


    public function index(\Request $request, $id = null)
    {
        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();

        $EmailReports = $logined_user->EmailReports;

        return $EmailReports;


    }

    public function show(ShowRequest $request, $id = null)
    {
        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();
        //$logined_user=\JWTAuth::parseToken()->authenticate();
        $model = $logined_user->EmailReports()->where('id','=',$id)->firstOrFail();
        return $model;

    }

    public function store(StoreRequest $request)
    {

        $logined_user = \Ecomtracker\User\Models\User::Logined()->first();

        $EmailReport = EmailReport::getModel()->fill($request->all());
        $EmailReport->user_id = $logined_user->id;

        $EmailReport->data=json_decode($request->input('data'));


        $EmailReport->save();


        return $EmailReport;



    }

    public function update(UpdateRequest $request, $id = null)
    {
        //$logined_user=\JWTAuth::parseToken()->authenticate();
        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();

        $EmailReport = $logined_user->EmailReports()->where('id', '=', $id)->firstOrFail();

        $result = ['status' => 'success', 'code' => '200'];
        $EmailReport->fill($request->all());

        $EmailReport->data=json_decode($request->input('data'));

        /*
        $arr=["selected_products" =>
        [
                "1"=>[1,2,3],
                "3"=>[3,7,4]
            ]
        ];
        print_r($arr);

        echo json_encode($arr);
        */

        $EmailReport->save();
        return response()->json(compact('result'));

    }

    public function destroy(DestroyRequest $request, $id = null)
    {
        //$logined_user=\JWTAuth::parseToken()->authenticate();
        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();

        $EmailReport = $logined_user->EmailReports()->where('id', '=', $id)->firstOrFail();

        if ($EmailReport )
        {
            $EmailReport->delete();

            $result = ['status' => 'success', 'code' => '200','action' => 'destroy', 'id' => $id];
        }


        return $result ;
    }




    public function PreviewEmailReport(ShowRequest $request)
    {




        $logined_user=\Ecomtracker\User\Models\User::Logined()->first();
        //$logined_user=\JWTAuth::parseToken()->authenticate();
        $EmailReport = EmailReport::getModel()->fill($request->all());
        $EmailReport->user_id = $logined_user->id;
        $EmailReport->data=json_decode($request->input('data'));

        $Preview=\Ecomtracker\Tracking\TrackingService::ProcessEmailReport($EmailReport,$request->input('format'));

        //$email_preview=  view('tracking::EmailReportTemplate') ;


        return $Preview;

    }



}