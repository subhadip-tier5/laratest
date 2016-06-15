<?php namespace Ecomtracker\User\Traits;

trait Permissible
{
    public function authorize()
    {
        try{
        $user = \JWTAuth::parseToken()->authenticate();
        } catch(\Exception $e)
        {
            $user = \Auth::user();

        }
        if ($this->denies($user)) {
            return false;
        }

        if($user->isAdmin()) return true;


        if (\Gate::denies(\Request::route()->getName(), $user)) {
            return false;
        }



        return true;
    }
    
}