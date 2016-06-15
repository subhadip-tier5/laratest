<?php namespace Ecomtracker\Venue\Http\Controllers;

use Ecomtracker\Venue\Http\Requests\Config\ShowRequest;
use Ecomtracker\Venue\Http\Requests\Config\UpdateRequest;
use Ecomtracker\Venue\Models\Config;
use Ecomtracker\Venue\Models\Venue;
use App\Http\Controllers\Controller;


class ConfigController extends Controller
{

    public function show(ShowRequest $request, $venue_id = null)
    {
        $venue = Venue::where('id','=',$venue_id)->firstOrFail();
        return $venue->configuration;

    }

    public function update(UpdateRequest $request, $venue_id = null)
    {
        $venue = Venue::where('id', '=', $venue_id)->firstOrFail();
        $config = $venue->configuration;

        if(!$venue->configuration)
        {
            $config = Config::getModel();

        }
        
        $result = ['status' => 'success', 'code' => '200'];
        $config->fill($request->all());

        //Add all of the extra stuff to the data field for the entity (amazon creds etc)
        $original_data = json_decode($request->get('data'));
        if(!isset($original_data)) $original_data = [];

        foreach($request->all() as $k => $v)
        {
            $original_data[$k] = $v;

        }

        unset($original_data['token']);


        $config->data = json_encode($original_data);
        $config->venue_id = $venue_id;




        //@todo AJW! this should also create a new config associated with the 
        $config->save();
        return response()->json(compact('result'));
    }

}