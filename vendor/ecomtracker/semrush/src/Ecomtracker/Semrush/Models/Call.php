<?php namespace Ecomtracker\Semrush\Models;

use Illuminate\Database\Eloquent\Model;


class Call extends Model
{
    protected $table = 'semrush_api_calls';
    
    
    protected $fillable = [
        'name',
        'lines',
        'is_historic',
        'cpl',
        'cplh',
        'user_id',
        'data',
        'entity_id',
    ];


    public function user()
    {
        return $this->hasOne('Ecomtracker\User\Models\User','id','user_id');
    }

    private function calculateTotalCost()
    {
        //If we are dealing with historic lines use that price to calculate the total
        if ($this->is_historic == 1) {
            //If we dont have the historic cost set get it from the config
            if (!isset($this->cplh)) {
                if (!isset($this->name)) {
                    \Log::error('The name for the call was not defined please pass the name to the call before logging');
                } else {
                    $this->cplh = \Config::get('semrush.calls.' . $this->name . '.cplh');
                }

            }

            $total = $this->cplh * $this->lines;

        } else {
            //We are dealing with non historic lines use that value to calculate total

            //If we dont have cpl get it from the config
            if (!isset($this->name)) {
                \Log::error('The name for the call was not defined please pass the name to the call before logging');
            } else {
                $this->cpl = \Config::get('semrush.calls.' . $this->name . '.cpl');
            }

            $total = $this->cpl * $this->lines;
        }
        return $total;

    }



    public function save(array $options = [])
    {
        $this->total_cost = $this->calculateTotalCost();

        return parent::save($options);
    }


}