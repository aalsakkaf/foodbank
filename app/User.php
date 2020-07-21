<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone', 'address','icNumber', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function donation(){
        return $this->hasMany('App\Donation');
    }

    public function post()
    {
        return $this->hasMany('App\Post');
    }

    public function deliveries()
    {
        return $this->hasMany('App\Delivery');
    }

    public function bundles()
    {
        return $this->hasMany('App\Bundle');
    }

    public function money(){
        return $this->hasMany('App\Money');
    }

    public function documents(){
        return $this->hasMany('App\Document');
    }
}
