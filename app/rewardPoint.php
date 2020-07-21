<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rewardPoint extends Model
{
    protected $fillable = ['*'];

    public function donations(){
        return $this->hasMany('App\Donation');
    }
}
