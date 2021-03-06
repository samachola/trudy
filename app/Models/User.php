<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'idcard', 'phone', 'image', 'role', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];
    
    public $timestamps = false;

    public static $newAccountRules = [
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'phone' => 'unique:users',
    ];

    public static $loginRules = [
        'email' => 'required',
        'password' => 'required'
    ];

    /**
     * User Skills
     * 
     * @return { UserSkills } - Skills belonging to a user.
     */
    public function userSkills()
    {
        return hasOne('App\Models\UserSkills');
    }
}
