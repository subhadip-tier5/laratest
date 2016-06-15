<?php namespace Ecomtracker\User\Models;

use Ecomtracker\User\Models\Collections\PermissionCollection;

class Permission extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'permissions';

    public function roles()
    {
        return $this->belongsToMany('Ecomtracker\User\Models\Role','role_permissions');
    }

    public function newCollection(array $models = [])
    {
        $collection = new PermissionCollection($models);
        return $collection->keyBy('id');
    }

}
