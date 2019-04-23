<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


use Tymon\JWTAuth\Contracts\JWTSubject;
/* use Illuminate\Notifications\Notifiable; */

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class User extends Eloquent implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable/*, Notifiable*/;

    protected $collection = 'users';
   
    /* public function __construct(){ */
    /*     dd('mongo'); */
    /*     parent::__construct(); */
    /* } */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /* protected $fillable = [ */
    /*     'name', 'email', */
    /* ]; */

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    /* protected $hidden = [ */
    /*     'password', */
    /* ]; */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     *      * Return a key value array, containing any custom claims to be added to the JWT.
     *           *
     *                * @return array
     *                     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /* public function retrieveByCredentials(array $credentials){ */
    /*     dd($credentials); */
    /* } */

    /* public function retrieveById($identifier) */
    /* { */
    /*     dd($identifier); */
    /* } */

}
