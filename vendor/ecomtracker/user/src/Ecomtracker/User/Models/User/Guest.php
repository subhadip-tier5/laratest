<?php namespace Ecomtracker\User\Models\User;

use Ecomtracker\User\Models\Relations\GuestRoleRelation;
use Ecomtracker\User\Models\Role;
use Ecomtracker\User\Models\User;

class Guest extends User
{
    protected $table = null;
    protected $fillable = [];
    protected $primary_key = 'id';


    public function role()
    {
        $instance = Role::getModel();
        return new GuestRoleRelation($instance->query(),$this);
    }


    public function roles()
    {
        $instance = Role::getModel();
        return new GuestRoleRelation($instance->query(),$this);
    }


    public function isGuest()
    {
        return true;
    }

    public function isAdmin()
    {
        return false;
    }

}