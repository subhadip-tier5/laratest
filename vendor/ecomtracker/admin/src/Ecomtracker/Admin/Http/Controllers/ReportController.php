<?php namespace Ecomtracker\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Ecomtracker\Admin\Http\Requests\Dashboard\ShowRequest;
use Ecomtracker\Admin\Http\Requests\Report\IndexRequest;
use Ecomtracker\User\Models\User;


class ReportController extends Controller
{
 
    
    public function index(IndexRequest $request)
    {

        $data = [
            'sales' => [],
        ];

        return view('admin::pages.report.index');

    }
    
    


}