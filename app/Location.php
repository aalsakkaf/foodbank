<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['*'];

    public function donation()
    {
        return $this->hasOne('App\Donation');
    }
}
