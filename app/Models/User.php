<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'users';
    protected $fillable = [
        'name', 'phone' , 'photo' , 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    
    public function advertisements()
    {
        return $this->hasMany(Advertisement::class, 'user_id', 'id');
    }

    

}
