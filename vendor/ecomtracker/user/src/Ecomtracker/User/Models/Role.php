<?php namespace Ecomtracker\User\Models;

use Ecomtracker\User\Models\Collections\PermissionCollection;
use Ecomtracker\User\Models\Collections\RoleCollection;

class Role extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'roles';
    protected $fillable = [
        'key'
    ];

    public function users()
    {
        return $this->hasMany('Ecomtracker\User\Models\User');
    }

    public function permissions()
    {
        $config = \Config::get('roles.'.$this->key);
        $permissionsCollection = new PermissionCollection();

        foreach($config as $item => $value)
        {
            if($value == true)
            {
                $newPermission = Permission::getModel();
                $newPermission->key = $item;
                $permissionsCollection->add($newPermission);

            }
        }

        return $permissionsCollection;

    }


    public function can($key = null)
    {
        if($this->permissions() && $this->permissions()->keyBy('key')->has($key))
        {
            return true;
        }else{
            //retrieve the permission by config
            $config = \Config::get('roles.'.$this->key.'.'.$key);
            if(!isset($config)) return false;

            return true;
        }
        return false;
    }
    
    public function newCollection(array $models = [])
    {
        return new RoleCollection($models);
    }
    


}
