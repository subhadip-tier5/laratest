<?php namespace Ecomtracker\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Ecomtracker\Admin\Http\Requests\Dashboard\ShowRequest;
use Ecomtracker\User\Models\User;


class DashboardController extends Controller
{
 
    public function show(ShowRequest $request)
    {
        $data = [
            'total_customers' => User::all()->count(),
            'active_customers' => 0, //@todo AJW! this needs to be worked out
            'inactive_customers' => 0, //@todo AJW! this needs to be worked out
            'recurring_sales' => 0, //@todo AJW! this needs to be worked out
            'new_sales' => 0, //@todo AJW! this needs to be worked out
            'gross_daily_sales' => 0, //@todo AJW! this needs to be worked out
        ];
        
        
        return response()->view('admin::pages.dashboard.show', $data);
        
    }

}