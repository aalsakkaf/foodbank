<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = ['*'];

    public function donation()
    {
        return $this->belongsTo('App\Donation');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
