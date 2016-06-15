<?php namespace Ecomtracker\User\Models\Collections;

use Illuminate\Database\Eloquent\Collection;

class RoleCollection extends Collection
{
    public function can($key = null)
    {
        foreach($this as $item)
        {
            if($item->can($key)) return true;
        }
        return false;

    }




}