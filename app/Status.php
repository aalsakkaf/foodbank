<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['*'];

    public function donations()
    {
        return $this->hasMany('App\Donation');
    }

    // public function donation()
    // {
    //     return $this->hasOne('App\Donation');
    // }
}
